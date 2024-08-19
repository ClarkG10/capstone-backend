<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockInRequest;
use App\Models\StockIn;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StockIn::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockInRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        $stockIn = StockIn::create($validated);

        return $stockIn;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stockIn = StockIn::FindOrFail($id);
        $stockIn->delete();
        return $stockIn;
    }
}
