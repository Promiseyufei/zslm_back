<?php

    namespace App\Models;
    
    
    use Illuminate\Http\Request;
    use DB;
    
    define('ADDRESS_SEPARATOR', ',');
    
    class dispensing_major
    {

        public static $sTableName = 'dispensing_major';

        public static function getDiMajorById($majorName,$felds){
            $data = DB::table(self::$sTableName)->where('is_delete', 0)->where('major_add', $majorName)->limit(1)->get($felds);
            return $data;
        }

        public static function judgeStopDis($majorName) {
            return DB::table(self::$sTableName)->where('is_delete', 0)->where('major_add', $majorName)->where('stop_dispensing')->pluck('stop_dispensing');
        }

    }