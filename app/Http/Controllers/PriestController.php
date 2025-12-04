<?php
namespace App\Http\Controllers;

use App\Models\Priest;
use App\Models\Reservation;
use Illuminate\Http\Request;

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
