<?php

/**
 * 资讯管理
 */

namespace App\Http\Controllers\Admin\Information;


use App\Models\information_relation as InfomationRelation;
use App\Models\information_major as InformationMajor;
use App\Models\user_follow_major as UserFollowMajor;
use App\Models\zslm_information as ZslmInformation;
use App\Models\system_setup as SystemSetup;
use App\Http\Requests\InfoCreateRequest;
use App\Http\Requests\InfoUpdateRequest;
use App\Models\zslm_major as ZslmMajor;
use App\Models\news_users as NewsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\dict as Dict;
use App\Models\news as News;
use Validator;
use DB;

class InformationController extends Controller 
{



    /**
     * @api {post} admin/information/getInfoPageMsg 咨询列表页分页
     * @apiGroup information
     * 
     * 
     * @apiParam {String} infoNameKeyword 咨询名称关键字
     * @apiParam {Number} screenType 筛选方式(0按展示状态；1按推荐状态;２咨询类型;3全部)
     * @apiParam {Number} infoType 咨询类型(0全部，非零传输咨询类型id)
     * @apiParam {Number} screenState 筛选状态(0展示/推荐；1不展示/不推荐;2全部)
     * @apiParam {Number} sortType 排序(0按权重升序，1按权重降序，2按更新时间降序(默认))
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
     *              "zx_name":"咨询名称",
     *              "weight":"展示权重",
     *              "is_show":"展示状态(0展示；1不展示)",
     *              "is_recommend":"推荐状态(0推荐，1不推荐)",
     *              "z_type":"咨询类型",
     *              "z_from":"咨询来源",
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
    public function getInfoPageMsg(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $rules = [
            'infoNameKeyword' => 'nullable|string|max:255',
            'screenType'      => 'required|numeric',
            'infoType'        => 'required|numeric',
            'screenState'     => 'required|numeric',
            'sortType'        => 'required|numeric',
            'pageCount'       => 'required|numeric',
            'pageNumber'      => 'required|numeric'
        ];

        $message = [
            'infoNameKeyword.max' => '搜索关键字超过最大长度',
            'infoType.*'          => '参数错误',
            'sortType.*'          => '参数错误',
            'screenType.*'        => '参数错误',
            'screenState.*'       => '参数错误',
            'pageCount.*'         => '参数错误',
            'pageNumber.*'        => '参数错误'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $get_info_msg = ZslmInformation::getInformationPageMsg($request->all())->toArray();

        $info_type = Dict::dictInformationType()->toArray();
        foreach($get_info_msg as $key => $info) {
            foreach($info_type as $val)
                ($info->z_type != $val->id) ? : $get_info_msg[$key]->z_type = $val->name;
            $get_info_msg[$key]->update_time = date("Y-m-d H:i:s",$info->update_time);
        }

        return ($get_info_msg ?? false) ? responseToJson(0, '', $get_info_msg) : responseToJson(1, '查询失败');
                
    }





    /**
     * @api {post} admin/information/getInfoPageCount 获取资讯列表页分页数据总数
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
    public function getInfoPageCount(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        if(isset($request->conditionArr) &&  is_array($request->conditionArr))
            return responseToJson(0, '', ZslmInformation::getInfoAppiCount($request->conditionArr));
        else return responseToJson(1, '查询失败', 0);
    }




    /**
     * @api {post} admin/information/setAppointInfoState 设置咨询的状态值(权重，展示状态，推荐状态)
     * @apiGroup information
     *
     * @apiParam {Number} infoId 指定活动的id
     * @apiParam {Number} type 要修改的状态类型(0修改权重；１修改展示状态；２修改推荐状态)
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
    public function setAppointInfoState(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        
        $info_id = (isset($request->infoId) && is_numeric($request->infoId)) ? $request->infoId : 0;
        $type = (isset($request->type) && is_numeric($request->type)) ? $request->type : -1;
        $state = (isset($request->state) && is_numeric($request->state)) ? $request->state : -1;

        if($info_id > 0 && $type != -1 && $state != -1) {
            if($type > 0 && $state > 1) return responseToJson(1, '状态值错误');
            $is_update = ZslmInformation::setAppiInfoState([
                'info_id'  => $info_id,
                'type'    => $type,
                'state'   => $state
            ]);

            return ($is_update ?? 0) ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
        }
        else return responseToJson(1, '参数错误');

    }



    /**
     * @api {get} admin/information/selectInfoReception 跳转到前台对应的咨询详情页
     * 
     * @apiGroup information
     *
     * @apiParam {Number} infoId 指定资讯的id
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
    public function selectInfoReception(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $info_id = (isset($request->infoId) && is_numeric($request->infoId)) ? $request->infoId : 0;
        if($info_id != 0) {
            $info = ZslmInformation::getAppointInfoMsg($info_id);
            return is_object($info) ? responseToJson(0, '', $info) : responseToJson(1, '获取信息失败');
        }
    }




    /**
     * @api {post} admin/information/updateAppointInfoMsg 编辑指定咨询信息
     * @apiGroup information
     *
     * @apiParam {Number} infoId 指定资讯的id
     * @apiParam {String} infoName 资讯的标题
     * @apiParam {Number} infoType 资讯类型
     * @apiParam {String} infoFrom 资讯来源
     * @apiParam {File} infoImage 资讯封面图
     * @apiParam {String} infoText 资讯内容
     * @apiParam {String} title 页面优化
     * @apiParam {String} keywords 页面优化
     * @apiParam {String} description 页面优化
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
    public function updateAppointInfoMsg(Request $request) {

    } 



    //

    /**
     * @api {post} admin/information/deleteAppointInfo 删除指定资讯
     * @apiGroup information
     *
     * @apiParam {Number} infoId 指定活动的id
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
    public function deleteAppointInfo(Request $request) {
        if(!$request->isMethod('get')) return responseToJson(2, '请求方式错误');
        $info_id = (isset($request->infoId) && is_numeric($request->infoId)) ? $request->infoId : 0;

        if($info_id == 0) return responseToJson(1, '参数错误');
        $is_del = ZslmInformation::delAppointInfo($info_id);
        return ($is_del ?? false) ? responseToJson(0, '删除成功') : responseToJson(1, '删除失败');

            
    } 




    /**
     * @api {post} admin/information/createInfo 添加资讯
     * @apiGroup information
     *
     * @apiParam {String} infoName 资讯的标题
     * @apiParam {Number} infoType 资讯类型
     * @apiParam {String} infoFrom 资讯来源
     * @apiParam {File} infoImage 资讯封面图
     * @apiParam {String} infoText 资讯内容
     * @apiParam {String} title 页面优化
     * @apiParam {String} keywords 页面优化
     * @apiParam {String} description 页面优化
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
    public function createInfo(InfoCreateRequest $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $img_handle = $request->file('infoImage');

        $img_name = getFileName('info', $img_handle->getClientOriginalExtension());

        $create_msg = [
            'zx_name'       => trim($request->infoName),
            'z_type'        => $request->infoType,
            'z_from'        => trim($request->infoFrom),
            'z_image'       => $img_name,
            'z_text'        => trim($request->infoText),
            'title'         => (trim($request->title) ?? false) ? trim($request->title) : '',
            'keywords'      => (trim($request->keywords) ?? false) ? trim($request->keywords) : '',
            'description'   => (trim($request->description) ?? false) ? trim($request->description) : ''
        ];

        try {
            DB::beginTransaction();

            $create_info_id = ZslmInformation::createInfo($create_msg);
    
            $is_create_img = $this->createDirImg($img_name, $img_handle);
    
            if($create_info_id && ($is_create_img === true)) {
                DB::commit();
                return responseToJson(0, '上传成功'); 
            }
            else if(is_array($is_create_img) && $is_create_img[0] == 1)
                throw new \Exception($is_create_img[1]);
            else throw new \Exception('上传失败');
        }catch(\Exception $e) {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }

    }




    /**
     * @api {post} admin/information/setAppointRelationCollege 设置指定资讯的关联院校
     * @apiGroup information
     *
     * @apiParam {Number} infoId 指定院校专业的id
     * @apiParam {Array} majorIdArr 相关院校id数组
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
    public function setAppointRelationCollege(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $info_id = $request->infoId ?? 0;
        $major_id_arr = (($request->majorIdArr ?? false) && is_array($request->majorIdArr)) ? $request->majorIdArr : [];

        if(empty($info_id) || empty($major_id_arr)) return responseToJson(1, '请求参数错误');

        $re_info_arr = InformationMajor::selectAppointRelation($info_id);

        $major_id_arr = array_diff($major_id_arr, $re_info_arr);  //返回差集
        

        $relevan_id = InformationMajor::setAppointRelevantMajor($info_id, $major_id_arr);

        return $relevan_id ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');  
        

    }





    /**
     * @api {post} admin/information/getAllCollege 获得所有的院校专业(在设置相关院校和推荐院校的手动设置时使用)
     * @apiGroup information
     * 
     * @apiParam {Number} type 在设置相关院校时获取还是在设置推荐院校时获取(0设置相关院校时;1设置推荐院校时)
     * @apiParam {Number} infoId 咨询id(在设置资讯相关院校时需要将指定资讯id发送给后台，默认情况为0)
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
    public function getAllCollege(Request $request, $infoId = 0) {

        $type = $request->type ?? -1;
        if($type < 0) return responseToJson(1, '参数错误');

        $info_id = empty($type) ? $request->infoId : 0;
        
        if($type == 1) return responseToJson(0, '', ZslmMajor::getAllDictMajor());
        else {
            $re_info_arr = InformationMajor::selectAppointRelation($info_id);
            $all_major_arr = ZslmMajor::getAllDictMajor()->toArray();
            foreach($all_major_arr as $key => $major) 
                if(in_array($major->id, $re_info_arr)) array_splice($all_major_arr, $key, 1);

            return responseToJson(0, '', $all_major_arr);
        }
    }






    /**
     * @api {post} admin/information/sendInfoDynamic 设置指定资讯作为院校动态更新推送给关注了主办院校的用户（插入消息表，并和用户进行关联，推送到个人中心－院校动态中）/资讯作为新消息内容发送给关注了主办院校的用户（插入消息表，并和用户关联，推送到消息中心中）
     * @apiGroup information
     *
     * @apiParam {Number} infoId 活动的id
     * @apiParam {Number} majorIdArr 相关院校院校id数组
     * @apiParam {Number} newOrDyna 设置类别(0作为院校动态；1作为新消息)
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
    public function sendInfoDynamic(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $info_id = (($request->infoId ?? false) && is_numeric($request->infoId)) ? $request->infoId : 0;
        $new_or_dyna = (($request->newOrDyna ?? false) && is_numeric($request->newOrDyna)) ? $request->newOrDyna : -1;

        if(empty($info_id) || $new_or_dyna < 0) return responseToJson(1, '参数错误');

        $appoint_major_arr = InformationMajor::selectAppointRelation($info_id);

        //插入news表->指定资讯的关联院校->查询用户-专业表->获得关注学生->去重->插入消息-用户关联表
        $info_msg = ZslmInformation::getAppointInfoMsg($info_id, ['id', 'zx_name', 'z_text', 'z_from']);

        //通过院校专业id获得所有的用户id，然后进行去重
        $users_id_arr = array_unique(UserFollowMajor::getAppointMajorRelevantUser($appoint_major_arr));

        try {
            DB::beginTransaction();

            $type = $new_or_dyna ? 2 : 3;

            $create_news_id = News::createNews([
                'carrier'     => 1,
                'news_title'  => $info_msg->zx_name,
                'context'     => (mb_strlen($info_msg->z_text, 'utf-8') > 20) ? (mb_substr($info_msg->z_text, 0, 20, 'gb2312') . '...') : $info_msg->z_text,
                'type'        => $type,
                'create_time' => time()
            ]);

            if(is_array($users_id_arr) && !empty($users_id_arr) && $create_info_id > 0) {
                $now_time = time();
                $data_arr = [];
                foreach($users_id_arr as $key => $user_id)
                    array_push($data_arr, [
                        'news_id' => $create_news_id, 
                        'user_id' => $user_id, 
                        'status' => 0, 
                        'create_time' => $time
                    ]);

                $is_create = NewsUsers::createNewsRelationUser($data_arr);

                if($is_create) return responseToJson(0, '发送成功');
                else throw new \Exception('发送失败');
            }
            else throw new \Exception('获得参数失败');

        }catch(\Exception $e) {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }

    }





    /**
     * @api {post} admin/information/setManualRecInfos 设置指定资讯的推阅读设置(手动设置)
     * @apiGroup information
     *
     * @apiParam {Number} infoId 活动的id
     * @apiParam {Array} infoArr 推荐阅读资讯id的数组
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
     * @apiErrorExample Error-Response:    private function createDirImg($imgName, &$imgHandle) {
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
    public function setManualRecInfos(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $info_id = (isset($request->infoId) && is_numeric($request->infoId)) ? $request->infoId : 0;
        $info_arr = (isset($request->infoArr) && is_array($request->infoArr)) ? $request->infoArr : [];

        if($info_id == 0 || count($info_arr) < 1) return responseToJson(0, '参数错误');

        $recom_info_count = SystemSetup::getContent('recommend_read');

        $relation_info_arr = strChangeArr(InfomationRelation::getAppointInfoContent($info_id, 'tj_yd_id'), ',');
        $merge_arr = mergeRepeatArray($info_arr, $relation_info_arr);
        if(count($merge_arr) > $recom_info_count) return responseToJson(1, '关联活动条数超过最大限制');

        $rela_info_str = strChangeArr($merge_arr, ',');

        $is_set = InfomationRelation::setRecommendInfos($info_id, 'tj_yd_id', $rela_info_str);

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }




    /**
     * @api {post} admin/information/setAutomaticRecInfos 设置指定资讯的推阅读设置(自动设置)
     * 
     * @apiGroup information
     *
     * @apiParam {Number} infoId 活动的id
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
    public function setAutomaticRecInfos(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $info_id = (isset($request->infoId) && is_numeric($request->infoId)) ? $request->infoId : 0;
        if($info_id == 0) return responseToJson(0, '参数错误');
        $recom_info_count = SystemSetup::getContent('recommend_read');

        $get_infos_id_arr = ZslmInformation::getAutoRecommendInfos($recom_info_count);

        if(count($get_infos_id_arr) < 1) return responseToJson(1, '暂无能够设置的活动');


        $is_set = InfomationRelation::setRecommendInfos($info_id, 'tj_yd_id', strChangeArr($get_infos_id_arr, ','));

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }






    /**
     * @api {post} admin/information/getAllInfo 获得所有的资讯(在设置推荐阅读的手动设置时使用)
     * @apiGroup information
     * 
     * @apiParam {Number} pageNumber 分页下标
     * @apiParam {Number} pageCount 每页显示数量
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
    public function getAllInfo(Request $request) {

        $page_num = ($request->pageNumber ?? false ) ? $request->pageNumber : 0;
        $page_count = ($request->pageCount ?? false) ? $request->pageCount : 10; 
        return responseToJson(0, '', ZslmInformation::getAllInfo($page_num, $page_count));
    }




    /**
     * @api {post} admin/information/setManualInfoRelationCollege 设置指定资讯的推荐院校专业设置(手动设置)
     * @apiGroup information
     *
     * @apiParam {Number} infoId 活动的id
     * @apiParam {Array} majorArr 推荐院校专业id的数组
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
    public function setManualInfoRelationCollege(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $info_id = (isset($request->infoId) && is_numeric($request->infoId)) ? $request->infoId : 0;
        $major_arr = (isset($request->majorArr) && is_array($request->majorArr)) ? $request->majorArr : [];

        if($info_id == 0 || count($major_arr) < 1) return responseToJson(0, '参数错误');

        $recom_info_count = SystemSetup::getContent('recommend_info_major');

        $relation_info_arr = strChangeArr(InfomationRelation::getAppointInfoContent($info_id, 'tj_sc_id'), ',');
        $merge_arr = mergeRepeatArray($info_arr, $relation_info_arr);
        if(count($merge_arr) > $recom_info_count) return responseToJson(1, '关联院校专业条数超过最大限制');

        $rela_info_str = strChangeArr($merge_arr, ',');

        $is_set = InfomationRelation::setRecommendInfos($info_id, 'tj_sc_id', $rela_info_str);

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }






    /**
     * @api {post} admin/information/setAutoInfoRelationCollege 设置指定资讯的推荐院校专业设置(自动设置)
     * 
     * @apiGroup information
     *
     * @apiParam {Number} infoId 活动的id
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
    public function setAutoInfoRelationCollege(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $info_id = (isset($request->infoId) && is_numeric($request->infoId)) ? $request->infoId : 0;
        if($info_id == 0) return responseToJson(0, '参数错误');
        $recom_info_major_count = SystemSetup::getContent('recommend_info_major');

        $get_major_id_arr = ZslmMajor::getAutoRecommendMajors($recom_info_major_count);

        if(count($get_major_id_arr) < 1) return responseToJson(1, '暂无能够设置的活动');


        $is_set = InfomationRelation::setRecommendInfos($info_id, 'tj_sc_id', strChangeArr($get_major_id_arr, ','));

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }


    private function createDirImg($imgName, &$imgHandle) {
        if($imgHandle->isValid()) {
            $originalName = $imgHandle->getClientOriginalName(); //源文件名
            $ext = $imgHandle->getClientOriginalExtension();    //文件拓展名

            $file_type_arr = ['png','jpg','jpeg','tif','image/jpeg'];
            $type = $imgHandle->getClientMimeType(); //文件类型
            $realPath = $imgHandle->getRealPath();   //临时文件的绝对路径
            $size = $imgHandle->getSize();

            if(!in_array(strtolower($ext), $file_type_arr)) return [1,'请上传格式为图片的文件'];
            else if(Storage::disk('info')->exists($imgName)) return [1, '图片已存在'];
            else if(getByteToMb($size) > 3) return [1, '文件超出最大限制'];

            $bool = Storage::disk('info')->put($imgName, file_get_contents($realPath));
            return $bool ? $bool : [1, '图片上传失败'];
        }
        else return [1, '图片未上传'];
    }





}