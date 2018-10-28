<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/10/27
     * Time: 3:15
     */
    
    namespace App\Models;

    use DB;
    class dict_activity_type
    {
        private static $sTableName = 'dict_activity_type';
        
        public static function getType(){
            return DB::table(self::$sTableName)->get(['id','name']);
        }
    }