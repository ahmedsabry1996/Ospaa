<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
	protected $fillable = ['ad_id','path'];
    public function ad()
    {
    	return $this->belongsTo('App\Ad');
    }
}
