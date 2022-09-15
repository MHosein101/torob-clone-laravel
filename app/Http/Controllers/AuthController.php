<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    /**
     * User try to login or signup
     *
     * @param phone_number  phone number of user that tried to login or signup
     * 
     * @return Response Json
     */ 
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [ 'phone_number' => 'required|digits_between:10,11|starts_with:09,9' ]);

        if($validator->fails())
            return response()->json([ 'message' => 'Invalid inputs.' , 'errors' => $validator->errors() ], 400);

        $user = User::where('phone_number', $request->input('phone_number'))->first(); // get user record
        
        $isSignUp = false;
        $code = 200;
        $message = 'کد تایید را وارد کنید';

        if ($user === null) { // user not exists
            $code = 201;
            $message = 'حساب شما ایجاد شد';
            $isSignUp = true;
            $user = User::create([ 'phone_number' => $request->input('phone_number') ]); // create user record
        }

        // user already have api token
        // if($user->api_token != null)
        //     return response()->json([ 'message' => 'You already have API_TOKEN.' ], 403);

        // user exists and give it a code
        $verificationCode = $user->generateVerificatioCode();

        return response()
        ->json([
            'message' => $message ,
            'verification_code' => $verificationCode , // FOR DEBUG
            'is_signup' => $isSignUp ,
        ], $code);

        // SHOULD SEND VERIFICATION CODE HERE
    }

    /**
     * Verify user by verification_code
     *
     * @param phone_number  phone number of user tath tried ro login or signup
     * @param verification_code random code that we sent to user
     * 
     * @return Response Json
     */ 
    public function verification(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [ 'phone_number' => 'required|digits_between:10,11|starts_with:09,9' ] ,
            [ 'verification_code' => 'required|digits:4' ] );

        if($validator->fails())
            return response()->json([ 'message' => 'Invalid inputs.' , 'errors' => $validator->errors() ], 400);

        
        $user = User::where('phone_number', $request->input('phone_number'))->first(); // get user
        
        if($user == null)
            return response()->json([ 'message' => 'User not found.' ], 404);

        // user already have api token
        // if($user->api_token != null)
        //     return response()->json([ 'message' => 'You already have API_TOKEN.' ], 403);

        // verification code invalid
        if( $user->verification_code != $request->input('verification_code') )
            return response()->json([ 'message' => 'کد وارد شده اشتباه است' ], 401); 
            
        // verification code is valid
        $apiToken = $user->generateApiToken(); // give user an api_token

        return response()
        ->json([
            'message' => 'با موفقیت وارد شدید' ,
            'phone_number' => $user->phone_number ,
            'API_TOKEN' => $apiToken
        ], 200);
    }

    /**
     * Redirect user here if they not authenticated
     *
     * @return Response Json
     */ 
    public function restricted(Request $request)
    {
        return response()->json([ 'message' => 'You are Unauthorized.' ], 401);
    }

    /**
     * Log user out from session
     *
     * @param BearerToken user api_token in Authorization header
     * 
     * @return Response Json
     */ 
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user(); // get loggedin user

        $user->api_token = null;
        $user->save();

        return response()->json([ 'message' => 'با موفقیت خارج شدید' ], 200);
    }
}
