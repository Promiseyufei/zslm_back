<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class activity_relation
{
    public static $sTableName = 'activity_relation';


    /**
     * 检测活动是否已关联到活动关联表中
     */
    private static function selectExistenceActivity($activityId = 0) {
        return DB::table(self::$sTableName)->where('id', $activityId)->count();
    }

    public static function setAppointHostMajor($activityId, $majorId) {
        switch(self::selectExistenceActivity($activityId))
        {
            case 0:
                return DB::table(self::$sTableName)->insertGetId(['host_major_id' => $majorId]);
                break;
            default :
                return DB::table(self::$sTableName)->where('id', $activityId)->update(['host_major_id' => $majorId]);
                break;
        }

    }




}