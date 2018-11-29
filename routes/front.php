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
        Route::get('getuseractivity', 'ActivityController@getUserActivity');
        Route::post('unsetactive', 'ActivityController@unsetUserActivity');
        
        

        Route::get('getAppointAcInfo', 'ActivityController@getAppointAcInfo');

        Route::get('getAcHostMajor', 'ActivityController@getAcHostMajor');

        Route::get('getPopularAcInfo', 'ActivityController@getPopularAcInfo');

        Route::post('activitySign', 'ActivityController@activitySign');
    
        });


    /**
     * 搜辅导
     */
    Route::group(['prefix' => 'coach', 'namespace' => 'Coach'],function() {
        Route::get("getcoach","CoachController@getSelectCoach");
        Route::get("getcoachbyname","CoachController@getCoachByName");
        Route::get("getusercoach","CoachController@getUserCoach");
        Route::get("getcoachbyid","CoachController@getCoachById");
        
        
    });

    /**
     * 选院校
     */
    Route::group(['prefix' => 'colleges', 'namespace' => 'Colleges'],function() {
    
        Route::get("getmajor","MajorController@getMajor");

        Route::get("info","MajorController@getInfo");
        Route::get("getCollegesType","CollegesController@getCollegesType");
        Route::get("getcollegebyname","MajorController@getMajorByName");
        Route::get("getmajordetails","MajorController@getMajorDetails");
        Route::get("getmajoractive","MajorController@getMajorActive");
        
    
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

        Route::get("getUserInfo","UserAccountController@getUserInfo");

        Route::get("getIndustryList","UserAccountController@getIndustryList");

        Route::post("changeName","UserAccountController@changeName");

        Route::post("changeUserInfo","UserAccountController@changeUserInfo");
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

        Route::get('getAppointRead', 'ConsultController@getAppointRead');

        Route::get('getConsultDeyail', 'ConsultController@getConsultDeyail');

        Route::get('getBt', 'ConsultController@getBt');
    });


    
});