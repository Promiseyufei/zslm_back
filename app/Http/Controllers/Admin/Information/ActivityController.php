<?php

/**
 * 活动管理
 */

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\zslm_activitys as ZslmActivitys;
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
     *              "begin_gime":"活动开始时间",
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
    public function getActivityPageMessage(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式失败');

        $rules = [
            'activityNameKeyword'   => 'nullable|string|max:255',
            'screenType'            => 'numeric',
            'screenState'           => 'numeric',
            'sortType'              => 'nullable|numeric',
            'pageCount'             => 'numeric',
            'pageNumber'            => 'numeric'
        ];
        $message = [
            'activityNameKeyword.max' =>'搜索关键字超过最大长度',
            'screenType.*'            =>'参数错误',
            'screenState.*'           =>'参数错误',
            'sortType.*'              => '参数错误',
            'pageCount.*'             => '参数错误',
            'pageNumber.*'            => '参数错误'
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $get_msg = ZslmActivitys::getActivityPageMsg($request->all());

        return $get_msg ? responseToJson(0, '', $get_msg) : responseToJson(1, '查询失败');
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

    }

    /**
     * @api {post} admin/information/setMajorState 设置活动的状态(权重，展示状态，推荐状态)
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
     * @apiParam {Number} type 要修改的状态类型(0修改权重；１修改展示状态；1修改推荐状态)
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
    public function updateActivityMsg(Request $request) {

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

    }



    /**
     * @api {post} admin/information/createActivity 新建活动
     * @apiGroup information
     *
     * @apiParam {Array} msgArr 信息
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
    public function createActivity(Request $request) {

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

    }


    

    /**
     * @api {post} admin/information/sendActivityDynamic 活动作为院校动态更新推送给关注了主办院校的用户（插入消息表，并和用户进行关联，推送到个人中心－院校动态中）
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
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
    public function sendActivityDynamic(Request $request) {

    }




    /**
     * @api {post} admin/information/sendActivityNews 活动作为新消息内容发送给关注了主办院校的用户（插入消息表，并和用户关联，推送到消息中心中）
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     * @apiParam {Number} majorId 主办院校专业id
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
    public function sendActivityNews(Request $request) {

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
    public function getAllActivitys(Request $request) {

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

    }




}