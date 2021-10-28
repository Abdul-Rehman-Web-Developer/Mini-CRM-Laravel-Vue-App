<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UserLoginRequest;
use Auth;

class AuthController extends Controller
{

	

    /**
     * Attempt to login
     */
    public function login(UserLoginRequest $request)
    { 
    	if(Auth::attempt($request->only('email','password'))){
    		return response()->json(Auth::user(),200);
    	}

  		return response()->json([
			'email' => ['The provided credentials are incorrect.']
		],422);  
       
    }

    /**
     * Attempt to logout
     */

    public function logout()
    {
    	Auth::logout();
    }

}
