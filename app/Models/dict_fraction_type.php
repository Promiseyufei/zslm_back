<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/18
     * Time: 19:25
     */
    
    namespace App\Models;
    
    
    use Illuminate\Support\Facades\DB;

    class dict_fraction_type
    {
        private static $sTableName = 'dict_fraction_type';
        
        public static function getAllType()
        {
            return DB::table(self::$sTableName)->get(['id','name']);
        }
    }