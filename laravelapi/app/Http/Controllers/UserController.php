<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function createUser(Request $request) {

    	try {

    		if ( $request->email != "" && $request->recovery_password != "" ) {

		        $user = new User;
		        $user->email = $request->email;
		        $user->recovery_password = $request->recovery_password;
		        $user->user_unique_id = Str::random(70);

				if ( User::where('email', $user->email)->exists() ){

					return response()
			        	->json([ "status" => "false", "message" => "Email already exists" ], 500);
				}

		        if ( $user->save() ) {

			        return response()
			        	->json([ "status" => "true", "message" => "New User Created" ], 201);
		        } else {

			        return response()
			        	->json([ "status" => "false", "message" => "Internal Server Error. Please try again" ], 500);
		        }
    		} else {

    			return response()
		        	->json([ "status" => "false", "message" => "Required parameters not given" ], 400);
    		}
    	} catch (Exception $e) {

    		return response()
	        	->json([ "status" => "false", "message" => "Internal Server Error" ], 500);
    	}
    }

    public function getUser($email, $recovery_password) {

    	try {

    		if ( $email != "" && $recovery_password != "") {

    			if ( User::where('email', $email)->exists() ) {

    				$user_details = User::where('email', $email)->where('recovery_password', $recovery_password)->first();

    				if ( $user_details ) {

    					$user_details = User::where('email', $email)->get();
    					return response()
	            			->json([ "status" => "false", "message" => "User Details Successfully Retrieved", "data" => $user_details ], 200);
    				} else {

	            		return response()
	            			->json([ "status" => "false", "message" => "Incorrect Recovery Password" ], 400);
    				}
    			} else {

    				return response()
            			->json([ "status" => "false", "message" => "User not found" ], 404);
    			}
    		} else {

    			return response()
		        	->json([ "status" => "false", "message" => "Required parameters not given" ], 400);
    		}
    	} catch (Exception $e) {

    		return response()
	        	->json([ "status" => "false", "message" => "Internal Server Error" ], 500);
    	}
    }
}
