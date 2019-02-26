<?php

/**
 * 活动管理
 */

namespace App\Http\Controllers\Admin\Information;


use App\Models\activity_relation as ActivityRelation;
use App\Models\dict_activity_type;
use App\Models\dict_major_type as dictMajorType;
use App\Models\zslm_activitys as ZslmActivitys;
use App\Models\user_accounts as UserAccounts;
// use App\Models\dict_region as DictRegion;
use App\Http\Requests\ActivityCreateRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Models\system_setup as SystemSetup;
use App\Models\dict_region as dictRegion;
use App\Models\zslm_activitys;
use App\Models\zslm_major as ZslmMajor;
use App\Models\news_users as NewsUsers;
use App\Models\user_follow_major as UserFollowMajor;
use App\Models\dynamic_news as DynamicNews;

use App\Http\Controllers\Controller;
use App\Models\zslm_major;
use Illuminate\Http\Request;
use App\Models\dict as Dict;
use App\Models\news as News;
use Illuminate\Support\Facades\Storage;
use Validator;
use DB;

class ActivityController extends Controller
{

    /**
     * @api {post} admin/information/getActivityPageMessage 获取活动列表页分页数据
     * @apiGroup information
     *
     *
     * @apiParam {String} activityNameKeyword 活动名称关键字
     * @apiParam {Number} screenType 筛选方式(0按展示状态；1按推荐状态;2活动状态；3全部)
     * @apiParam {Number} screenState 筛选状态(0展示/推荐；1不展示/不推荐;2全部)
     * @apiParam {Number} activityState 活动状态(0未开始；1进行中;2已结束；3全部)
     * @apiParam {Number} sortType 排序类型(0按权重升序；1按权重降序;2按信息更新时间)
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} pageNumber 跳转页面下标
     *
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "name":"活动名称",
     *              "weight":"活动权重",
     *              "is_show":"是否展示",
     *              "if_recommended":"是否推荐",
     *              "active_type":"活动类型",
     *              "major_type":"专业类型",
     *              "province":"所在省市",
     *              "address":"活动地址",
     *              "begin_time":"活动开始时间",
     *              "end_time":"活动结束时间",
     *              "host_school":"活动主办院校",
     *              "sign_up_state":"报名状态",
     *              "update_time":"信息更新时间"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    
    private function setProvice(array &$msg = []) {
        
        $province = $this->getMajorP()[0];
        
        foreach($msg as $key => $item) {
            $msg[$key]->province = strChangeArr($item->province, ',');
            
            if($province != null)
                for($i = 0;$i<sizeof($province);$i++){
                    if( $msg[$key]->province[0] == $province[$i]->id){
                        $msg[$key]->province = $province[$i]->name;
                    }
                    
                }
    
            $msg[$key]->create_time = date("Y-m-d",$item->create_time);
            $msg[$key]->sign_up_state =  $msg[$key]->sign_up_state == 0 ? '可报名':'不可报名';
            
        }
    }



    
    private function setTime(array &$msg = []) {
        
        
        foreach($msg as $key => $item) {
            
            $msg[$key]->begin_time = date("Y-m-d",$item->begin_time);
            $msg[$key]->end_time =  date("Y-m-d",$item->end_time);
            
        }
    }



    
    public function getMajorP(){
        return getMajorProvincesAndCity();
    }
    


    public function getActivityPageMessage(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式失败');
    
        $rules = [
            'soachNameKeyword' =>'nullable|string|max:255',
            'sortType' => 'numeric',
            'pageCount' => 'numeric',
            'pageNumber' => 'numeric'
        ];
    
        $message = [
            'soachNameKeyword.max' =>'搜索关键字超过最大长度',
            'pageCount.*'             => '参数错误',
            'pageNumber.*'            => '参数错误'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);
        $data =  ZslmActivitys::getActivityPageMsg($request->all());
        $get_msg =$data[0]->toArray();
        $this->setProvice($get_msg);
        return $get_msg ? responseToJson(0, '', [$get_msg,$data[1]]) : responseToJson(1, '没有数据');
    }




    
    public function getActivityAll(Request $request) {
        if(!$request->isMethod('get')) return responseToJson(2, '请求方式失败');
        
        $rules = [
            'soachNameKeyword' =>'nullable|string|max:255',
            'sortType' => 'numeric',
            'pageCount' => 'numeric',
            'pageNumber' => 'numeric'
        ];
        
        $message = [
            'soachNameKeyword.max' =>'搜索关键字超过最大长度',
            'pageCount.*'             => '参数错误',
            'pageNumber.*'            => '参数错误'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray());
        $data =  ZslmActivitys::getActivityAll($request->all());
        $get_msg =$data[0]->toArray();
        $this->setProvice($get_msg);
        return $get_msg ? responseToJson(0, '', [$get_msg,$data[1]]) : responseToJson(1, '没有数据');
    }
    



    public function getActivityMessage(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式失败');
        
        $rules = [
            'soachNameKeyword' =>'nullable|string|max:255',
            'sortType' => 'numeric',
            'pageCount' => 'numeric',
            'pageNumber' => 'numeric'
        ];
        
        $message = [
            'soachNameKeyword.max' =>'搜索关键字超过最大长度',
            'pageCount.*'             => '参数错误',
            'pageNumber.*'            => '参数错误'
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $data =  ZslmActivitys::getActivityMsg($request->all());
        if($data[0] != null && sizeof($data[0])>0)
            foreach($data[0] as $key => $item) {
                $data[0][$key]->update_time  = date("Y-m-d", $item->update_time);
            }
        return ($data[0] != null && sizeof($data[0])>=0) ? responseToJson(0, '', $data) : responseToJson(1, '没有数据');
    }




    /**
     * @api {post} admin/information/getActivityPageCount 获取活动列表页分页数据总数
     * @apiGroup information
     *
     *
     * @apiParam {Array} conditionArr 筛选条件
     *
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *         count:240
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function getActivityPageCount(Request $request) {
        try {
            if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
            if(isset($request->conditionArr) &&  is_array($request->conditionArr))
                return responseToJson(0, '', ZslmActivitys::getActivityAppiCount($request->conditionArr));
            else throw new \Exception('查询失败');
        } catch(\Exception $e) {
            return responseToJson(1, $e->getMessage());
        }
    }
    
    
    public function getOneAct(Request $request){
        if(!$request->isMethod('get')) return responseToJson(2, '请求方式错误');
        if(!isset($request->id) &&  !is_numeric($request->id))
            return responseToJson(0, 'no id');
        $get_msg = ZslmActivitys::getOneActivity($request->id);
        $get_msg->begin_time = date("Y-m-d", $get_msg->begin_time);
        $get_msg->end_time =  date("Y-m-d", $get_msg->end_time);
        $get_msg->active_cover_img_name = $get_msg->active_img;
        $get_msg->active_img = splicingImgStr('admin', 'info', $get_msg->active_img);

        return $get_msg ? responseToJson(0, '', $get_msg) : responseToJson(1, '没有数据');
    }

    /**
     * @api {post} admin/information/setActivityState 设置活动的状态(权重，展示状态，推荐状态)
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
     * @apiParam {Number} type 要修改的状态类型(0修改权重；１修改展示状态；２修改推荐状态;3修改活动状态)
     * @apiParam {Number} state 要修改的值
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "更新成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setActivityState(Request $request) {
        if($request->isMethod('post')) {
            $act_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
            $type = (isset($request->type) && is_numeric($request->type)) ? $request->type : -1;
            $state = (isset($request->state) && is_numeric($request->state)) ? $request->state : -1;

            if($act_id > 0 && $type != -1 && $state != -1) {
                if($type > 0 && $type != 3 && $state > 1) return responseToJson(1, '状态值错误');
                if($type == 3 && $state > 2) return responseToJson(1, '状态值错误');
                $is_update = ZslmActivitys::setAppiActivityState([
                    'act_id'  => $act_id,
                    'type'    => $type,
                    'state'   => $state
                ]);

                return $is_update ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
            }
        }
        else
            return responseToJson(2, '请求方式错误');
    }


    /**
     * @api {get} admin/information/selectActivityReception 跳转到前台对应的活动主页
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * 重定向到前台对应的活动详情页
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '跳转失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function selectActivityReception(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        if($activity_id != 0) {
            $activity = ZslmActivitys::getAppointActivityMsg($activity_id);
            return is_object($activity) ? responseToJson(0, '', $activity) : responseToJson(1, '获取信息失败');
        }
    }



    /**
     * @api {post} admin/information/updateActivityMsg 修改活动的信息
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "更新成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function updateActivityMsg(ActivityUpdateRequest $request) {

    }



    //设置活动的权重
    public function updateActivityWeight(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1,'request error');
        if(!isset($request->id) && !is_numeric($request->id))
            return responseToJson(1,'no id or id is not number');
        if(!isset($request->showWeight) && !is_numeric($request->showWeight))
            return responseToJson(1,'no showWeight or showWeight is not number');
        
        $result = ZslmActivitys::setWeight($request->id, $request->showWeight);
        return  $result ? responseToJson(0,'success') : responseToJson(1,'error');
    }
    

    //设置活动的展示状态
    public function updateActivityShow(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1,'request error');
        if(!isset($request->id) && !is_numeric($request->id))
            return responseToJson(1,'no id or id is not number');
        if(!isset($request->showState) && !is_numeric($request->showState))
            return responseToJson(1,'no showWeight or showState is not number');
    
        $result = ZslmActivitys::setShow($request->id,$request->showState);
        return  $result == 1 ? responseToJson(0,'success') : responseToJson(1,'success');
    }
    


    //设置活动的推荐状态
    public function updateActivityRec(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1,'request error');
        if(!isset($request->id) && !is_numeric($request->id))
            return responseToJson(1,'no id or id is not number');
        if(!isset($request->rec) && !is_numeric($request->rec))
            return responseToJson(1,'no showWeight or rec is not number');
    
        $result = ZslmActivitys::setRec($request->id,$request->rec);
        return  $result == 1 ? responseToJson(0,'success') : responseToJson(1,'success');
    }
    

    /**
     * @api {post} admin/information/deleteActivity 删除指定的活动
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "删除成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function deleteActivity(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        
        $activity_id = (isset($request->activityId) && is_array($request->activityId)) ? $request->activityId : [];
        
        if($activity_id != null && sizeof($activity_id) > 0) {
            $is_del = ZslmActivitys::delAppointActivity($activity_id);
            return $is_del ? responseToJson(0, '删除成功') : responseToJson(1, '删除失败');
        }
        else
            return responseToJson(1, '参数错误');


    }


    /**
     * @api {post} admin/information/updateActivityInformationTime 更新活动信息的更新时间
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "更新成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function updateActivityInformationTime(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;

        if($activity_id != 0) {
            $is_del = ZslmActivitys::updateActivityTime($activity_id);
            return $is_del ? responseToJson(0, '更新成功') : responseToJson(1, '更新失败');
        }
        else return responseToJson(1, '参数错误');
    }



    /**
     * @api {post} admin/information/createActivity 新建活动
     * @apiGroup information
     *
     * @apiParam {String} activityName 活动名称
     * @apiParam {Number} activityType 活动类型
     * @apiParam {Number} majorType 专业类型
     * @apiParam {String} province 活动省市
     * @apiParam {String} address 活动地址
     * @apiParam {timeInt} beginTime 开始时间
     * @apiParam {timeInt} endTime 结束时间
     * @apiParam {NUmber} signUpState 报名状态
     * @apiParam {FormData} activeImg 活动封面图
     * @apiParam {String} title 主页优化
     * @apiParam {String} keywords 主页优化
     * @apiParam {String} description 主页优化
     * @apiParam {String} introduce 活动介绍
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "上传成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function createActivity(ActivityCreateRequest $request) {
        
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        try {
            DB::beginTransaction();
            $file_handle = $request->file('activityCoverImg');
            if(empty($file_handle)) return responseToJson(1, '创建活动需要活动封面，请上传活动封面。');

            $img_name = trim($request->coverImgName) == '' ? getFileName('activity', $file_handle->getClientOriginalExtension()) : trim($request->coverImgName) . '.' . $file_handle->getClientOriginalExtension();
            $create_msg = [
                'active_name'    => trim($request->activityName),
                'active_type'    => $request->activityType,
                'major_type'     => $request->majorType,
                'province'       => $request->province,
                'address'        => trim($request->address),
                'begin_time'     => strtotime($request->beginTime),
                'end_time'       => strtotime($request->endTime),
                'sign_up_state'  => $request->signUpState,
                'active_img'     => $img_name,
                'create_time'    => time(),
                'active_alt'     => $request->coverImgDescribe,
                'is_delete'      => 0
            ];
    
            $is_create = ZslmActivitys::createAppointActivityMsg($create_msg);

            $is_create_img = createDirImg($img_name, $file_handle, 'info');

            if($is_create && ($is_create_img === true)) {
                DB::commit();
                return responseToJson(0, '上传成功',$is_create);
            }
            else if(is_array($is_create_img) && $is_create_img[0] == 1) {
                throw new \Exception($is_create_img[1]);
            }
            else throw new \Exception('上传失败');
        } catch(\Exception $e)  {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }
    }
    

    //更新活动主要信息
    public function updateActivity(ActivityCreateRequest $request) {
        
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        try {
            DB::beginTransaction();
            $file_handle = !empty($request->file('activityCoverImg')) ? $request->file('activityCoverImg') : null;
            $img_name = ($file_handle != null) 
                ? (!empty($request->coverImgName) 
                ? trim($request->coverImgName) . '.' . $file_handle->getClientOriginalExtension() 
                : getFileName('activity', $file_handle->getClientOriginalExtension())) : null;
            $create_msg = [
                'active_name'    => trim($request->activityName),
                'active_type'    => $request->activityType,
                'major_type'     => $request->majorType,
                'province'       => $request->province,
                'address'        => trim($request->address),
                'begin_time'     => strtotime($request->beginTime),
                'end_time'       => strtotime($request->endTime),
                'sign_up_state'  => $request->signUpState,
                // 'active_img'     => $img_name,
                'update_time'    => time()
            ];
            
            //修改图片alt
            if(trim($request->coverImgDescribe) !== '') {
                $create_msg['active_alt'] = trim($request->coverImgDescribe);
            }
            
            //修改图片名称
            if($is_update_cover_name_bool = (!empty($request->coverImgName) && $file_handle == null)) {
                $activity_cover_old_name = ZslmActivitys::getActivityCoverName($request->id);
                $arr = strChangeArr($activity_cover_old_name, '.');
                $activity_cover_new_name = $request->coverImgName . '.' . end($arr);
                $create_msg['active_img'] = trim($activity_cover_new_name);
            }
            
            //是否需要上传新的图片，并设置名字
            if($file_handle != null) {
                $create_msg['active_img'] = $img_name;
            }
            
            $is_create = ZslmActivitys::updateMsg($request->id,$create_msg);
            
            
            if($is_update_cover_name_bool) $is_update = updateDirImgName($activity_cover_old_name, $activity_cover_new_name, 'info', 'admin/info');
            // dd($is_update);

            if($file_handle != null) $is_create_img = createDirImg($img_name, $file_handle, 'info');
            
            if($is_create == 1) {
                if((!empty($is_update) && $is_update == true) || (!empty($is_create_img) && $is_create_img == true)) {
                    DB::commit();
                    return responseToJson(0, '修改成功',$is_create);
                }
                else throw new \Exception('修改失败');
            }
            else throw new \Exception('修改失败');
            
        } catch(\Exception $e)  {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }
    }
    


    //更新活动的title等三个字段
    public function updateTiltle(Request $request){
        if(!isset($request->title)){
            return responseToJson(1,'no title');
        }else if(!isset($request->keywords)){
            return responseToJson(1,'no keywords');
        }else if(!isset($request->description)){
            return responseToJson(1,'no description');
        }else if(!isset($request->id)){
            return responseToJson(1,'no id');
        }
        $result = ZslmActivitys::setTKDById($request);
        return responseToJson(0, '', $result);
        if($result == 1){
            return responseToJson(0,'success');
        }else{
            return responseToJson(1,'error');
        }
    }
    
    

    //更新活动的活动介绍
    public function updateIntroduce(Request $request){
        if(!isset($request->introduce)){
            return responseToJson(1,'no title');
        }else if(!isset($request->id)){
            return responseToJson(1,'no id');
        }
        $result = ZslmActivitys::setIntroduce($request);
        if($result == 1){
            return responseToJson(0,'success');
        }else{
            return responseToJson(1,'error',$result);
        }
    }
    
    public function getPageInfo(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,'request error');
        
        $major = dictMajorType::getAllSonMajor();
        // $provice = dictRegion::getProvice();
        $city = dictRegion::getCity();
        $type = dict_activity_type::getType();
        if(($major != null && sizeof($major)>0) && ($type!= null && sizeof($type)>0) && ($city != null && sizeof($city)>0) )
            return responseToJson(0,'success',['major'=>$major, 'city'=>$city, 'type'=>$type]);
        else
            return responseToJson(1,'error');
    }


    private function createDirImg($imgName, $imgHandle) {
        if($imgHandle->isValid()) {
            $originalName = $imgHandle->getClientOriginalName(); //源文件名

            $file_type_arr = ['png','jpg','jpeg','tif','image/jpeg'];
            $ext = $imgHandle->guessClientExtension(); //文件类型
            $realPath = $imgHandle->getRealPath();   //临时文件的绝对路径
            $size = $imgHandle->getSize();
     
            if(!in_array(strtolower($ext), $file_type_arr)) return [1,"请上传 png jpg jpeg tif等格式的图片"];
            else if(Storage::disk('info')->exists($imgName.$ext)) return [1, '图片已存在'];
            else if(getByteToMb($size) > 3) return [1, '文件超出最大限制'];
            $bool = Storage::disk('info')->put($imgName.$ext, file_get_contents($realPath));
            return $bool ? $bool : [1, '图片上传失败'];
        }
        else return [1, '图片未上传'];
    }




    /**
     * @api {post} admin/information/getActivityType 获得活动类型字典
     * @apiGroup information
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "name":"xxxxxxxxxxxx"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function getActivityType(Request $request) {
        return responseToJson(0, '', Dict::getActivityType());
    }


    /**\
     * 获得活动类型和市字典
     */
    public function getAcTypeAndCity() {
        $type = Dict::getActivityType()->toArray();
        $city = dictRegion::getCity()->toArray();
        return responseToJson(0, '', ['acType' => $type, 'city' => $city]);
    }

