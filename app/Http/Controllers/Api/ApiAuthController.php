<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    //
    function login(Request $request)
    {

        //validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // check if user exists
        $user = User::where('email', $request->email)->first();

        //check if password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'massage' => 'Bad credentials'
            ], 401);
        }

        //generate token
        $token = $user->createToken('token')->plainTextToken;

        //return response json
        return response()->json([
            'token' => $token,
        ], 200);
    }
}
