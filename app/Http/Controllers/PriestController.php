<?php
namespace App\Http\Controllers;

use App\Models\Priest;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
