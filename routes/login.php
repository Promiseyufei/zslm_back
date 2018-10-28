<?php



Route::group(['prefix' => 'login','namespace' => 'Login'],function() {

    Route::group(['prefix' => 'admin','namespace' => 'Admin'],function() {
        Route::get('captcha/{tmp}', 'CodeController@captcha');
    
    });
    Route::group(['prefix' => 'front','namespace' => 'Front'],function() {

    
    });

});