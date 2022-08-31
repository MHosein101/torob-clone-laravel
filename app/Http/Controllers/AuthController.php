<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->first();
        $validationCode = Str::random(5);

        if ($user === null) { // user not exists
           $newUser = new User;
           $newUser->email = $request->input('email');
           $newUser->validatoin_code = $validationCode;
           $newUser->save();

            return response()->json([
                'code' => 201 ,
                'message' => 'User created , waiting for validation.' ,
                'isSignup' => true
            ], 201); 
        }

        // user already have api token
        if($user->api_token != '') return;

        // user exists
        $user->validatoin_code = $validationCode;
        $user->save();

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok , Waiting for validation.' ,
            'isSignup' => false
        ], 200);

        // SEND EMAIL HERE

    }

    public function validation(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->first();
        
        if( $user->validatoin_code == $request->input('validation_code') ) { // validation ok
            
            $user->generateAuthToken();
            $user->validatoin_code = "";
            $user->save();

            return response()->json([
                'code' => 200 ,
                'message' => 'Login successful.' ,
                'API_TOKEN' => $user->api_token
            ], 200);
        }
        else { // validation not ok
            return response()->json([
                'code' => 401 ,
                'message' => 'Login failed.'
            ], 401);
        }
    }

    
    public function cancel(Request $request)
    {
        if($request->input('isSignup') == true) {
            User::where('email', '=', $request->input('email'))->delete();
            return response()->json([
                'code' => 200 ,
                'message' => 'Record removed.'
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json([
            'code' => 200 ,
            'message' => 'Logged out successfully.'
        ], 200);
    }
}
