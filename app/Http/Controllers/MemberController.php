<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use App\Models\Sacrament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $eventCount   = Event::count();

        $reservationCount = auth()->user()->member
            ? auth()->user()->member->reservations()->count()
            : 0;

        return view('member.dashboard', compact(
            'members',
            'events',
            'totalMembers',
            'eventCount',
            'reservationCount',
            'nextEvent'
        ));
    }

    public function adminMemberView()
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
        $eventCount   = Event::count();

        $reservationCount = auth()->user()->member
            ? auth()->user()->member->reservations()->count()
            : 0;

        return view('admin.dashboard', compact(
            'members',
            'events',
            'totalMembers',
            'eventCount',
            'reservationCount',
            'nextEvent'
        ));
    }

    public function profile()
    {
        $user = auth()->user();

        // If user has no member record, create one
        if (!$user->member) {
            $user->member()->create([]);
        }

        return view('member.profile', [
            'user' => $user,
            'member' => $user->member
        ]);
    }

    public function memberList()
    {
        $members = Member::with('user')->get();
        return view('admin.members', compact('members'));
    }

    public function reservation()
    {
        $sacraments = Sacrament::all();
        $events     = Event::with('user')->get();
        return view('member.reservation', compact('events', 'sacraments'));
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
    public function showMore($id)
    {
        $member = Member::where('user_id', $id)->firstOrFail();
        return view('admin.users', compact('member'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'firstname'      => 'required|string|max:255',
            'lastname'       => 'required|string|max:255',
            'phone_number'   => 'nullable|string|max:20',

            // Member table fields
            'middle_name'    => 'nullable|string|max:255',
            'birth_date'     => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'address'        => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        // Update user data
        $user->update([
            'firstname'    => $request->firstname,
            'lastname'     => $request->lastname,
            'phone_number' => $request->phone_number,
        ]);

        // Update member data
        $user->member->update([
            'middle_name'    => $request->middle_name,
            'birth_date'     => $request->birth_date,
            'place_of_birth' => $request->place_of_birth,
            'address'        => $request->address,
            'contact_number' => $request->contact_number,
        ]);

        return back()->with('success', 'Profile updated successfully!');
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
