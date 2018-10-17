<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class coach_organize
{
    public static $sTableName = 'coach_organize';


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
    
    public static function getCoachNameById($id){
        return DB::table(self::$sTableName)->where('is_delete', 0)->where('id',$id)->first(['coach_name']);
    }

    public static function getCoachPageMsg(array $val = []) {
        
        $handle = DB::table(self::$sTableName)->where('is_delete', 0);
        $sort_type = [0=>['is_show','desc'], 1=>['is_show','asc'], 2=>['update_time','desc']];
        if(isset($val['soachNameKeyword'])) $handle = $handle->where('coach_name', 'like', '%' . $val['soachNameKeyword'] . '%');

        switch($val['screenType'])
        {
            case 0:
                self::judgeScreenState($val['screenState'], 'is_show', $handle);
                break;
            case 1:
                self::judgeScreenState($val['screenState'], 'is_recommend', $handle);
                break;
            case 2:
                self::judgeScreenState($val['screenState'], 'if_coupons', $handle);
                break;
            case 3:
                self::judgeScreenState($val['screenState'], 'if_back_money', $handle);
                break;
            default :
                break;
        }

        $get_page_msg = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])
        ->offset($val['pageCount'] * $val['pageNumber'])
        ->limit($val['pageCount'])->get();

        return count($get_page_msg)>= 0 ? $get_page_msg : false;
    }

    public static function getCoachAppiCount(array $condition = []) {
        return DB::table(self::$stableName)->where($condition)->count();
    }


    public static function setAppiCoachState(array $coach = []) {

        $handle = DB::table(self::$sTableName)->where('id', $coach['coach_id']);
        switch($activity['type'])
        {
            case 0:
                return $handle->update(['weight' => $coach['state'], 'update_time' => time()]);
                break;
            case 1:
                return $handle->update(['is_show' => $coach['state'], 'update_time' => time()]);
                break;
            case 2:
                return $handle->update(['is_recommend' => $coach['state'], 'update_time' => time()]);
                break;
        }
    }

    public static function getAppointCoachMsg($coachId = 0, $msgName = '') {
        if(empty($msgName))
            return DB::table(self::$sTableName)->where('id', $coachId)->first();
        else
            return DB::table(self::$sTableName)->where('id', $coachId)->select($msgName)->first();
    }


    public static function delAppointCoach($coachId = 0) {
        return DB::table(self::$sTableName)->where('id', $coachId)->update(['is_delete' => 1, 'update_time' => time()]);
    }

    public static function getBranchCoachMsg($totleId = 0, $pageNum = 0, $pageCount = 10) {
        return DB::table(self::$sTableName)->where('father_id', $totleId)
        ->offset($pageNum * $pageCount)->limit($pageCount)
        ->select('id', 'weight', 'is_show', 'is_recommend', 'coach_name', 'province', 'phone', 'address', 'web_url', 'coach_type', 'if_coupons', 'if_back_money', 'update_time')
        ->get();
    }

    public static function createCoach(array $createCoachMsg = []) {
        
        return DB::table(slef::$sTableName)->insertGetId($createCoachMsg);
    }

    public static function setCouponsState($coachId = 0, $state = -1) {
        return DB::table(sself::$sTableName)->where('id', $coachId)->update(['if_coupons' => $state, 'update_time' => time()]);
    }

}