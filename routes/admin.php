<?php
    
    
    /**
     * 后台管理员
     */
    
    Route::get('/test', 'TestController@showProfile');
    
    Route::post('/admin/login', 'Admin\Login@validateLogin');
    Route::get('/admin/createuuid', 'Admin\Login@createUUID');
    Route::post('/admin/loginout', 'Admin\Login@loginout');
    Route::post('/admin/img', 'Admin\img@imgUpdate');
    
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>'login'], function () {


        /**
         * 调剂专题模块
         */
        Route::group(['prefix' => 'dispen', 'namespace' => 'Dispensing'], function () {
            Route::get('getProvinces', 'DispensingController@getProvinces');
            Route::get('getDisPro', 'DispensingController@getDisPro');
            Route::post('subscribe', 'DispensingController@subscribe');
            Route::get('getCurrentMajorMsg', 'DispensingController@getCurrentMajorMsg');
            Route::post('setMajorSubscribe', 'DispensingController@setMajorSubscribe');
            Route::post('sendSmsCode', 'DispensingController@sendSmsCode');
            Route::post('judgeSms', 'DispensingController@judgeSms');
        });


        /**
         * 招生服务专题模块
         */
        Route::group(['prefix' => 'recruit', 'namespace' => 'Recruit'], function () {
            Route::get('getRecruitInfo', 'RecruitController@getRecruitInfo');

            Route::post('sendRecruitSmsCode', 'RecruitController@sendRecruitSmsCode');

            Route::post('sendRecruit', 'RecruitController@sendRecruit');
        });


        
        /**
         * Accounts模块
         */
        Route::group(['prefix' => 'accounts', 'namespace' => 'Accounts'], function () {
            
            Route::get('getmajoruser', 'AccountsController@getMajorUser');
            Route::get('createmajorexcel', 'AccountsController@createMajorExcel');
            Route::get('createCouponExcel', 'AccountsController@createCouponExcel');
            Route::get('createUserExcel', 'AccountsController@createUserExcel');
            Route::get('createActivityExcel', 'AccountsController@createActivityExcel');
            
            Route::get('getmajorone', 'AccountsController@getMajorOneUser');
            Route::get('getuser', 'AccountsController@getUser');
            Route::get('getoneuser', 'AccountsController@getOneUser');
            Route::get('getcoupon', 'AccountsController@getCouponUser');
            Route::get('getcouponone', 'AccountsController@getCouponOneUser');
            Route::get('getactivityuser', 'AccountsController@getActivityUser');
            Route::get('getactivityoneuser', 'AccountsController@getActivityOneUser');
            Route::get('getaccountloginmsg', 'AccountsController@getAccountLoginMsg');
            
        });
        
        
        /**
         * 退款订单管理模块
         */

        Route::group(['prefix' => 'refund', 'namespace' => 'Refund'], function () {
    
            Route::get('export', 'ExportExcelController@export');
    
    
            Route::post('getInfoPageMsg', 'InformationController@getInfoPageMsg');
    
            Route::post('getInfoPageCount', 'InformationController@getInfoPageCount');
    
            Route::post('setAppointInfoState', 'InformationController@setAppointInfoState');
    
            Route::post('selectInfoReception', 'InformationController@selectInfoReception');
            
            Route::post('updateAppointInfoMsg', 'InformationController@updateAppointInfoMsg');
    
            Route::post('deleteAppointInfo', 'InformationController@deleteAppointInfo');
    
            Route::post('createInfo', 'InformationController@createInfo');
    
            Route::post('setAppointRelationCollege', 'InformationController@setAppointRelationCollege');
    
            Route::post('getAllCollege', 'InformationController@getAllCollege');
    
            Route::post('sendInfoDynamic', 'InformationController@sendInfoDynamic');
    
            Route::post('setManualRecInfos', 'InformationController@setManualRecInfos');
    
            Route::post('setAutomaticRecInfos', 'InformationController@setAutomaticRecInfos');
    
            Route::post('getAllInfo', 'InformationController@getAllInfo');
    
            Route::post('setManualInfoRelationCollege', 'InformationController@setManualInfoRelationCollege');
    
            Route::post('setAutoInfoRelationCollege', 'InformationController@setAutoInfoRelationCollege');
    
            Route::post('getInfoType', 'InformationController@getInfoType');
    
            Route::post('updateInfoExtendMsg', 'InformationController@updateInfoExtendMsg');
    
            Route::post('updateInfoTextMsg', 'InformationController@updateInfoTextMsg');
    
            Route::post('getAppointInfoRecommendRead', 'InformationController@getAppointInfoRecommendRead');
    
            Route::post('delAppointInfoRecommendRead', 'InformationController@delAppointInfoRecommendRead');
    
            Route::post('getAppointInfoRecommendMajor', 'InformationController@getAppointInfoRecommendMajor');
    
            Route::post('getAppointInfoRelevantMajor', 'InformationController@getAppointInfoRelevantMajor');
    
            
    
        });
        
        
        /**
         * Files模块
         */
        Route::group(['prefix' => 'files', 'namespace' => 'Files'], function () {
            
            Route::get('getuploadfile', 'FilesController@getUploadFile');
            Route::post('upload', 'FilesController@uploadFile');
            Route::post('deletefiles', 'FilesController@deleteFile');
            Route::any('updateweight', 'FilesController@updateShowWeight');
            Route::any('test', 'FilesController@getMajorByRegion');
            Route::get('getmajorbypro', 'FilesController@getMajorByRegion');
            Route::post('updatefile', 'FilesController@updateFile');
            Route::get('getonemajorfile', 'FilesController@getOneMajorFile');
            Route::post('deletemajorallf', 'FilesController@deleteMajorAllF');
            
//        getMajorByRegion
        });
        
        
        /**
         * Information模块
         */
        Route::group(['prefix' => 'information', 'namespace' => 'Information'], function () {
            
            
            /**
             * test
             */
            Route::get('testa', 'MajorController@getMajorProvincesAndCities');
          
            
            /**
             * 院校专业模块　major模块
             */
            Route::post('getAppointInfoRecommendMajor', 'InformationController@getAppointInfoRecommendMajor');
            Route::post('getMajorPageMessage', 'MajorController@getMajorPageMessage');
            
            Route::post('getMajorPageCount', 'MajorController@getMajorPageCount');
            
            Route::post('setMajorState', 'MajorController@setMajorState');
            
            Route::get('selectReception', 'MajorController@selectReception');
            
            Route::post('updateMajorMsg', 'MajorController@updateMajorMsg');
            
            Route::post('updateMajorExtendMsg', 'MajorController@updateMajorExtendMsg');
            
            Route::post('deleteMajor', 'MajorController@deleteMajor');
            
            Route::post('updateMajorInformationTime', 'MajorController@updateMajorInformationTime');
            
            Route::post('createMajor', 'MajorController@createMajor');
            
            Route::post('getMajorAuthentication', 'MajorController@getMajorAuthentication');
            
            Route::post('getMajorNature', 'MajorController@getMajorNature');
            
            Route::post('getMajorType', 'MajorController@getMajorType');
            
            Route::post('getMajorProvincesAndCities', 'MajorController@getMajorProvincesAndCities');
            
            Route::post('getAllSchoolName', 'MajorController@getAllSchoolName');
            
            
            /**
             * 招生项目　studentProject
             */
            
            Route::post('getAllProject', 'StudentProjectController@getAllProject');
            
            Route::post('updateAppointProjectMsg', 'StudentProjectController@updateAppointProjectMsg');
            
            Route::post('deleteAppointProject', 'StudentProjectController@deleteAppointProject');
            
            Route::post('setProjectState', 'StudentProjectController@setProjectState');
            
            Route::post('createProject', 'StudentProjectController@createProject');
            
            Route::post('getMajorDirection', 'StudentProjectController@getMajorDirection');
            
            Route::post('getFractionLineType', 'StudentProjectController@getFractionLineType');
            
            Route::post('getUnifiedRecruitPattern', 'StudentProjectController@getUnifiedRecruitPattern');
            
            Route::post('getAppointIdProject', 'StudentProjectController@getAppointIdProject');
    
            Route::post('delAppointInfoRecommendRead', 'InformationController@delAppointInfoRecommendRead');
            /**
             * 活动管理模块　activity模块
             */
    
            
            Route::post('cancelAppointRecommendActivity', 'ActivityController@cancelAppointRecommendActivity');

            Route::post('setActivitydynamic', 'ActivityController@setActivitydynamic');

            Route::post('cancelAppointRecommendMajor', 'ActivityController@cancelAppointRecommendMajor');

            Route::post('cancelAppointActicityAllRe', 'ActivityController@cancelAppointActicityAllRe');

            Route::post('cancelAppointMajorAllRe', 'ActivityController@cancelAppointMajorAllRe');
            
            Route::get('getActivityAll', 'ActivityController@getActivityAll');

            Route::get('getCoachRecommendAc', 'ActivityController@getCoachRecommendAc');

            Route::get('getAcTypeAndCity', 'ActivityController@getAcTypeAndCity');
            
            Route::get('getguanlian', 'ActivityController@getGuanlianById');
            
            Route::get('getpageinfo', 'ActivityController@getPageInfo');
            
            Route::get('getoneact', 'ActivityController@getOneAct');
            
            Route::get('getimg', 'ActivityController@getImg');
            
            Route::post('setkwt', 'ActivityController@updateTiltle');
            
            Route::post('setin', 'ActivityController@updateIntroduce');
            
            Route::post('getActivityPageMessage', 'ActivityController@getActivityPageMessage');
            
            Route::post('getActivityMessage', 'ActivityController@getActivityMessage');
            
            Route::post('getActivityPageCount', 'ActivityController@getActivityPageCount');
            
            Route::post('setActivityState', 'ActivityController@setActivityState');
            
            Route::post('selectActivityReception', 'ActivityController@selectActivityReception');
            
            Route::post('updateActivityMsg', 'ActivityController@updateActivityMsg');
            
            Route::post('updateActivityWeight', 'ActivityController@updateActivityWeight');
            
            Route::post('updateActivityShow', 'ActivityController@updateActivityShow');
            
            Route::post('updateActivityRec', 'ActivityController@updateActivityRec');
            
            Route::post('deleteActivity', 'ActivityController@deleteActivity');
            
            Route::post('updateActivityInformationTime', 'ActivityController@updateActivityInformationTime');
            
            Route::post('createActivity', 'ActivityController@createActivity');
            
            Route::post('updateActivity', 'ActivityController@updateActivity');
            
            Route::post('getActivityType', 'ActivityController@getActivityType');
            
            Route::post('getMajorType', 'ActivityController@getMajorType');
            
            Route::post('getMajorProvincesAndCities', 'ActivityController@getMajorProvincesAndCities');
            
            Route::post('getAllMajor', 'ActivityController@getAllMajor');
            
            Route::post('setHostMajor', 'ActivityController@setHostMajor');
            
            Route::post('sendActivityDynamic', 'ActivityController@sendActivityDynamic');
            
            Route::post('getAllActivitys', 'ActivityController@getAllActivitys');
            
            Route::post('setManualRecActivitys', 'ActivityController@setManualRecActivitys');
            
            Route::post('setAutomaticRecActivitys', 'ActivityController@setAutomaticRecActivitys');
            
            Route::post('setManualRecMajors', 'ActivityController@setManualRecMajors');
            
            Route::post('setAutomaticRecMajors', 'ActivityController@setAutomaticRecMajors');
            
            
            /**
             * 辅导机构　
             */
            
            

            Route::post('setCoachActivity', 'CoachOrganizeController@setCoachActivity');

            Route::post('updateCoachTime', 'CoachOrganizeController@updateCoachTime');

            Route::post('cancelAllReActivity', 'CoachOrganizeController@cancelAllReActivity');

            Route::post('cancelRelevanActivity', 'CoachOrganizeController@cancelRelevanActivity');
            
            Route::get('getAppoinCoachRelevantActivity', 'CoachOrganizeController@getAppoinCoachRelevantActivity');

            Route::get('getAppointCoachCoupon', 'CoachOrganizeController@getAppointCoachCoupon');

            Route::get('getcoachinfo', 'CoachOrganizeController@getPageInfo');
            
            Route::post('getPageCoachOrganize', 'CoachOrganizeController@getPageCoachOrganize');
            
            Route::post('getPageCoachCount', 'CoachOrganizeController@getPageCoachCount');
            
            Route::post('setAppointCoachState', 'CoachOrganizeController@setAppointCoachState');
            
            Route::post('selectCoachReception', 'CoachOrganizeController@selectCoachReception');
            
            Route::post('updateCoachMessage', 'CoachOrganizeController@updateCoachMessage');
            
            Route::post('updateCoachWeight', 'CoachOrganizeController@updateCoachWeight');
    
            Route::post('updateCoachShow', 'CoachOrganizeController@updateCoachShow');
    
            Route::post('updateCoachRec', 'CoachOrganizeController@updateCoachRec');
    
            Route::post('updateCoachCon', 'CoachOrganizeController@updateCoachCon');
    
            Route::post('updateCoachTui', 'CoachOrganizeController@updateCoachTui');
            
            Route::post('deleteAppointCoach', 'CoachOrganizeController@deleteAppointCoach');
            
            Route::post('getAllBranchCoach', 'CoachOrganizeController@getAllBranchCoach');
            
            Route::get('getonecoach', 'CoachOrganizeController@getOneCoach');
            
            Route::post('createCoach', 'CoachOrganizeController@createCoach');
    
            Route::get('getcoubycoach', 'CouponController@getCouByCoach');
            
            Route::post('updateCoach', 'CoachOrganizeController@updateCoach');
            
            Route::post('createktd', 'CoachOrganizeController@setNewKTD');
            
            Route::post('created', 'CoachOrganizeController@setD');
    
            Route::post('setManualRecInfos', 'InformationController@setManualRecInfos');
    
            Route::post('getAppointInfoRelevantMajor', 'InformationController@getAppointInfoRelevantMaj');
            /**
             * 优惠券模块　coupon模块
             */
            
            
            Route::post('getPageCoupon', 'CouponController@getPageCoupon');
            
            Route::get('getcoachcoupon', 'CouponController@getCouponByCoachId');

            Route::get('getAppoCoupon', 'CouponController@getAppoCoupon');
            
            Route::post('updateweight', 'CoachOrganizeController@updateWeight');
            
            Route::post('updateshow', 'CoachOrganizeController@updateShow');
            
            Route::post('getPageCouponCount', 'CouponController@getPageCouponCount');
            
            Route::post('setAppointCoachCouponsEnable', 'CouponController@setAppointCoachCouponsEnable');
            
            Route::post('getAppointCoupon', 'CouponController@getAppointCoupon');
            
            Route::post('setAppointCouponEnable', 'CouponController@setAppointCouponEnable');
            
            Route::post('createCoupon', 'CouponController@createCoupon');
            
            Route::post('updateAppointCoupon', 'CouponController@updateAppointCoupon');
            
            
            /**
             * 资讯模块　information模块
             */
            
            Route::post('setInformationdynamic', 'InformationController@setInformationdynamic');

            Route::post('getInfoPageMsg', 'InformationController@getInfoPageMsg');
            
            Route::post('getInfoPageCount', 'InformationController@getInfoPageCount');
            
            Route::post('setAppointInfoState', 'InformationController@setAppointInfoState');
            
            Route::post('selectInfoReception', 'InformationController@selectInfoReception');
            
            Route::post('updateAppointInfoMsg', 'InformationController@updateAppointInfoMsg');
            
            Route::post('deleteAppointInfo', 'InformationController@deleteAppointInfo');
            
            Route::post('createInfo', 'InformationController@createInfo');
            
            Route::post('setAppointRelationCollege', 'InformationController@setAppointRelationCollege');
            
            Route::post('getAllCollege', 'InformationController@getAllCollege');
            
            Route::post('sendInfoDynamic', 'InformationController@sendInfoDynamic');
            
            Route::post('setManualRecInfos', 'InformationController@setManualRecInfos');
            
            Route::post('setAutomaticRecInfos', 'InformationController@setAutomaticRecInfos');
            
            Route::post('getAllInfo', 'InformationController@getAllInfo');
            
            Route::post('setManualInfoRelationCollege', 'InformationController@setManualInfoRelationCollege');
            
            Route::post('setAutoInfoRelationCollege', 'InformationController@setAutoInfoRelationCollege');
            
            Route::post('getInfoType', 'InformationController@getInfoType');
            
            Route::post('updateInfoExtendMsg', 'InformationController@updateInfoExtendMsg');
            
            Route::post('updateInfoTextMsg', 'InformationController@updateInfoTextMsg');
            
            Route::post('getAppointInfoRecommendRead', 'InformationController@getAppointInfoRecommendRead');
            
            Route::post('delinfos', 'InformationController@delInfos');
            
            Route::post('delappoinrelevantmajor', 'InformationController@delAppoinRelevantMajor');
    
            /**
             * 轮询获取消息提醒
             */
            Route::get('getding', 'InformationController@getDing');
        });
        
        
        /**
         * News模块
         */
        Route::group(['prefix' => 'news', 'namespace' => 'News'], function () {
            
            // Route::get('test','HistoricalNewsController@getFailSendNews');
            
            /**
             * 发送消息
             */
            Route::post('getAllAccounts', 'SendNewsController@getAllAccounts');

            Route::get('putExcel', 'SendNewsController@putExcel');
            
            Route::post('batchScreenAccounts', 'SendNewsController@batchScreenAccounts');
            
            Route::post('manualSelectionAccounts', 'SendNewsController@manualSelectionAccounts');
            
            Route::post('getNewNewsMessage', 'SendNewsController@getNewNewsMessage');
            
            Route::post('getAllMajorDict', 'SendNewsController@getAllMajorDict');
            
            Route::post('getAllActivityDict', 'SendNewsController@getAllActivityDict');
            
            /**
             * 历史消息
             */
            Route::post('getScreenNews', 'HistoricalNewsController@getScreenNews');
            
            Route::post('getAppointNews', 'HistoricalNewsController@getAppointNews');
            
            Route::post('getFailSendNews', 'HistoricalNewsController@getFailSendNews');
            
            Route::post('exportNewsExcel', 'HistoricalNewsController@exportNewsExcel');
            
            Route::post('getAppointUser', 'HistoricalNewsController@getAppointUser');
            
            
        });
    
    
        Route::group(['prefix' => 'refund', 'namespace' => 'Refund'], function () {
    
            Route::post('getrefund', 'RefundController@getRefundPageMsg');
            Route::post('setApproveStatus', 'RefundController@setApproveStatus');
            Route::get('getOne', 'RefundController@getOne');
            
        });
        
        /**
         * OPerate模块
         */
        Route::group(['prefix' => 'operate', 'namespace' => 'Operate'], function () {
            
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