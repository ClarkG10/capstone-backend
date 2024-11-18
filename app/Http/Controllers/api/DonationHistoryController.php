<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationHistoryRequest;
use App\Models\DonationHistory;

class DonationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DonationHistory::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DonationHistoryRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $donationhistory = DonationHistory::create($validated);

        return $donationhistory;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donationhistory = DonationHistory::findOrFail($id);

        $donationhistory->delete();

        return $donationhistory;
    }
}
