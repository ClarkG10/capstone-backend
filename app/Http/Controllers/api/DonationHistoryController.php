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
        // Retrieve the validated input data
        $validated = $request->validated();

        // Check if the request has a file for 'laboratory_attachment'
        if ($request->hasFile('laboratory_attachment')) {
            // Store the file in the 'Laboratory_report' directory within the 'public' disk
            $labPath = $request->file('laboratory_attachment')->store('Laboratory_reports', 'public');

            // Add the stored file path to the validated data
            $validated['laboratory_attachment'] = $labPath;
        }

        // Create a new DonationHistory record with the validated data
        $donationHistory = DonationHistory::create($validated);

        // Return the newly created donation history record as a response
        return response()->json($donationHistory, 201); // Returning JSON with a 201 Created status
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
