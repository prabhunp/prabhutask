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
    return view('userdetails.index');
});

Auth::routes();

/*Route::get('/home', 'HomeController@index')->name('home');*/


Route::get('/userdetails', 'UserDetailsController@index')->name('userdetails');
Route::get('/userdetails/create', 'UserDetailsController@createUsers')->name('userdetailscreate');
Route::post('/userdetails/create', 'UserDetailsController@storeUsers')->name('userdetailscreate');
Route::get('/userdetails/edit', 'UserDetailsController@editusersDetails')->name('userdetailsedit');
Route::post('/userdetails/edit', 'UserDetailsController@updateusersDetails')->name('userdetailsedit');
Route::get('/userdetails/delete', 'UserDetailsController@deleteUserDetails')->name('userdetailsdelete');

Route::get('ajax/userdetails', 'UserDetailsController@getUsersDetails');
