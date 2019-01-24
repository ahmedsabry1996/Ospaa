<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad as ad;

class SearchController extends Controller
{

	public function search (Request $request){
		
		
		
		$ads = ad::take(5)->where('title','like',"%$request->word%")->orWhere('address','like',"%$request->word%")->orWhere('content','like',"%$request->word%")->orWhere('tags','like',"%$request->word%")->get();
		return response()->json($ads);
	}
}
