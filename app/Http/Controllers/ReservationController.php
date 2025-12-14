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
        ]);

        $reservation = Reservation::create([
            'member_id'        => auth()->user()->member->id,
            'sacrament_id'     => $request->sacrament_id,
            'fee'              => preg_replace('/[^\d.]/', '', $request->fee),
            'reservation_date' => $request->reservation_date,
            'remarks'          => $request->remarks,
            'status'           => 'pending',
        ]);

        // Payment handling (unchanged)
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

        // Document upload
        if ($request->submission_method === 'online' && $request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('documents', 'public');

                ReservationDocument::create([
                    'reservation_id' => $reservation->id,
                    'file_path'      => $path,
                ]);
            }
        }

        return redirect()->route('member.reservation')
            ->with('success', 'Reservation created successfully.');
    }

    /**
     * Forward reservation to priest
     */
    public function forward($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Cannot forward if already approved or rejected or already forwarded
        if (in_array($reservation->status, ['approved', 'rejected', 'forwarded_to_priest'])) {
            return back()->with('error', 'This reservation cannot be forwarded.');
        }

        $reservation->update([
            'status'       => 'forwarded_to_priest',
            'forwarded_by' => auth()->user()->id,
            'forwarded_at' => now(),
        ]);

        return back()->with('success', 'Reservation forwarded to the priest.');
    }

    public function priestReject(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status !== 'forwarded_to_priest') {
            return back()->with('error', 'Only forwarded reservations can be rejected.');
        }

        $remarks = $request->remarks
            ? $request->remarks . ' (by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname . ')'
            : null;

        $reservation->update([
            'status'      => 'rejected',
            'approved_by' => auth()->user()->id,
            'remarks'     => $remarks,
        ]);
        $response = Http::asForm()->post('https://semaphore.co/api/v4/messages', [
            'apikey'     => config('services.semaphore.key'),
            'number' => optional($reservation->member->user)->phone_number,
            'message'    => 'Your reservation was rejected by Priest: ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
            'sendername' => 'SalnPlatfrm',
        ]);

        if ($response->failed()) {
            return back()->with('warning', 'Reservation rejected, but SMS failed to send.');
        }

        return back()->with('success', 'Reservation rejected successfully.');
    }


    public function priestApprove(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status !== 'forwarded_to_priest') {
            return back()->with('error', 'Only forwarded reservations can be approved.');
        }

        $remarks = $request->remarks
            ? $request->remarks . ' (by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname . ')'
            : null;

        $reservation->update([
            'status'      => 'approved',
            'approved_by' => auth()->user()->id,
            'remarks'     => $remarks,
        ]);


        $response = Http::asForm()->post('https://semaphore.co/api/v4/messages', [
            'apikey'     => config('services.semaphore.key'),
            'number' => optional($reservation->member->user)->phone_number,
            'message'    => 'Your reservation was approved by Priest: ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
            'sendername' => 'SalnPlatfrm',
        ]);


        if ($response->failed()) {
            return back()->with('warning', 'Reservation approved, but SMS failed to send.');
        }

        return back()->with('success', 'Reservation approved successfully.');
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

        if (in_array($request->status, ['pending', 'cancel','forwarded_to_priest'])) {
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
