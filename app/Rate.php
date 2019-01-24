<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    
	public function ads(){
		return $this->belongsTo('App\Ad');
	}
}
