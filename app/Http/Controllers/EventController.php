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
        $end = $request->query('end');

        $query = Event::query();

        if ($start && $end) {
            // Filter events where start_date falls between the calendar's requested range
            $query->whereBetween('start_date', [$start, $end]);
        }

        $events = $query->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->toIso8601String(),
                'end' => $event->end_date ? $event->end_date->toIso8601String() : null,
                'description' => $event->description,
                'type' => $event->type,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
