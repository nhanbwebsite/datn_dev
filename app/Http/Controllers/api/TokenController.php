<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    protected $permission = [];
    public function createToken(Request $request){
        $request->vqalidate([
            'username' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('phone', '=', $request->phone)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
               'status' => false,
               'message' => 'Invalid'
            ],422);
        }

        $token = $user->createToken($request->TokenName,$this->permission)->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }
}
