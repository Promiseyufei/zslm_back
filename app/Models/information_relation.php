<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class information_relation
{
    public static $sTableName = 'information_relation';


    private static function judgeInfoRelationExistence($infoId) {
        if($infoId < 1) return 0;
        $is_existence = DB::table(self::$sTableName)->where('zx_id', $infoId)->count();

        if($is_existence > 0) return 1;
        else {
            return DB::table(self::$sTableName)->insertGetId([
                'zx_id' => $infoId
            ]);
        }
    }

    public static function getAppointInfoContent($infoId = 0, $contentName = '') {

        if(self::judgeInfoRelationExistence($infoId)) {
            if($contentName == '')
                return DB::table(self::$sTableName)->where('zx_id', $infoId)->first();
            else 
                return DB::table(self::$sTableName)->where('zx_id', $infoId)->value($contentName);
        }
    }

    public static function setRecommendInfos($infoId = 0, $name = '', $infoStr = '') {
        
        if(self::judgeInfoRelationExistence($infoId)) {
            // dd($name);
            return DB::table(self::$sTableName)->where('zx_id', $infoId)->update(["$name" => $infoStr]);
        }
    }
    
}   