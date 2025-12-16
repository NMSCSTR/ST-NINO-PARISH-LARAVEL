<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $events = Event::all();
        return view('admin.events', compact('events'));
        // return $events;
    }
    public function fecthEvents()
    {
        //
        $events = Event::all();
        return view('member.events', compact('events'));
    }

    public function fetchEventsData(Request $request)
    {
        $start = $request->query('start');
        $end   = $request->query('end');

        $query = Event::query();

        if ($start && $end) {
            $query->whereBetween('start_date', [$start, $end]);
        }

        $events = $query->get()->map(function ($event) {
            return [
                'id'          => $event->id,
                'title'       => $event->title,
                'start'       => $event->start_date->toIso8601String(),
                'end'         => $event->end_date ? $event->end_date->toIso8601String() : null,
                'description' => $event->description,
                'type'        => $event->type,
            ];
        });

        return response()->json($events);
    }

    public function fetchEvents(Request $request)
    {
        $start = $request->query('start');
        $end   = $request->query('end');

        $query = Event::query();

        if ($start && $end) {
            $query->whereBetween('start_date', [$start, $end]);
        }

        $events = $query->get()->map(function ($event) {
            return [
                'id'          => $event->id,
                'title'       => $event->title,
                'start'       => $event->start_date->toIso8601String(),
                'end'         => $event->end_date ? $event->end_date->toIso8601String() : null,
                'description' => $event->description,
                'type'        => $event->type,
            ];
        });

        return response()->json($events);
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
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'type'        => 'nullable|string|max:50',
        ]);

        Event::create([
            'user_id'     => auth()->id(), // logged-in admin
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'type'        => $request->type ?? 'general',
        ]);

        return redirect()->back()->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'type'        => 'nullable|string|max:50',
        ]);

        $event->update($request->only('title', 'description', 'start_date', 'end_date', 'type'));

        return redirect()->back()->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->back()->with('success', 'Event deleted successfully!');
    }
}
