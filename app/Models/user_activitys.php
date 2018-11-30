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
        
        public static function getCountUserActivity($id,$status = 0){
            return DB::table(self::$sTableName)->where('user_id',$id)->where('status',$status)->count('activity_id');
        }
    
        public static function unsetUserActivity($id,$a_id){
            return DB::table(self::$sTableName)->where('user_id',$id)->where('activity_id',$a_id)->update(['status'=>1]);
        }

        
        private static function judgeUserIsActivity($userId, $acId, $isInsert = false) {
            $is_existence = DB::table(self::$sTableName)->where('user_id', $userId)->where('activity_id', $acId)->count();
            if($is_existence < 1 && isset($isInsert)) 
                $insert_id = DB::table(self::$sTableName)->insertGetId([
                    'user_id' => $userId,
                    'activity_id' => $acId,
                    'status' => 1,
                    'create_time' => time()
                ]);

            return !empty($insert_id) ?  $insert_id : $is_existence;
            
        }

        public static function changeUserAcStatus($userId, $acId, $status) {
            if(self::judgeUserIsActivity($userId, $acId, true)) {
                return DB::table(self::$sTableName)
                    ->where('user_id', $userId)->where('activity_id', $acId)
                    ->update(['status' => $status, 'update_time' => time()]);
            }

        }
        
        //front
      
    }