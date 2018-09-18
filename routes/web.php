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


Route::get('/smsSend', function() {
    SmsController::sendSms('15837587256', ['name'=>'李闪磊'], '测试', '');
});

Route::get('/smsBatchSend', function() {
    SmsController::sendBatchSms(['15837587256', '13569829175'],'测试', [['name'=>'李闪磊'], ['name' => '尤齐秦']]);
});


Route::group(['middleware' => 'cors'], function() {
    include('admin.php');
    include('front.php');

});

