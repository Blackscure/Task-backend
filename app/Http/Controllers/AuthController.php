<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email_address' => 'required|email',
            'password' => 'required'
        ]);
        if ($validated->fails()) {
            return response(['message' => $validated->errors()->first()],400);
        }
        $credentials = request(['email_address', 'password']);
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('authToken')->accessToken;
            return response(['user' => $user, 'access_token' => $token]);
        }

        return response(['message' => 'Invalid Credentials'],400);
    }

    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email_address' => 'required|email',
            'password' => 'required'
        ]);
        if ($validated->fails()) {
            return response(['message' => $validated->errors()->first()],400);
        }
        $user = User::create([
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response(['message' => 'Logged out']);
    }
}
