<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/9
     * Time: 17:54
     */
    
    namespace App\Models;
    
    use DB;
    class dict_industry
    {
        private static $sTableName = 'dict_industry';
        
        public static function getAllIndustry(){
            return DB::table(self::$sTableName)->get();
        }
        
    }