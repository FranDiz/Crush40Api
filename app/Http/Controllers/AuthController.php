<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class AuthController extends Controller
{
    public function register (Request $request){
        $this->validate($request,[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:8',
        ]);
        $user = User::create([
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);
        $user->save();

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['message'=> 'Usuario registrado', 'token' => $token],200);
    }
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user instanceof \App\Models\User) {
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['message' => 'Login OK', 'token' => $token], 200);
            } else {
                return response()->json(['message' => 'Not logged in or incorrect user type'], 401);
            }
        } else {
            return response()->json(['message' => 'Login Error'], 401);
        }
    }
    public function user (Request $request){
        $user = $request->user();

        if($user){
            return response()->json([
                'name'=>$user->name,
                'email'=>$user->email,
                'id'=>$user->id
            ]);
        }else{
            return response()->json(['message'=>'Usuario no autenticado'],404);
        }
    }
    public function logout(){
        Auth::logout();
        return response()->json(['message'=>'Ha salido correctamente']);
    }
    //
}
