<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class information_relation
{
    public static $sTableName = 'information_relation';


    public static function getAppointInfoContent($infoId = 0, $contentName = '') {

        
        if($contentName == '')
            return DB::table(self::$sTableName)->where('zx_id', $infoId)->first();
        else 
            return DB::table(self::$sTableName)->where('zx_id', $infoId)->value($contentName);
        

    }

    public static function setRecommendInfos($infoId = 0, $name = '', $infoStr = '') {
        
        return DB::table(self::$sTableName)->where('zx_id', $infoId)->update([$name => $infoStr, 'update_time' => time()]);
    }
    
}   