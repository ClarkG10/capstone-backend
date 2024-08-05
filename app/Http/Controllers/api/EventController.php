<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $event = Event::where('user_id', $request->user()->id);

        if ($request->keyword) {
            $event->where(function ($query) use ($request) {
                $query->where('event_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('event_location', 'like', '%' . $request->keyword . '%')
                    ->orWhere('gender', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        return $event->paginate(5);
    }

    /**
     * Display a listing of the resource.
     */
    public function report(Request $request)
    {
        // Fetch all events for the current user
        $events = Event::where('user_id', $request->user()->id)->get();

        // Optionally, handle CSV export here or in a separate method
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $event = Event::create($validated);

        return $event;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Event::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, string $id)
    {
        $validated = $request->validated();

        $event = Event::FindOrFail($id);

        $event->update($validated);

        return $event;
    }

    /**
     * Update the event of the specified resource in storage.
     */
    public function updateEvent(EventRequest $request, string $id)
    {
        $event = Event::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $event->event_name =  $validated['event_name'];
        $event->event_location =  $validated['event_location'];
        $event->start_date =  $validated['start_date'];
        $event->end_date =  $validated['end_date'];
        $event->time_start =  $validated['time_start'];
        $event->time_end =  $validated['time_end'];
        $event->description =  $validated['description'];
        $event->gender =  $validated['gender'];
        $event->weight =  $validated['weight'];
        $event->min_age =  $validated['min_age'];
        $event->max_age =  $validated['max_age'];
        $event->contact_info =  $validated['contact_info'];

        $event->save();

        return $event;
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(EventRequest $request, string $id)
    {
        $event = Event::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $event->status =  $validated['status'];

        $event->save();

        return $event;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::FindOrFail($id);
        $event->delete();
        return $event;
    }
}
