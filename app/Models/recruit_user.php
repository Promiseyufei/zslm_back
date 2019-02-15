<?php

    namespace App\Models;
    
    use Illuminate\Support\Facades\DB;

    class recruit_user
    {
        private static $sTableName = 'recruit_user';


        public static function judgePhone($phone, $recruirId) {
            return DB::table(self::$sTableName)->where('user_phone', $phone)->where('pro_id', $recruirId)->count();
        }

        public static function insertRecruitUser(array $userArr) {
            
            return DB::table(self::$sTableName)->insertGetId($userArr);
        }

        public static function updateRecruitUser($phone, $recruirId, array $userArr) {
            
            return DB::table(self::$sTableName)->where('user_phone', $phone)->where('pro_id', $recruirId)->update($userArr);
        }
        
    }