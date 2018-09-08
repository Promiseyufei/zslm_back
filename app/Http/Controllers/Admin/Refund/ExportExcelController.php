<?php


namespace App\Http\Controllers\Admin\Refund;

use App\Models\refund_apply as RefundApply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;

class ExportExcelController extends Controller
{




    /**
     * @api {get} admin/refund/export 导出退款单表格
     * @apiGroup refund
     * 
     * 
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
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
    public function export(Request $request) {

        if(!$request->isMethod('get')) return responseToJson(2, '请求方式错误');
        
        $cellData = [];
        $get_all_msg = $this->getRefundAllMessage();
        
        if($get_all_msg == false) return responseToJson(1, '数据错误');
        
        $column = [
            '退款申请id', 
            '退款申请时间', 
            '账户id', 
            '账号', 
            '辅导机构名称', 
            '申请退款金额', 
            '优惠券', 
            '报名日期', 
            '联系电话', 
            '支付宝', 
            '收款人', 
            '银行卡号', 
            '开户行信息'
        ];

        array_push($cellData, $column);

        foreach($get_all_msg as $key=> $vlaue)
            array_push($cellData, array_values($vlaue->toArray()));

        unset($get_all_msg);
        
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');

    }


    private function getRefundAllMessage() {

        $all_message = RefundApply::getAllMessage();

        return (is_array($all_message) && count($all_message) > 0) ? $all_message : false;
        
    }
}


