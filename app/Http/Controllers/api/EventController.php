<?php

namespace App\Http\Controllers\api;

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
        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Get the authenticated user's ID
        $userId = $request->user()->id ?? $request->user()->user_id;

        // Query Events for the authenticated user
        $eventQuery = Event::where('user_id', $userId)->orderBy('created_at', 'desc');

        // If there is a keyword, add additional filtering
        if ($request->keyword) {
            $eventQuery->where(function ($query) use ($request) {
                $query->where('event_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('event_location', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // Return paginated results
        return response()->json($eventQuery->paginate(6));
    }


    /**
     * Display a listing of the resource.
     */
    public function report(Request $request)
    {
        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Get the authenticated user's ID
        $userId = $request->user()->id ?? $request->user()->user_id;

        // Query Events for the authenticated user
        $events = Event::where('user_id', $userId)->get();

        return response()->json($events);
    }


    /**
     * Display a listing of the resource.
     */
    public function eventIndex()
    {
        return Event::all();
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

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');

            $validated['image'] = $imagePath;
            $event->image = $validated['image'];
        }

        $event->event_name =  $validated['event_name'];
        $event->event_location =  $validated['event_location'];
        $event->start_date =  $validated['start_date'];
        $event->end_date =  $validated['end_date'];
        $event->time_start =  $validated['time_start'];
        $event->time_end =  $validated['time_end'];
        $event->description =  $validated['description'];
        $event->min_age =  $validated['min_age'];
        $event->max_age =  $validated['max_age'];
        $event->contact_info =  $validated['contact_info'];
        $event->participants =  $validated['participants'];

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
