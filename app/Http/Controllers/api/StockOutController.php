<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockOutRequest;
use App\Models\StockOut;
use Illuminate\Http\Request;

class StockOutController extends Controller
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

        $stockOut = StockOut::where('user_id', $userId)->get();

        return response()->json($stockOut);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockOutRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $stockOut = StockOut::create($validated);

        return $stockOut;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stockOut = StockOut::FindOrFail($id);
        $stockOut->delete();
        return $stockOut;
    }
}
