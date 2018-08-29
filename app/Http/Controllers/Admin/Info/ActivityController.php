<?php

/**
 * 活动管理
 */

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ActivityController extends Controller 
{

    /**
     * @api {post} admin/information/getActivityPageMessage 获取活动列表页分页数据
     * @apiGroup information
     * 
     * 
     * @apiParam {String} majorNameKeyword 活动名称关键字
     * @apiParam {Number} screenType 筛选方式()
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} pageNumber 跳转页面下标
     * @apiParam {Number} sortType 排序类型(0按权重升序；1按权重降序)
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




}