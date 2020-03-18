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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/douyin_users','DouyinUserController@index')->name('douyin_users.index');
    Route::get('/douyin_users/get_qrcode','DouyinUserController@getQrcode')->name('douyin_users.get_qrcode');
    Route::get('/douyin_users/{token}/check_qrconnect','DouyinUserController@checkQrconnect')->name('douyin_users.check_qrconnect');
});
