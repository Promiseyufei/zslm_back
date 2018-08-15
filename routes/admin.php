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

    });

});