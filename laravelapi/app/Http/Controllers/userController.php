<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\userReg;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class userController extends Controller
{
    //register api
    public $successStatus = 200;

    public function registerForNotification(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
           'category'=>'required'
        ]);
        $results = DB::select('select category_id from category');
        
        if ($validator ->fails() && !in_array($validator['category'], $results )){
            return response()->json(['error'=>$validator->errors()], 401);
            }
        $input = $request->all();
        $user = userReg::Create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
         
        $success['name'] =  $user->name;
    return response()->json(['success'=>$success], $this-> successStatus);
    
    }

    
    


}
