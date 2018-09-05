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
        return DB::table(self::$sTableName)->where('activity_id', $activityId)->count();
    }


    /**
     * 设置指定活动的主办院校
     */
    public static function setAppointHostMajor($activityId, $majorId) {
        switch(self::selectExistenceActivity($activityId))
        {
            case 0:
                return DB::table(self::$sTableName)->insertGetId(['host_major_id' => $majorId]);
                break;
            default :
                return DB::table(self::$sTableName)->where('activity_id', $activityId)->update(['host_major_id' => $majorId]);
                break;
        }

    }


    /**
     * 获得指定活动的关联信息或指定活动的指定关联字段信息
     */
    public static function getAppointContent($activityId = 0, $contentName = '') {
        if($contentName == '')
            return DB::table(self::$sTableName)->where('activity_id', $activityId)->first();
        else
            return DB::table(self::$sTableName)->where('activity_id', $activityId)->value($contentName);
    }


    /**
     * 设置指定活动的关联推荐活动/推荐
     */
    public static function setRecommendActivitys($activityId = 0, $name = '', $activityStr = '') {

        return DB::table(self::$sTableName)->where('activity_id', $activityId)->update([$name => $activityStr, 'update_time' => time()]);
    }

    








}