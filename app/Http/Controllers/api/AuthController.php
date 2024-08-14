<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login using the specified resource.
     */
    public function login(UserRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $staff = Staff::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return $this->createTokenResponse($user, 'user');
        }

        if ($staff && Hash::check($request->password, $staff->password)) {
            return $this->createTokenResponse($staff, 'staff');
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

    /**
     * Logout using the specified resource.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $response = [
            'message' => 'Logout.'
        ];

        return $response;
    }
}
