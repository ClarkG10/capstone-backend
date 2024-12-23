<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonorRequest;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class DonorController extends Controller
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

        $donorQuery = Donor::where('user_id', $userId)->orderBy('created_at', 'desc');

        if ($request->keyword) {
            $donorQuery->where(function ($query) use ($request) {
                $query->where('fullname', 'like', '%' . $request->keyword . '%')
                    ->orWhere('address', 'like', '%' . $request->keyword . '%')
                    ->orWhere('gender', 'like', $request->keyword)
                    ->orWhere('blood_type', 'like', $request->keyword);
            });
        }

        // Return paginated results
        return response()->json($donorQuery->paginate(6));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Donor::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     */
    public function report(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $userId = $request->user()->id ?? $request->user()->user_id;

        $donors = Donor::where('user_id', $userId)->get();

        return response()->json($donors);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(DonorRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $donor = Donor::create($validated);

        return $donor;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(DonorRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = Donor::create($validated);

        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DonorRequest $request, string $id)
    {
        $donor = Donor::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $donor->update($validated);

        return $donor;
    }

    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(DonorRequest $request, string $id)
    {
        $donor = Donor::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $donor->status =  $validated['status'];

        $donor->save();

        return $donor;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donor = Donor::FindOrFail($id);
        $donor->donationHistory()->delete();
        $donor->delete();
        return $donor;
    }
}
