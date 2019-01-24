<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Verification;
use App\User as user;
use Session as session;
class EmailVerification extends Controller
{
    public function send_code()
    {
    	if(is_null(session::get('code'))){
			
		$rand_code = rand(1000,10000);
		
        $code = session(['code'=>$rand_code]);
        
		$code = session::get('code');

        //get user email
        $email = Auth::user()->email;
		
       	Mail::to($email)->send(new Verification($code));
       
        return view('email.insertcode',['error'=>false]);
		
		}
		else{
		
			return view('email.insertcode',['error'=>false]);

		}
    }

    public function verify_code(Request $request)
    {
    	$current_user = user::findOrFail(Auth::id());	
		
		$request->validate(['code'=>'required']);
		
		$code = session::get('code');
		
		if($code != $request->code){

        return view('email.insertcode',['error'=>true]);

		}
		
		$current_user->is_verified = 1;
		
		$current_user->save();
		
		return redirect()->route('home');
    
    }
}
