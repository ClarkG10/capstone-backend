<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Donor::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function report(Request $request)
    {
        return Donor::where('user_id', $request->user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $donor = Donor::create($validated);

        return $donor;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Donor::FindorFail($id);
    }

    /**
     * Update the role specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $donor = Donor::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $donor->fullname =  $validated['fullname'];
        $donor->birthday =  $validated['birthday'];
        $donor->gender =  $validated['gender'];
        $donor->address =  $validated['address'];
        $donor->email =  $validated['email'];
        $donor->phonenumber =  $validated['phonenumber'];
        $donor->blood_type =  $validated['blood_type'];
        $donor->medical_history =  $validated['medical_history'];
        $donor->current_medications =  $validated['current_medications'];
        $donor->allergies =  $validated['allergies'];
        $donor->previous_donation =  $validated['previous_donation'];
        $donor->emergency_name =  $validated['emergency_name'];
        $donor->emergency_relationship =  $validated['emergency_relationship'];
        $donor->emergency_phonenumber =  $validated['emergency_phonenumber'];

        $donor->save();

        return $donor;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donor = Donor::FindOrFail($id);
        $donor->delete();
        return $donor;
    }
}
