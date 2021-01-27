<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'names' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'required|string|confirmed',
            'email' => 'required|email|unique:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);

        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response([
            'token' => $token
        ], 200);
    }

    // public function login(Request $request) {

    // }
}
