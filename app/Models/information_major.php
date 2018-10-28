<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class information_major
{
    public static $sTableName = 'information_major';


    public static function setAppointRelevantMajor($infoId = 0, array $majorArr = []) {

        $msg_arr = [];
        foreach($majorArr as $key => $major_id)
            array_push($msg_arr,[
                'zx_id' => $infoId,
                'xg_sc_id' => $major_id
            ]);
        
        return DB::table(self::$sTableName)->insert($msg_arr);
    }

    public static function selectAppointRelation($infoId) {

        return DB::table(self::$sTableName)->where('zx_id', $infoId)->pluck('xg_sc_id');

    }

}