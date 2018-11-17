<?php

/**
 * 前台网站
 */
Route::group(['prefix' => 'front', 'namespace' => 'Front'],function() {



    /**
     * 找活动
     */
    Route::group(['prefix' => 'activity', 'namespace' => 'Activity'],function() {
    
    });


    /**
     * 搜辅导
     */
    Route::group(['prefix' => 'coach', 'namespace' => 'Coach'],function() {
    
    });

    /**
     * 选院校
     */
    Route::group(['prefix' => 'colleges', 'namespace' => 'Colleges'],function() {
    
    });


    /**
     * 首页
     */
    Route::group(['prefix' => 'index', 'namespace' => 'Index'],function() {
    
    });


    /**
     * 奖学金专题页
     */
    Route::group(['prefix' => 'reward', 'namespace' => 'Reward'],function() {
    
    });

    /**
     * 用户个人中心
     */
    Route::group(['prefix' => 'usercore', 'namespace' => 'UserCore'],function() {
    
    });


    /**
     * 看资讯
     */
    Route::group(['prefix' => 'consult', 'namespace' => 'Consult'],function() {
    
    });


    
});