<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Staff;
use App\Models\Donor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $staff = Staff::where('email', $request->email)->first();
        $donor = Donor::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return $this->createTokenResponse($user, 'user');
        }
        if ($staff && Hash::check($request->password, $staff->password)) {
            return $this->createTokenResponse($staff, 'staff');
        }
        if ($donor && Hash::check($request->password, $donor->password)) {
            return $this->createTokenResponse($donor, 'donor');
        }
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    protected function createTokenResponse($user, $type)
    {
        return response()->json([
            'user'  => $user,
            'token' => $user->createToken($user->email)->plainTextToken,
            'type'  => $type,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful.',
        ]);
    }
}
