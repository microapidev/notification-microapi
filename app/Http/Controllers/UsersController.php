<?php

namespace App\Http\Controllers;

use App\UsersModel;
use App\NotificationsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function createUser(Request $request) {

    	try {

            $user = new UsersModel;
            $user->user_unique_id = Str::random(50);

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
