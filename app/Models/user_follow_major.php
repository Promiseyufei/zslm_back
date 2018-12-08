<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class user_follow_major
{
    public static $sTableName = 'user_follow_major';



    public static function getAppointMajorRelevantUser(array $selectMajorArr = []) {

        return DB::table(self::$sTableName)->whereIn('major_id', $selectMajorArr)->where('is_focus', 0)->pluck('user_id');
    }
    
    public static function getMajorId($id){
        return DB::table(self::$sTableName)->where('user_id',$id)->where('is_focus',0)->get(['major_id']);
    }
    
    public static function getCountUserMajor($id,$status = 0){
        return DB::table(self::$sTableName)->where('user_id',$id)->where('is_focus',$status)->count('major_id');
    }
    
    public static function getUserFollowMajors($id,$page,$page_size,$fields){
    
        return DB::table(self::$sTableName)
            ->where('user_id',$id)
            ->where('is_focus',0)
            ->leftjoin('zslm_major',self::$sTableName.'.major_id','=','zslm_major.id')
            ->where('zslm_major.is_delete',0)
            ->where('is_show',0)
            ->orderBy('weight','desc')
            ->offset(($page-1)*$page_size)
            ->limit($page_size)
            ->get($fields);
            
    }
    
    /**
     * 获取用户是否关注某些院校
     */
    
    public static function getIfUsesMajor($u_id,$m_id){
        return DB::table(self::$sTableName)
            ->where('user_id',$u_id)
            ->where('is_focus',0)
             ->where('major_id',$m_id)
            ->count('id');
    }
    
    /**
     * 用户关注院校
     * @param $u_id 用户id
     * @param $m_id 院校id
     */
    public static function setUserMajor($u_id,$m_id){
        return DB::table(self::$sTableName)->insert(['user_id'=>$u_id,'major_id'=>$m_id,'create_time'=>time()]);
    }
    
    public static function unsetUserMajor($u_id,$m_id){
        return DB::table(self::$sTableName)->where('user_id',$u_id)->where('major_id',$m_id)->update(['is_focus'=>1,'update_time'=>time()]);
    }
}