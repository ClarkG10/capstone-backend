<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Staff::where('user_id', $request->user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $staff = Staff::create($validated);

        return $staff;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return staff::FindorFail($id);
    }

    /**
     * Update the role specified resource in storage.
     */
    public function updateRole(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $staff->role =  $validated['role'];

        $staff->save();

        return $staff;
    }

    /**
     * Update the status specified resource in storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $staff->status =  $validated['status'];

        $staff->save();

        return $staff;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = Staff::FindOrFail($id);
        $staff->delete();
        return $staff;
    }
}
