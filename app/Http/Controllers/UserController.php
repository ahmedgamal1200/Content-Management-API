<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'phone'=> 'required|string|max:255|unique:users,phone',
            'password'=>'required|string|min:8|confirmed'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password)
        ]);
        return response()->json([
            'message'=>'User Registered Successfully',
            'User'=> $user
            
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);
    
        if (Auth::attempt($request->only('phone', 'password'))) {
            // تسجيل الدخول ناجح
            $user = User::where('phone', $request->phone)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'message' => 'Login Successful',
                'user' => $user,
                'token' => $token,
            ], 200);
        }
    
        // إذا فشل تسجيل الدخول
        return response()->json([
            'message' => 'Invalid phone or password',
        ], 401);
    }
    

    public function logout(Request $request)
    {   
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout Successful']);
    }

}