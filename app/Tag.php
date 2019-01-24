<?php

namespace App;

use App\User as user;
use Auth ;
use App\Tag as tag;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function ads()
    {
    	return $this->belongsToMany('App\Ad');
    }

}
