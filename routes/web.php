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

Route::get('/', function () {
    return view('welcome');
});



//短信测试验证码
Route::get('/smsSend', function() {
    $a = SmsController::sendSms('15837587256', ['name'=>'李闪磊'], '测试', '');
    dd($a);
});
Route::get('/smsBatchSend', function() {
    SmsController::sendBatchSms(['15837587256', '13569829175'],'测试', [['name'=>'李闪磊'], ['name' => '尤齐秦']]);
});

//微信第三方登录测试
Route::get('auth/weixin', 'Auto\ThirdLogin\WeixinController@redirectToProvider');
Route::get('auth/authWeixinCallback', 'Auto\ThirdLogin\WeixinController@handleProviderCallback');

// 错:https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx4bc9b1b4f2bbe009&redirect_uri=http://www.lishanlei.cn&response_type=code&scope=snsapi_login&state=fWW91SAQ3wKJJywJ5TLVRfYjD9utlwWXR2EyOt53&connect_redirect=1#wechat_redirect
// 对:https://open.weixin.qq.com/connect/qrconnect?appid=wx4bc9b1b4f2bbe009&redirect_uri=http://www.lishanlei.cn&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect


Route::group(['middleware' => 'cors'], function() {
    include('admin.php');
    include('front.php');
    include('login.php');
});

