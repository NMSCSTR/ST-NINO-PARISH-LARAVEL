<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Member;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();
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

        $userId = Auth::user()->id ?? null;
        $memberId = Member::where('user_id', $userId)->value('id');


        if (!$memberId) {
            return redirect()->back()->withErrors(['member_id' => 'You do not have a valid member account.']);
        }

        $validated = $request->validate([
            'type' => 'required',
            'reservation_date' => 'nullable|date',
            'remarks' => 'nullable|string|max:1000',

        ]);

        Reservation::create([
            'member_id' => $memberId,
            'type' => $validated['type'],
            'status' => 'pending',
            'reservation_date' => $validated['reservation_date'] ?? now(),
            'remarks' => $validated['remarks'] ?? null,
            'approved_by' => null,
        ]);

        return redirect()->back()->with('success', 'Reservation submitted successfully!');
    }

    public function approve($id)
    {
        $reservation = Reservation::findOrFail($id);

        if (! $reservation->approved_by) {
            $reservation->approved_by = Auth::id();
            $reservation->status      = 'approved';
            $reservation->remarks     = 'approved';
            $reservation->save();
        }

        return redirect()->back()->with('success', 'Reservation approved successfully.');
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
        //
    }
}
