<?php

use Illuminate\Database\Seeder;
use App\User as user;
class UserSeeder extends Seeder
{
  
  public function run()
    {
        //


        user::create([

        	'name'=>'Ahmed',
        	'email'=>'a@s.com',
        	'password'=>bcrypt('password'),
        	'original_password'=>'password'

        ]);
    
        user::create([

        	'name'=>'Mohamed',
        	'email'=>'m@s.com',
        	'password'=>bcrypt('password'),
        	'original_password'=>'password'

        ]);
    
        user::create([

        	'name'=>'Ali',
        	'email'=>'al@s.com',
        	'password'=>bcrypt('password'),
        	'original_password'=>'password'

        ]);
    
}

}
