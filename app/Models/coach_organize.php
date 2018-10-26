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
    
    public static function getFatherCoach(){
        return DB::table(self::$sTableName)->where('is_delete', 0)->where('father_id',0)->get(['id','coach_name']);
    }
    
    public static function getCoachNameById($id){
        return DB::table(self::$sTableName)->where('is_delete', 0)->where('id',$id)->first(['coach_name']);
    }

    public static function getCoachPageMsg(array $val = []) {
        
        $handle = DB::table(self::$sTableName)->where('is_delete', 0);
        $sort_type = [0=>['is_show','desc'], 1=>['is_show','asc'], 2=>['update_time','desc']];
        if(isset($val['soachNameKeyword'])) $handle = $handle->where('coach_name', 'like', '%' . $val['soachNameKeyword'] . '%');
        if($val['showType'] != 2)
            self::judgeScreenState($val['showType'], 'is_show', $handle);
        if($val['recommendType'] != 2)
            self::judgeScreenState($val['recommendType'], 'is_recommend', $handle);
        if($val['couponsType'] != 2)
            self::judgeScreenState($val['couponsType'], 'if_coupons', $handle);
        if($val['moneyType'] != 2)
            self::judgeScreenState($val['moneyType'], 'if_back_money', $handle);
        $count = $handle->count();
  
        $get_page_msg = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])
        ->offset($val['pageCount'] * ($val['pageNumber']-1))
        ->limit($val['pageCount'])->get();
        return count($get_page_msg)>= 0 ? [$get_page_msg,$count] : false;
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
      
        return DB::table(self::$sTableName)->insertGetId($createCoachMsg);
    }
    
    public static function createKTD(Request $request){
        return DB::table(self::$sTableName)
            ->where('id',$request->id)
            ->update([
                'title'=>$request->title,
                'keywords'=>$request->keywords,
                'description'=>$request->description]);
    }
    
    public static function createD(Request $request){
        return DB::table(self::$sTableName)
            ->where('id',$request->id)
            ->update([
                'describe'=>$request->describe]);
    }

    public static function setCouponsState($coachId = 0, $state = -1) {
        return DB::table(sself::$sTableName)->where('id', $coachId)->update(['if_coupons' => $state, 'update_time' => time()]);
    }
    
    public static function setWeight(Request $request){
        return DB::table(self::$sTableName)->where('id', $request->id)->update(['weight' => intval($request->weight), 'update_time' => time()]);
    }
    public static function setShow(Request $request){
        return DB::table(self::$sTableName)->where('id', $request->id)->update(['is_show' => $request->state, 'update_time' => time()]);
    }

}