<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth ;
use App\User as user ;
use App\Role as role ; 
use App\Ad as ads ;
use Session as session;
use Img as imgs ;
use App\Notifications\AdsApproved;
use Storage as storage;
use App\Report as report;
use App\Mail\ReplyReprt;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
   
	
	
    public function index()
    {
		$current_user = Auth::user();
		
        $current_user_role = $current_user->roles()->get();
		
		$roles = array();
		
		foreach($current_user_role as $role):
			
				array_push($roles,$role->pivot->role_id);
				
		endforeach;
		
		return view('users.cpanel',['roles'=>$roles]);
		
    }

    
	public function cpanel()
    {
        
		$current_user = Auth::user();
		
        $current_user_role = $current_user->roles()->get();
		
		$roles = array();
		
		$all_roles = role::all();
		
		$all_users = user::paginate(100);
		
		foreach($current_user_role as $role):
			
				array_push($roles,$role->pivot->role_id);
				
		endforeach;
		
		
		
		
		
		if(in_array(4,$roles)){
	
		return view ('users.cpanel.users',['users'=>$all_users,'roles'=>$roles,'all_roles'=>$all_roles]);
			
		}
		else{
			
			return redirect()->route('user.home');
		}
		
    }
	
	
	public function discuss()
    {
        
		$current_user = Auth::user();
		
        $current_user_role = $current_user->roles()->get();
		
		$roles = array();
		
		foreach($current_user_role as $role):
			
				array_push($roles,$role->pivot->role_id);
				
		endforeach;
		
		$all_users = user::orderBy('created_at','desc')->get();
		
		if(in_array(2,$roles) || in_array(3,$roles)|| in_array(4,$roles)){
	
		$reports = report::orderBy('created_at','desc')->paginate(100);
			
			
		return view ('users.cpanel.discuss',['users'=>$all_users,'roles'=>$roles,'reports'=>$reports]);
			
		}
	
		return redirect()->route('home');
		
    }

	public function ads (){
		
		$current_user = Auth::user();
		
        $current_user_role = $current_user->roles()->get();
		
		$roles = array();
		
		foreach($current_user_role as $role):
			
				array_push($roles,$role->pivot->role_id);
				
		endforeach;
		
		
		if(in_array(3,$roles)|| in_array(4,$roles))
		{
			$all_ads = ads::orderBy('created_at','desc')->paginate(100);
		return view('users.cpanel.ads',['ads'=>$all_ads]);
		}
				return redirect()->route('home');
		
		
	}
	
	public function approve_ad(Request $request,$id){
		
		
		
		$current_ad = ads::findOrFail($id);
		
		$request->validate([
			'title'=>'required',
			'address'=>'required',
			'content'=>'required',
			'tags'=>'nullable',
			'is_approved'=>'nullable'
		]);
		
		$is_approved = $request->is_approved ? 1 : 0;
	

		
		$current_ad->title = $request->title;
		$current_ad->address = $request->address;
		$current_ad->content = $request->content;
		$current_ad->tags = $request->tags;
		$current_ad->is_approved = $is_approved;
		
		
		$current_ad->save();
		
		Session::flash('success','تم بنجاح');

		if ($is_approved) {
		
		$ads_publisher = user::findOrFail( ads::findOrFail($id)->user->id);

		$msg = 'تهانينا ! تمت الموافقة على اعلانك';

				$ads_publisher->notify(new AdsApproved($msg,$id,$current_ad->title));
			}
		
		return redirect()->back();
	}
	
	public function cancel_ad($id){
		
		$current_ad = ads::findOrFail($id);
		
			
		$count_imgs = $current_ad->imgs()->get();
		
		
		
		foreach($count_imgs as $img):
		
	
				storage::delete(str_replace('storage/','public/',$img->path))	;
		
		endforeach;
		
	
		
		$current_ad->imgs()->delete();	
		
		$current_ad->delete();
	
		
		
		session::flash('success','تمت ازالة الاعلان بنجاح');
		
		return redirect()->back();
		
		
	}
    
	public function store(Request $request)
    {
        //
    }
    
	public function show($id)
    {
        //
    }
	
    public function update(Request $request, $id)
    {
        
		$current_user = user::findOrFail($id);
		
		$request->validate([
			'name'=>'required',
			'email'=>'required|email',
			'password'=>'required',
		]);
		
		
		$current_user->name = $request->name;
		
		$current_user->email = $request->email;
		
		$current_user->original_password = $request->password;
		
		$current_user->password = bcrypt($request->password);
		
		$roles = $request->roles;
		
		$current_user->roles()->sync($roles);
		
		$current_user->save();
		
		
		return redirect()->route('cpanel');
    }
    public function destroy($id)
    {
        $current_user = user::findOrFail($id);
		
		
		//dd($current_user->roles()->get());
		
		$user_roles = array();
		
		
		foreach($current_user->roles as $role):
		
			array_push($user_roles,$role->pivot->role_id);
		endforeach;
		
		if(in_array(4,$user_roles)){
			
		return redirect()->back();

		}
		//delete ads
		$ads = $current_user->ads()->delete();
		
		//delete comments
		$comments = $current_user->comments()->delete();
		
		//delete roles		
		$roles = $current_user->roles()->detach();
		
		//delete account
		$current_user->delete();
		
		return redirect()->back();
		
    }
	
	public function edit_my_data(Request $request){
		
		$current_user = Auth::user();
		
		
		if($current_user->email == $request->email){
			
			$email_valid = "required|email";
			
		}
		else{
			$email_valid = "required|email|unique:users,email";
		}
		if($current_user->facebook_id){
		
		$request->validate([
			'username'=>'required',
			'email'=>$email_valid,
			'password'=>'nullable',
		]);
		
		}
		
		else{
			
		$request->validate([
			'username'=>'required',
			'email'=>$email_valid,
			'password'=>'required',
		]);
		
		}
		
		$current_user->name = $request->username;
		$current_user->email = $request->email;
		$current_user->password = bcrypt($request->password);
		$current_user->original_password = $request->password;
		
		$current_user->save();
		
		Session::flash('success','تم تعديل البيانات بنجاح');
		return redirect()->route('home');
	}
	
	public function my_ads(){
		return view('ads.my_ads');
	}
	
	public function reply_to_report(Request $request,$reporter_id){
		
		$request->validate([
			
			'reply'=>'required'
		]);
	
		
		$reporter_email = user::findOrFail($reporter_id)->email;
		
		($reporter_email);

		Mail::to($reporter_email)->send(new ReplyReprt($request->reply));
		
		session::flash('success','تم ارسال الرد بنجاح');
		return redirect()->back();
	
	}
}
