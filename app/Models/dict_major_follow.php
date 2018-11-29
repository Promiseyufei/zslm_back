<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/20
     * Time: 9:02
     */
    
    namespace App\Models;
    
    
    use Illuminate\Support\Facades\DB;

    class dict_major_follow
    {
        private static $sTabelName = 'dict_major_follow';
        
        public static function getAllMajorFollow(){
            $result =  DB::table(self::$sTabelName)->get(['id','name']);
            $len = sizeof($result);
            $major_follows = [];
            for($i = 0;$i<$len;$i++){
                $major_follows[$result[$i]->id] = $result[$i]->name;
            }
            return $major_follows;
        }
    }