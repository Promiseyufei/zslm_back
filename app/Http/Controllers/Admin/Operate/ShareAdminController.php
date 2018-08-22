<?php

/**
 * 分享管理
 */

namespace App\Http\Controllers\Admin\Operate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ShareAdminController extends Controller 
{


    //分页



    /**
     * @api {post} admin/operate/getPagingData 获取分页数据
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
     *              "wx_count":"xxxxxxxxxxxx",
     *              "wb_count":"xxxxxxxxxxxx",
     *              "wx_browse":"xxxxxxxxxxxx",
     *              "wb_browse":"xxxxxxxxxxxx"
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
    public function getPagingData(Request $request) {

    }



    //查询


    /**
     * @api {post} admin/operate/selectAppointData 获得查询的指定数据
     * @apiGroup operate
     *
     * @apiParam {Number} contentType 内容类型
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
     *              "wx_count":"xxxxxxxxxxxx",
     *              "wb_count":"xxxxxxxxxxxx",
     *              "wx_browse":"xxxxxxxxxxxx",
     *              "wb_browse":"xxxxxxxxxxxx"
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
    public function selectAppointData(Request $request) {

    }





    
}