<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveBloodRequest;
use App\Models\ReserveBlood;
use Illuminate\Http\Request;


class ReserveBloodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the user_id based on whether the authenticated user is a staff member or regular user
        $userId = $request->user()->user_id ?? $request->user()->id; // Fallback to `id` if `user_id` is not present

        // Fetch inventory where the user_id matches
        $reserveblood = ReserveBlood::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return $reserveblood;
    }


    /**
     * Display a listing of the resource.
     */
    public function report(Request $request)
    {
        // Get the user_id based on whether the authenticated user is a staff member or regular user
        $userId = $request->user()->user_id ?? $request->user()->id; // Fallback to `id` if `user_id` is not present

        // Fetch all inventory records where user_id matches
        return ReserveBlood::where('user_id', $userId)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReserveBloodRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $reserveblood = ReserveBlood::create($validated);

        return $reserveblood;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ReserveBlood::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ReserveBloodRequest $request, string $id)
    {
        $validated = $request->validated();

        $reserveblood = ReserveBlood::FindOrFail($id);

        $reserveblood->update($validated);

        return $reserveblood;
    }

    /**
     * Update the blood units of the specified resource in storage.
     */
    public function bloodUnits(ReserveBloodRequest $request, string $id)
    {
        $reserveblood = ReserveBlood::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $reserveblood->avail_blood_units =  $validated['avail_blood_units'];

        $reserveblood->save();

        return $reserveblood;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserveblood = ReserveBlood::findOrFail($id);

        // Delete related stock_in and stock_out records
        $reserveblood->stockIn()->delete();
        $reserveblood->stockOut()->delete();

        // Delete the inventory record
        $reserveblood->delete();

        return response()->json(['message' => 'Inventory and related records deleted successfully']);
    }
}
