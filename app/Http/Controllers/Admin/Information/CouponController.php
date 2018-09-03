<?php

/**
 * 优惠券管理
 */

namespace App\Http\Controllers\Admin\Information;

use App\Models\coach_organize as CoachOrganize;
use App\Models\zslm_coupon as ZslmCoupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class CouponController extends Controller 
{


    /**
     * @api {post} admin/information/getPageCoupon 优惠券列表页(对于辅导机构)分页
     * @apiGroup information
     * 
     * 
     * @apiParam {String} soachNameKeyword 辅导机构名称关键字
     * @apiParam {Number} screenType 筛选方式(0按是否支持优惠券；1按机构类型;2是全部)
     * @apiParam {Number} screenState 筛选状态(0支持优惠券/总部；1不支持/分校;2全部)
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
     *              "coach_name":"辅导机构名称",
     *              "father_id":"辅导结构类别(０是总部，非零为分校)",
     *              "if_coupons":"优惠券启用状态，是否支持优惠券",
     *              "coupon_count":"优惠券的张数"
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
    public function getPageCoupon(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $rules = [
            'soachNameKeyword' =>'nullable|string|max:255',
            'screenType' => 'numeric',
            'screenState' => 'numeric',
            'pageCount' => 'numeric',
            'pageNumber' => 'numeric'
        ];

        $message = [
            'soachNameKeyword.max' =>'搜索关键字超过最大长度',
            'screenType.*'            =>'参数错误',
            'screenState.*'           =>'参数错误',
            'pageCount.*'             => '参数错误',
            'pageNumber.*'            => '参数错误'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $coupons_msg = ZslmCoupon::getCouponPageMsg($request->all()->toArray());

        return ($coupons_msg != false) ? responseToJson(0,'', $coupons_msg) : responseToJson(1, '查询失败'); 
        
    }



    /**
     * @api {post} admin/information/getPageCouponCount 优惠券列表页(对于辅导机构)分页总数
     * @apiGroup information
     * ZslmCoupon
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
    public function getPageCouponCount(Request $request) {
            if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

            if(isset($request->conditionArr) &&  is_array($request->conditionArr))
                return responseToJson(0, '', ZslmCoupon::getcoachAppiCount($request->conditionArr));
            else responseToJson(1, '查询失败');

    }


    /**
     * @api {post} admin/information/setAppointCoachCouponsEnable 设置指定辅导机构的优惠券启用状态
     * @apiGroup information
     *
     * @apiParam {Number} coachId 指定辅导机构的id
     * @apiParam {Number} state 要修改的值(０启用；１禁用)
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
    public function setAppointCoachCouponsEnable(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '参数错误');

        $coach_id = (isset($request->coachId) && is_numeric($request->coachId)) ? $request->coachId : 0;
        $state = ($request->state != null && is_numeric($request->state)) ? $request->state : -1;

        $is_update = CoachOrganize::setCouponsState($coach_id, $state);

        return $is_update ? responseToJson(0, '修改成功') : responseToJson(1, '修改失败');

    }





    /**
     * @api {post} admin/information/getAppointCoupon 设置指定的辅导机构的优惠券(跳转到优惠券新增页的列表页，注意分页)
     * @apiGroup information
     * 
     * 
     * @apiParam {Number} CoachId 辅导机构的id
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} pageNumber 跳转页面下标
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
     *              "name":"优惠券名称",
     *              "type":"优惠券类型",
     *              "context":"优惠券内容",
     *              "zslm_couponcol":"优惠券的使用说明",
     *              "is_enable":"优惠券的启用状态"
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
    public function getAppointCoupon(Request $request) {

    }



    //设置单张优惠券的启用状态


    /**
     * @api {post} admin/information/setAppointCouponEnable 设置指定优惠券的启用状态
     * @apiGroup information
     *
     * @apiParam {Number} couponId 指定优惠券的id
     * @apiParam {Number} state 要修改的值(０启用；１禁用)
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
    public function setAppointCouponEnable(Request $request) {

    }



    //更新指定优惠券的字段信息
    public function updateAppointCoupon(Request $request) {

    }



    //新增优惠券
    public function createCoupon(Request $request) {

    }


}