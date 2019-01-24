<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','original_password','is_verified','fb_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function ads()
    {
        return $this->hasMany('App\Ad');
    }
	
	public function comments(){
		
		return $this->hasMany('App\Comment');
	}
	
	public function reports(){
		
		return $this->hasMany('App\Report');
	}
	
	
}
