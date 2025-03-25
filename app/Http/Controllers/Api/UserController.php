<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function signUp(Request $request){
        try {
            $existingUser = User::where('username', $request->input('username'))->first();
            
            if ($existingUser) {
                return response()->json(['message' => 'Username is already taken !'], 400);
            }

            $validated = $request->validate([
                'username'=>'required|string|max:255',
                'password'=>'required|string|min:8',
                'role'=>'required|string|max:50',
            ]);
    
            $user = User::create([
                'username'=>$validated['username'],
                'password' => Hash::make($validated['password']),
                'role'=>$validated['role'],
            ]);
            return response()->json(['message'=>'User created successfully, please sign in !',
        'user'=>$user],200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function signIn (Request $request){
        try {
            $existingUser = User::where('username',$request->input('username'))->first();

            if(!$existingUser){
                return response()->json(['message'=>'User could not be found !'],404);
            }

            if (!Hash::check($request->input('password'), $existingUser->password)) {
                return response()->json(['message' => 'Password is incorrect !'], 400);
            }

            return response()->json(['message'=>'You have signed in successfully !', 'data'=>$existingUser,200]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage(),500]);
        }
    }
}
