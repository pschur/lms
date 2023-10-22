<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ApiAuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only(['username', 'password']);

        if(!auth()->once($credentials)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = auth()->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    public function me(Request $request){
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
        ]);

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

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ]);
    }
}
