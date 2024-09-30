<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inventory = Inventory::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->paginate(8);

        return $inventory;
    }

    /**
     * Display a listing of the resource.
     */
    public function report(Request $request)
    {
        return Inventory::where('user_id', $request->user()->id)->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function inventoryIndex()
    {
        return Inventory::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $inventory = Inventory::create($validated);

        return $inventory;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inventory::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryRequest $request, string $id)
    {
        $validated = $request->validated();

        $inventory = Inventory::FindOrFail($id);

        $inventory->update($validated);

        return $inventory;
    }

    /**
     * Update the blood units of the specified resource in storage.
     */
    public function bloodUnits(InventoryRequest $request, string $id)
    {
        $inventory = Inventory::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $inventory->avail_blood_units =  $validated['avail_blood_units'];

        $inventory->save();

        return $inventory;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);

        // Delete related stock_in and stock_out records
        $inventory->stockIn()->delete();
        $inventory->stockOut()->delete();

        // Delete the inventory record
        $inventory->delete();

        return response()->json(['message' => 'Inventory and related records deleted successfully']);
    }
}
