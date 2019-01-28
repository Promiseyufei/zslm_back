<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class refund_apply
{
    public static $sTableName = 'refund_apply';


    public static function getNoAccessMsg(){
        return DB::table(self::$sTableName)->where('is_delete',0)->where('approve_status',0)->count('id');
    }
    
    public static function getPageRefundMsg(array $val = []) {
        
        $handle = DB::table(self::$sTableName)
        ->leftJoin('user_accounts', self::$sTableName . '.account_id', '=', 'user_accounts.id')
        ->leftJoin('coach_organize', self::$sTableName . '.f_id', '=', 'coach_organize.id');
        
            $handle = $handle->where(self::$sTableName.'.name', 'like', '%' . $val['keyWord'] . '%')->where(self::$sTableName.'.phone', 'like', '%' . $val['phone'] . '%');

        switch($val['screenState'])
        {
            case 0:
            case 1:
            case 2:
                $handle = $handle->where('approve_status', $val['screenState']);
                break;
            default :
                break;
        }
        
        if($val['type2']<2)
            $handle = $handle->where('process_status', $val['type2']);
        
        $count = $handle->count();
        
        return [$handle->select(
            self::$sTableName . '.id', 
            'coach_organize.coach_name',
            self::$sTableName . '.name',
            self::$sTableName . '.card',
            self::$sTableName . '.bank',
            self::$sTableName . '.phone',
            self::$sTableName.'.account_id',
            self::$sTableName . '.coupon_id',
            self::$sTableName . '.create_time',
            self::$sTableName . '.update_time',
            self::$sTableName . '.approve_status',
            self::$sTableName . '.process_status',
            self::$sTableName . '.approve_context',
            
            'user_accounts.phone as user_account',
            self::$sTableName . '.alipay_account',
            self::$sTableName . '.apply_refund_money',
            self::$sTableName . '.registration_deadline'
            )->offset($val['pageCount'] * ($val['pageNumber']-1))
            ->limit($val['pageCount'])->orderBy('create_time', 'desc')->get(),$count];

    }
    
    public static function getOne($id) {
        
        $handle = DB::table(self::$sTableName)
            ->leftJoin('user_accounts', self::$sTableName . '.account_id', '=', 'user_accounts.id')
            ->leftJoin('coach_organize', self::$sTableName . '.f_id', '=', 'coach_organize.id')
            ->where( self::$sTableName . '.id',$id);
        
        
        return $handle->select(
            self::$sTableName . '.id',
            'coach_organize.coach_name',
            self::$sTableName . '.name',
            self::$sTableName . '.card',
            self::$sTableName . '.bank',
            self::$sTableName . '.phone',
            self::$sTableName.'.account_id',
            self::$sTableName . '.coupon_id',
            self::$sTableName . '.create_time',
            self::$sTableName . '.update_time',
            self::$sTableName . '.approve_status',
            self::$sTableName . '.process_status',
            self::$sTableName . '.approve_context',
            self::$sTableName . '.imgs',
            
            'user_accounts.phone as user_account',
            self::$sTableName . '.alipay_account',
            self::$sTableName . '.apply_refund_money',
            self::$sTableName . '.registration_deadline'
        )->get();
        
    }

    public static function selectAppealMsg($refundId = 0) {
        return DB::table(self::$sTableName)
            ->leftJoin('coach_organize', self::$sTableName . '.f_id', '=', 'coach_organize.id')
            ->where('id', $refundId)->select(
                self::$sTableName . '.id', 
                'coach_organize.coach_name',
                self::$sTableName . '.apply_refund_money',
                self::$sTableName . '.registration_deadline',
                self::$sTableName . '.to_apply_for_reimbursement',
                self::$sTableName . '.imgs'
            )->first();
    }

    public static function setAppointRefundApproveStatus($refundId, $approveStatus, $approveContext = '',$stat) {
        return DB::table(self::$sTableName)
        ->where('id', $refundId)
        ->update([
            'approve_status' => $approveStatus, 
            'approve_context' => $approveContext,
            'process_status'=>$stat,
            'update_time' => time()
            ]);

    }

    public static function judgeAppointApproveStatus($refundId = 0) {

        return DB::table(self::$sTableName)->where('id', $refundId)->value('approve_status');
    }


    public static function setAppointRefundProcessStatus($refundId = 0, $processStatus) {
        return DB::table(self::$sTableName)
        ->where('id', $refundId)
        ->update([
            'process_status' => $processStatus, 
            'update_time' => time()
            ]);
    }


    public static function getAllMessage() {
        return DB::table(self::$sTableName)
            ->leftJoin('user_accounts', self::$sTableName . '.account_id', '=', 'user_accounts.id')
            ->leftJoin('coach_organize', self::$sTableName . '.f_id', '=', 'coach_organize.id')->select(
                self::$sTableName . '.id', 
                'coach_organize.coach_name',
                self::$sTableName . '.name',
                self::$sTableName . '.card',
                self::$sTableName . '.bank',
                self::$sTableName . '.phone', 
                self::$sTableName . '.coupon_id',
                self::$sTableName . '.create_time', 
                'user_accounts.phone as user_account',
                self::$sTableName . '.alipay_account',
                self::$sTableName . '.apply_refund_money',
                self::$sTableName . '.registration_deadline'
                )->get()->map(function($item) {
                 
                    $coupon_key = DB::table('user_coupon')->where([
                        ['user_id', '=', $item->id],
                        ['coupon_id', '=', $item->coupon_id]
                    ])->value('key');

                    empty($coupon_key) ? $item->coupon_key = '未使用' : $item->coupon_key = $coupon_key;
                    
                    $item->create_time = date('Y-m-d h:i:s', $item->create_time);
                    $item->registration_deadline = date('Y-m-d h:i:s', $item->registration_deadline);

                    return $item;
                });
        
        
    }
    
    public static function addRefund(Request $request){
        return DB::table(self::$sTableName)->insert(['account_id'=>$request->u_id,'f_id'=>$request->f_id,
            'is_use_coupon'=>$request->is_coupon,'coupon_id'=>$request->cou_id,'registration_deadline'=>$request->time,
            'phone'=>$request->phone,'alipay_account'=>$request->alipay_account,'name'=>$request->name,'card'=>$request->card,
            'bank'=>$request->blank_addr,'to_apply_for_reimbursement'=>$request->message]);
    }
    
}