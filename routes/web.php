<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>'auth'],function(){
	
	Route::get('/verify','EmailVerification@send_code')->name('email.send');
	Route::post('/confirm','EmailVerification@verify_code')->name('email.confirm');
});


Route::group(['middleware'=>['auth','isadmin','isVerified'],'prefix'=>'cpanel'],function(){
//user data
Route::group(['prefix'=>'user'],function(){
	
	
	Route::get('/home','UserController@index')->name('user.home');
	Route::get('/cpanel','UserController@cpanel')->name('cpanel')->middleware('isadmin');
	Route::get('/discuss','UserController@discuss')->name('discuss');
	Route::get('/delete/{id}','UserController@destroy')->name('user.delete')->middleware('isadmin');
	Route::post('/update/{id}','UserController@update')->name('user.update')->middleware('isadmin');
	Route::post('/myedit','UserController@edit_my_data')->name('edit.my.data');
	Route::post('/reply/{id}','UserController@reply_to_report')->name('reply');
	
});
	
	//categories
Route::group(['prefix'=>"category"],function(){
	
	Route::get('/all','CategoryController@index')->name('category.all');
	Route::post('/create','CategoryController@store')->name('category.create');
	Route::post('/edit/{id}','CategoryController@update')->name('category.edit');
	Route::get('/delete/{id}','CategoryController@destroy')->name('category.delete');
	Route::get('/show/{id}','CategoryController@show')->name('category.show');
	
});

	//tags
Route::group(['prefix'=>"tag"],function(){
	
	Route::get('/all','TagController@index')->name('tag.all');
	Route::post('/create','TagController@store')->name('tag.create');
	Route::post('/edit/{id}','TagController@update')->name('tag.edit');
	Route::get('/delete/{id}','TagController@destroy')->name('tag.delete');
	
});
	
	//ads Review
	
	Route::group(['prefix'=>'ads'],function(){
		
		Route::get('/all','UserController@ads')->name('ads.all');
		Route::post('/approve/{id}','UserController@approve_ad')->name('ads.approve');
		Route::get('/cancel/{id}','UserController@cancel_ad')->name('ads.cancel');
		Route::get('/my-ads/','UserController@my_ads')->name('my.ads');
		
	});
	
	

});




//ads
Route::group(['middleware'=>['auth','isVerified'],'prefix'=>"ads"],function(){
	Route::get('create','AdsController@create')->name('ads.create');
	Route::post('store','AdsController@store')->name('ads.store');
	Route::get('edit/{id}/{img_id}','AdsController@edit_imgs')->name('ads.edit');
	Route::post('update_ad/{id}','AdsController@update')->name('ads.update');
	Route::get('/rate','RateController@rate');
	Route::post('/report/{id}','AdsController@report')->name('report');
		

});

Route::group(['prefix'=>'ads'],function(){
	
	Route::get('show','AdsController@index')->name('ads.show');
	Route::get('single/{id}','AdsController@show')->name('ads.single');
	Route::get('/show/{id}','CategoryController@show')->name('category.show');

});

//comments
Route::group(['middleware'=>['auth','isVerified'],'prefix'=>"comment"],function(){
	
	Route::post('add','CommentController@add_comment')->name('comment.add');
	
});


Route::get('search','SearchController@search');

Route::get('login/fb', 'Auth\LoginController@redirectToProvider')->name('fb.login');
Route::get('login/fb/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('unr','CommentController@count_unread');
Route::get('allnotifications','CommentController@list_notifications');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
