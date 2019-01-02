<?php

    namespace App\Models;
    
    
    use Illuminate\Http\Request;
    use DB;
    
    define('ADDRESS_SEPARATOR', ',');
    
    class dispensing_major
    {

        public static $sTableName = 'dispensing_major';

        public static function getDiMajorById($id,$felds){
            $data = DB::table(self::$sTableName)->where('is_delete', 0)->where('id', $id)->limit(1)->get($felds);
            return $data;
        }

    }