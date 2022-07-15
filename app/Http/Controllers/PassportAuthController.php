<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'max:30', 'min:8', 'confirmed']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        $token = $user->createToken('authToken')->accessToken;
 
        return response()->json([
            'token' => $token
        ], 200);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(auth()->attempt($data))
        {
            $token = auth()->user()->createToken(auth()->user()->email." authToken ".now())->accessToken;
            return response()->json([
                'token' => $token
            ], 200);
        }
        else
        {
            return response()->json([
                'error' => 'Unauthorised'
            ], 401);
        }
    }
}
