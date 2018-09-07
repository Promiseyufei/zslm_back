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
        ->leftJoin(self::$sTableName . '.f_id', '=', 'coach_organize.id');
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



    //没写完
    public static function selectAppealMsg($refundId = 0) {
        DB::table(self::$sTableName)
            ->leftJoin(self::$sTableName . '.f_id', '=', 'coach_organize.id')
            ->where('id', $refundId)->select('id', '')->first();
    }
    
}