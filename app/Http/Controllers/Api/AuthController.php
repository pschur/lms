<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],

            'client_id' => ['required', 'string', 'max:255'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $credentials = $request->only(['username', 'password']);

        $token_name = Client::findOrFail($request->client_id)->name;

        if(!auth()->once($credentials)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        if ($request->has('device_name')){
            $token_name = $request->device_name.': ['.$token_name.']';
        }

        $token = auth()->user()->createToken($token_name, ['*']);

        return response()->json([
            'access_token' => $token->plainTextToken,
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    public function user(Request $request){
        return response()->json($request->user());
    }

    public function refresh(Request $request){
        $token = $request->user()->currentAccessToken()->refresh();

        return response()->json([
            'access_token' => $token
        ]);
    }

    public function register(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            'client_id' => ['required', 'string', 'max:255'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $token_name = Client::findOrFail($request->client_id)->name;

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'code' => uniqid(),
        ]);

        if ($request->has('school_code')){
            $school = School::where('code', $request->school_code)->first();
        } elseif ($request->has('school_id')){
            $school = School::find($request->school_id);
        }

        if (isset($school)){
            $user->school()->associate($school);
            $user->save();
        }

        if ($request->has('device_name')){
            $token_name = $request->device_name.': ['.$token_name.']';
        }

        $token = $user->createToken($token_name, ['*']);

        return response()->json([
            'access_token' => $token->plainTextToken,
        ]);
    }
}
