<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment as comment;
use App\Notifications\NewComment;
use App\Ad as ad;
use App\User as user;
use Auth;
class CommentController extends Controller
{
    public function add_comment(Request $request){
	
		$comment = new comment();
		
		//commenter id
		$comment->user_id = $request->user_id;
		
		$comment->ad_id = $request->ad_id;
		$comment->comment = $request->comment;
		$comment->save();
		
		//ads publisher id
		$user = user::findOrFail(ad::findOrFail($request->ad_id)->user->id);
		
		
		//ad title 
		
		$ad_title = ad::findOrFail($request->ad_id)->title;
		if(ad::findOrFail($request->ad_id)->user->id !== Auth::id()){
			
		$user->notify(new NewComment($request->user_id,$request->ad_id,$ad_title));
	
		}
		return response()->json($comment);
	}
	
	
	public function count_unread(){
		
		
		$current_user = Auth::user();
		
			
		$unread=$current_user->unreadNotifications()->get()->count();

		
		return response()->json($unread);
	}
	
	public function list_notifications(){
		
		$current_user = Auth::user();
		
		$current_user_notifications = $current_user->notifications()->get();
		
		//mark all as read
		foreach ($current_user->unreadNotifications as $notification) {
    		
			$notification->markAsRead();
			
		}
		
		//json request
		return response()->json($current_user_notifications);
		
	}
}
