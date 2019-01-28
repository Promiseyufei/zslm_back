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

use App\Http\Controllers\Auto\Sms\SmsController;
// use App\Http\Controllers\Auto\Share\AutographController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getToken', 'Auto\Share\AutographController@getSignPackage');


//短信测试验证码
Route::get('/smsSend', function() {
    $a = SmsController::sendSms('15837587256', ['name'=>'李闪磊'], '测试', '');
});
Route::get('/smsBatchSend', function() {
    SmsController::sendBatchSms(['15837587256', '13569829175'],'测试', [['name'=>'李闪磊'], ['name' => '尤齐秦']]);
});

//微信第三方登录测试
Route::get('auth/weixin', 'Auto\ThirdLogin\WeixinController@redirectToProvider');
Route::get('auth/authWeixinCallback', 'Auto\ThirdLogin\WeixinController@handleProviderCallback');

Route::group(['middleware' => 'cors'], function() {
    
    include('admin.php');
    include('front.php');
    include('login.php');
});

