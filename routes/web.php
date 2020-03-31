<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get('/douyin_users','DouyinUserController@index')->name('douyin_users.index');
    Route::get('/douyin_users/get_qrcode','DouyinUserController@getQrcode')->name('douyin_users.get_qrcode');
    Route::get('/douyin_users/{token}/check_qrconnect','DouyinUserController@checkQrconnect')->name('douyin_users.check_qrconnect');

    Route::get('/alimama_orders','AlimamaOrderController@index')->name('alimama_orders.index');

    Route::get('/roi/{douyinUser}/hour','RoiController@hour')->name('roi.hour');

    Route::get('/roi/rank/account','RoiRankController@account')->name('roi.rank.account');
});
