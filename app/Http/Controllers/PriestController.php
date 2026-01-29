<?php
namespace App\Http\Controllers;

use App\Models\Priest;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PriestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['member.user', 'sacrament'])
            ->where('status', 'forwarded_to_priest')
            ->get();

        return view('priest.dashboard', compact('reservations'));
    }

    // public function scheduleCalendar()
    // {
    //     $user         = auth()->user();
    //     $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
    //     $endOfMonth   = \Carbon\Carbon::now()->endOfMonth();

    //     $reservations = \App\Models\Reservation::with(['member.user', 'sacrament', 'documents', 'payments'])
    //         ->where('approved_by', $user->id)
    //         ->where('status', 'approved')
    //         ->whereBetween('reservation_date', [$startOfMonth, $endOfMonth])
    //         ->orderBy('reservation_date')
    //         ->get()
    //         ->groupBy(function ($res) {
    //             return $res->reservation_date->format('Y-m-d');
    //         });

    //     return view('priest.schedule-calendar', compact('reservations', 'startOfMonth'));
    // }

    public function scheduleCalendar(Request $request)
    {
        $user = auth()->user();

        // Get the year from the request, or default to the current year
        $year = $request->get('year', date('Y'));

        // Define the start and end of the chosen year
        $startOfYear = Carbon::createFromDate($year, 1, 1)->startOfDay();
        $endOfYear = Carbon::createFromDate($year, 12, 31)->endOfDay();

        $reservations = \App\Models\Reservation::with(['member.user', 'sacrament', 'documents', 'payments'])
            ->where('approved_by', $user->id)
            ->where('status', 'approved')
            ->whereBetween('reservation_date', [$startOfYear, $endOfYear])
            ->orderBy('reservation_date')
            ->get()
            ->groupBy(function ($res) {
                return $res->reservation_date->format('Y-m-d');
            });

        return view('priest.schedule-calendar', compact('reservations', 'year'));
    }

    public function schedule()
    {
        $user = Auth::user();

        // Current month start and end
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $reservations = Reservation::with(['member.user', 'sacrament'])
            ->where('approved_by', $user->id)
            ->where('status', 'approved')
            ->whereBetween('reservation_date', [$startOfMonth, $endOfMonth])
            ->orderBy('reservation_date', 'asc')
            ->get();

        return view('priest.schedule', compact('reservations'));
    }

    public function priestList()
    {
        $priest = Priest::all();
        return view('admin.priest', compact('priest'));
    }

    public function editProfile()
    {
        $priest = Auth::user();
        return view('priest.profile', compact('priest'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Priest $priest)
    {
        //
    }

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'reservation_date' => 'required|date|after:today',
        ]);

        $reservation = Reservation::with(['member.user', 'sacrament'])->findOrFail($id);
        $oldDate     = $reservation->reservation_date->format('M d, Y h:i A');
        $newDate     = Carbon::parse($request->reservation_date)->format('M d, Y h:i A');

        // Update the date
        $reservation->update([
            'reservation_date' => $request->reservation_date,
            // Keep status as forwarded_to_priest so they can still 'approve' it later
        ]);

        // Notify Member via SMS
        if ($reservation->member->user->phone_number) {
            $msg = "Notice: Father has changed your {$reservation->sacrament->sacrament_type} schedule from {$oldDate} to {$newDate}. Please check your portal.";

            try {
                Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                    'apikey'     => config('services.semaphore.key'), // Ensure this is in your .env
                    'number'     => $reservation->member->user->phone_number,
                    'message'    => $msg,
                    'sendername' => 'SalnPlatfrm',
                ]);
            } catch (\Exception $e) {
                // Log error if SMS fails but allow the process to continue
                \Log::error("SMS Failure: " . $e->getMessage());
            }
        }

        return back()->with('success', 'The reservation date has been updated and the member has been notified.');
    }

    public function approve(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'remarks'     => $request->remarks,
        ]);

        return back()->with('success', 'Reservation has been officially approved.');
    }

    public function reject(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'status'  => 'rejected',
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Reservation has been rejected.');
    }

    public function updateProfile(Request $request)
    {
        $priest = auth()->user();

        $request->validate([
            'firstname'    => 'required|string|max:255',
            'lastname'     => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $priest->id,
            'phone_number' => 'nullable|string|max:20',
            'password'     => 'nullable|string|min:6|confirmed',
        ]);

        $priest->firstname    = $request->firstname;
        $priest->lastname     = $request->lastname;
        $priest->email        = $request->email;
        $priest->phone_number = $request->phone_number;

        if ($request->filled('password')) {
            $priest->password = bcrypt($request->password);
        }

        $priest->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Priest $priest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Priest $priest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Priest $priest)
    {
        //
    }
}
