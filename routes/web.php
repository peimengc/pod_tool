<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth', function (\Illuminate\Http\Request $request) {

    $url = 'https://oauth.taobao.com/token';
    $postfields = array('grant_type' => 'authorization_code',
        'client_id' => '30351084',
        'client_secret' => '226a8cbe7d04c8066bbe6884537aabe9',
        'code' => $request->code,
        'redirect_uri' => 'http://taodoujia.cn/auth');
    $post_data = '';
    foreach ($postfields as $key => $value) {
        $post_data .= "$key=" . urlencode($value) . "&";
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //指定post数据
    curl_setopt($ch, CURLOPT_POST, true);
    //添加变量
    curl_setopt($ch, CURLOPT_POSTFIELDS, substr($post_data, 0, -1));
    $output = curl_exec($ch);
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo $httpStatusCode;
    curl_close($ch);
    var_dump($output);
    echo $request->getMethod();
    return $request->all();
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get('/douyin_users', 'DouyinUserController@index')->name('douyin_users.index');
    Route::get('/douyin_users/get_qrcode', 'DouyinUserController@getQrcode')->name('douyin_users.get_qrcode');
    Route::get('/douyin_users/{token}/check_qrconnect', 'DouyinUserController@checkQrconnect')->name('douyin_users.check_qrconnect');

    Route::get('/douyin_awemes', 'DouyinAwemeController@index')->name('douyin_awemes.index');
    Route::get('/douyin_awemes/{aweme}/tasks', 'DouyinAwemeController@tasks')->name('douyin_awemes.tasks');

    Route::get('/alimama_orders', 'AlimamaOrderController@index')->name('alimama_orders.index');

    Route::get('/roi/{douyinUser}/hour', 'RoiController@hour')->name('roi.hour');

    Route::get('/roi/rank/account', 'RoiRankController@account')->name('roi.rank.account');
});
