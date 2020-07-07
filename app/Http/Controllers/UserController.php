<?php

namespace App\Http\Controllers;

use App\User;
use App\NotificationModel;
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
			        	->json([
                            "success" => "false",
                            "message" => "Email already exists",
                            "error" => [
                                "status_code" => "400",
                                "message" => "Email already exists"
                            ]
                        ], 400);
				}

		        if ( $user->save() ) {

			        return response()
			        	->json([
                            "success" => "true",
                            "message" => "New User Created",
                            "data" => $user
                        ], 201);
		        } else {

			        return response()
			        	->json([
                            "success" => "false",
                            "message" => "Internal Server Error. Please try again",
                            "error" => [
                                "status_code" => "500",
                                "message" => "Internal Server Error. Please try again"
                            ]
                        ], 500);
		        }
    		} else {

    			return response()
		        	->json([
                        "success" => "false",
                        "message" => "Required parameters not given",
                        "error" => [
                            "status_code" => "400",
                            "message" => "Required parameters not given"
                        ]
                    ], 400);
    		}
    	} catch (Exception $e) {

    		return response()
	        	->json([
                    "success" => "false",
                    "message" => "Internal Server Error",
                    "error" => [
                        "status_code" => "500",
                        "message" => "Internal Server Error"
                    ]
                ], 500);
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
	            			->json([
                                "success" => "true",
                                "message" => "User Details Successfully Retrieved",
                                "data" => $user_details
                            ], 200);
    				} else {

	            		return response()
	            			->json([
                                "success" => "false",
                                "message" => "Incorrect Recovery Password",
                                "error" => [
                                    "status_code" => "400",
                                    "message" => "Incorrect Recovery Password"
                                ]
                            ], 400);
    				}
    			} else {

    				return response()
            			->json([
                            "success" => "false",
                            "message" => "User not found",
                            "error" => [
                                "status_code" => "404",
                                "message" => "User not found"
                            ]
                        ], 404);
    			}
    		} else {

    			return response()
		        	->json([
                        "success" => "false",
                        "message" => "Required parameters not given",
                        "error" => [
                            "status_code" => "400",
                            "message" => "Required parameters not given"
                        ]
                    ], 400);
    		}
    	} catch (Exception $e) {

    		return response()
	        	->json([
                    "success" => "false",
                    "message" => "Internal Server Error",
                    "error" => [
                        "status_code" => "500",
                        "message" => "Internal Server Error"
                    ]
                ], 500);
    	}
    }

}
