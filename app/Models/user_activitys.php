<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/10
     * Time: 15:54
     */
    
    namespace App\Models;
    
    use DB;
    class user_activitys
    {
        public static $sTableName = 'user_activitys';
        
        public static function getActivityByUser($userId){
            
           return DB::table(self::$sTableName)->where('user_id',$userId)->where('status',0)->get(['activity_id']);
        }
    }