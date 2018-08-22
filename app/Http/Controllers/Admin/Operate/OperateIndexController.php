<?php

/**
 * 资讯频道首页管理
 */

namespace App\Http\Controllers\Admin\Operate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class OperateIndexController extends Controller 
{

    
    /**
     * 资讯频道首页推荐
     */




    /**
     * @api {post} admin/operate/getIndexBanner 获得指定区域的资讯内容
     * @apiGroup operate
     *
     * @apiParam {Number} regionId 指定区域的id
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
     *              "show_weight":"xxxxxxxxxxxx",
     *              "title":"front/test/test",
     *              "information_type":"xxxxxxxxxxxx",
     *              "create_time":"xxxxxxxxxxxx"
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
    public function getAppointRegionData(Request $request) {

    }





    /**
     * @api {post} admin/operate/setAppointRegionName 修改指定区域的名称
     * @apiGroup operate
     *
     * @apiParam {Number} regionId 指定区域的id
     * @apiParam {String} regionName　要修改的名称
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
    public function setAppointRegionName(Request $request) {

    }





    /**
     * @api {post} admin/operate/setAppoinInformationWeight 设置指定资讯的权重
     * @apiGroup operate
     *
     * @apiParam {Number} informationId 指定资讯的id
     * @apiParam {Number} weight 要修改的权重，默认为0
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
    public function setAppoinInformationWeight(Request $request) {

    }




    /**
     * @api {post} admin/operate/deleteAppoIninInformation 删除指定区域上的指定资讯
     * @apiGroup operate
     *
     * @apiParam {Number} ininInformationId 要删除的资讯的id
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
    public function deleteAppoIninInformation(Request $request) {

    }


    /**
     * 资讯频道首页推荐-添加列表
     */



    /**
     * @api {post} admin/operate/getInformPagingData 获取咨询列表添加分页数据
     * @apiGroup operate
     *
     * @apiParam {Number} pageNumber 跳转页面下标
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} sortType 排序方式
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
     *              "information_type":"xxxxxxxxxxxx",
     *              "create_time":"xxxxxxxxxxxx"
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
     public function getInformPagingData(Request $request) {

     }




    /**
     * @api {post} admin/operate/selectAppointInformData 获得咨询列表添加页查询的指定数据
     * @apiGroup operate
     *
     * @apiParam {Number} informationTypeId 资讯类型id
     * @apiParam {String} titleKeyword 标题关键字
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
     *              "information_type":"xxxxxxxxxxxx",
     *              "create_time":"xxxxxxxxxxxx"
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
     public function selectAppointInformData(Request $request) {

     }


     //注意添加的时候需要判断资讯是否在这两个区域中
    /**
     * @api {post} admin/operate/addAppoinInformations 向指定区域添加相关咨讯
     * @apiGroup operate
     *
     * @apiParam {Array} informArr 需要添加的资讯id数组
     * @apiParam {Number} appointId 指定区域的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "添加成功"
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
     public function addAppoinInformations(Request $request) {

     }





    /**
     * @api {post} admin/operate/getInformationType 获取所有资讯类型
     * @apiGroup operate
     * 
     * @apiDescription 在资讯频道首页推荐-添加列表页面调用，获得所有资讯的类型，不需要传递参数
     * 
     *
     * @apiSuccess {Object[]} obj  资讯类型名称
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
     *
     */
     public function getInformationType(Request $request) {

     }







}