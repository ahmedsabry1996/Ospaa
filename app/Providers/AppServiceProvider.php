<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Auth;
use App\Category as categories;
class AppServiceProvider extends ServiceProvider
{
	
	
    public function boot()
    {
        
	
		Schema::defaultStringLength(191);
		Carbon::setLocale('ar');
		View::share('categories',categories::all());
		        
    }

    
	public function register()
    {
        //
    }
}
