<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('original_password')->nullable();
			$table->string('fb_id')->unique()->nullable();
            $table->boolean('is_verified')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }



    public function down()
    {
        Schema::dropIfExists('users');
    }
}
