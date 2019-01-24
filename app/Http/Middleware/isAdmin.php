<?php

namespace App\Http\Middleware;

use Closure;
use Auth ; 
use App\User as user;
class isAdmin
{
 
    public function handle($request, Closure $next)
    {
   
        return $next($request);
    }
}
