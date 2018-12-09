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
            return DB::table(self::$sTableName)
                ->join('zslm_coupon',self::$sTableName.'.coupon_id','zslm_coupon.id')
                ->where('is_delete',0)
                ->where('user_id',$id)
                ->where('use_time',0)
                ->where('is_enable',0)
                ->count('zslm_coupon.id');
        }
    
        public static function getCountEnableCoupon($id,$status){
            return DB::table(self::$sTableName)
                ->join('zslm_coupon',self::$sTableName.'.coupon_id','zslm_coupon.id')
                ->where('user_id',$id)->where('is_enable',$status)->count('zslm_coupon.id');
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
        
        public static function useCoupon($u_id,$c_id){
          return  DB::table(self::$sTableName)
                ->where('user_id',$u_id)
                ->where('coupon_id',$c_id)
                ->update(['is_use'=>1,"use_time"=>time(),"update_time"=>time()]);
        }
        
        public static function getUserCouponByCouponId($u_id,$c_id){
            return DB::table(self::$sTableName)
                ->where('user_id',$u_id)
                ->where('coupon_id',$c_id)
                ->limit(1)
                ->get(['id','use_time']);
        }
        
        public static function addUserCoupon($u_id,$c_id){
            return DB::table(self::$sTableName)->insert(['coupon_id'=>$c_id,'user_id'=>$u_id,'is_use'=>0,"create_time"=>time(),'is_delete'=>0]);
        }
        
        public static function checkUserCoupon($u_id,$c_id){
            return DB::table(self::$sTableName)->where('user_id',$u_id)->where('coupon_id',$c_id)->where('use_time',0)->where('is_delete',0)->count('id');
        }
     
        
    }