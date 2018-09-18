<?php

/**
 * 退款管理模块
 */

namespace App\Http\Controllers\Admin\Refund;

use App\Models\refund_apply as RefundApply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class RefundController extends Controller 
{


    /**
     * @api {post} admin/refund/getRefundPageMsg 获取退款单管理页面分页数据
     * @apiGroup refund
     * 
     * 
     * @apiParam {String} keyWord 关键字(手机号/用户姓名)
     * @apiParam {Number} screenState 筛选状态(按审批状态筛选，0未审批，１通过，２驳回,3全部)
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
     *              "create_time":"退款申请时间",
     *              "user_account":"账号(手机号)",
     *              "coach_name":"辅导机构名称",
     *              "apply_refund_money":"申请退款金额",
     *              "coupon_key":"优惠券标识",
     *              "registration_deadline":"报名日期",
     *              "phone":"联系电话",
     *              "alipay_account":"支付宝账号",
     *              "name":"收款人",
     *              "card":"银行卡号",
     *              "bank":"开户行信息",
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
    public function getRefundPageMsg(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $rules = [
            'keyWord'       =>'nullable|string|max:255',
            'screenState'   => 'required｜numeric',
            'pageCount'     => 'required｜numeric',
            'pageNumber'    => 'required｜numeric'
        ];

        $message = [
            'soachNameKeyword.max'    =>'搜索关键字超过最大长度',
            'screenType.*'            =>'参数错误',
            'screenState.*'           =>'参数错误',
            'pageCount.*'             => '参数错误',
            'pageNumber.*'            => '参数错误'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $get_refund_msg = RefundApply::getPageRefundMsg($request->all());

        return (is_array($get_refund_msg) && count($get_refund_msg) >= 0) ? responseToJson(0, '', $get_refund_msg) : responseToJson(1, '查询失败');


    }



    /**
     * @api {post} admin/refund/selectAppointAppealMessage 查看指定退款订单的申诉信息
     * @apiGroup refund
     * 
     * 
     * @apiParam {NUmber} refundId 退款单id
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
     *              "apply_refund_money":"申请退款金额",
     *              "registration_deadline":"报名日期",
     *              "to_apply_for_reimbursement":"申诉理由",
     *              "imgs":"相关图片"
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
    public function selectAppointAppealMessage(Request $request) {

        $refund_id = (isset($request->refundId) && is_numeric($request->refundId)) ? $request->refundId : 0;
        if($refund_id == 0) return responseToJson(1, '参数错误');
        $appoint_refund_msg = RefundApply::selectAppealMsg($refund_id);

        return (($appoint_refund_msg ?? false) && is_object($appoint_refund_msg)) ? responseToJson(0, '', $appoint_refund_msg) : responseToJson(1, '查询新信息失败');
    }



    /**
     * @api {post} admin/refund/setApproveStatus 修改审批状态
     * @apiGroup refund
     * 
     * 
     * @apiParam {NUmber} refundId 退款单id
     * @apiParam {NUmber} approveStatus 审批状态(0未审批，１通过，２驳回)
     * @apiParam {String} approveContext 驳回内容(审批状态设置成驳回时需要提交驳回理由，该参数在未审批或通过时不提交)
     * 
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功",
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
    public function setApproveStatus(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $refund_id = (isset($request->refundId) && is_numeric($request->refundId)) ? $request->refundId : 0;
        $approve_status = ($request->approveStatus ?? false && is_numeric($request->approveStatus)) ? $request->approveStatus : -1;

        $approve_context = '';
        if(intval($approve_status) == 2) 
            if(trim($request->approveContext) ?? false) 
                $approve_context = trim($request->approveContext);
            else 
                return responseToJson(1, '请填写驳回理由');
        
        if($refund_id == 0 || intval($approve_status) < 0 || intval($approve_status) > 3) return responseToJson(1, '参数错误');

        $is_update = RefundApply::setAppointRefundApproveStatus($refund_id, $approve_status, $approve_context);

        return $is_update ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');

    }




    /**
     * @api {post} admin/refund/setApproveStatus 设置流程状态
     * @apiGroup refund
     * 
     * 
     * @apiParam {NUmber} refundId 退款单id
     * @apiParam {NUmber} processStatus 流程状态状态(0进行中；1已结束)
     * 
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功",
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
    public function setProcessStatus(Request $request) {
        
        $refund_id = (isset($request->refundId) && is_numeric($request->refundId)) ? $request->refundId : 0;
        $process_status = ($request->processStatus ?? false && is_numeric($request->processStatus)) ? $request->processStatus : -1;
        
        if($refund_id == 0 || intval($process_status) < 0 || intval($process_status) > 1 ) return responseToJson(1, '参数错误');

        if(RefundApply::judgeAppointApproveStatus($refund_id)) return responseToJson(1, '该订单还未审批!');

        $is_update = RefundApply::setAppointRefundProcessStatus($refund_id, $process_status);

        return $is_update ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');

    }


}