<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth ;
use Session as session;
use Storage as storage;
use App\User as user;
use App\Role as role;
use App\Category as category;

class CategoryController extends Controller
{
	
	
public function index(){
		
		$current_user = Auth::user();
		
        $current_user_role = $current_user->roles()->get();
		
		$roles = array();
		
		$all_roles = role::all();
		
		$all_categories = category::orderBy('created_at','desc')->paginate(100);
		
		foreach($current_user_role as $role):
			
				array_push($roles,$role->pivot->role_id);
				
		endforeach;
			
		
		if(in_array(4,$roles) || in_array(3,$roles)){
	
		return view ('category.all',['categories'=>$all_categories,'roles'=>$roles,'all_roles'=>$all_roles]);
			
		}
		else{
			
			return redirect()->route('user.home');
		}
		
    }
		
		
	
    public function store(Request $request)
    {
        
		$category = new category ();
		
		
		$num_of_categories = category::count();
		
		
		
		$last_id = $num_of_categories == 0 ? 1 : category::orderBy('id','desc')->first()->id + 1;
		
		//dd($last_id);
		
		$request->validate([
			'category'=>'required',
			'has_map'=>'nullable|boolean',
			'has_img'=>'nullable|boolean',
			'icon'=>'nullable|image'
		]);
		
		if($request->has('has_map')){
			
			$category->has_map = $request->has_map;

		}
		
		if($request->has('has_img')){
			
			$category->has_img = $request->has_img;

		}
	
		
		if($request->hasFile('icon')){
		
				$icon = $request->icon;
			
			$icon_name = $request->icon->getClientOriginalName();
	
				
			$icon_new_name = $last_id  ."_icon.".$request->icon-> guessClientExtension();
			
			$save_image = $icon->storeAs("public/icons",$icon_new_name);
			
			if(!$icon->isValid()){
				
				Session::error('error','توجد مشكلة في رفع الايقونة');
				
			}
			
			else{
				$category->icon = "storage/icons/$icon_new_name";
			}
		}
		
		$category->category = $request->category;
		
		$category->save();
		
		Session::flash('success','تم بنجاح');
		return redirect()->back();
    }

	public function show($id){
		
		$current_category = category::findOrFail($id)->ads()->where('is_approved',1)->paginate(1000);
		
		
		return view('category.show',['category'=>$current_category]);
	}
	
    public function update(Request $request, $id)
    {
        
		$current_category = category::findOrFail($id);
		
		$request->validate([
			'category'=>'required',
			'has_map'=>'nullable|boolean',
			'has_img'=>'nullable|boolean',
			'icon'=>'nullable|image'
		]);
		
	
		if($request->hasFile('icon')){
		
			$icon = $request->icon;
			
			$icon_name = $request->icon->getClientOriginalName();
	
				
			$icon_new_name =$id."_icon.".$request->icon-> guessClientExtension();
			
			$save_image = $icon->storeAs("public/icons",$icon_new_name);
			
			if(!$icon->isValid()){
				
				Session::error('error','توجد مشكلة في رفع الايقونة');
				
			}
			
			else{
				$current_category->icon = "storage/icons/$icon_new_name";
			}
		}
		
		if($request->filled('has_map')){
			
			$current_category->has_map = $request->has_map;
					
		}
		else{
			$current_category->has_map =0;
			
		}
		
		if($request->filled('has_img')){
			
			$current_category->has_img = $request->has_img;
					
		}
		else{
			$current_category->has_img =0;
			
		}
			
		$current_category->category = $request->category;
					
				
		$current_category->save();
		
		return redirect()->back();
		
    }

    public function destroy($id)
    {
		
			$current_category = category::findOrFail($id);
		
		
		
		$icon_name = $current_category->icon;
		
		 $icon_full_name = explode('/',$icon_name)[2];
		
		if($icon_full_name !== 'placeholder.png'){
			//delete icon 
			$icon = storage::delete("public/icons/".$icon_full_name);
		
			}
			//delete ads
			$ads = $current_category->ads()->delete();
		 	
			//delete
			$current_category->delete();
			
			return redirect()->back();
		
			
	}
}
