<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class user_follow_major
{
    public static $sTableName = 'user_follow_major';



    public static function getAppointMajorRelevantUser(array $selectMajorArr = []) {

        return DB::table(self::$sTableName)->whereIn('major_id', $selectMajorArr)->where('is_focus')->pluck('user_id');
    }
}