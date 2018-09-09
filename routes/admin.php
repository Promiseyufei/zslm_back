<?php


/**
 * 后台管理员
 */

Route::get('/test','Admin\Accounts\AccountsController@getActivityUser');

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
        Route::get('test','FilesController@test');
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
        

        /**
         * Banner
         */
        Route::post('getIndexListName', 'BannerController@getIndexListName');

        Route::post('getIndexBanner', 'BannerController@getIndexBanner');
        
        Route::post('setBtWeight', 'BannerController@setBtWeight');

        Route::post('setBtMessage', 'BannerController@setBtMessage');

        Route::post('deleteBannerAd', 'BannerController@deleteBannerAd');

        Route::post('createBannerAd', 'BannerController@createBannerAd');


        /**
         * 广告
         */

        Route::post('getAllPageListName', 'BannerController@getAllPageListName');

        Route::post('getAppointPageBillboard', 'BannerController@getAppointPageBillboard');

        Route::post('setBillboardWeight', 'BannerController@setBillboardWeight');

        Route::post('setBillboardMessage', 'BannerController@setBillboardMessage');

        Route::post('deletePageBillboard', 'BannerController@deletePageBillboard');

        Route::post('createPageBillboard', 'BannerController@createPageBillboard');




        /**
         * 分享记录
         */
        Route::post('getPagingData', 'BannerController@getPagingData');

        Route::post('getPagingCount', 'BannerController@getPagingCount');



        /**
         * 资讯首页
         */

        Route::post('getAppointRegionData', 'BannerController@getAppointRegionData');

        Route::post('setAppointRegionName', 'BannerController@setAppointRegionName');

        Route::post('setAppoinInformationWeight', 'BannerController@setAppoinInformationWeight');

        Route::post('deleteAppoinInformation', 'BannerController@deleteAppoinInformation');

        Route::post('getInformPagingData', 'BannerController@getInformPagingData');

        Route::post('addAppoinInformations', 'BannerController@addAppoinInformations');

        Route::post('getInformationType', 'BannerController@getInformationType');


    });

});