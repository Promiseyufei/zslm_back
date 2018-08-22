<?php

/**
 * 广告位管理
 */

namespace App\Http\Controllers\Admin\Operate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class BillboardController extends Controller 
{


    /**
     * @api {post} admin/operate/getAllPageListName 获得所有页面的名称
     * @apiGroup operate
     * 
     * @apiDescription 在广告位管理页面调用，获得顶部各页的名称，不需要传递参数
     * 
     *
     * @apiSuccess {Object[]} obj  页面名称json
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
     *              "url":"front/test/test"
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
    public function getAllPageListName(Request $request) {

    }


    /**
     * @api {post} admin/operate/getAppointPageBillboard 获得指定页面的广告
     * @apiGroup operate
     *
     * @apiParam {Number} pageId 页面id
     * @apiParam {Number} btType banner-Or-Billboard的类型　０是banner类型，1是广告类型
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
     *              "img":"xxxxxxxxxxxx",
     *              "img_alt":"front/test/test",
     *              "re_rul":"xxxxxxxxxxxx",
     *              "re_alt":"xxxxxxxxxxxx",
     *              "show_weight":"xxxxxxxxxxxx",
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
    public function getAppointPageBillboard(Request $request) {

    }


    /**
     * @api {post} admin/operate/setBillboardWeight 设置页面上广告的权重
     * @apiGroup operate
     *
     * @apiParam {Number} billboardId 指定广告的id
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
    public function setBillboardWeight(Request $request) {

    }



    /**
     * @api {post} admin/operate/setBillboardMessage 修改页面上指定广告的信息
     * @apiGroup operate
     *
     * @apiParam {String} btName 图片名称
     * @apiParam {String} btImgAlt 图片alt
     * @apiParam {String} reUrl 点击跳转的路由
     * @apiParam {String} btId Billboard的id
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
    public function setBillboardMessage(Request $request) {

    }



    /**
     * @api {post} admin/operate/deleteBannerAd 删除页面上的指定广告
     * @apiGroup operate
     *
     * @apiParam {String} btId 要删除的Billboard的id
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
    public function deletePageBillboard(Request $request) {

    }



    /**
     * @api {post} admin/operate/createBannerAd 新增页面上的广告
     * @apiGroup operate
     *
     * @apiParam {String} imgName 图片名称
     * @apiParam {String} imgAlt 图片alt
     * @apiParam {String} reUrl 点击跳转的路由
     * @apiParam {file} img 图片
     * @apiParam {Number} urlId 页面的id
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
    public function createPageBillboard(Request $request) {

    }


    private function createDirImg() {

    }


    private function updateDirImgName() {

    }



}