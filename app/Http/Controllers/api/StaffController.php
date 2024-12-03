<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;


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
     * Display a listing of the resource.
     */
    public function indexAll(Request $request)
    {
        $query = Staff::query();

        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('fullname', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%');
            });
        }

        $staff = $query->get();

        return $staff;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

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
    public function updateRole(StaffRequest $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        // Retrieve the validated input data...
        $validated = $request->validated();

        $staff->role =  $validated['role'];

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
