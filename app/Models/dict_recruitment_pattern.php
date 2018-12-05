<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/21
     * Time: 21:56
     */
    
    namespace App\Models;

    use Illuminate\Support\Facades\DB;
    class dict_recruitment_pattern
    {
        private static $sTableName = 'dict_recruitment_pattern';
        
        public static function getAllPattern(){
            return DB::table(self::$sTableName)->get(['id','name']);
        }
        
        public static function getPattern($id){
            return DB::table(self::$sTableName)->where('id',$id)->get(['name']);
        }
    }