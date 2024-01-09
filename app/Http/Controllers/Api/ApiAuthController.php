<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    //
    function login(LoginRequest $request)
    {
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
        return  new LoginResource([
            'token' => $token,
        ]);
    }
}
