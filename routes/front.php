<?php

/**
 * 前台网站
 */
Route::group(['prefix' => 'front', 'namespace' => 'Front'],function() {



    /**
     * 找活动
     */
    Route::group(['prefix' => 'activity', 'namespace' => 'Activity'],function() {

        Route::get('getSearchActivity', 'ActivityController@getSearchActivity');

        Route::get('getActivity', 'ActivityController@getActivity');
    
    });


    /**
     * 搜辅导
     */
    Route::group(['prefix' => 'coach', 'namespace' => 'Coach'],function() {
        Route::get("getcoach","CoachController@getSelectCoach");
    });

    /**
     * 选院校
     */
    Route::group(['prefix' => 'colleges', 'namespace' => 'Colleges'],function() {
    
        Route::get("getmajor","MajorController@getMajor");
    
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
    
        Route::get('getSearchConsult', 'ConsultController@getSearchConsult');

        Route::get('getRecommendRead', 'ConsultController@getRecommendRead');

        Route::get('getConsultType', 'ConsultController@getConsultType');

        Route::get('getConsultListBroadcast', 'ConsultController@getConsultListBroadcast');

        Route::get('getConsultListInfo', 'ConsultController@getConsultListInfo');
    });


    
});