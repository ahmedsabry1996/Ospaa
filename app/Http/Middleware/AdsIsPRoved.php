<?php

namespace App\Http\Middleware;

use Closure;
use App\Ad as ad;

class AdsIsPRoved
{
 
	
    public function handle($request,$id, Closure $next)
    {
		
		
		
        return $next($request);
	}
}
