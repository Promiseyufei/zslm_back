<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/21
     * Time: 10:14
     */
    
    namespace App\Http\Controllers\Front\Coach;
    
    
    use App\Http\Controllers\Controller;
    use App\Models\dict_region as dictRegion;
    use App\Models\user_coupon;
    use App\Models\zslm_activitys;
    use App\Models\zslm_coupon;
    use Illuminate\Http\Request;
    
    use App\Models\coach_organize as coachOrganize;
    
    
    class CoachController extends Controller
    {
        /*
         * getSelectCoach 获取辅导机构列表
         *
         * 用于在院校列表页面，通过用户选择和输入的筛选条件，筛选符合条件的辅导机构
         *
         * @param page 页码
         * @param page_size 页面大小
         */
        public function getSelectCoach(Request $request)
        {
            if(!$request->method('get'))
                return responseToJson(1,'请求方式错误');
            if(!isset($request->page) || !isset($request->page_size) || !is_numeric($request->page) || !is_numeric($request->page_size))
                return responseToJson(1,'没有页码、页面大小或者页码、也买你大小不是数字');
            $provice = '';
            
//            if (!empty($request->provice) && $request->provice != '')
//                $provice = dictRegion::getProvinceIdByName($request->provice);
            
            $fields = ['id', 'coach_name', 'province', 'if_coupons', 'if_back_money', 'cover_name', 'cover_alt', 'logo_name', 'logo_alt'];
            $coachs = coachOrganize::getSelectCoach($provice, $request->coach_type,
                $request->coach_name, $request->page, $request->page_size,
                $request->if_back, $request->if_coupon, $fields);
        
            if (sizeof($coachs) == 0)
                return responseToJson(1, '暂时没有数据');
            $len = sizeof($coachs);
            $f = ['id','coach_name'];
            for ($i = 0; $i < $len; $i++) {
                $coachs[$i]->son_coachs = coachOrganize::getSonCoach($coachs[$i]->id,$f);
            }
            $count = coachOrganize::getSelectCoachCount($provice, $request->coach_type,
                $request->coach_name, $request->if_back, $request->if_coupon);

            return responseToJson(0,'success',[$coachs,$count]);
        }
    
        /**
         * @param Request $request
         *
         * @return 查询结构
         */
        
        public function getCoachByName(Request $request){
            if(!$request->isMethod('get'))
                return responseToJson('1','请求错误');
    
            if(!isset($request->page) || !isset($request->page_size) || !is_numeric($request->page) || !is_numeric($request->page_size))
                return responseToJson(1,'没有页码、页面大小或者页码、也买你大小不是数字');
            
            $coachs = $this->getIndexInfo($request->name,$request->page,$request->page_size);
            if(sizeof($coachs) == 0)
                return responseToJson(1,'没有数据');
            return responseToJson(0,'success',$coachs);
        }
    
        /**
         * 在首页获取首页的coach列表
         *
         * @param     $name coach名称
         * @param int $page 页码
         * @param int $page_size 页面大小
         *
         * @return 查询结构
         */
        
        public function getIndexInfo($name,$page = 1,$page_size = 3){
            $fields = ['id', 'coach_name', 'if_coupons', 'if_back_money', 'cover_name', 'cover_alt', 'logo_name', 'logo_alt'];
            $coachs = coachOrganize::getSelectCoach('', null,
                $name, $page, $page_size,
                null,null, $fields);
            return $coachs;
        }
        
        /**
         *  获取指定的coach
         */
        public function getCoachById(Request $request){
    
            if(!$request->isMethod('get'))
                return responseToJson('1','请求错误');
    
            if(!isset($request->id) || !is_numeric($request->id))
                return responseToJson(1,'id错误');
            
            $fields = ['id', 'coach_name', 'phone', 'address', 'web_url', 'update_time',
                'coach_type', 'describe', 'logo_name', 'logo_alt','cover_name', 'cover_alt','province'];
            $coach = coachOrganize::getCoachById($request->id,$fields);
            if(sizeof($coach) == 0)
                return responseToJson(1,'没有数据');
            $coach[0]->son_coach = coachOrganize::getSonCoach($request->id,$fields);
            $f = ['id','name','type','is_enable'];
            //获取辅导机构的优惠券
            $coach[0]->coupont = zslm_coupon::getFrontCouponByCoach($request->id,$f);
            
            //获取地区热门的活动
            $province = explode(EXPLODE_STR,$coach[0]->province)[0];
            $get_activitys = zslm_activitys::getFrontActiById($province,1,1);
            $get_activitys['info'] = $get_activitys['info']->toArray();
    
            foreach ($get_activitys['info'] as $key => $item) {
                $now_time = time();
                $get_activitys['info'][$key]->start_state = $now_time < $item->begin_time ? 0 : $now_time > $item->end_time ? 2 : 1;
                $get_activitys['info'][$key]->begin_time = date("m-d",$item->begin_time);
                $get_activitys['info'][$key]->end_time = date("m-d", $item->end_time);
                if($item->province !== '')
                    $get_activitys['info'][$key]->province = getProCity($item->province);
            }
            
            $coach[0]->best_hot_active = $get_activitys;
            return responseToJson(0,'success',$coach);
        }
        
        public function getUserCoach(Request $request){
    
            if(!$request->isMethod('get'))
                return responseToJson('1','请求错误');
    
            if(!isset($request->id) || !isset($request->id))
                return responseToJson(1,'user_id 错误');
    
    
            if(!isset($request->type) || !isset($request->type))
                return responseToJson(1,'type 错误');
            if(!isset($request->is_use) || !isset($request->is_use))
                return responseToJson(1,'is_use 错误');
            
            $use_coupon = user_coupon::getCountUserCoupon($request->id,0);
            $notuse_coupon =   user_coupon::getCountUserCoupon($request->id,1);
            $noEn_coupon = user_coupon::getCountEnableCoupon($request->id,1);
            
            if(!isset($request->page) || !isset($request->page_size) || !is_numeric($request->page) || !is_numeric($request->page_size))
                return responseToJson(1,'没有页码、页面大小或者页码、也买你大小不是数字');
            
            
            $id = $request->id;
           $coupon_ids =  user_coupon::getCouponIdWithUse($id,$request->is_use);
           if(sizeof($coupon_ids) == 0)
               return responseToJson(1,'没有优惠券');
           $coupon_id_arr = [];
           for($i = 0;$i<sizeof($coupon_ids);$i++)
               $coupon_id_arr[$i] = $coupon_ids[$i]->coupon_id;
           
            $coachs = zslm_coupon::getCoachByCoupon($coupon_id_arr,$request->page,$request->page_size,$request->type);
            
            $coach_arr = [];
    
            for($i = 0;$i<sizeof($coachs);$i++)
                $coach_arr[$i] = $coachs[$i]->coach_id;
            
            $coach_res = coachOrganize::getAllCoachByIds($coach_arr,['id','coach_name','province','web_url']);
            
            for($i = 0;$i<sizeof($coach_res);$i++){
                $province = explode(EXPLODE_STR,$coach_res[$i]->province);
                
                $coach_res[$i]->province = dictRegion::getOneArea($province[0])[0]->name;
                $coach_res[$i]->city = '';
                if (sizeof($province) > 1)
                    $coach_res[$i]->city = dictRegion::getOneArea($province[1])[0]->name;
                $coupon = zslm_coupon::getUserCoachCoupon($request->id,$coach_res[$i]->id,$request->type,$request->is_use);
                $coach_res[$i]->coupon = $coupon;
            }
//            dd($coach_res);
            return responseToJson(0,'success',$coach_res);
            
        }
    }