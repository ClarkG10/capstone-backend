<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestBloodRequest;
use Illuminate\Http\Request;
use App\Models\BloodRequest;
use App\Mail\BloodRequestMail;
use App\Models\Organization;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RequestController extends Controller
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

        $userId = $request->user()->id ?? $request->user()->user_id;

        $organization = Organization::find($userId);

        $query = BloodRequest::where(function ($query) use ($userId, $organization) {
            $query->where('user_id', $userId)
                ->orWhere('receiver_id', $userId);

            // Add organization check only if it exists
            if ($organization) {
                $query->orWhere('receiver_id', $organization->org_id);
            }
        })->orderBy('created_at', 'desc');

        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('blood_type', 'like', $request->keyword)
                    ->orWhere('component', 'like',  $request->keyword)
                    ->orWhere('quantity', 'like', $request->keyword);
            });
        }

        // Fetch all matching records
        $bloodRequests = $query->paginate(10);

        return response()->json($bloodRequests);
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

        $userId = $request->user()->id ?? $request->user()->user_id;

        $organization = Organization::find($userId);

        $query = BloodRequest::where(function ($query) use ($userId, $organization) {
            $query->where('user_id', $userId)
                ->orWhere('receiver_id', $userId);

            // Add organization check only if it exists
            if ($organization) {
                $query->orWhere('receiver_id', $organization->org_id);
            }
        })->orderBy('created_at', 'desc');

        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('blood_type', 'like', $request->keyword)
                    ->orWhere('component', 'like',  $request->keyword)
                    ->orWhere('quantity', 'like', $request->keyword);
            });
        }

        // Fetch all matching records
        $bloodRequests = $query->get();

        return response()->json($bloodRequests);
    }
    /**
     * Stream updates for blood requests in real-time using Server-Sent Events.
     */
    public function stream(Request $request)
    {
        // Set unlimited execution time
        set_time_limit(0);  // This will allow the script to run indefinitely

        // Ensure the user is authenticated
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the user ID
        $userId = $request->user()->id ?? $request->user()->user_id;

        // Return the streaming response
        return response()->stream(function () use ($userId) {
            try {
                while (true) {
                    // Fetch updates for the user (you may want to customize the query)
                    $updates = BloodRequest::where('user_id', $userId)
                        ->orWhere('status', 'Pending')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    Log::info('Fetched ID:', ['updates' => json_encode($updates)]);

                    // Check if updates are empty or not and send appropriate data
                    if ($updates->isEmpty()) {
                        echo "data: dasdasd \n\n"; // Send empty object if no updates
                    } else {
                        // Send the updates data as JSON
                        echo "data: " . json_encode($updates) . "\n\n";
                    }

                    // Flush the output buffer to send data to the client
                    flush();

                    // Exit if the client disconnects
                    if (connection_aborted()) {
                        break;
                    }

                    // Sleep to reduce server load (every 5 seconds)
                    sleep(2);
                }
            } catch (\Exception $e) {
                Log::error('SSE Stream Error: ' . $e->getMessage());
                echo "data: {\"error\": \"An error occurred while streaming data.\"}\n\n";
                ob_flush();
                flush();
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Access-Control-Allow-Origin' => '*',  // Allow any origin or specify a specific one
            'Access-Control-Allow-Methods' => 'GET', // Specify allowed methods
            'Access-Control-Allow-Headers' => 'Content-Type', // Allow necessary headers
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestBloodRequest $request)
    {
        // Retrieve the validated input data
        $validated = $request->validated();

        // Create the blood request
        $bloodRequest = BloodRequest::create($validated);

        // Retrieve organization details
        $organization = Organization::where('org_id', $validated['receiver_id'])->first();

        $organizationName = Organization::find($validated['user_id']);

        // Send email to the receiver (organization)
        Mail::to($organization->org_email)->send(new BloodRequestMail($bloodRequest, $organizationName->org_name));

        return response()->json($bloodRequest, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return BloodRequest::findOrFail($id);
    }

    /**
     * Update the event of the specified resource in storage.
     */
    public function update(RequestBloodRequest $request, string $id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);

        // Check if the request was created more than 3 minutes ago
        $threeMinutesAgo = Carbon::now()->subMinutes(3);
        if ($bloodRequest->created_at < $threeMinutesAgo) {
            return response()->json(['error' => 'Cannot update a blood request after 3 minutes.'], 403);
        }

        // Retrieve the validated input data...
        $validated = $request->validated();

        $bloodRequest->blood_type =  $validated['blood_type'];
        $bloodRequest->component =  $validated['component'];
        $bloodRequest->urgency_scale =  $validated['urgency_scale'];
        $bloodRequest->quantity =  $validated['quantity'];

        $bloodRequest->save();

        return response()->json($bloodRequest);
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(RequestBloodRequest $request, string $id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $bloodRequest->status =  $validated['status'];

        $bloodRequest->save();

        return $bloodRequest;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bloodRequest = BloodRequest::FindOrFail($id);
        $bloodRequest->delete();
        return $bloodRequest;
    }
}
