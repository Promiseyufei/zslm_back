<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class zslm_activitys
{
    public static $sTableName = 'zslm_activitys';



    private static function judgeScreenState($screenState, $title, &$handle) {
        switch($screenState) {
            case 0:
                $handle = $handle->where($title, '=', 0);
                break;
            case 1:
                $handle = $handle->where($title, '=', 1);
                break;
            default :
                break;
        }
    }

    private static function judgeActivityState($activiState, $title, &$handle) {
        switch($activiState)
        {
            case 0:
                $handle = $handle->where($title, '=', 0);
                break;
            case 1:
                $handle = $handle->where($title, '=', 1);
                break;
            case 2:
                $handle = $handle->where($title, '=', 2);
                break;
            default :
        }
    }

    public static function getActivityPageMsg(array $val = []) {

        $handle = DB::table(self::$sTableName);
        $sort_type = [0=>['show_weight','desc'], 1=>['show_weight','asc'], 2=>['update_time','desc']];
        if(isset($val['activityNameKeyword'])) $handle = $handle->where('active_name', 'like', '%' . $val['activityNameKeyword'] . '%');

        switch($val['screenType'])
        {
            case 0:
                self::judgeScreenState($val['screenState'], 'show_state', $handle);
                break;
            case 1:
                self::judgeScreenState($val['screenState'], 'recommended_state', $handle);
                break;
            case 2:
                self::judgeActivityState($val['activityState'], 'active_status', $handle);
                break;
            default :
                break;
        }

        $get_page_msg = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])
        ->offset($val['pageCount'] * $val['pageNumber'])
        ->limit($val['pageCount'])->get();

        return count($get_page_msg >= 0) ? $get_page_msg : false;
    }


    public static function getActivityAppiCount(array $condition = []) {
        return DB::table(self::$stableName)->where($condition)->count();
    }


    public static function setAppiActivityState(array $activity = []) {
        $handle = DB::table(self::$sTableName)->where('id', $activity['act_id']);
        switch($activity['type'])
        {
            case 0:
                return $handle->update(['show_weight' => $activity['state'], 'update_time' => time()]);
                break;
            case 1:
                return $handle->update(['show_state' => $activity['state'], 'update_time' => time()]);
                break;
            case 2:
                return $handle->update(['recommended_state' => $activity['state'], 'update_time' => time()]);
                break;
            case 3:
                return $handle->update(['active_status' => $activity['state'], 'update_time' => time()]);
                break;
        }
    }

    public static function getAppointActivityMsg($activityId = 0, $msgName = '') {
        if(empty($msgName))
            return DB::table(self::$sTableName)->where('id', $activityId)->first();
        else
            return DB::table(self::$sTableName)->where('id', $activityId)->select(...$msgName)->first();
    }

    public static function delAppointActivity($activityId = 0) {
        return DB::table(self::$sTableName)->where('id', $activityId)->update(['is_delete' => 1, 'update_time' => time()]);
    }

    public static function updateActivityTime($activityId = 0) {
        return DB::table(self::$sTableName)->where('id', $activityId)->update(['update_time' => time()]);
    }


    public static function getAllActivity($getMsgName = '') {
        if(!empty($getMsgName))
            return DB::table(self::$sTableName)->where('is_delete', 0)->select($getMsgName)->get();
        else
            return DB::table(slef::$sTableName)->where('is_delete', 0)->get();
    }


        /**
     * 自动设置推荐活动时获得可以推荐的活动的id数组
     */
    public static function getAutoRecommendActivitys($recomActivityCount = 8) {
        return DB::table(self::$sTableName)->where([
            ['is_delete', '=', 0],
            ['show_state', '=', 0],
            ['recommended_state', '=', 0],
            ['active_status', '<>', 2]
        ])->orderBy('active_status','desc')->orderBy('show_weight', 'desc')->skip($recomActivityCount)->pluck('id');
    }


    public static function createAppointActivityMsg(array $createActivityMsg = []) {
        
        return DB::table(self::$sTableName)->insertGetId($createActivityMsg);

    }
    
    public static function getUserActivitys($activity_ids){
        return DB::table(self::$sTableName)->where('is_delete',0)->whereIn('id',$activity_ids)->get(['name']);
    }





}