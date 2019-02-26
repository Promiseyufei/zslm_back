<?php
    
    namespace App\Http\Controllers\Front\Activity;
    
    use App\Models\dict as Dict;
    use App\Models\user_activitys;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Models\dict_region as DictRegion;
    use App\Models\activity_relation as ActivityRelation;
    use App\Models\zslm_activitys as ZslmActivitys;
    use App\Models\zslm_major as ZslmMajor;
    use App\Models\user_activitys as UserActivitys;
    use League\Flysystem\Exception;
    
    class ActivityController extends Controller
    {
        
        
        /**
         * 搜索页面请求活动
         *
         * @param $keyword 关键字
         * @param $pageCount 页面显示行数
         * @param $pageNumber 页面显示下标
         *
         * return :
         * 活动id
         * 活动名称
         * 活动地点（城市）
         * 活动日期范围
         * 活动开始状态
         * 活动封面
         * 活动类型
         * 活动主办院校名称
         *
         */
        public function getSearchActivity(Request $request)
        {
            
            if ($request->isMethod('get')) {
                $keyword = !empty($request->keyword) ? trim($request->keyword) : '';
                // if(!defined($request->pageCount) || !isset($requesst->pageNumber)) return responseToJson(1, '参数错误');
                $get_activity_info = ZslmActivitys::getSearchActivitys($keyword, $request->pageNumber, $request->pageCount);
                // dd($get_activity_info);
                foreach ($get_activity_info['activitys'] as $key => $item) {
                    $now_time = time();
                    $get_activity_info['activitys'][$key]->startState = $now_time < $item->begin_time ? 0 : $now_time > $item->end_time ? 2 : 1;
                    $get_activity_info['activitys'][$key]->begin_time = date("m-d", $item->begin_time);
                    $get_activity_info['activitys'][$key]->end_time = date("m-d", $item->end_time);
                    if ($item->active_img != '')
                        $get_activity_info['activitys'][$key]->active_img = splicingImgStr('admin', 'info', $item->active_img);
                    if ($item->magor_logo_name != '')
                        $get_activity_info['activitys'][$key]->magor_logo_name = splicingImgStr('admin', 'info', $item->magor_logo_name);
                    if ($item->province !== '')
                        $get_activity_info['activitys'][$key]->province = getProCity($item->province);
                }
                if (empty($get_activity_info['activitys'])) return responseToJson(1, '没有查询到数据');
                return responseToJson(0, 'success', $get_activity_info);
            } else return responseToJson(2, '请求方式错误');
        }
        
        
        /**
         * 前台活动列表页获得活动类型
         */
        public function getActivityType(Request $request)
        {
            if ($request->isMethod('get'))
                return responseToJson(0, 'success', Dict::getActivityType());
            else
                return responseToJson(2, '请求方式错误');
        }
        
        
        /**
         * 前台活动列表页获得搜索的活动
         *
         * @param $keyword string
         * @param $majorType array
         * @param $province array
         * @param $activityType array
         * @param $activityState array
         * @param $activityDate int
         * @param $pageCount 页面显示行数
         * @param @pageNumber 页面下表
         *
         * @return
         * 活动id
         * 活动名称
         * 活动地点（城市）
         * 活动日期范围
         * 活动开始状态
         * 活动封面
         * 活动类型
         * 活动主办院校名称
         */
        public function getActivity(Request $request)
        {
            
            if ($request->isMethod('get')) {
                // dd($request);
                
                $provice_id_arr = [];
                $keyword = !empty($request->keyword) ? trim($request->keyword) : '';
                $pageCount = !empty($request->pageCount) ? $request->pageCount : 12;
                $pageNumber = !empty($request->pageNumber) ? $request->pageNumber : 1;
                if (isset($request->province) && is_array($request->province) && count($request->province)) {
                    $provice_id_arr = DictRegion::getProvinceIdByName($request->province);
                }
                
                $get_activitys = ZslmActivitys::getFrontActiListInfo($keyword, $request->majorType, $provice_id_arr, $request->activityType,
                    $request->activityState, $request->activityDate, $pageCount, $pageNumber);
                
                $get_activitys['info'] = $get_activitys['info']->toArray();
                
                foreach ($get_activitys['info'] as $key => $item) {
                    $now_time = time();
                    $get_activitys['info'][$key]->start_state = $now_time < $item->begin_time ? 0 : $now_time > $item->end_time ? 2 : 1;
                    $get_activitys['info'][$key]->begin_time = date("m-d", $item->begin_time);
                    $get_activitys['info'][$key]->end_time = date("m-d", $item->end_time);
                    if ($item->active_img != '')
                        $get_activitys['info'][$key]->active_img = splicingImgStr('admin', 'info', $item->active_img);
                    if ($item->magor_logo_name != '')
                        $get_activitys['info'][$key]->magor_logo_name = splicingImgStr('admin', 'info', $item->magor_logo_name);
                    
                    if ($item->province !== '')
                        $get_activitys['info'][$key]->province = getProCity($item->province);
                }
                return responseToJson(0, 'success', $get_activitys);
                
            } else return responseToJson(2, 'error');
        }
        
        /**
         * 获取主页的activity
         *
         * @param Request $request
         * @param         $page
         * @param         $page_size
         *
         * @return array|null
         */
        
        public function getIndexActivity(Request $request, $page, $page_size)
        {
            if ($request->isMethod('get')) {
                $provice_id_arr = [];
                $keyword = !empty($request->keyword) ? trim($request->keyword) : '';
                if (isset($request->province) && is_array($request->province) && count($request->province)) {
                    $provice_id_arr = DictRegion::getProvinceIdByName($request->province);
                }
                
                
                $get_activitys = ZslmActivitys::getFrontActiListInfoNoCount('', $request->majorType, $provice_id_arr, $request->activityType,
                    
                    $request->activityState, $request->activityDate, $page_size, $page);
                
                $get_activitys['info'] = $get_activitys['info']->toArray();
                
                if ($get_activitys['info'] != null && sizeof($get_activitys['info']) > 0)
                    foreach ($get_activitys['info'] as $key => $item) {
                        $now_time = time();
                        $get_activitys['info'][$key]->start_state = $now_time < $item->begin_time ? 0 : $now_time > $item->end_time ? 2 : 1;
                        $get_activitys['info'][$key]->begin_time = date("m-d", $item->begin_time);
                        $get_activitys['info'][$key]->end_time = date("m-d", $item->end_time);
                        
                        if ($item->province !== '' && !empty($item->province))
                            try {
                                $get_activitys['info'][$key]->province = getProCity_B($item->province);
                            } catch (\Exception $e) {
//                                dd($item);
                                return responseToJson(1,'出错了');
                            }
                    }
                return $get_activitys;
                
            } else return null;
        }
        
        /**获取用户关注的activity
         *
         * @param Request $request
         *
         * @return mixed
         */
        
        public function getUserActivity(Request $request)
        {
            if (!$request->isMethod('get'))
                return responseToJson(1, '请求错误');
            
            if (!isset($request->id) && !is_numeric($request->id))
                return responseToJson(1, "院校id不存在，或者不为数字");
            
            if (!isset($request->page) || !isset($request->page_size) || !is_numeric($request->page) || !is_numeric($request->page_size))
                return responseToJson(1, '没有页码、页面大小或者页码、页面大小不是数字');
            $active_ids = user_activitys::getActivityByUser($request->id);
            $acitve_ids_arru = [];
            
            if ($active_ids == null || sizeof($active_ids) == 0)
                return responseToJson(1, '暂无数据');
            
            if ($active_ids != null)
                for ($i = 0; $i < sizeof($active_ids); $i++) {
                    $acitve_ids_arru[$i] = $active_ids[$i]->activity_id;
                }
            
            $get_activitys = ZslmActivitys::getFrontUserActivity($acitve_ids_arru, $request->page, $request->page_size);
            
            
            $get_activitys['info'] = $get_activitys['info']->toArray();
            
            foreach ($get_activitys['info'] as $key => $item) {
                $now_time = time();
                $get_activitys['info'][$key]->start_state = $now_time < $item->begin_time ? 0 : $now_time > $item->end_time ? 2 : 1;
                $get_activitys['info'][$key]->begin_time = date("Y-m-d", $item->begin_time);
                $get_activitys['info'][$key]->end_time = date("Y-m-d", $item->end_time);
                $get_activitys['info'][$key]->update_time = date("Y-m-d", $item->update_time);
                if ($item->province !== '')
                    $get_activitys['info'][$key]->province = getProCity($item->province);
            }
            return responseToJson(0, 'success', $get_activitys);
            
        }
        
        /**取消关注
         *
         * @param Request $request
         *
         * @return mixed
         */
        public function unsetUserActivity(Request $request)
        {
            if (!$request->isMethod('post'))
                return responseToJson(1, '请求错误');
            if (!isset($request->id) || !is_numeric($request->id) || !isset($request->a_id) || !is_numeric($request->a_id))
                return responseToJson(1, 'id或者a_id错误');
            $result = user_activitys::unsetUserActivity($request->id, $request->a_id);
            if ($result > 0)
                return responseToJson(0, '取消成功');
            else
                return responseToJson(1, '取消失败');
        }
        
        
        /**
         * 活动详情页获得活动信息
         */
        public function getAppointAcInfo(Request $request)
        {
            if ($request->isMethod('get')) {
                $activity_id = !empty($request->acId) ? $request->acId : 0;
                if ($activity_id == 0) return responseToJson(1, '参数错误');
                $activity = ZslmActivitys::getAppointAcInfos($activity_id);
                if (!empty($activity)) {
                    $now_time = time();
                    $activity->start_state = $now_time < $activity->begin_time ? 0 : $now_time > $activity->end_time ? 2 : 1;
                    $activity->begin_time = date("Y-m-d H:i", $activity->begin_time);
                    $activity->end_time = date("Y-m-d H:i", $activity->end_time);
                    return responseToJson(0, 'success', $activity);
                } else return responseToJson(1, '没有查询到数据');
                
            } else return responseToJson(2, '请求方式错误');
        }
        
        /**
         * 活动详情页获得活动的主办院校信息
         */
        public function getAcHostMajor(Request $request)
        {
            if ($request->isMethod('get')) {
                $activity_id = !empty($request->acId) ? $request->acId : 0;
                if ($activity_id == 0) return responseToJson(1, '参数错误');
                $host_major_id = ActivityRelation::getAppointContent($activity_id, 'host_major_id');
                $major = ZslmMajor::getMjorInfo($host_major_id, ['id', 'magor_logo_name', 'major_cover_name', 'z_name', 'province']);
                
                if (!empty($host_major_id) || !empty($major)) {
                    if ($major->province !== '') {
                        $p = getProCity($major->province);
                        $major->province = $p['province'];
                        $major->city = $p['city'];
                    }
                    
                    if (!empty($major->magor_logo_name)) $major->magor_logo_name = splicingImgStr('admin', 'info', $major->magor_logo_name);
                    if (!empty($major->major_cover_name)) $major->major_cover_name = splicingImgStr('admin', 'info', $major->major_cover_name);
                    
                    return responseToJson(0, 'success', $major);
                } else return responseToJson(1, '该活动不存在主办院校');
            } else return responseToJson(2, '请求方式错误');
        }
        
        /**
         * 活动详情页获得热门(推荐)活动数据列表
         */
        public function getPopularAcInfo(Request $request)
        {
            if ($request->isMethod('get')) {
                $activity_id = !empty($request->acId) ? $request->acId : 0;
                if ($activity_id == 0) return responseToJson(1, '参数错误');
                $relation_activity = ActivityRelation::getAppointContent($activity_id, 'relation_activity');
                $tuijian_activity_id_arr = !empty($relation_activity) ? strChangeArr($relation_activity, ',') : [];
                
                $tuijian_ac = ZslmActivitys::getFrontPopularAcInfo($tuijian_activity_id_arr, $request->pageNumber);
                
                if (count($tuijian_ac['acInfo']))
                    foreach ($tuijian_ac['acInfo'] as $key => $item) {
                        $tuijian_ac['acInfo'][$key]->begin_time = date('Y.m.d', $item->begin_time);
                        if (!empty($item->active_img)) $tuijian_ac['acInfo'][$key]->active_img = splicingImgStr('admin', 'info', $item->active_img);
                    }
                return responseToJson(0, 'success', $tuijian_ac);
                
            } else return responseToJson(2, '请求方式错误');
        }
        
        /**
         * 活动详情页点击我要报名按钮后端接口
         */
        public function activitySign(Request $request)
        {
            if ($request->isMethod('post')) {
                $user_id = !empty($request->userId) ? $request->userId : 0;
                $ac_id = !empty($request->acId) ? $request->acId : 0;
                if ($user_id == 0 || $ac_id == 0) return responseToJson(1, '参数错误');
                
                if (time() <= ZslmActivitys::getAcEndTime($ac_id)) {
                    $is_update = UserActivitys::changeUserAcStatus($user_id, $ac_id, 0);
                    return $is_update ? responseToJson(0, '报名成功') : responseToJson(1, '报名失败');
                } else return responseToJson(1, '该活动已过期');
            } else return responseToJson(2, '请求方式错误');
        }
        
    }