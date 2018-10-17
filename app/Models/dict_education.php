<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/9
     * Time: 17:26
     */
    
    namespace App\Models;
    
    use DB;
    class dict_education
    {
        private static $sTableName = 'dict_education';
        
        public static function getAllSchooling(){
        
            $schooling = DB::table(self::$sTableName)->get();
            return $schooling;
        }
        
        public static function getSchoolingById($id){
            $schooling = DB::table(self::$sTableName)->where('id',$id)->first(['name']);
            return $schooling;
        }
    }