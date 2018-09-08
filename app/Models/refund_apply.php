<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class refund_apply
{
    public static $sTableName = 'refund_apply';


    public static function getPageRefundMsg(array $val = []) {
        
        $handle = DB::table(self::$sTableName)
        ->leftJoin('user_accounts', self::$sTableName . '.account_id', '=', 'user_accounts.id')
        ->leftJoin('coach_organize', self::$sTableName . '.f_id', '=', 'coach_organize.id');
        if(isset($val['keyWord']))
            $handle = $handle->where('name', 'like', '%' . $val['keyWord'] . '%')->orWhere('phone', 'like', '%' . $val['keyWord'] . '%');

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

        return $handle->select(
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
            )->offset($val['pageCount'] * $val['pageNumber'])
            ->limit($val['pageCount'])->orderBy('create_time', 'desc')->get()->toArray()->map(function($item) {
                $coupon_key = DB::table('user_coupon')->where([
                    ['user_id', '=', $item->account_id],
                    ['coupon_id', '=', $item->coupon_id]
                ])->value('key');

                empty($coupon_key) ? $item->coupon_key = '未使用' : $item->coupon_key = $coupon_key;
                
                $item->create_time = date('Y-m-d h:i:s', $item->create_time);
                $item->registration_deadline = date('Y-m-d h:i:s', $item->registration_deadline);

                return $item;
            });

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

    public static function setAppointRefundApproveStatus($refundId, $approveStatus, $approveContext = '') {
        return DB::table(self::$sTableName)
        ->where('id', $refundId)
        ->update([
            'approve_status' => $approveStatus, 
            'approve_context' => $approveContext, 
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
                )->get()->toArray()->map(function($item) {
                    $coupon_key = DB::table('user_coupon')->where([
                        ['user_id', '=', $item->account_id],
                        ['coupon_id', '=', $item->coupon_id]
                    ])->value('key');

                    empty($coupon_key) ? $item->coupon_key = '未使用' : $item->coupon_key = $coupon_key;
                    
                    $item->create_time = date('Y-m-d h:i:s', $item->create_time);
                    $item->registration_deadline = date('Y-m-d h:i:s', $item->registration_deadline);

                    return $item;
                });
        
        
    }
    
}