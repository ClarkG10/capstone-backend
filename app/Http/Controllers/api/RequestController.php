<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestBloodRequest;
use Illuminate\Http\Request;
use App\Models\BloodRequest;
use App\Mail\BloodRequestMail;
use App\Models\Organization;
use Illuminate\Support\Facades\Mail;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Use the appropriate user_id or id
        $userId = $request->user()->user_id ?? $request->user()->id;

        // Query BloodRequest for the authenticated user (either staff or user)
        $bloodRequest = BloodRequest::where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        // Search for keyword in blood_type, component, or quantity if provided
        if ($request->keyword) {
            $bloodRequest->where(function ($query) use ($request) {
                $query->where('blood_type', 'like', $request->keyword)
                    ->orWhere('component', 'like', $request->keyword)
                    ->orWhere('quantity', 'like', $request->keyword);
            });
        }

        return $bloodRequest->paginate(5);
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

        $query = BloodRequest::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->orWhere('receiver_id', $userId);
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
     * Store a newly created resource in storage.
     */
    public function store(RequestBloodRequest $request)
    {
        // Retrieve the validated input data
        $validated = $request->validated();

        // Create the blood request
        $bloodRequest = BloodRequest::create($validated);

        // Retrieve organization details
        $organization = Organization::find($validated['receiver_id']);

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

        // Retrieve the validated input data...
        $validated = $request->validated();

        $bloodRequest->blood_type =  $validated['blood_type'];
        $bloodRequest->component =  $validated['component'];
        $bloodRequest->urgency_scale =  $validated['urgency_scale'];
        $bloodRequest->quantity =  $validated['quantity'];

        $bloodRequest->save();

        return $bloodRequest;
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
