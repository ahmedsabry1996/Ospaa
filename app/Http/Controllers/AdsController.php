<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Storage as storage;
use Session ;
use Imagick;
use App\User as user;
use App\Category as category;
use App\Tag as tag;
use App\Img as img;
use App\Ad as ad;
use App\Report as report;
use App\View as view;
class AdsController extends Controller
{
    
	public function create(){
		
		$all_categories  = category::all();
	
		return view('ads.create',
					['categories'=>$all_categories]);
	}
	
	public function store(Request $request){
			
		
		$ads = new ad();
		$imgs = new img();
		chdir('../storage/app/public/ads_imgs');
		
		
		
		$categroy_has_img = category::findOrFail($request->category)->has_img;
		
		
		if($categroy_has_img == 0){
			$imgs_validation = 'nullable';
				$img_prop = "nullable";
		}
		else{
			$imgs_validation= 'required|between:1,3';
			$img_prop ="image|max:4000";	
		}
		
		
		$request->validate([
				'title'=>'required',
				'category'=>'required',
				'address'=>'required',
				'phone'=>'required|digits:11',
				'content'=>'required|min:30',				
				'imgs'=>$imgs_validation,
				'imgs.*'=>$img_prop,
				'tags'=>'nullable',
			]);
		
		
		$ads::create([
			'title'=>$request->title,
			'user_id'=>Auth::id(),
			'category_id'=>$request->category,
			'address'=>$request->address,
			'tags'=>$request->tags,
			'phone'=>$request->phone,
			'content'=>$request->content			
		]);
		
		
		$ads_id = 0;
		
		$user_ad = Auth::user()->ads()->get();
		
		foreach($user_ad as $ad):
			$ads_id = $ad->id;
		endforeach;
		
		
		if($categroy_has_img){
		for($i =0 ; $i < count($request->file('imgs'));$i++):
		
		//rename the uploaded imgs		
		$new_img_name = "ad_$ads_id"."_".$request->imgs[$i]->getClientOriginalName();
		
		//save the uploaded imgs
		$request->imgs[$i]->storeAs('public/ads_imgs',$new_img_name);
		
		//open watermark
		$watermark = new Imagick('logo.jpeg');
		$watermark->setImageOpacity(.3);
		$watermark->resizeImage( 80, 80, Imagick::FILTER_LANCZOS, 0.9, TRUE );
		$watermark->writeImage('logo.jpg');
		
		//open uploaded file
		$uploaded_img = new Imagick($new_img_name);
		$uploaded_img->resizeImage( 500, 500, Imagick::FILTER_LANCZOS, 0.9, TRUE );
		$uploaded_img->compositeImage($watermark, Imagick::COMPOSITE_OVER, 0, 0);
		$uploaded_img->writeImage($new_img_name);
		
		
		$imgs::create([
			'ad_id'=>$ads_id,
			"path"=>"storage/ads_imgs/$new_img_name"
		]);
		endfor;		
		}
		
		
		Session::flash('success','تم رفع الاعلان بنجاح و جاري مراجعته');
		return redirect()->route('home');
	}
	
	public function index(){
	
		
		$all_ads = ad::where('is_approved',1)->orderBy('created_at','desc')->paginate(10);
		return view('ads.show',['ads'=>$all_ads]);
		
	
	}
	
	public function show($id){
		
		
		$ads = ad::findOrFail($id);

		if(!$ads->is_approved){
			return redirect()->route('home');
		}
		$ratio = $ads->rate->avg('rate');
		
		$is_user_rated  = $ads->rate()->select('rate')->where('user_id',Auth::id())->value('rate'); 
		
		
		$view_counter = view::firstOrCreate(['ad_id'=>$id],['view'=>1]);
		
		$view_counter->increment('views');	
		
		return view('ads.single',['ad'=>$ads,
								  'avg'=>$ratio,$is_user_rated,
								  'is_rated'=>$is_user_rated]);
		
	}
	
