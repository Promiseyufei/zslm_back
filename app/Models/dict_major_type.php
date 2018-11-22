<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/10/13
     * Time: 9:42
     */
    
    namespace App\Models;
    
    
    use Illuminate\Support\Facades\DB;

    class dict_major_type
    {
        private static $sTableName = 'dict_major_type';
        
        public static function getAllSonMajor(){
            return DB::table(self::$sTableName)->where('father_id','!=',0)->get(['id','name']);
        }
    
        public static function getAllMajor(){
            return DB::table(self::$sTableName)->where('father_id',0)->get(['id','name']);
        }
    }