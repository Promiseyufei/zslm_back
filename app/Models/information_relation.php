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
            return DB::table(self::$sTableName)->where('zx_id', $infoId)->update(["$name" => $infoStr]);
        }
    }
    

    public static function delAppointInfoReRead($id, $infoId = null) {
        // dd(strChangeArr(DB::table(self::$sTableName)->where('zx_id', $id)->value('tj_yd_id'), ','));
        if($infoId !== null) {
            if(is_numeric($infoId)) 
                return DB::table(self::$sTableName)->where('zx_id', $id)->update(['tj_yd_id' => strChangeArr(deleteArrValue(strChangeArr(DB::table(self::$sTableName)->where('zx_id', $id)->value('tj_yd_id'), ','), $infoId), ',')]);
            else if(is_array($infoId))
                return DB::table(self::$sTableName)->where('zx_id', $id)->update(['tj_yd_id' => strChangeArr(array_diff(strChangeArr(DB::table(self::$sTableName)->where('zx_id', $id)->value('tj_yd_id'), ','), $infoId))]);
        }
        else 
            return DB::table(self::$sTableName)->where('zx_id', $id)->update(['tj_yd_id' => '']);

    }
}   