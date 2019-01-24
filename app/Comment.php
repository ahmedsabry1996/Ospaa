<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =  ['user_id','ad_id','comment'];
	
	public function user(){
		
		return $this->belongsTo('App\User');
	}
	
	public function ad(){
		return $this->belongsTo('App\Ad');
	}
}
