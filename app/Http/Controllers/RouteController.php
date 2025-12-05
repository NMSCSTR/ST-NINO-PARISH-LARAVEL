<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Event;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Baptism;
use App\Models\Weddings;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin()
    {
        $users = User::all();
        $events = Event::all();
        $reservations = Reservation::all();
        return view('admin.dashboard', compact('users','events','reservations'));
    }

    public function events()
    {
        $events = Event::all();
        return view('admin.events', compact('events'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function members()
    {
        $members = Member::all();
        // return view('admin.members', compact('members'));
        return $members;
    }

    public function baptisms()
    {
        $baptisms = Baptism::all();
        return view('admin.baptisms', compact('baptisms'));
    }

    public function weddings()
    {
        $weddings = Wedding::all();
        return view('admin.weddings', compact('weddings'));
    }

    public function reservations()
    {
        $reservations = Reservation::all();
        return view('admin.reservations', compact('reservations'));
    }

    public function payments()
    {
        $payments = Payment::all();
        return view('admin.payments', compact('payments'));
    }

    public function documents()
    {
        // $documents = Documents::all();
        // return view('admin.documents', compact('documents'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
