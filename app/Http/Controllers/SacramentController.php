<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SacramentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sacraments = Sacrament::all();
        return view('admin.sacraments', compact('sacraments'));
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
        $request->validate([
            'sacrament_type' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
        ]);

        Sacrament::create([
            'sacrament_type' => $request->sacrament_type,
            'fee' => $request->fee,
        ]);

        return redirect()->back()->with('success', 'Sacrament added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sacrament $sacrament)
    {
        $request->validate([
            'sacrament_type' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0',
        ]);

        $sacrament->update([
            'sacrament_type' => $request->sacrament_type,
            'fee' => $request->fee,
        ]);

        return redirect()->back()->with('success', 'Sacrament updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sacrament $sacrament)
    {
        $sacrament->delete();
        return redirect()->back()->with('success', 'Sacrament deleted successfully.');
    }
}
