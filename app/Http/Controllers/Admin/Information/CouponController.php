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
     *              "type":"优惠券类型(0:满减型; 1:优惠型)",
     *              "context":"优惠券内容",
     *              "zslm_couponcol":"优惠券的使用说明",
     *              "is_enable":"优惠券的启用状态(０：已启用　１：已禁用)"
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

        if(!$request->isMethod('post')) return responseToJson(2, '参数错误');

        $coach_id = (isset($request->CoachId) && is_numeric($request->CoachId)) ? $request->CoachId : 0;
        $page_count = (isset($request->pageCount) && is_numeric($request->pageCount)) ? $request->pageCount : 10;
        $page_number = (isset($request->pageCount) && is_numeric($request->pageCount)) ? $request->request : 0;

        if($coach_id == 0) return responseToJson(1, '参数错误');

        $get_coupon = ZslmCoupon::getCoachAppointCoupon($coach_id, $page_count, $page_number);

        return (is_object($get_coupon) && count($get_coupon) >=0) ? responseToJson(0, '', $get_coupon) : responseToJson(1, '查询失败');
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

        if(!$request->isMethod('post')) return responseToJson(2, '参数错误');

        $coupon_id = (isset($request->couponId) && is_numeric($request->couponId)) ? $request->couponId : 0;

        $state = ($request->state != null && is_numeric($request->state)) ? $request->state : -1;

        if($coupon_id == 0 || $state < 0 || intval($state) > 1) return responseToJson(1, '参数错误');

        $is_update = ZslmCoupon::setAppointCoipon($coupon_id, $state);

        return $is_update ? responseToJson(0, '设置成功') : responseToJson(1, '参数错误');
    }





    /**
     * @api {post} admin/information/createCoupon 新增优惠券
     * @apiGroup information
     *
     * @apiParam {Number} coachId 所属辅导机构id
     * @apiParam {String} couponName 优惠券名称
     * @apiParam {Number} couponType 优惠券类型(0:满减型; 1:优惠型)
     * @apiParam {String} context 优惠券内容
     * @apiParam {String} couponcol 优惠券说明
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
    public function createCoupon(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '参数错误');

        $rules = [
            'coachId'       => 'required|numeric',
            'couponName'    => 'required|string|max:255',
            'couponType'    => 'required|numeric',
            'context'       => 'required|string',
            'couponcol'     => 'required|string'
        ];

        $message = [
            'coachId.*'       => '参数错误',
            'couponName.max'  => '名称超过最大长度',
            'couponType.*'    => '参数错误',
            'context.*'       => '参数错误',
            'couponcol.*'     => '参数错误'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $create_id = ZslmCoupon::createCoupon($request->all());

        return $create_id ? responseToJson(0, '新增成功') : responseToJson(1, '新增失败');

    }



    /**
     * @api {post} admin/information/updateAppointCoupon 更新指定优惠券的字段信息
     * @apiGroup information
     *
     * @apiParam {Number} couponId 优惠券id
     * @apiParam {String} couponName 优惠券名称
     * @apiParam {Number} couponType 优惠券类型(0:满减型; 1:优惠型)
     * @apiParam {String} context 优惠券内容
     * @apiParam {String} couponcol 优惠券说明
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
    public function updateAppointCoupon(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '参数错误');

        $rules = [
            'couponId'       => 'required|numeric',
            'couponName'    => 'required|string|max:255',
            'couponType'    => 'required|numeric',
            'context'       => 'required|string',
            'couponcol'     => 'required|string'
        ];

        $message = [
            'couponId.*'       => '参数错误',
            'couponName.max'  => '名称超过最大长度',
            'couponType.*'    => '参数错误',
            'context.*'       => '参数错误',
            'couponcol.*'     => '参数错误'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $is_update = ZslmCoupon::updateCoupon($request->all());

        return $is_update ? responseToJson(0, '修改成功') : responseToJson(1, '修改失败');
    }


}