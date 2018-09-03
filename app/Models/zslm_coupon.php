<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class zslm_coupon
{
    public static $sTableName = 'zslm_coupon';

    public static function getCouponPageMsg(array $msg = []) {
        $handle = DB::table('coach_organize')->leftJoin(self::$sTableName, 'coach_organize.id', '=', self::$sTableName. '.coach_id')->where('coach_organize.is_delete', 0);
        if(isset($val['soachNameKeyword'])) $handle = $handle->where('coach_organize.coach_name', 'like', '%' . $val['soachNameKeyword'] . '%');

        switch($val['screenType'])
        {
            case 0:
                self::judgeScreenState($val['screenState'], 'coach_organize.if_coupons', $handle);
                break;
            case 1:
                self::judgeScreenState($val['screenState'], 'coach_organize.father_id', $handle);
                break;
            default :
                break;
        }

        // $select_msg = $handle->offset($val['pageCount'] * $val['pageNumber'])->limit($val['pageCount'])
        // ->select('coach_organize.id', 'coach_organize.coach_name', 'coach_organize.father_id', 'coach_organize.f_coupons', 'DB::raw(count() as coupon_count'))
        // ->get()->groupBy();

        return count($get_page_msg)>= 0 ? $get_page_msg : false; 
    }


    private static function judgeScreenState($screenState, $title, &$handle) {
        switch($screenState) {
            case 0:
                $handle = $handle->where($title, '=', 0);
                break;
            case 1:
                $handle = ($title == 'father_id') ? $handle->where($title, '<>', 0) : $handle->where($title, '=', 1);
                break;
            default :
                break;
        }
    }


    public static function getcoachAppiCount(array $condition = []) {
        return DB::table('coach_organize')->where($condition)->count();
    }


    
}