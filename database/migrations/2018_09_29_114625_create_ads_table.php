<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
	
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->string('title');
            $table->text('tags')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->text('content');
			$table->boolean('is_approved')->default(0);
            $table->timestamps();
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
