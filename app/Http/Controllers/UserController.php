<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use \Validator;

class UserController extends Controller
{
    //
    public function Register(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);
        if($validate->fails()){
            return response()->json([
                'code' => 201,
                'data' => null,
                'message' => "User could not registered successfully"
            ]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_token' => Hash::make($request->name . $request->ip()),
            'user_type' => $request->user_type
        ]);

        return response()->json([
            'code' => 200,
            'data' => $user,
            'message' => "User registered successfully"
        ]);
        
    }
    public function Login(Request $request){
        $user = User::query()->where('email', '=', $request->email)->first();
        
        if($user != null && Hash::check($request->password,$user->password)){
            return response()->json([
                'code' => 200,
                'data' => $user,
                'message' => "User logged in successfully"
            ]);
        }
        return response()->json([
            'code' => 401,
            'data' => null,
            'message' => "User could not login successfully, wrong password or email."
        ]);
        
    }

    public function VerifyToken(Request $request){
        $user = User::query()->where('user_token', '=', $request->token)->first();
        if($user != null){
            return response()->json([
                'code' => 200,
                'data' => $user,
                'message' => "User Token Verified Correctly"
            ]);
        }
        return response()->json([
            'code' => 401,
            'data' => null,
            'message' => "User Token Could Not be Verified Correctly"
        ]);
    }
}
