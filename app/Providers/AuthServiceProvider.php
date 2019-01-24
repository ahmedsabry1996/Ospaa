<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('boss',function($user){
		
			$roles = array();
			
			foreach($user->roles as $role):
				
				array_push($roles,$role->pivot->role_id);
			
			endforeach;
			
			return in_array(4,$roles);
			
		});
		
		Gate::define('admin',function($user){
		
			$roles = array();
			
			foreach($user->roles as $role):
				
				array_push($roles,$role->pivot->role_id);
			
			endforeach;
			
			return in_array(3,$roles) || in_array(4,$roles);
			
		});
		
		
		Gate::define('customer-service',function($user){
		
			$roles = array();
			
			foreach($user->roles as $role):
				
				array_push($roles,$role->pivot->role_id);
			
			endforeach;
			
			return in_array(4,$roles) || in_array(3,$roles) || in_array(2,$roles);
			
		});
    }
}
