<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/21
     * Time: 21:52
     */
    
    namespace App\Models;

    use Illuminate\Support\Facades\DB;
    class dict_major_direction
    {
        private static $sTableName = 'dict_major_direction';
        
        public static function  getAllDirection(){
            return DB::table(self::$sTableName)->get(['id','name']);
        }
    }