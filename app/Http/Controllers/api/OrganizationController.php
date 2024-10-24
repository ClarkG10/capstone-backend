<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $userId = $request->user()->id ?? $request->user()->user_id;

        $organizations = Organization::where('user_id', $userId)->get();

        return response()->json($organizations);
    }

    /**
     * Display a listing of the resource.
     */
    public function organizationIndex()
    {
        return Organization::all();
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(OrganizationRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $organization = Organization::create($validated);

        return $organization;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Organization::findOrFail($id);
    }


    /**
     * Update the organization information of the specified resource in storage.
     */
    public function updateOrganization(OrganizationRequest $request, string $id)
    {
        $organization = Organization::findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');

            $validated['image'] = $imagePath;
            $organization->image = $validated['image'];
        }

        $organization->org_name = $validated['org_name'];
        $organization->org_email = $validated['org_email'];
        $organization->description = $validated['description'];
        $organization->country = $validated['country'];
        $organization->city = $validated['city'];
        $organization->address = $validated['address'];
        $organization->zipcode = $validated['zipcode'];
        $organization->operating_hour = $validated['operating_hour'];
        $organization->contact_info = $validated['contact_info'];

        $organization->save();

        return $organization;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $organization = Organization::FindOrFail($id);
        $organization->delete();
        return $organization;
    }
}
