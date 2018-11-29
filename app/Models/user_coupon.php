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
        
        public static function getCouponId($user_id,$is_use){
        
            return DB::table(self::$sTableName)
                ->where('is_delete',0)
                ->where('user_id',$user_id)
                ->get(['coupon_id']);
        }
        
        
        public static function getCountUserCoupon($id,$status){
            return DB::table(self::$sTableName)->where('user_id',$id)->where('is_use',$status)->count('id');
        }
    
        public static function getCouponIdWithUse($user_id,$is_use){
       
            $query =  DB::table(self::$sTableName)
                ->where('is_delete',0)
                ->where('user_id',$user_id);
             if($is_use == 0)
                 $query = $query->where('use_time',0);
             else if($is_use == 1)
                 $query = $query->where('use_time','>',0);
             return $query->get(['coupon_id']);
        }
        
    }