	public function edit_imgs($id,$img_id){
		
		
		$current_ad = ad::findOrFail($id);
		
		$num_of_imgs = $current_ad->imgs()->get()->count();
		if($num_of_imgs !== 1 && $num_of_imgs <= 3){

			$current_img = img::findOrFail($img_id);
			
			$current_img->delete();
			
			$img_name = explode('/',$current_img->path)[2];

			storage::delete("public/ads_imgs/".$img_name);
		
			return response()->json(['imgs'=>1]);

		}
		
		else{
		return response()->json(['imgs'=>0]);
		}
	
		
		return response()->json($num_of_imgs);
	
	}
	
	public function update(Request $request,$id){
		
		$imgs = new img();
		
			chdir('../storage/app/public/ads_imgs');

		$categroy_has_img = category::findOrFail($request->category)->has_img;
		
			$current_ad = ad::findOrFail($id);

		
		
		if($categroy_has_img == 0){
			$imgs_validation = 'nullable';
			$img_prop = "nullable";
			$allowed_imgs = 0;
		}
		else{
			
		
		$num_of_imgs = $current_ad->imgs()->get()->count();
		
		$allowed_imgs = 3 - $num_of_imgs;
		
		$imgs_validation= "nullable|between:0,$allowed_imgs";
		
		$img_prop ="image|max:4000";	
		
		}
		
		
		
		
		
		//dd($allowed_imgs);
			$request->validate([
				'title'=>'required',
				'category'=>'required',
				'address'=>'required',
				'phone'=>'required|numeric|min:11',
				'content'=>'required|min:30',				
				'imgs'=>$imgs_validation,
				'imgs.*'=>$img_prop,
				'tags'=>'nullable',
			]);
		
		
		$current_ad->title = $request->title;
		$current_ad->tags = $request->tags;
		$current_ad->category_id = $request->category;
		$current_ad->phone = $request->phone;
		$current_ad->address = $request->address;
		$current_ad->content = $request->content;
		$current_ad->is_approved = 0;
		
		$current_ad->save();
		if($categroy_has_img){
		if($request->hasFile('imgs')){
		for($i =0 ; $i < count($request->imgs);$i++):
		
		//rename the uploaded imgs		
		$new_img_name = "ad_$id"."_".$request->imgs[$i]->getClientOriginalName();
		
		//save the uploaded imgs
		$request->imgs[$i]->storeAs('public/ads_imgs',$new_img_name);
		$imgs::create([
			'ad_id'=>$id,
			"path"=>"storage/ads_imgs/$new_img_name"
		]);
			
			
			//open watermark
		$watermark = new Imagick('logo.jpeg');
		$watermark->setImageOpacity(.3);
		$watermark->resizeImage( 80, 80, Imagick::FILTER_LANCZOS, 0.9, TRUE );
		$watermark->writeImage('logo.jpg');
		
		//open uploaded file
		$uploaded_img = new Imagick($new_img_name);
		$uploaded_img->resizeImage( 500, 500, Imagick::FILTER_LANCZOS, 0.9, TRUE );
		$uploaded_img->compositeImage($watermark, Imagick::COMPOSITE_OVER, 0, 0);
		$uploaded_img->writeImage($new_img_name);
		
			
		endfor;		
		}
		}
		session::flash('success','تم تعديل الاعلان بنجاح');
		return redirect()->route('home');
		
	}
	
	public function report(Request $request , $id){
		
			$request->validate([
				'report'=>'required|min:30'
			]);
			
		
		$report = new report();
		
		$current_ad = ad::findOrFail($id);
		
		$ad_id = $id;
		
		$user_id = Auth::id();
	
		$report_data = $request->report;
		
		$report->user_id = $user_id;
		
		$report->ads_id = $ad_id;
		
		$report->report = $report_data;
		
		$report->save();
		
		Session::flash('success','تم ارسال الشكوى وسيتم اعلامكم عبر البريد الالكتروني الخاص بكم');
		
		return redirect()->route('home');
		
		
	}
	
}
