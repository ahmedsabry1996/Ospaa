<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rate as rate;
class RateController extends Controller
{
    public function rate(Request $request){
		
		$user_id = $request->user_id;
		$ad_id = $request->ad_id;
		$rate = $request->rate;
		
		$rates = new rate();
		
		$is_rated  = rate::where('user_id',$user_id)->where('ad_id',$ad_id)->get()->count();
		
		if($is_rated){
			rate::where('user_id',$user_id)->where('ad_id',$ad_id)->update(['rate'=>$rate]);
		}
		
		else{
		
			$rates->user_id=$request->user_id;
			$rates->ad_id=$request->ad_id;
			$rates->rate=$request->rate;			
			$rates->save();
		}
		
		return response()->json($is_rated);
		
	}
}
