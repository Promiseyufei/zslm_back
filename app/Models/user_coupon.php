<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/10
     * Time: 18:01
     */
    
    namespace App\Models;
    
    use DB;
    class user_coupon
    {
        private static $sTableName = 'user_coupon';
        
        public static function getCouponId($user_id){
        
            return DB::table(self::$sTableName)
                ->where('is_delete',0)
                ->where('user_id',$user_id)
                ->get(['coupon_id']);
        }
    }