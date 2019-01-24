<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
	
	protected $fillable = ['title','address','category_id','user_id','phone','content','tags','is_approved'];
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
    public function imgs()
    {
    	return $this->hasMany('App\Img');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
	
	public function comments(){
		
		return $this->hasMany('App\Comment');
	}
	
	public function rate(){
		return $this->hasMany('App\Rate');
	
	}
	
	public function views(){
		return $this->hasOne('App\View');
	}
}
