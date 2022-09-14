<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    /**
     * User try to login or signup
     *
     * @param email_or_number  email or number of user tath tried ro login or signup
     * 
     * @return Json (Object)
     */ 
    public function login(Request $request)
    {
        $user = User::where('email_or_number', $request->input('email_or_number'))->first(); // get user record
        $verificationCode = Str::random(5);
        $isSignUp = false;
        $code = 200;
        $message = 'Ok , Waiting for verification.';

        if ($user === null) { // user not exists
            $code = 201;
            $message = 'New account created , Waiting for verification.';
            $isSignUp = true;
            $user = User::create([ 'email_or_number' => $request->input('email_or_number') ]); // create user record
        }

        // user already have api token
        if($user->api_token != null)
            return response()->json([
                'message' => 'You already have API_TOKEN.'
            ], 403);

        // user exists and give it a code
        $user->verification_code = $verificationCode;
        $user->save();

        return response()->json([
            'message' => $message ,
            'verification_code' => $verificationCode , // FOR DEBUG
            'is_signup' => $isSignUp ,
        ], $code);

        // SEND EMAIL HERE
        // Mail::to($request->input('email_or_number'))->send(new UserVerification($verificationCode));

    }

    /**
     * Verify user by verification_code
     *
     * @param email_or_number  email or number of user tath tried ro login or signup
     * @param verification_code random code that we sent to user
     * 
     * @return Json (Object)
     */ 
    public function verification(Request $request)
    {
        $user = User::where('email_or_number', $request->input('email_or_number'))->first(); // get user
        
        // user already have api token
        if($user->api_token != null)
            return response()->json([
                'message' => 'You already have API_TOKEN.'
            ], 403);

        if( $user->verification_code == $request->input('verification_code') ) { // verification ok
            
            $user->generateAuthToken(); // give user an api_token

            return response()
            ->json([
                'message' => 'با موفقیت وارد شدید' ,
                'API_TOKEN' => $user->api_token
            ], 200)
            ->cookie('API_TOKEN', $user->api_token, 20160, '', '', false, true);
        }
        else { // verification not ok
            return response()->json([
                'message' => 'کد وارد شده اشتباه است'
            ], 401);
        }
    }

    
    /**
     * Remove user record or just verification_code
     *
     * @param email_or_number  email or number of user to cancel its login or signup
     * @param is_signup if new user didnt complete the sign up , check this to remove its record
     * 
     * @return Json (Object)
     */ 
    public function cancel(Request $request)
    {
        if($request->input('is_signup') == true)
            User::where('email_or_number', $request->input('email_or_number'))->delete(); // delete new user record
        else {
            User::where('email_or_number', $request->input('email_or_number'))->update([ // clear verification_code for user
                'verification_code' => null
            ]);
        }

        return response()->json([
            'message' => 'Record removed.'
        ], 200);
    }

    /**
     * Log user out from session
     *
     * @param BearerToken user api_token in Authentication header
     * 
     * @return Json (Object)
     */ 
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user(); // get loggedin user

        $user->api_token = null;
        $user->save();

        return response()->json([
            'message' => 'با موفقیت خارج شدید'
        ], 200);
    }


    /**
     * Redirect user here if they not authenticated
     *
     * @return Json
     */ 
    public function restricted(Request $request)
    {
        return response()->json([
            'message' => 'You are Unauthorized.'
        ], 401);
    }

    /**
     * Check user login cookie
     *
     * @return Json
     */ 
    public function checkCookie(Request $request)
    {
        if($request->hasCookie('cookie_name') != false) {
            
            $user = User::where('api_token', $request->cookie('API_TOKEN'));

            return response()
            ->json([
                'message' => 'Ok' ,
                'email_or_number' => $user->email_or_number ,
                'API_TOKEN' => $user->api_token
            ], 200)
            ->cookie('API_TOKEN', $user->api_token, 20160, '', '', false, true);
        }

        return response()
        ->json([
            'message' => 'You are Unauthorized'
        ], 403);
    }
}
