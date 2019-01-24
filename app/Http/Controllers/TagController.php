<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Auth ;
use App\User as user;
use App\Role as role;
use App\Category as category;
use App\Tag as tag;


class TagController extends Controller
{
	
public function index(){
		
		$current_user = Auth::user();
		
        $current_user_role = $current_user->roles()->get();
		
		$roles = array();
		
		$all_roles = role::all();
		
		$all_tags = tag::orderBy('created_at','desc')->paginate(100);
		
		foreach($current_user_role as $role):
			
				array_push($roles,$role->pivot->role_id);
				
		endforeach;
			
		
		if(in_array(4,$roles) || in_array(3,$roles)){
	
		return view ('tag.all',['tags'=>$all_tags,'roles'=>$roles,'all_roles'=>$all_roles]);
			
		}
		else{
			
			return redirect()->route('user.home');
		}
		
    }


	
	    public function store(Request $request)
    {
        
		$tag = new tag ();
		
		$request->validate([
			'tag'=>'required',
			'has_map'=>'nullable|boolean'
		]);
		
		if($request->has('has_map')){
			
			$tag->has_map = $request->has_map;

		};
	
		
		$tag->tag = $request->tag;
		
		$tag->save();
		
		return redirect()->back();
    }


	
    public function update(Request $request, $id)
    {
        
		$current_tag = tag::findOrFail($id);
		
		$request->validate([
			'tag'=>'required',
		]);
		
	
			
		$current_tag->tag = $request->tag;
					
				
		$current_tag->save();
		
		return redirect()->back();
		
    }

    public function destroy($id)
    {
			$current_tag = tag::findOrFail($id);
		
			$current_tag->delete();
			
			return redirect()->back();
		
			
	}
}
