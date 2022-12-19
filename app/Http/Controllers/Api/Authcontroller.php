<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Authcontroller extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $token = $user->createToken('Blog')->accessToken;
        return ResponseHelper::success($token);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required||email',
            'password'=>'required'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = auth()->user();
            $token = $user->createToken('Blog')->accessToken;
            return ResponseHelper::success($token);
        }
    }

    public function logout(Request $request){
        auth()->user()->token()->revoke();
        return ResponseHelper::success([],'Successfully Logout');
    }
}
