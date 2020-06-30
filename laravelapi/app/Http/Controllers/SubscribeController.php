<?php

namespace App\Http\Controllers;
use Validator;
use App\User;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SubscribeController extends Controller
{

    public function subscribeUser(Request $request) {

        try {

            if ( $request->user_unique_id != "" && $request->notification_unique_id != "" && $request->email != "" ) {

                if ( User::where('user_unique_id', $request->user_unique_id)->exists() ){

                    if ( Notification::where('notification_unique_id', $request->notification_unique_id)->exists() ) {

                        $notification = Notification::where('notification_unique_id', $request->notification_unique_id)->first();

                        if ( $request->user_unique_id == $notification->user_unique_id ) {

                            $new_subscribed_users = array();

                            if ( $notification->subscribed_users == "" || $notification->subscribed_users == NULL ) {

                                $new_subscribed_users[] = $request->email;
                            } else {

                                $new_subscribed_users = $notification->subscribed_users;

                                // Linear Search
                                for ( $i=0; $i < sizeof($new_subscribed_users); $i++ ) {
                                    if( $new_subscribed_users[$i] == $request->email ){
                                        return response()
                                            ->json([ "success" => "false", "message" => "This Email is already subscribed to this notification" ], 200);
                                        exit(0);
                                    }
                                }

                                array_push( $new_subscribed_users, $request->email );
                            }

                            $notification->subscribed_users = $new_subscribed_users;

                            $notification->save();

                            return response()
                                ->json([ "success" => "true", "message" => "Email subscribed to this notification successful", "data" => $notification ], 200);
                        } else {

                            return response()
                                ->json([ "success" => "false", "message" => "This is not yours 😏" ], 400);
                        }
                    } else {

                        return response()
                            ->json([ "success" => "false", "message" => "Notification not found" ], 404);
                    }
                } else {

                    return response()
                        ->json([ "success" => "false", "message" => "user_unique_id not found" ], 404);
                }
            } else {

                return response()
                    ->json([ "success" => "false", "message" => "Required parameter not given" ], 400);
            }
        } catch (Exception $e) {

            return response()
                ->json([ "success" => "false", "message" => "Internal Server Error" ], 500);
        }
    }
    
    public function unsubscribeUser(Request $request) {



 		try {

 			$validator = Validator::make($request->all(),[     
				'email' => 'required|email',
                'user_unique_id'=> 'required',
				'notification_unique_id' => 'required'

 			]);

 			if ($validator ->fails()){

 				return response()->json(['error'=>$validator->errors()], 401);

 			}

 			$input = $request->all();

     		if (Notification::where('subscribed_users', $input['email'])->exists()) {

 		        DB::table('tbl_notifications')
					->where('subscribed_users', '=', $input['email'])
					->delete();
					return response()
					->json([ "status" => "True", "message" => "User successfully unsubscribe" ], 201);
			}else{
				return response()
					->json([ "status" => "false", "message" => "Email could not be found" ], 500);
			}

     	} catch (Exception $e) {

     		return response()
	        	->json([ "status" => "false", "message" => "Internal Server Error" ], 500);
    	}
    }
