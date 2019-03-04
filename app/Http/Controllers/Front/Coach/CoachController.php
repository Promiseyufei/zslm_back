<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/21
     * Time: 10:14
     */
    
    namespace App\Http\Controllers\Front\Coach;
    
    
    use App\Http\Controllers\Controller;
    use App\Models\dict_fraction_type;
    use App\Models\dict_recruitment_pattern;
    use App\Models\dict_region as dictRegion;
    use App\Models\major_recruit_project;
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
         * @param provice 地区
         * @param coach_type 辅导形式　0线上，1线下，2线上＋线下
         * @param coach_name 辅导机构名称
         * @param if_back 是否支持退款（0支持，1不支持）
         * @param if_coupon 是否支持优惠券  （0支持，1不支持）
         * @param page 页码
         * @param page_size 页面大小
         */
        public function getSelectCoach(Request $request)
        {

            if (!$request->method('get')) return responseToJson(1, '请求方式错误');
            
            $page = $request->page ? (int)$request->page : 1;
            $page_size = $request->page_size ? (int)$request->page_size : 10;
            
            $provice = '';
            
            if (!empty($request->provice) && $request->provice != '') {
                $provice = dictRegion::getProvinceIdByName_c($request->provice);
                $provice = $provice->id;
            }

            $fields = ['id', 'coach_name', 'province', 'if_coupons', 'if_back_money', 'cover_name', 'cover_alt', 'logo_name', 'logo_alt' , 'logo_white'];
            
            $coachs = coachOrganize::getSelectCoach($provice, $request->coach_type,
                $request->coach_name, $page, $page_size,
                $request->if_back, $request->if_coupon, $fields);

            
            if ($coachs == null || sizeof($coachs) == 0)
                return responseToJson(1, '暂时没有数据');
            $len = sizeof($coachs);
            $f = ['coach_organize.id', 'coach_name'];
            for ($i = 0; $i < $len; $i++) {
                $coachs[$i]->son_coachs = coachOrganize::getSonCoach($coachs[$i]->id, $f);
            }
            
            $count = coachOrganize::getSelectCoachCount($provice, $request->coach_type,
                $request->coach_name, $request->if_back, $request->if_coupon);
            
            return responseToJson(0, 'success', [$coachs, $count]);
        }
        
        /**
         * @param Request $request
         *
         * @return 查询结构
         */
        
        public function getCoachByName(Request $request)
        {
            if (!$request->isMethod('get'))
                return responseToJson('1', '请求错误');
            
            if (!isset($request->page) || !isset($request->page_size) || !is_numeric($request->page) || !is_numeric($request->page_size))
                return responseToJson(1, '没有页码、页面大小或者页码、也买你大小不是数字');
            
            $coachs = $this->getIndexInfo($request->name, $request->page, $request->page_size);
            $count = coachOrganize::getSelectCoachCount('', null, $request->name, null, null);
            if ($coachs == null || sizeof($coachs) == 0)
                return responseToJson(1, '没有数据');
            return responseToJson(0, 'success', ['coachs' => $coachs, 'count' => $count]);
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
        
        public function getIndexInfo($name, $page = 1, $page_size = 3)
        {
            $fields = ['id', 'coach_name', 'if_coupons', 'if_back_money', 'cover_name', 'cover_alt', 'logo_name', 'logo_alt'];
            $coachs = coachOrganize::getSelectCoach('', null,
                $name, $page, $page_size,
                null, null, $fields);
            return $coachs;
        }
        
        /**
         *
         * 辅导机构详情
         *  获取指定的coach
         */
        public function getCoachById(Request $request)
        {
            
            if (!$request->isMethod('get'))
                return responseToJson('1', '请求错误');
            
            if (!isset($request->id) || !is_numeric($request->id))
                return responseToJson(1, 'id错误');
            
            $fields = ['id', 'coach_name', 'phone', 'address', 'web_url', 'update_time', 'title',
                'coach_type', 'describe', 'logo_name', 'logo_alt', 'cover_name', 'cover_alt', 'province'];
            $coach = coachOrganize::getCoachById($request->id, $fields);
            if ($coach == null || sizeof($coach) == 0)
                return responseToJson(1, '没有数据');

            $coach[0]->logo_name = splicingImgStr('admin', 'info', $coach[0]->logo_name);
            $coach[0]->cover_name = splicingImgStr('admin', 'info', $coach[0]->cover_name);
            $coach[0]->update_time = date('Y.m.d' , $coach[0]->update_time);

            $fields = ['coach_organize.id', 'coach_name', 'phone', 'address', 'web_url', 'update_time',
                'coach_type', 'describe', 'logo_name', 'logo_alt', 'cover_name', 'cover_alt', 'dict_region.name as province' , 'if_coupons' , 'if_back_money'];
            $coach[0]->son_coach = coachOrganize::getSonCoach($request->id, $fields);

            foreach($coach[0]->son_coach as $k=>$v){
                $coach[0]->son_coach[$k]->update_time = date('Y.m.d' , $v->update_time);
                $coach[0]->son_coach[$k]->cover_name = splicingImgStr('admin', 'info', $v->cover_name);
                $coach[0]->son_coach[$k]->logo_name = splicingImgStr('admin', 'info', $v->logo_name);
            }

            $f = ['id', 'name', 'type', 'is_enable'];
            
            //获取辅导机构的优惠券
            $coach[0]->coupon = zslm_coupon::getFrontCouponByCoach($request->id, $f);
            if ($coach[0]->coupon != null)
                for ($i = 0; $i < sizeof($coach[0]->coupon); $i++) {
                    $user_coupont = user_coupon::getUserCouponByCouponId($request->u_id, $coach[0]->coupon[$i]->id);
                    $user_coupont_len = $user_coupont != null ? sizeof($user_coupont) : 0;
                    $coach[0]->coupon[$i]->is_have = $user_coupont_len;
                    $coach[0]->coupon[$i]->is_use = 0;
                    if ($user_coupont_len > 0) {
                        $coach[0]->coupon[$i]->is_use = $user_coupont[0]->use_time;
                    }
                }
            //获取地区热门的活动
            $province = explode(EXPLODE_STR, $coach[0]->province)[0];
            $get_activitys = zslm_activitys::getFrontActiById($province, 1, 1);
            $get_activitys['info'] = $get_activitys['info']->toArray();
            
            foreach ($get_activitys['info'] as $key => $item) {
                $now_time = time();
                $get_activitys['info'][$key]->start_state = $now_time < $item->begin_time ? 0 : $now_time > $item->end_time ? 2 : 1;
                $get_activitys['info'][$key]->begin_time = date("m月d日", $item->begin_time);
                $get_activitys['info'][$key]->end_time = date("m月d日", $item->end_time);
                $get_activitys['info'][$key]->active_img = splicingImgStr('admin', 'info', $item->active_img);
                $get_activitys['info'][$key]->magor_logo_name = splicingImgStr('admin', 'info', $item->magor_logo_name);
                if ($item->province !== '')
                    $get_activitys['info'][$key]->province = getProCity($item->province);
            }
            
            $coach[0]->best_hot_active = $get_activitys;
            return responseToJson(0, 'success', $coach);
        }
        
        /**
         * 获取用户领取的优惠券
         *
         * @param Request $request
         *
         * @return mixed
         */
        public function getUserCoach(Request $request)
        {
            
            if (!$request->isMethod('get'))
                return responseToJson('1', '请求错误');
            
            if (!isset($request->id) || !isset($request->id))
                return responseToJson(1, 'user_id 错误');
            
            
            if (!isset($request->type) || !isset($request->type))
                return responseToJson(1, 'type 错误');
            if (!isset($request->is_use) || !isset($request->is_use))
                return responseToJson(1, 'is_use 错误');
            
            $page = $request->page ? (int)$request->page : 1;
            $page_size = $request->page_size ? (int)$request->page_size : 10;
            $type = $request->type ? (int)$request->type : 0;
            $is_use = $request->is_use ? (int)$request->is_use : 0;
            
            $id = $request->id;
            $coupon_ids = user_coupon::getCouponIdWithUse($id, $is_use);
            
            //获取每种优惠券的数量
            $c1 = zslm_coupon::getUserCoachCouponCount($request->id, 0, 0);   //  未使用
            $c2 = zslm_coupon::getUserCoachCouponCount($request->id, 1, 1);   //  已使用
            $c3 = zslm_coupon::getUserCoachCouponCount($request->id, 2, 0);   //  已失效
            
            if ($coupon_ids == null || sizeof($coupon_ids) == 0) {
                return responseToJson(1, '没有优惠券', ['nouse' => $c1, 'use' => $c2, 'enable' => $c3]);
            }
            
            $coupon_id_arr = [];
            for ($i = 0; $i < sizeof($coupon_ids); $i++) {
                $coupon_id_arr[$i] = $coupon_ids[$i]->coupon_id;
            }
            
            //获取辅导机构
            $coachs = zslm_coupon::getCoachByCoupon($coupon_id_arr, $page, $page_size, $type);
            
            $coach_arr = [];
            
            if ($coachs != null) {
                for ($i = 0; $i < sizeof($coachs); $i++) {
                    $coach_arr[$i] = $coachs[$i]->coach_id;
                }
            }
            
            $coach_res = coachOrganize::getAllCoachByIds($coach_arr, ['id', 'coach_name', 'province', 'web_url']);
            /**
             * 根据用户选择的使用我、未使用或者过期，获取辅导机构的优惠券
             */
            if ($coach_res != null) {
                for ($i = 0; $i < sizeof($coach_res); $i++) {
                    
                    if (!empty($coach_res[$i]->province) && $coach_res[$i]->province != '') {
                        $province = explode(EXPLODE_STR, $coach_res[$i]->province);
                        
                        $coach_res[$i]->province = dictRegion::getOneArea($province[0])[0]->name;
                        $coach_res[$i]->city = '';
                        if ($province != null && sizeof($province) > 1) {
                            $coach_res[$i]->city = dictRegion::getOneArea($province[1])[0]->name;
                        }
                    } else {
                        $coach_res[$i]->province = '';
                        $coach_res[$i]->city = '';
                    }
                    $coupon = zslm_coupon::getUserCoachCoupon($request->id, $coach_res[$i]->id, $type, $is_use);
                    
                    $coach_res[$i]->coupon = $coupon;
                }
                
            }
            return responseToJson(0, 'success', [$coach_res, 'nouse' => $c1, 'use' => $c2, 'enable' => $c3]);
            
        }
        
        /**
         * 用户领取优惠券
         *
         * @param Request $request
         *
         * @return mixed
         */
        public function addUserCoupon(Request $request)
        {
            
            if (!isset($request->c_id) || !isset($request->c_id))
                return responseToJson(1, 'c_id 错误');
            
            if (!isset($request->u_id) || !isset($request->u_id))
                return responseToJson(1, 'u_id 错误');
            
            $result = user_coupon::addUserCoupon($request->u_id, $request->c_id);
            if ($result == 1) {
                return responseToJson(0, 'success');
            } else {
                return responseToJson(1, "领取失败");
            }
            
        }
        
        
        public function getAllConpon(Request $request)
        {
            $where = ['is_delete'=>0];

            $coupon = coachOrganize::getAllCoupon($where , $request->name);
            
            if (empty($coupon) || sizeof($coupon) == 0)
                return responseToJson(1, '暂无数据');
            
            for ($i = 0; $i < sizeof($coupon); $i++) {
                $coupon[$i]->logo_name = splicingImgStrPro('admin/info/', $coupon[$i]->logo_name);
                $coupon[$i]->cover_name = splicingImgStrPro('admin/info/', $coupon[$i]->cover_name);
            }
            return responseToJson(0, 'success', $coupon);
        }
    }