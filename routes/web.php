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
    return view('fe-layout.index');
});

Route::get('/login', function(){
    return view('fe-layout.login');
});

Route::get('/search', function(){
    return view('fe-layout.search');
});

Route::get('/sign-up', function(){
    return view('fe-layout.sign-up');
});

Route::get('/forgot-password', function(){
    return view('fe-layout.forgot-password');
});

Route::get('/latest-post', function () {
    return view('fe-layout.latest-post');
});

Route::get('/article', function () {
    return view('fe-layout.article');
});

Route::get('/stock', function () {
    return view('fe-layout.stock');
});

Route::get('/stock/symbol/{symbol}', function ($symbol) {
    return view('fe-layout.stock_detail');
});

Route::get('/movers', function () {
    return view('fe-layout.movers');
});

Route::get('/stream', function () {
    return view('fe-layout.stream');
});

Route::get('/stream/{path}', function(){
    return view('fe-layout.stream_detail');
});

Route::get('/users/{fullname}', function(){
    return view('fe-layout.user_detail');
});

Route::get('/follow', function () {
    return view('fe-layout.follow');
});

Route::get('/timeline', function () {
    return view('fe-layout.timeline');
});

Route::get('/chat', function () {
    return view('fe-layout.chat');
});


Route::group(['prefix' => 'announcements'], function(){
 	Route::get('asx', function(){
 		return view('fe-layout.announcements.asx');
 	});
 	Route::get('nsx', function(){
 		return view('fe-layout.announcements.nsx');
 	});
 	Route::get('nzx', function(){
 		return view('fe-layout.announcements.nzx');
 	});
});

Route::group(['prefix' => 'asx-sharemarket-game'], function(){
	Route::get('forum', function(){
      	return view('fe-layout.asx-sharemarket-game.forum');
	});
});

//test
Route::get('test-chat', function(){
	return view('fe-layout.temp-chat');
});