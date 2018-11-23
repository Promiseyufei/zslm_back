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
            ->join('zslm_major',self::$sTableName.'.major_id','=','zslm_major.id')
            ->where('zslm_major.is_delete',0)
            ->where('is_show',0)
            ->orderBy('weight','desc')
            ->offset(($page-1)*$page_size)
            ->limit($page_size)
            ->get($fields);
            
    }
}