    /**
     * @api {post} admin/information/getMajorType 获得专业类型字典
     * @apiGroup information
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "name":"xxxxxxxxxxxx"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function getMajorType(Request $request) {
        return responseToJson(0, '', Dict::dictMajorType());
    }



    /**
     * @api {post} admin/information/getMajorProvincesAndCities 获得活动省市字典
     * @apiGroup information
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "name":"xxxxxxxxxxxx"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    
    public function getMajorProvincesAndCities(Request $request) {
        // $region = Dict::dictRegion();

        // foreach($region[0] as $key=>$item) {
        //     $item->citys = $region[$item->id];
        //     unset($region[$item->id]);
        // }

        return responseToJson(0, '', getMajorProvincesAndCity());
    }



    /**
     * @api {post} admin/information/getAllMajor 获得所有专业字典
     * @apiGroup information
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "name":"xxxxxxxxxxxx",
     *              "xxx":"xxx"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function getAllMajor(Request $request) {
        return responseToJson(0, '', ZslmMajor::getAllDictMajor());
    }



    /**
     * @api {post} admin/information/setHostMajor 设置主办院校专业
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定院校专业的id
     * @apiParam {Number} majorId 主办院校id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setHostMajor(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(0, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        $major_id = (is_numeric($request->majorId)) ? $request->majorId : 0;

        $is_set = ActivityRelation::setAppointHostMajor($activity_id, $major_id);
        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }


    

    /**
     * @api {post} admin/information/sendActivityDynamic 活动作为新消息内容推送给关注了主办院校的用户
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     * @apiParam {String} contents 附加内容
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function sendActivityDynamic(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        if($activity_id == 0) return responseToJson(1, '参数错误');
        $major_id = ZslmActivitys::getHostMajorImg($activity_id)->id;
        if(empty($major_id)) return responseToJson(1, '该活动还没有设置主办院校');

        try {
            DB::beginTransaction();

            $activity_msg = ZslmActivitys::getAppointActivityMsg($activity_id, ['active_name', 'introduce']);

            $create_news_id = News::createNews([
                'carrier'      => 1,
                'act_major_id' => $major_id,
                'news_title'   => trim($request->contents) == '' ? $activity_msg->active_name : trim($request->contents),
                'context'      => ((mb_strlen($activity_msg->introduce, 'utf-8') > 40) ? (mb_substr($activity_msg->introduce, 0, 40, 'gb2312') . '...') : $activity_msg->introduce),
                'type'         => !empty($request->type) ? $request->type : 1,
                'url'          => $request->url,
                'create_time'  => time(),
                'is_delete'    => 0,
                'success'      => 1
            ]);
            $all_users_id = UserFollowMajor::getFollowMajorUsers($major_id);
            $time = time();
            $data_arr = [];
            if($create_news_id > 0) {
                foreach($all_users_id as $key => $user_id) {
                    array_push($data_arr, [
                        'news_id' => $create_news_id,
                        'user_id' => $user_id,
                        'status' => 0,
                        'create_time' => $time
                    ]);
                }
               
                $is_create = NewsUsers::createNewsRelationUser($data_arr);
                if($is_create){
                    DB::commit();
                    return responseToJson(0, '发送成功');
                }
                else
                    throw new \Exception('发送失败');
            }
            else
                throw new \Exception('插入消息失败');
        } catch(\Exception $e) {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }
    }

    /**
     * @api {post} admin/information/sendActivityDynamic 活动作为院校动态更新推送给关注了主办院校的用户
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setActivitydynamic(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;

        if($activity_id == 0) return responseToJson(1, '参数错误');
        $major_id = ZslmActivitys::getHostMajorImg($activity_id)->id;
        if(empty($major_id)) return responseToJson(1, '该活动还没有设置主办院校');

        $follow_major_id_arr = UserFollowMajor::getFollowMajorUsers($major_id);

        // if(is_array($follow_major_id_arr) && count($follow_major_id_arr) < 1) return responseToJson(1, '没有用户关注该活动的主办院校');
        try {
            $time = time();
            $data_arr = [];
            foreach($follow_major_id_arr as $key => $user_id) {
                array_push($data_arr, [
                    'user_id' => $user_id,
                    'content_id' => $activity_id,
                    'content_type' => 2,
                    'status' => 0,
                    'create_time' => $time
                ]);
            } 
            // return responseToJson(0, '发送成功', $follow_major_id_arr);
            $is_create = DynamicNews::setDynamic($data_arr);
            if($is_create) return responseToJson(0, '发送成功');
            else throw new \Exception('发送失败');
        }catch(\Exception $e) {
            return responseToJson(1, $e->getMessage());
        }
    }


    /**
     * @api {post} admin/information/getAllActivitys 获得所有的活动
     * @apiGroup information
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "active_name":"xxxxxxxxxxxx",
     *              "xxx":"xxx"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function getAllActivitys(Request $request) {

        return responseToJson(0, ZslmActivitys::getAllActivity(['id', 'active_name']));
        
    }

    //


    /**
     * @api {post} admin/information/setManualRecActivitys 手动设置推荐活动
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     * @apiParam {Array} activityArr 推荐活动id的数组
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setManualRecActivitys(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        $activity_arr = (isset($request->activityArr) && is_array($request->activityArr)) ? $request->activityArr : [];
     
        if($activity_id == 0 || ($activity_arr != null && sizeof($activity_arr) < 1)) return responseToJson(0, '参数错误');

        $recom_activity_count = SystemSetup::getContent('recommend_activity');

        $relation_activity_arr = strChangeArr(ActivityRelation::getAppointContent($activity_id, 'relation_activity'), ',');
        if($relation_activity_arr == 0){
            return responseToJson(1, '暂无关联活动信息');
        }
        $merge_arr = mergeRepeatArray($activity_arr, $relation_activity_arr);
        if(count($merge_arr) > $recom_activity_count) return responseToJson(1, '关联活动条数超过最大限制');

        $rela_activity_str = strChangeArr($merge_arr, ',');

        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'relation_activity', $rela_activity_str);

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');


    }


    /**
     * 取消指定活动的某一推荐活动
     * acId 指定活动id
     * cancelAcId 取消推荐的活动id
     */
    public function cancelAppointRecommendActivity(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求防水错误');
        $activity_id = !empty($request->acId) && is_numeric($request->acId) ? $request->acId : null;
        $cancel_ac_id = !empty($request->cancelAcId) && is_numeric($request->cancelAcId) ? $request->cancelAcId : null;
        $relation_activity_arr = strChangeArr(ActivityRelation::getAppointContent($activity_id, 'relation_activity'), ',');
        if($relation_activity_arr == 0 || count($relation_activity_arr) == 0){
            return responseToJson(1, '暂无关联活动信息');
        }
        $relation_activity_str = strChangeArr(deleteArrValue($relation_activity_arr, $cancel_ac_id), ',');
        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'relation_activity', $relation_activity_str);
        return $is_set ? responseToJson(0, '取消推荐成功') : responseToJson(1, '取消推荐失败');
    }


    /**
     * 取消指定活动的某一推荐专业
     * acId 指定活动id
     * cancelMaId 取消推荐的专业id
     */
    public function cancelAppointRecommendMajor(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求防水错误');
        $activity_id = !empty($request->acId) && is_numeric($request->acId) ? $request->acId : null;
        $cancel_ma_id = !empty($request->cancelMaId) && is_numeric($request->cancelMaId) ? $request->cancelMaId : null;
        $relation_activity_arr = strChangeArr(ActivityRelation::getAppointContent($activity_id, 'recommend_id'), ',');
        if($relation_activity_arr == 0 || count($relation_activity_arr) == 0){
            return responseToJson(1, '暂无关联活动信息');
        }
        $relation_activity_str = strChangeArr(deleteArrValue($relation_activity_arr, $cancel_ma_id), ',');
        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'recommend_id', $relation_activity_str);
        return $is_set ? responseToJson(0, '取消推荐成功') : responseToJson(1, '取消推荐失败');
    }



    /**
     * 取消指定活动的所有推荐活动
     */
    public function cancelAppointActicityAllRe(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = !empty($request->acId) && is_numeric($request->acId) ? $request->acId : null;

        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'relation_activity', '');

        return $is_set ? responseToJson(0, '清空推荐活动成功') : responseToJson(1, '清空推荐活动失败');

    }

    /**
     * 取消指定活动的所有推荐院校专业
     */
    public function cancelAppointMajorAllRe(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = !empty($request->acId) && is_numeric($request->acId) ? $request->acId : null;
    
        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'recommend_id', '');
    
        return $is_set ? responseToJson(0, '清空推荐院校专业成功') : responseToJson(1, '清空推荐院校专业失败'); 
    }


    /**
     * @api {post} admin/information/setAutomaticRecActivitys 自动设置推荐活动
     *
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setAutomaticRecActivitys(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        if($activity_id == 0) return responseToJson(0, '参数错误');
        $recom_activity_count = SystemSetup::getContent('recommend_activity');

        $get_activits_id_arr = ZslmActivitys::getAutoRecommendActivitys($recom_activity_count);

        if(!is_array($get_activits_id_arr)) $get_activits_id_arr = $get_activits_id_arr->toArray();

        if(count($get_activits_id_arr) < 1) return responseToJson(1, '暂无能够设置的活动');

        $get_activity_id_str = strChangeArr($get_activits_id_arr, ',');

        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'relation_activity', $get_activity_id_str);

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');

    }



    /**
     * @api {post} admin/information/setManualRecMajors 手动设置推荐院校
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     * @apiParam {Array} majorArr 专业id的数组
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setManualRecMajors(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        $major_arr = (isset($request->majorArr) && is_array($request->majorArr)) ? $request->majorArr : [];

        if($activity_id == 0 || count($major_arr) < 1) return responseToJson(0, '参数错误');

        $recom_major_count = SystemSetup::getContent('recommend_major');

        $relation_major_arr = strChangeArr(ActivityRelation::getAppointContent($activity_id, 'recommend_id'), ',');
        $merge_arr = mergeRepeatArray($major_arr, $relation_major_arr);
        if(count($merge_arr) > $recom_major_count) return responseToJson(1, '关联活动条数超过最大限制');

        $rela_major_str = strChangeArr($merge_arr, ',');

        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'recommend_id', $rela_major_str);

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }




    
    public function getImg(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,'request error');
        if(!isset($request->id) && !is_numeric($request->id))
            return responseToJson(1,'no id or id is not number');


        $img = ZslmActivitys::getHostMajorImg($request->id);

        $img->magor_logo_name =  splicingImgStr('admin', 'info', $img->magor_logo_name);
       return responseToJson(0,'success',$img);
    }



    /**
     * @api {post} admin/information/setAutomaticRecMajors 自动设置推荐院校
     *
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
     * }
     *拉取代码本地查看
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setAutomaticRecMajors(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        if($activity_id == 0) return responseToJson(0, '参数错误');
        $recom_major_count = SystemSetup::getContent('recommend_major');

        $get_major_id_arr = ZslmMajor::getAutoRecommendMajors($recom_major_count);

        if(!is_array($get_major_id_arr)) $get_major_id_arr = $get_major_id_arr->toArray();

        if(count($get_major_id_arr) < 1) return responseToJson(1, '暂无能够设置的院校');

        $get_major_id_str = strChangeArr($get_major_id_arr, ',');

        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'recommend_id', $get_major_id_str);

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }
    



    public function getGuanlianById(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,'请求错误');
        if(!isset($request->id) && !is_numeric($request->id))
            return responseToJson(1,'no id or id is not number.please try again');
        
        $id = $request->id;
        $data = ActivityRelation::getGuanlianById($id);
        $majorObj = [];
        $activeObj = [];
        if($data != null && sizeof($data)>0){
        $active = explode(',',$data->relation_activity);
        $major = explode(',',$data->recommend_id);
        $majorObj = ZslmMajor::getMajorByids($major);
        $activeObj = ZslmActivitys::getActiveByids($active);
        $province = getMajorProvincesAndCity()[0];
        
        $t = ['0'=>'提前面试','1'=>'招生宣讲','2'=>'高精会议','3'=>'讲座论坛'];
        foreach($activeObj as $key => $item) {
            $item->create_time = date("Y-m-d H:i:s",$item->create_time);
            $item->active_type = $t[$item->active_type];
        }
        
        foreach($majorObj as $key => $item) {
            $majorObj[$key]->province = strChangeArr($item->province, ',');
            if($item->province[0] != ''){
                if($province != null)
                    for($i = 0;$i<sizeof($province);$i++){
                        if($item->province[0] == $province[$i]->id){
                            $majorObj[$key]->province[0] = $province[$i]->name;
                            if($item->province != null && sizeof($item->province)>1)
                                foreach($province[intval($item->province[0])]->citys as $value)
                                    if($item->province[1] == $value->id) $majorObj[$key]->province[1] = $value->name;
                            $p = '';
                            if($majorObj[$key]->province != null)
                                for($i = 0;$i<sizeof($majorObj[$key]->province);$i++)
                                    $p.=$majorObj[$key]->province[$i];
                            $majorObj[$key]->province = $p;
                            break;
                        }
                    }
            }
            $majorObj[$key]->update_time = date("Y-m-d H:i:s",$item->update_time);
        }
        }
        return responseToJson(0,'success',[$activeObj,$majorObj]);
        
    }




    /**
     * 辅导机构中设置相关活动时添加活动页面查询活动列表接口
     *  name
     *  showstate
     *  recommendedState
     *  signState
     *  actType
     *  city
     *  pageNumber
     *  pagecount
     *  sortType
     */
    public function getCoachRecommendAc(Request $request) {
        if(!$request->isMethod('get')) return responseToJson(2, '请求方式失败');
        
        $rules = [
            'name' =>'nullable|string|max:255',
            'showstate' => 'numeric',
            'recommendedState' => 'numeric',
            'signState' => 'numeric',
            'actType' => 'numeric',
            'city' => 'numeric',
            'pageNumber' => 'numeric',
            'pagecount' => 'numeric',
            'sortType'  => 'numeric'
        ];
        
        $message = [
            'name.max' =>'搜索关键字超过最大长度',
            'showstate.*'             => '参数错误',
            'recommendedState.*'            => '参数错误',
            'signState.*'             => '参数错误',
            'actType.*'             => '参数错误',
            'city.*'             => '参数错误',
            'pageNumber.*'             => '参数错误',
            'pagecount.*'             => '参数错误',
            'sortType.*'             => '参数错误',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $ac_arr = ZslmActivitys::getCoachRecommendAc($request->all());
        
        if(empty($ac_arr[0]) || count($ac_arr[0]->toArray()) < 1) return responseToJson(0, '没有数据', $ac_arr);
        $ac_arr[0] = $ac_arr[0]->toArray(); 
        
        $type = Dict::getActivityType()->toArray();
        $city = dictRegion::getAllArea()->toArray();

        foreach($ac_arr[0] as $key => $item) {
            foreach($type as $keys => $value) {
                if($item->active_type == $value->id) $ac_arr[0][$key]->active_type = $value->name;
            }
            foreach($city as $keses => $values) {
                if($item->province == $values->id) $ac_arr[0][$key]->province = $values->name;
            }
            $ac_arr[0][$key]->show_state = $item->show_state ? '不展示' : '展示';
            $ac_arr[0][$key]->recommended_state = $item->recommended_state ? '不推荐' : '推荐';
            $ac_arr[0][$key]->sign_up_state = $item->sign_up_state ? '可设提醒' : '可报名';
        }

        return responseToJson(0, '', $ac_arr);
    }
    

}