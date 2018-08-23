<?php


/**
 * 后台管理员
 */
Route::group(['prefix' => 'admin','namespace' => 'Admin'],function() {

    /**
     * Accounts模块
     */
    Route::group(['prefix' => 'accounts', 'namespace' => 'Accounts'],function() {

        Route::get('test', 'AccountsController@index');
    });


    /**
     * Files模块
     */
    Route::group(['prefix' => 'files', 'namespace' => 'Files'],function() {
        Route::get('getUploadFile','FilesController@getUploadFile');
        Route::get('test','FilesController@updateFile');
    });


    /**
     * Information模块
     */
    Route::group(['prefix' => 'information', 'namespace' => 'Information'],function() {

    });


    /**
     * News模块
     */
    Route::group(['prefix' => 'news', 'namespace' => 'News'],function() {

    });



    /**
     * OPerate模块
     */
    Route::group(['prefix' => 'operate', 'namespace' => 'Operate'],function() {
        
        Route::post('getIndexListName', 'BannerController@getIndexListName');

        Route::post('getIndexBanner', 'BannerController@getIndexBanner');
        
        Route::post('setBtWeight', 'BannerController@setBtWeight');

        Route::post('setBtMessage', 'BannerController@setBtMessage');

        Route::post('deleteBannerAd', 'BannerController@deleteBannerAd');

        Route::post('createBannerAd', 'BannerController@createBannerAd');

        
    });

});