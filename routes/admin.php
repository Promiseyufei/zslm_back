<?php


/**
 * 后台管理员
 */

Route::get('/test','Admin\Login\LoginController@login');

Route::group(['prefix' => 'admin','namespace' => 'Admin'],function() {

    /**
     * Accounts模块
     */
    Route::group(['prefix' => 'accounts', 'namespace' => 'Accounts'],function() {

        Route::get('test', 'AccountsController@index');
    });




    /**
     * 退款订单管理模块
     */
    Route::group(['prefix' => 'refund', 'namespace' => 'Refund'],function() {

        Route::get('export', 'ExportExcelController@export');
    });


    /**
     * Files模块
     */
    Route::group(['prefix' => 'files', 'namespace' => 'Files'],function() {
        Route::get('getuploadfile','FilesController@getUploadFile');
        Route::post('upload','FilesController@uploadFile');
        Route::post('deletefiles','FilesController@deleteFile');
        Route::any('updateweight','FilesController@updateShowWeight');
        Route::any('test','FilesController@getMajorByRegion');
//        getMajorByRegion
    });


    /**
     * Information模块
     */
    Route::group(['prefix' => 'information', 'namespace' => 'Information'],function() {



        /**
         * test
         */
        Route::get('testa','MajorController@getMajorProvincesAndCities');




        /**
         * 院校专业模块　major模块
         */
        Route::post('getMajorPageMessage','MajorController@getMajorPageMessage');

        Route::post('getMajorPageCount','MajorController@getMajorPageCount');

        Route::post('setMajorState','MajorController@setMajorState');

        Route::post('selectReception','MajorController@selectReception');

        Route::post('updateMajorMsg','MajorController@updateMajorMsg');

        Route::post('deleteMajor','MajorController@deleteMajor');

        Route::post('updateMajorInformationTime','MajorController@updateMajorInformationTime');

        Route::post('createMajor','MajorController@createMajor');

        Route::post('getMajorAuthentication','MajorController@getMajorAuthentication');

        Route::post('getMajorNature','MajorController@getMajorNature');

        Route::post('getMajorType','MajorController@getMajorType');

        Route::post('getMajorProvincesAndCities','MajorController@getMajorProvincesAndCities');

        Route::post('getAllSchoolName','MajorController@getAllSchoolName');


        /**
         * 招生项目　studentProject
         */

        Route::post('getAllProject','StudentProjectController@getAllProject');

        Route::post('updateAppointProjectMsg','StudentProjectController@updateAppointProjectMsg');

        Route::post('deleteAppointProject','StudentProjectController@deleteAppointProject');

        Route::post('setProjectState','StudentProjectController@setProjectState');

        Route::post('createProject','StudentProjectController@createProject');

        Route::post('getMajorDirection','StudentProjectController@getMajorDirection');

        Route::post('getFractionLineType','StudentProjectController@getFractionLineType');

        Route::post('getUnifiedRecruitPattern','StudentProjectController@getUnifiedRecruitPattern');

        Route::post('getUnifiedRecruitPattern','StudentProjectController@getUnifiedRecruitPattern');
        



        /**
         * 活动管理模块　activity模块
         */

        Route::post('getActivityPageMessage','ActivityController@getActivityPageMessage');

        Route::post('getActivityPageCount','ActivityController@getActivityPageCount');

        Route::post('setActivityState','ActivityController@setActivityState');

        Route::post('selectActivityReception','ActivityController@selectActivityReception');

        Route::post('updateActivityMsg','ActivityController@updateActivityMsg');

        Route::post('deleteActivity','ActivityController@deleteActivity');

        Route::post('updateActivityInformationTime','ActivityController@updateActivityInformationTime');

        Route::post('createActivity','ActivityController@createActivity');

        Route::post('getActivityType','ActivityController@getActivityType');

        Route::post('getMajorType','ActivityController@getMajorType');

        Route::post('getMajorProvincesAndCities','ActivityController@getMajorProvincesAndCities');

        Route::post('getAllMajor','ActivityController@getAllMajor');

        Route::post('setHostMajor','ActivityController@setHostMajor');

        Route::post('sendActivityDynamic','ActivityController@sendActivityDynamic');

        Route::post('getAllActivitys','ActivityController@getAllActivitys');

        Route::post('setManualRecActivitys','ActivityController@setManualRecActivitys');

        Route::post('setAutomaticRecActivitys','ActivityController@setAutomaticRecActivitys');

        Route::post('setManualRecMajors','ActivityController@setManualRecMajors');

        Route::post('setAutomaticRecMajors','ActivityController@setAutomaticRecMajors');


        /**
         * 辅导机构　
         */

        Route::post('getPageCoachOrganize','CoachOrganizeController@getPageCoachOrganize');

        Route::post('getPageCoachCount','CoachOrganizeController@getPageCoachCount');

        Route::post('setAppointCoachState','CoachOrganizeController@setAppointCoachState');

        Route::post('selectCoachReception','CoachOrganizeController@selectCoachReception');

        Route::post('updateCoachMessage','CoachOrganizeController@updateCoachMessage');

        Route::post('deleteAppointCoach','CoachOrganizeController@deleteAppointCoach');

        Route::post('getAllBranchCoach','CoachOrganizeController@getAllBranchCoach');

        Route::post('createCoach','CoachOrganizeController@createCoach');


        /**
         * 优惠券模块　coupon模块
         */

        Route::post('getPageCoupon','CouponController@getPageCoupon');

        Route::post('getPageCouponCount','CouponController@getPageCouponCount');

        Route::post('setAppointCoachCouponsEnable','CouponController@setAppointCoachCouponsEnable');

        Route::post('getAppointCoupon','CouponController@getAppointCoupon');

        Route::post('setAppointCouponEnable','CouponController@setAppointCouponEnable');

        Route::post('createCoupon','CouponController@createCoupon');

        Route::post('updateAppointCoupon','CouponController@updateAppointCoupon');



        /**
         * 资讯模块　information模块
         */

        Route::post('getInfoPageMsg','InformationController@getInfoPageMsg');

        Route::post('getInfoPageCount','InformationController@getInfoPageCount');

        Route::post('setAppointInfoState','InformationController@setAppointInfoState');

        Route::post('selectInfoReception','InformationController@selectInfoReception');

        Route::post('updateAppointInfoMsg','InformationController@updateAppointInfoMsg');

        Route::post('deleteAppointInfo','InformationController@deleteAppointInfo');

        Route::post('createInfo','InformationController@createInfo');

        Route::post('setAppointRelationCollege','InformationController@setAppointRelationCollege');

        Route::post('getAllCollege','InformationController@getAllCollege');

        Route::post('sendInfoDynamic','InformationController@sendInfoDynamic');

        Route::post('setManualRecInfos','InformationController@setManualRecInfos');

        Route::post('setAutomaticRecInfos','InformationController@setAutomaticRecInfos');

        Route::post('getAllInfo','InformationController@getAllInfo');

        Route::post('setManualInfoRelationCollege','InformationController@setManualInfoRelationCollege');

        Route::post('setAutoInfoRelationCollege','InformationController@setAutoInfoRelationCollege');

        

        
    });


    /**
     * News模块
     */
    Route::group(['prefix' => 'news', 'namespace' => 'News'],function() {

        Route::get('test','HistoricalNewsController@getFailSendNews');


    });



    /**
     * OPerate模块
     */
    Route::group(['prefix' => 'operate', 'namespace' => 'Operate'],function() {
        
        /**
         * postman post 
         */
        Route::post('test', 'OperateController@thisIsTest');



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

        Route::post('getAllPageListName', 'BillboardController@getAllPageListName');

        Route::post('getAppointPageBillboard', 'BillboardController@getAppointPageBillboard');

        Route::post('setBillboardWeight', 'BillboardController@setBillboardWeight');

        Route::post('setBillboardMessage', 'BillboardController@setBillboardMessage');

        Route::post('deletePageBillboard', 'BillboardController@deletePageBillboard');

        Route::post('createPageBillboard', 'BillboardController@createPageBillboard');

    
        /**
         * 分享记录
         */
        Route::post('getPagingData', 'ShareAdminController@getPagingData');
        Route::post('getPagingCount', 'ShareAdminController@getPagingCount');
        
        /**
         * 资讯首页
         */

        Route::post('getAppointRegionData', 'OperateIndexController@getAppointRegionData');

        Route::post('setAppointRegionName', 'OperateIndexController@setAppointRegionName');

        Route::post('setAppoinInformationWeight', 'OperateIndexController@setAppoinInformationWeight');

        Route::post('deleteAppoinInformation', 'OperateIndexController@deleteAppoinInformation');

        Route::post('getInformPagingData', 'OperateIndexController@getInformPagingData');

        Route::post('addAppoinInformations', 'OperateIndexController@addAppoinInformations');

        Route::post('getInformationType', 'OperateIndexController@getInformationType');


    });

});