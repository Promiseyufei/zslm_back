<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/8
     * Time: 20:31
     */
    
    namespace App\Models;
    
    use DB;
    class dict_region
    {
    
        private static $sTableName = 'dict_region';
        
        public static function getProvince(){
           $provice =  DB::table(self::$sTableName)->where('father_id',0)->get(['id','name']);
           return $provice;
        }
        
        public static function getAllArea(){
            $provice =  DB::table(self::$sTableName)->get(['id','name']);
            return $provice;
        }
    }