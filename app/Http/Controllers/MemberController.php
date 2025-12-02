<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with('user')->get();


        $events = Event::where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        $nextEvent = Event::where('start_date', '>=', now())
                   ->orderBy('start_date', 'asc')
                   ->first();



        $totalMembers = Member::count();


        $eventCount = Event::count();


        $reservationCount = auth()->user()
            ->events()
            ->withCount('reservations')
            ->get()
            ->sum('reservations_count');

        return view('member.dashboard', compact(
            'members',
            'events',
            'totalMembers',
            'eventCount',
            'reservationCount',
            'nextEvent'
        ));
    }

    public function reservation()
    {
        $events = Event::with('user')->get();
        return view('member.reservation', compact('events'));
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
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
