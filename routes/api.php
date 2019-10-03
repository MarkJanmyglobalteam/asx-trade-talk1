<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix'  => 'authentication'], function(){
		
		Route::post('register', 'AuthController@register');
		Route::post('login', 'AuthController@login');
		Route::get('existed/{email}', 'AuthController@existedEmail');
		Route::get('activated/{token}', 'AuthController@accountActivated');
		Route::get('resend-link/{user_id}', 'AuthController@resendLink');
		Route::get('token/refresh', 'AuthController@refreshToken');
		Route::post('password/forgot', 'AuthController@passwordForgot');
		Route::get('password/reset/{token}', 'AuthController@passwordResetToken');
		Route::post('password/reset', 'AuthController@passwordReset');
		Route::get('forgot/password/resend-link/{email}', 'AuthController@forgotPasswordResendLink');

		Route::group(['middleware' => 'jwt.auth'], function() {
			Route::get('user/get', 'AuthController@getAuthenticatedUser');
		    Route::get('logout', 'AuthController@logout');   
		});

});

Route::group(['prefix' => 'index'],  function(){
        Route::get('get', 'IndexController@index');
});

Route::group(['prefix' => 'article'],  function(){
        Route::get('get', 'ArticleController@index');
});


Route::group(['prefix' => 'stock'],  function(){
        Route::get('get', 'ArticleController@stock');
});

Route::group(['prefix' => 'latest-post'],  function(){
        Route::get('get', 'LatestPostController@index');
});

Route::group(['prefix' => 'announcement'],  function(){ 
	    Route::group(['prefix' => 'get'], function(){
	    	 Route::get('symbols', 'AnnouncementController@getSymbols');
	    	 Route::get('announcements', 'AnnouncementController@getAnnouncements');
	    });
});

Route::group(['prefix' => 'asx-sharemarket-game'], function(){
		Route::group(['prefix' => 'forum'], function(){
			Route::get('get/{list_type}','AsxShareMarketGameController@getForums');
		});
});

Route::group(['prefix' => 'streams'], function(){
	Route::post('create', 'StreamController@createPost');
	Route::get('retrieve', 'StreamController@getPost');
});

Route::get('test', 'TestController@index');
Route::get('getAsxDetailsUsingFileContents', 'TestController@getAsxDetailsUsingFileContents');
Route::get('getAsxDetailsUsingCurl', 'TestController@getAsxDetailsUsingCurl');
Route::get('useGuzzleAlphaAdvantage/{item}', 'TestController@useGuzzleAlphaAdvantage');
Route::get('useGuzzleXignite/{item}', 'TestController@useGuzzleXignite');
Route::post('/send/chat', 'TestController@triggerEvent');
Route::get('/data/get/{item}', 'TestController@getData');


