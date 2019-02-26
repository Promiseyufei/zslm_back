<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/20
     * Time: 9:02
     */
    
    namespace App\Models;
    
    
    use Illuminate\Support\Facades\DB;

    class dict_major_confirm
    {
        private static $sTableName = 'dict_major_confirm';
        
        public static function getAllMajorConfirm(){
            $result = DB::table(self::$sTableName)->get(['id','name']);
            $len = $result != null ? sizeof($result) : 0;
            $major_confirms = [];
            for($i = 0;$i < $len;$i++){
                $major_confirms[$result[$i]->id] = $result[$i]->name;
            }
            return $major_confirms;
        }
    }