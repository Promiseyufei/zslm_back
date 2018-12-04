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


    public static function getGuanlianById($id){
        return DB::table(self::$sTableName)->where('activity_id',$id)->first(['host_major_id','recommend_id','relation_activity']);
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
        $judge = DB::table(self::$sTableName)->where('activity_id',$activityId)->first();
        if(sizeof($judge) == 1){
            return DB::table(self::$sTableName)->where('activity_id', $activityId)->update([$name => $activityStr]);
        }else{
            return DB::table(self::$sTableName)->insert(['activity_id'=>$activityId,$name=>$activityStr]);
        }
    }


    public static function getDynamicActivity($activityId) {
        return DB::table(self::$sTableName)
            ->leftJoin('zslm_major', self::$sTableName . '.host_major_id', '=', 'zslm_major.id')
            ->leftJoin('zslm_activitys', self::$sTableName . '.activity_id', '=', 'zslm_activitys.id')
            ->leftJoin('dict_activity_type', 'zslm_activitys.active_type', '=', 'dict_activity_type.id')
            ->where(self::$sTableName . '.activity_id', $activityId)->where([
                ['zslm_major.is_delete', '=', 0],
                ['zslm_activitys.is_delete', '=', 0]
            ])->select(
                'zslm_activitys.id',
                'zslm_major.z_name', 
                'zslm_activitys.address', 
                'zslm_activitys.end_time', 
                'zslm_activitys.begin_time', 
                'zslm_activitys.active_name', 
                'zslm_activitys.active_img',
                'zslm_major.magor_logo_name',
                'dict_activity_type.name as active_type'
            )->get()->map(function($item) {
                $item->begin_time = date("Y-m-d H:i", $item->begin_time);
                $item->end_time = date("Y-m-d H:i", $item->end_time);
                return $item;
            });
    }

    
    
    /**
     * 获取院校主办的活动
     * @param $id 院校id
     */
    public static function getMajorActivity($id,$page,$page_size){
        $result =  DB::table(self::$sTableName)->where('host_major_id',$id)
            ->offset(($page-1)*$page_size)->limit($page_size)->get(['activity_id']);
        return $result->toArray();
    }
    
    /**
     * 获取活动的主办院校
     * @param $id
     *
     * @return mixed
     */
    public static function getOneMajorActivity($id){
        $result =  DB::table(self::$sTableName)
            ->where('activity_id',$id)
            ->limit(1)
            ->get(['host_major_id']);
        return $result;
    }





}