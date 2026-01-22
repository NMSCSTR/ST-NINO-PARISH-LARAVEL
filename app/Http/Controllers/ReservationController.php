<?php
namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ReservationDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReservationController extends Controller
{
    public function index()
    {
        // dd(config('services.semaphore.key'));

        $reservations = Reservation::with([
            'member.user', 'sacrament', 'payments', 'approvedBy', 'forwardedByUser',
        ])->get();

        return view('admin.reservations', compact('reservations'));
    }

    public function memberReservations()
    {
        $memberId = auth()->user()->member->id;

        $reservations = Reservation::with(['sacrament', 'payments'])
            ->where('member_id', $memberId)
            ->latest()
            ->get();

        return view('member.reservation_history', compact('reservations'));
    }

    public function sendSMS(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'message'      => 'required|string',
        ]);

        try {
            $response = Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                'apikey'     => config('services.semaphore.key'),
                'number'     => $request->phone_number,
                'message'    => $request->message,
                'sendername' => 'SalnPlatfrm',
            ]);

            if ($response->failed()) {
                \Log::error('Semaphore API failed: ' . $response->body());
                return response()->json(['success' => false, 'error' => 'SMS API failed']);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('SMS sending error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Exception occurred']);
        }
    }

    public function makeReservation(Request $request)
    {
        $request->validate([
            'sacrament_id'      => 'required|exists:sacraments,id',
            'reservation_date'  => 'nullable|date',
            'remarks'           => 'nullable|string',
            'payment_option'    => 'required|in:pay_now,pay_later',
            'receipt'           => 'nullable|image|max:2048',
            'submission_method' => 'required|in:online,walkin',
            'documents.*'       => 'nullable|image|max:2048',
            'fee'               => 'required|numeric',
        ]);

        $reservation = Reservation::create([
            'member_id'        => auth()->user()->member->id,
            'sacrament_id'     => $request->sacrament_id,
            'fee'              => $request->fee,
            'reservation_date' => $request->reservation_date,
            'remarks'          => $request->remarks,
            'status'           => 'pending',
        ]);

        // Payment handling
        if ($request->payment_option === 'pay_now' && $request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');

            Payment::create([
                'reservation_id' => $reservation->id,
                'member_id'      => auth()->user()->member->id,
                'amount'         => $reservation->fee,
                'method'         => 'GCash',
                'status'         => 'pending',
                'receipt_path'   => $path,
            ]);
        }

        if ($request->payment_option === 'pay_later') {
            Payment::create([
                'reservation_id' => $reservation->id,
                'member_id'      => auth()->user()->member->id,
                'amount'         => $reservation->fee,
                'method'         => 'Pay-later',
                'status'         => 'pending',
                'receipt_path'   => null,
            ]);
        }

        if ($request->submission_method === 'online' && $request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('documents', 'public');

                ReservationDocument::create([
                    'reservation_id' => $reservation->id,
                    'file_path'      => $path,
                ]);
            }
        }

        $message = "🔔 NEW RESERVATION
                    Sacrament: {$reservation->sacrament->name}
                    Status: Pending
                    Date Submitted: " . now()->format('M d, Y h:i A');

        $users = User::whereIn('role', ['staff', 'admin'])
            ->whereNotNull('phone_number')
            ->get();

        foreach ($users as $user) {
            Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                'apikey'     => config('services.semaphore.key'),
                'number'     => $user->phone_number,
                'message'    => $message,
                'sendername' => 'SalnPlatfrm',
            ]);
        }

        return redirect()->route('member.reservation')
            ->with('success', 'Reservation created successfully.');
    }

    /**
     * Forward reservation to priest
     */
    // public function forward($id)
    // {
    //     $reservation = Reservation::findOrFail($id);

    //     if (in_array($reservation->status, ['approved', 'rejected', 'forwarded_to_priest'])) {
    //         return back()->with('error', 'This reservation cannot be forwarded.');
    //     }

    //     $reservation->update([
    //         'status'       => 'forwarded_to_priest',
    //         'forwarded_by' => auth()->user()->id,
    //         'forwarded_at' => now(),
    //     ]);

    //     $priest = User::where('role', 'priest')->first();

    //     if ($priest && $priest->phone_number) {
    //         $response = Http::asForm()->post('https://semaphore.co/api/v4/messages', [
    //             'apikey'     => config('services.semaphore.key'),
    //             'number'     => $priest->phone_number,
    //             'message'    => 'Good day Father. A reservation has been forwarded to you for approval. Please log in to the system to review it.',
    //             'sendername' => 'SalnPlatfrm',
    //         ]);

    //         if ($response->failed()) {
    //             return back()->with(
    //                 'warning',
    //                 'Reservation forwarded, but SMS notification to priest failed.'
    //             );
    //         }
    //     }

    //     return back()->with('success', 'Reservation forwarded to the priest.');
    // }

    public function forward($id)
    {
        // Eager load member.user and sacrament
        $reservation = Reservation::with(['member.user', 'sacrament'])->findOrFail($id);

        // Cannot forward if already approved, rejected, or forwarded
        if (in_array($reservation->status, ['approved', 'rejected', 'forwarded_to_priest'])) {
            return back()->with('error', 'This reservation cannot be forwarded.');
        }

        // Update reservation status
        $reservation->update([
            'status'       => 'forwarded_to_priest',
            'forwarded_by' => auth()->user()->id,
            'forwarded_at' => now(),
        ]);

        // Get all priests with phone numbers
        $priests = User::where('role', 'priest')
            ->whereNotNull('phone_number')
            ->get();

        if ($priests->isEmpty()) {
            return back()->with('warning', 'Reservation forwarded, but no priests with phone numbers found.');
        }

        // Get member name from related user
        $memberName = $reservation->member && $reservation->member->user
            ? $reservation->member->user->firstname . ' ' . $reservation->member->user->lastname
            : 'N/A';

        // Get reservation date & time
        $reservationDate = $reservation->reservation_date
            ? $reservation->reservation_date->format('M d, Y')
            : 'N/A';
        $reservationTime = $reservation->reservation_date
            ? $reservation->reservation_date->format('h:i A')
            : 'N/A';

        // Get sacrament type
        $sacramentType = $reservation->sacrament ? $reservation->sacrament->sacrament_type : 'N/A';

        // Send SMS to all priests with personalized greeting
        foreach ($priests as $priest) {

            $message = "Good day Father {$priest->firstname}, a new reservation has been forwarded to you for approval.\n"
                . "Member: {$memberName}\n"
                . "Sacrament: {$sacramentType}\n"
                . "Date: {$reservationDate}\n"
                . "Pls log in to system to review.";

            Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                'apikey'     => config('services.semaphore.key'),
                'number'     => $priest->phone_number,
                'message'    => $message,
                'sendername' => 'SalnPlatfrm',
            ]);
        }

        return back()->with('success', 'Reservation forwarded and priests notified via SMS.');
    }

    public function priestReject(Request $request, $id)
    {
        // Load reservation with member.user and sacrament
        $reservation = Reservation::with(['member.user', 'sacrament'])->findOrFail($id);

        if ($reservation->status !== 'forwarded_to_priest') {
            return back()->with('error', 'Only forwarded reservations can be rejected.');
        }

        // Add remarks with approver name if provided
        $remarks = $request->remarks
            ? $request->remarks . ' (by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname . ')'
            : null;

        // Update reservation
        $reservation->update([
            'status'      => 'rejected',
            'approved_by' => auth()->user()->id,
            'remarks'     => $remarks,
        ]);

        // Get member name
        $memberName = $reservation->member && $reservation->member->user
            ? $reservation->member->user->firstname . ' ' . $reservation->member->user->lastname
            : 'N/A';

        // Get reservation date & time
        $reservationDate = $reservation->reservation_date
            ? $reservation->reservation_date->format('M d, Y')
            : 'N/A';
        $reservationTime = $reservation->reservation_date
            ? $reservation->reservation_date->format('h:i A')
            : 'N/A';

        // Get sacrament type
        $sacramentType = $reservation->sacrament ? $reservation->sacrament->sacrament_type : 'N/A';

        // Prepare SMS message
        $message = "Good day {$memberName}, your reservation has been rejected by Priest "
        . auth()->user()->firstname . " " . auth()->user()->lastname . ".\n"
            . "Sacrament: {$sacramentType}\n"
            . "Date: {$reservationDate}\n"
            . (! empty($remarks) ? "Remarks: {$remarks}\n" : "")
            . "Please contact the parish for further details.";

        // Send SMS if member phone exists
        $memberPhone = optional($reservation->member->user)->phone_number;
        if ($memberPhone) {
            $response = Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                'apikey'     => config('services.semaphore.key'),
                'number'     => $memberPhone,
                'message'    => $message,
                'sendername' => 'SalnPlatfrm',
            ]);

            if ($response->failed()) {
                return back()->with('warning', 'Reservation rejected, but SMS failed to send.');
            }
        }

        return back()->with('success', 'Reservation rejected successfully and member notified.');
    }

    public function certificate(Reservation $reservation)
    {
        abort_if($reservation->status !== 'approved', 403);

        $reservation->load([
            'member.user',
            'sacrament',
            'approvedBy',
        ]);

        return view('admin.certificate', compact('reservation'));
    }

    // public function priestApprove(Request $request, $id)
    // {
    //     $reservation = Reservation::with(['member.user', 'sacrament'])->findOrFail($id);

    //     if ($reservation->status !== 'forwarded_to_priest') {
    //         return back()->with('error', 'Only forwarded reservations can be approved.');
    //     }

    //     // Add remarks with approver name if provided
    //     $remarks = $request->remarks
    //         ? $request->remarks . ' (by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname . ')'
    //         : null;

    //     // Update reservation
    //     $reservation->update([
    //         'status'      => 'approved',
    //         'approved_by' => auth()->user()->id,
    //         'remarks'     => $remarks,
    //     ]);

    //     // Get member name
    //     $memberName = $reservation->member && $reservation->member->user
    //         ? $reservation->member->user->firstname . ' ' . $reservation->member->user->lastname
    //         : 'N/A';

    //     // Get reservation date & time
    //     $reservationDate = $reservation->reservation_date
    //         ? $reservation->reservation_date->format('M d, Y')
    //         : 'N/A';
    //     $reservationTime = $reservation->reservation_date
    //         ? $reservation->reservation_date->format('h:i A')
    //         : 'N/A';

    //     // Get sacrament type
    //     $sacramentType = $reservation->sacrament ? $reservation->sacrament->sacrament_type : 'N/A';

    //     // Prepare SMS message
    //     $message = "Good day {$memberName}, your reservation has been approved by Priest "
    //     . auth()->user()->firstname . " " . auth()->user()->lastname . ".\n"
    //         . "Sacrament: {$sacramentType}\n"
    //         . "Date: {$reservationDate}\n"
    //         . (! empty($remarks) ? "Remarks: {$remarks}\n" : "")
    //         . "Thank you for using our service.";

    //     // Send SMS if member phone exists
    //     $memberPhone = optional($reservation->member->user)->phone_number;
    //     if ($memberPhone) {
    //         $response = Http::asForm()->post('https://semaphore.co/api/v4/messages', [
    //             'apikey'     => config('services.semaphore.key'),
    //             'number'     => $memberPhone,
    //             'message'    => $message,
    //             'sendername' => 'SalnPlatfrm',
    //         ]);

    //         if ($response->failed()) {
    //             return back()->with('warning', 'Reservation approved, but SMS failed to send.');
    //         }
    //     }

    //     return back()->with('success', 'Reservation approved successfully and member notified.');
    // }

    public function priestApprove(Request $request, $id)
    {
        $reservation = Reservation::with(['member.user', 'sacrament'])->findOrFail($id);

        if ($reservation->status !== 'forwarded_to_priest') {
            return back()->with('error', 'Only forwarded reservations can be approved.');
        }

        $remarks = $request->remarks
            ? $request->remarks . ' (by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname . ')'
            : null;

        // 1. Update reservation status
        $reservation->update([
            'status'      => 'approved',
            'approved_by' => auth()->user()->id,
            'remarks'     => $remarks,
        ]);

        // 2. NEW: Generate the Payment Record now that it is approved
        Payment::create([
            'reservation_id' => $reservation->id,
            'member_id'      => $reservation->member_id,
            'amount'         => $reservation->fee,
            'method'         => 'GCash', // Default method
            'status'         => 'pending',
        ]);

        // 3. Notify the user via SMS that they can now pay
        $memberPhone = optional($reservation->member->user)->phone_number;
        if ($memberPhone) {
            $message = "Good day {$reservation->member->user->firstname}, your reservation for {$reservation->sacrament->sacrament_type} is APPROVED. You may now settle your payment of ₱" . number_format($reservation->fee, 2) . " via the portal. Thank you!";

            Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                'apikey'     => config('services.semaphore.key'),
                'number'     => $memberPhone,
                'message'    => $message,
                'sendername' => 'SalnPlatfrm',
            ]);
        }

        return back()->with('success', 'Reservation approved. Payment request sent to member.');
    }

    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->status      = 'approved';
        $reservation->approved_by = auth()->user()->id;
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation approved successfully.');
    }

    public function fetchPayments($id)
    {
        $reservation = Reservation::with(['payments', 'member.user', 'sacrament'])->findOrFail($id);

        return response()->json([
            'member'    => $reservation->member->user->firstname . ' ' . $reservation->member->user->lastname,
            'sacrament' => $reservation->sacrament->sacrament_type ?? 'N/A',
            'payments'  => $reservation->payments->map(function ($p) {
                return [
                    'id'           => $p->id,
                    'amount'       => $p->amount,
                    'method'       => $p->method,
                    'status'       => $p->status,
                    'receipt_path' => $p->receipt_path,
                    'receipt_url'  => $p->receipt_path ? asset('storage/' . $p->receipt_path) : null,
                    'date'         => $p->created_at->format('M d, Y'),
                ];
            }),
        ]);
    }

    public function markPaymentAsPaid($id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->status === 'paid') {
            return response()->json(['message' => 'This payment is already marked as PAID.'], 400);
        }

        $payment->status = 'paid';
        $payment->save();

        return response()->json(['message' => 'Payment status updated to PAID successfully.']);
    }

    public function getDocuments($id)
    {
        $reservation = Reservation::with('documents', 'member.user', 'sacrament')->findOrFail($id);

        return response()->json([
            'member'    => $reservation->member->user->firstname . ' ' . $reservation->member->user->lastname,
            'sacrament' => $reservation->sacrament->sacrament_type,
            'documents' => $reservation->documents->map(function ($doc) {
                return [
                    'id'  => $doc->id,
                    'url' => asset('storage/' . $doc->file_path),
                ];
            }),
        ]);
    }

    public function edit($id)
    {
        $reservations = Reservation::findOrFail($id);
        return view('admin.update.update_reservation', compact('reservations'));
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'status'           => 'required',
            'reservation_date' => 'date',
            'remarks'          => 'nullable|string',
        ]);

        $reservation->status           = $request->status;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->remarks          = $request->remarks;

        if (in_array($request->status, ['pending', 'cancel', 'forwarded_to_priest'])) {
            $reservation->approved_by = null;
        }

        $reservation->save();

        return redirect()->route('admin.reservations')
            ->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations')
            ->with('success', 'Reservation deleted successfully.');
    }
}
