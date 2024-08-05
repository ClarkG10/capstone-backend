<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestBloodRequest;
use Illuminate\Http\Request;
use App\Models\BloodRequest;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bloodRequest = BloodRequest::where('user_id', $request->user()->id);

        if ($request->keyword) {
            $bloodRequest->where(function ($query) use ($request) {
                $query->where('blood_type', 'like', '%' . $request->keyword . '%')
                    ->orWhere('component', 'like', '%' . $request->keyword . '%')
                    ->orWhere('quantity', 'like', '%' . $request->keyword . '%');
            });
        }

        return $bloodRequest->paginate(5);
    }


    /**
     * Display a listing of the resource.
     */
    public function report(Request $request)
    {
        return BloodRequest::where('user_id', $request->user()->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestBloodRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $bloodRequest = BloodRequest::create($validated);

        return $bloodRequest;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return BloodRequest::findOrFail($id);
    }


    /**
     * Update the status of the specified resource in storage.
     */
    public function updateStatus(RequestBloodRequest $request, string $id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $bloodRequest->status =  $validated['status'];

        $bloodRequest->save();

        return $bloodRequest;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bloodRequest = BloodRequest::FindOrFail($id);
        $bloodRequest->delete();
        return $bloodRequest;
    }
}
