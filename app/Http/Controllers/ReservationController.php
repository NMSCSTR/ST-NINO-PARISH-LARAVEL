<?php
namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ReservationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['member.user', 'sacrament', 'payments'])->get();
        return view('admin.reservations', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        // Handle Payment
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

        // Handle Uploaded Documents
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reservations = Reservation::findOrFail($id);
        return view('admin.update.update_reservation', compact('reservations'));
    }

    /**
     * Update the specified resource in storage.
     */
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

        if (in_array($request->status, ['pending', 'cancel'])) {
            $reservation->approved_by = null;
        }

        $reservation->save();

        return redirect()->route('admin.reservations')->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations')
            ->with('success', 'Reservation deleted successfully.');
    }

}
