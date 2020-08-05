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

// Route::get('/enum', function () {
//     return view('welcome');
// });

Route::get('/', 'MyPageController@index')->middleware('auth');
// Route::get('/favorite/auth', 'FavoriteController@auth');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/mypage', 'MyPageController@index');
Route::resource('/mypage', 'MyPageController')->middleware('auth');
// Route::delete('/mypage/{id}', 'FavoriteController@destroy')->middleware('auth');

Route::resource('/inquiry', 'InquiryController')->middleware('auth');
Route::post('/inquiry_reply', 'InquiryReplyController@store')->middleware('auth');


Route::get('/favorite/{pref}/{shop_id}/{shop_slug}/', 'FavoriteController@index');
Route::delete('/favorite/{favorite}', 'FavoriteController@destroy');
// Route::get('/favorite/{pref}/{shop_id}/{shop_slug}/', 'FavoriteController@index')->middleware('auth');
// Route::delete('/favorite/{favorite}', 'FavoriteController@destroy')->middleware('auth');

// Route::get('/favorite/{pref}/{shop_id}/{shop_slug}/{return_url}', 'FavoriteController@index')->middleware('auth');

// Route::resource('/favorite/{id}', 'FavoriteController')->middleware('auth');

// http://mg.rlf.local/favorite/okinawa/183/tedaya/http%3A%2F%2Frlf.local%2Fokinawa%2Fshops%2Ftedaya%2F