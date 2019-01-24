<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    
	
	protected $fillable = ['user_id','ads_id','report'];


	public function user(){
		
		return $this->belongsTo('App\User');
	}
}
