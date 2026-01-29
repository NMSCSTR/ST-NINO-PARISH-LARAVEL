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

    public function allDocuments()
    {

        $documents = ReservationDocument::with([
            'reservation.member.user',
            'reservation.sacrament',
        ])->latest()->get();

        dd($documents);

        return view('admin.documents', compact('documents'));
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

    // public function makeReservation(Request $request)
    // {
    //     $request->validate([
    //         'sacrament_id'      => 'required|exists:sacraments,id',
    //         'reservation_date'  => 'nullable|date',
    //         'remarks'           => 'nullable|string',
    //         'payment_option'    => 'required|in:pay_now,pay_later',
    //         'receipt'           => 'nullable|image|max:2048',
    //         'submission_method' => 'required|in:online,walkin',
    //         'documents.*'       => 'nullable|image|max:2048',
    //         'fee'               => 'required|numeric',
    //     ]);

    //     $reservation = Reservation::create([
    //         'member_id'        => auth()->user()->member->id,
    //         'sacrament_id'     => $request->sacrament_id,
    //         'fee'              => $request->fee,
    //         'reservation_date' => $request->reservation_date,
    //         'remarks'          => $request->remarks,
    //         'status'           => 'pending',
    //     ]);

    //     // Payment handling
    //     if ($request->payment_option === 'pay_now' && $request->hasFile('receipt')) {
    //         $path = $request->file('receipt')->store('receipts', 'public');

    //         Payment::create([
    //             'reservation_id' => $reservation->id,
    //             'member_id'      => auth()->user()->member->id,
    //             'amount'         => $reservation->fee,
    //             'method'         => 'GCash',
    //             'status'         => 'pending',
    //             'receipt_path'   => $path,
    //         ]);
    //     }

    //     if ($request->payment_option === 'pay_later') {
    //         Payment::create([
    //             'reservation_id' => $reservation->id,
    //             'member_id'      => auth()->user()->member->id,
    //             'amount'         => $reservation->fee,
    //             'method'         => 'Pay-later',
    //             'status'         => 'pending',
    //             'receipt_path'   => null,
    //         ]);
    //     }

    //     if ($request->submission_method === 'online' && $request->hasFile('documents')) {
    //         foreach ($request->file('documents') as $file) {
    //             $path = $file->store('documents', 'public');

    //             ReservationDocument::create([
    //                 'reservation_id' => $reservation->id,
    //                 'file_path'      => $path,
    //             ]);
    //         }
    //     }

    //     $message = "🔔 NEW RESERVATION
    //                 Sacrament: {$reservation->sacrament->name}
    //                 Status: Pending
    //                 Date Submitted: " . now()->format('M d, Y h:i A');

    //     $users = User::whereIn('role', ['staff', 'admin'])
    //         ->whereNotNull('phone_number')
    //         ->get();

    //     foreach ($users as $user) {
    //         Http::asForm()->post('https://semaphore.co/api/v4/messages', [
    //             'apikey'     => config('services.semaphore.key'),
    //             'number'     => $user->phone_number,
    //             'message'    => $message,
    //             'sendername' => 'SalnPlatfrm',
    //         ]);
    //     }

    //     return redirect()->route('member.reservation')
    //         ->with('success', 'Reservation created successfully.');
    // }

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

    public function makeReservation(Request $request)
    {
        $request->validate([
            'sacrament_id'      => 'required|exists:sacraments,id',
            'reservation_date'  => 'required|date|after:today', // Improved validation
            'remarks'           => 'nullable|string',
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

        // Save Documents (if online)
        if ($request->submission_method === 'online' && $request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('documents', 'public');
                ReservationDocument::create([
                    'reservation_id' => $reservation->id,
                    'file_path'      => $path,
                ]);
            }
        }

        // Notify Staff/Admin via SMS (logic unchanged)
        $message = "🔔 NEW RESERVATION\nSacrament: {$reservation->sacrament->sacrament_type}\nStatus: Pending Approval";
        $users   = User::whereIn('role', ['staff', 'admin'])->whereNotNull('phone_number')->get();

        foreach ($users as $user) {
            Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                'apikey'     => config('services.semaphore.key'),
                'number'     => $user->phone_number,
                'message'    => $message,
                'sendername' => 'SalnPlatfrm',
            ]);
        }

        return redirect()->route('member.reservation')
            ->with('success', 'Reservation request submitted successfully. Please wait for the priest to review and approve.');
    }

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
    public function cancel($id)
    {
        $reservation = Reservation::with(['member.user', 'sacrament'])
            ->where('id', $id)
            ->where('member_id', auth()->user()->member->id)
            ->firstOrFail();

        if (in_array($reservation->status, ['pending', 'forwarded_to_priest'])) {
            $memberName = auth()->user()->firstname . ' ' . auth()->user()->lastname;
            $sacrament  = $reservation->sacrament->sacrament_type ?? 'Sacrament';
            $oldDate    = $reservation->reservation_date ? $reservation->reservation_date->format('M d, Y') : 'N/A';

            // 1. Update Status
            $reservation->update(['status' => 'cancelled']);

            // 2. Notify Admin/Staff via SMS
            $message = "⚠️ RESERVATION CANCELLED\n"
                . "Member: {$memberName}\n"
                . "Sacrament: {$sacrament}\n"
                . "Original Date: {$oldDate}\n"
                . "The slot is now available.";

            $recipients = User::whereIn('role', ['admin', 'staff'])
                ->whereNotNull('phone_number')
                ->get();

            foreach ($recipients as $user) {
                Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                    'apikey'     => config('services.semaphore.key'),
                    'number'     => $user->phone_number,
                    'message'    => $message,
                    'sendername' => 'SalnPlatfrm',
                ]);
            }

            return back()->with('success', 'Reservation cancelled successfully.');
        }

        return back()->with('error', 'Approved or rejected reservations cannot be cancelled.');
    }

    // public function reschedule(Request $request, $id)
    // {
    //     $request->validate([
    //         'reservation_date' => 'required|date|after:today',
    //     ]);

    //     $reservation = Reservation::with(['member.user', 'sacrament'])
    //         ->where('id', $id)
    //         ->where('member_id', auth()->user()->member->id)
    //         ->firstOrFail();

    //     $oldDate    = $reservation->reservation_date ? $reservation->reservation_date->format('M d, Y h:i A') : 'N/A';
    //     $newDate    = \Carbon\Carbon::parse($request->reservation_date)->format('M d, Y h:i A');
    //     $memberName = auth()->user()->firstname . ' ' . auth()->user()->lastname;
    //     $sacrament  = $reservation->sacrament->sacrament_type ?? 'Sacrament';

    //     $reservation->update([
    //         'status'      => 'forwarded_to_priest',
    //         'remarks'     => 'REQUESTING FOR RESCHEDULE',
    //     ]);

    //     $message = "🔔 RESCHEDULE ALERT\n"
    //         . "Member: {$memberName}\n"
    //         . "Sacrament: {$sacrament}\n"
    //         . "Old Date: {$oldDate}\n"
    //         . "New Date: {$newDate}\n"
    //         . "Please log in to review the change.";

    //     $recipients = User::whereIn('role', ['admin', 'staff', 'priest'])
    //         ->whereNotNull('phone_number')
    //         ->get();

    //     foreach ($recipients as $user) {
    //         try {
    //             Http::asForm()->post('https://semaphore.co/api/v4/messages', [
    //                 'apikey'     => config('services.semaphore.key'),
    //                 'number'     => $user->phone_number,
    //                 'message'    => $message,
    //                 'sendername' => 'SalnPlatfrm',
    //             ]);
    //         } catch (\Exception $e) {
    //             \Log::error("Failed to send reschedule SMS to {$user->phone_number}: " . $e->getMessage());
    //         }
    //     }

    //     return back()->with('success', 'Reschedule request submitted. Admin and Priests have been notified via SMS.');
    // }

    // public function reschedule(Request $request, $id)
    // {

    //     $request->validate([
    //         'reservation_date' => 'required|date|after:today',
    //         'reason'           => 'required|string|max:500',
    //     ]);

    //     $reservation = Reservation::with(['member.user', 'sacrament'])
    //         ->where('id', $id)
    //         ->where('member_id', auth()->user()->member->id)
    //         ->firstOrFail();


    //     $user       = auth()->user();
    //     $memberName = "{$user->firstname} {$user->lastname}";
    //     $sacrament  = $reservation->sacrament->sacrament_type ?? 'Sacrament';
    //     $reason     = $request->input('reason');
    //     $timestamp  = now()->format('M d, Y g:i A');

    //     $oldDate = $reservation->reservation_date
    //         ? $reservation->reservation_date->format('M d, Y h:i A')
    //         : 'N/A';

    //     $newDate = \Carbon\Carbon::parse($request->reservation_date)->format('M d, Y h:i A');


    //     $detailedRemarks = "--- RESCHEDULE LOG [$timestamp] ---\n"
    //         . "Requested By: {$memberName}\n"
    //         . "From: {$oldDate}\n"
    //         . "To: {$newDate}\n"
    //         . "Reason: {$reason}\n"
    //         . "Status: Forwarded for Review";


    //     $reservation->update([
    //         'status'           => 'forwarded_to_priest',
    //         'remarks'          => $detailedRemarks,
    //         'reservation_date' => $request->reservation_date,
    //     ]);


    //     $message = "🔔 RESCHEDULE ALERT\n"
    //         . "Member: {$memberName}\n"
    //         . "Sacrament: {$sacrament}\n"
    //         . "New Date: {$newDate}\n"
    //         . "Reason: {$reason}";

    //     $recipients = User::whereIn('role', ['admin', 'staff', 'priest'])
    //         ->whereNotNull('phone_number')
    //         ->get();

    //     foreach ($recipients as $recipient) {
    //         try {
    //             Http::asForm()->post('https://semaphore.co/api/v4/messages', [
    //                 'apikey'     => config('services.semaphore.key'),
    //                 'number'     => $recipient->phone_number,
    //                 'message'    => $message,
    //                 'sendername' => 'SalnPlatfrm',
    //             ]);
    //         } catch (\Exception $e) {
    //             \Log::error("SMS Failed: " . $e->getMessage());
    //         }
    //     }

    //     return back()->with('success', 'Reschedule request submitted and staff notified.');
    // }

