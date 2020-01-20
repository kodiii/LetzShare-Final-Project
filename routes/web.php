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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::view('/terms', 'termsconditions')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/about-us', 'about-us')->name('about-us');

Route::get('/contact', 'ContactController@index')->name('contact');
Route::post('/contact/sendemail', 'ContactController@sendEmail');
Route::post('/sendmessage/{id}', 'ContactController@sendMessage');

Route::get('/uploadphoto', 'PhotoController@create')->name('uploadphoto');
Route::post('/uploadphoto', 'PhotoController@store');

Route::get('/userprofile/{id}', 'ProfileController@index')->name('userprofile');
Route::post('/userprofile/{id}', 'ProfileController@store');
Route::post('/userprofile/description/{id}', 'ProfileController@description');
Route::post('/userprofile/photo/{id}','ProfileController@changePhoto');
Route::post('/userprofile/location/{id}', 'ProfileController@location');
Route::post('/edit-photo-details/{id}', 'ProfileController@photoDetails');
Route::post('/delete/user-photo/{id}', 'ProfileController@destroy');
Route::post('/delete/user-account/{id}', 'ProfileController@deleteAccount');

Route::get('/gallery', 'PhotoController@index');
Route::post('/gallery', 'PhotoController@filters');
Route::get('/gallery/{category_id}', 'PhotoController@getCategory');

//** Likes handler */
Route::post('/like', 'PhotoController@photoLikePhoto')->name('like');

//** ADMIN - Middleware auth validation */
Route::resource('/admin', 'AdminController')->middleware('admin');
Route::delete('/admin/deletePhoto/{photo_id}', 'AdminController@deletePhoto')->middleware('admin');
