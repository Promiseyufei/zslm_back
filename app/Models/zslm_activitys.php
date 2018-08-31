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



}