public function reschedule(Request $request, $id)
{
    $request->validate([
        'reservation_date' => 'required|date|after:today',
        'reason'           => 'required|string|max:100', // Keep reason short for SMS
    ]);

    $reservation = Reservation::with(['member.user', 'sacrament'])
        ->where('id', $id)
        ->where('member_id', auth()->user()->member->id)
        ->firstOrFail();

    $user       = auth()->user();
    $memberName = $user->firstname . ' ' . $user->lastname;
    $sacrament  = $reservation->sacrament->sacrament_type ?? 'Sacrament';
    $reason     = $request->input('reason');
    $timestamp  = now()->format('M d, g:i A');

    // Dates for the Database (Detailed)
    $oldDateStr = $reservation->reservation_date ? $reservation->reservation_date->format('M d, Y') : 'N/A';
    $newDateStr = \Carbon\Carbon::parse($request->reservation_date)->format('M d, Y');

    // 1. Update Database with FULL details (No character limit here)
    $reservation->update([
        'status'  => 'forwarded_to_priest',
        'remarks' => "RESCHEDULE LOG [$timestamp]\nBy: $memberName\nFrom: $oldDateStr\nTo: $newDateStr\nReason: $reason",
        'reservation_date' => $request->reservation_date
    ]);

    // 2. Short SMS Message (STRICTLY matching your working Cancel format)
    // We keep this under 160 characters
    $message = "🔔 RESCHEDULE: {$sacrament}\n"
             . "Member: {$memberName}\n"
             . "New Date: {$newDateStr}\n"
             . "Reason: {$reason}";

    $recipients = User::whereIn('role', ['admin', 'staff', 'priest'])
        ->whereNotNull('phone_number')
        ->get();

    foreach ($recipients as $recipient) {
        // Exact same Http call as your working cancel function
        Http::asForm()->post('https://semaphore.co/api/v4/messages', [
            'apikey'     => config('services.semaphore.key'),
            'number'     => $recipient->phone_number,
            'message'    => $message,
            'sendername' => 'SalnPlatfrm',
        ]);
    }

    return back()->with('success', 'Reschedule request submitted successfully.');
}

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations')
            ->with('success', 'Reservation deleted successfully.');
    }
}
