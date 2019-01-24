<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = ['ad_id','views'];

	public function ad(){
		
		return $this->belongsTo('App\Ad');
	}
}
