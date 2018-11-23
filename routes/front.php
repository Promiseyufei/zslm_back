<?php

/**
 * 前台网站
 */
Route::group(['prefix' => 'front', 'namespace' => 'Front'],function() {



    /**
     * 找活动
     */
    
    
      Route::get('indexinfo', 'indexController@getIndexInfo');
    
    Route::group(['prefix' => 'activity', 'namespace' => 'Activity'],function() {

        Route::get('getSearchActivity', 'ActivityController@getSearchActivity');

        Route::get('getActivity', 'ActivityController@getActivity');

        Route::get('getActivityType', 'ActivityController@getActivityType');
    
    });


    /**
     * 搜辅导
     */
    Route::group(['prefix' => 'coach', 'namespace' => 'Coach'],function() {
        Route::get("getcoach","CoachController@getSelectCoach");
        Route::get("getcoachbyname","CoachController@getCoachByName");
    });

    /**
     * 选院校
     */
    Route::group(['prefix' => 'colleges', 'namespace' => 'Colleges'],function() {
    
        Route::get("getmajor","MajorController@getMajor");

        Route::get("info","MajorController@getInfo");
        Route::get("getCollegesType","CollegesController@getCollegesType");
        Route::get("getcollegebyname","MajorController@getMajorByName");

    
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
        Route::get("getuserinfo","userController@getUserInfo");
        Route::get("getusermajor","userController@getUserMajor");
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