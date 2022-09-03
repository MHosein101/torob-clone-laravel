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
        $user = User::where('email_or_number', '=', $request->input('email_or_number'))->first();
        $verificationCode = Str::random(5);
        $isSignUp = false;
        $code = 200;
        $message = 'Ok , Waiting for verification.';

        if ($user === null) { // user not exists
            $code = 201;
            $message = 'New account created , Waiting for verification.';
            $isSignUp = true;
            $user = User::create([ 'email_or_number' => $request->input('email_or_number') ]);
        }

        // user already have api token
        if($user->api_token != '') return;

        // user exists
        $user->verification_code = $verificationCode;
        $user->save();

        return response()->json([
            'message' => $message ,
            'is_signup' => $isSignUp ,
            'verification_code' => $verificationCode , // FOR DEBUG
        ], $code);

        // SEND EMAIL HERE
        // Mail::to($request->input('email_or_number'))->send(new UserVerification($verificationCode));

    }

    public function verification(Request $request)
    {
        $user = User::where('email_or_number', '=', $request->input('email_or_number'))->first();
        
        // user already have api token
        if($user->api_token != '') return;

        if( $user->verification_code == $request->input('verification_code') ) { // verification ok
            
            $user->generateAuthToken();
            $user->verification_code = "";
            $user->save();

            return response()->json([
                'message' => 'Login successful.' ,
                'API_TOKEN' => $user->api_token
            ], 200);
        }
        else { // verification not ok
            return response()->json([
                'code' => 401 ,
                'message' => 'Login failed.'
            ], 401);
        }
    }

    
    public function cancel(Request $request)
    {
        if($request->input('is_signup') == true) {
            User::where('email_or_number', '=', $request->input('email_or_number'))->delete();
            
            return response()->json([
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
            'message' => 'Logged out successfully.'
        ], 200);
    }
}
