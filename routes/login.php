<?php



Route::group(['prefix' => 'login','namespace' => 'Login'],function() {

    Route::group(['prefix' => 'admin','namespace' => 'Admin'],function() {
        Route::get('captcha/{tmp}', 'CodeController@captcha');
    
    });
    Route::group(['prefix' => 'front','namespace' => 'Front'],function() {
        Route::get('sendSmsCode', 'FrontLoginController@sendSmsCode');

        Route::get('loginOut', 'FrontLoginController@loginOut');
        Route::post('login', 'FrontLoginController@login');
        Route::post('register', 'FrontLoginController@register');
        Route::post('resetUserPassWord', 'FrontLoginController@resetUserPassWord');
    });

});

Route::group(['prefix' => 'auto','namespace' => 'Auto'],function() {
    Route::group(['prefix' => 'thirdlogin','namespace' => 'ThirdLogin'],function() {
        Route::post('bindAccounts', 'WeixinController@bindAccounts');
    });
});