<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User as user;
use Auth;
use Session;
use Exception;
class LoginController extends Controller
{
    
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	 public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
	
	  public function handleProviderCallback()
    {
        
         try{ 
             $user = Socialite::driver('facebook')->user();

		 $id =   $user->getId();
		 $name = $user->getName();
		 $email= $user->getEmail();

		$has_login_by_fb = user::firstOrCreate(['fb_id'=>$id],['name'=>$name,'email'=>$email,'is_verified'=>1]);
		  
		Auth::login($has_login_by_fb,true);
		  
		 return redirect($this->redirectTo) ;
	 }
	 
	 catch(Exception $e){
	            Session::flash('success','يوجد خطأ في الدخول حاول مرة اخرى ﻻحقاً');
	    		 return redirect()->route('main') ;

	 }
	 
        
    }
	
}
