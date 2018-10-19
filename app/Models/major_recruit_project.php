<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class major_recruit_project
{
    public static $sTableName = 'major_recruit_project';



    public static function getAppointProject($majorId, $pageNum = 0, $pageCount = 10) {

        $select_handle = DB::table(self::$sTableName)->leftJoin('zslm_major', self::$sTableName . '.major_id', '=', 'zslm_major.id')->where([
            [self::$sTableName . '.major_id', '=', $majorId],
            [self::$sTableName . '.is_delete', '=', 0]
        ]);
        $sel_count = $select_handle->count();
        $select_page = $select_handle->offset(($pageNum-1) * $pageCount)->limit($pageCount)
        ->select(self::$sTableName . '.id', self::$sTableName . '.weight', self::$sTableName . '.project_name', self::$sTableName . '.is_show', self::$sTableName . '.if_recommend', self::$sTableName . '.update_time', 'zslm_major.z_name')
        ->get()->map(function($item) {
            $item->update_time = date("Y-m-d H:i",$item->update_time);
            return $item;
        })->toArray();
        return ['total' => $sel_count, 'data' => $select_page];
    }


    public static function updateAppointProjectMsg($projectId = 0, array $projectMsg = []) {

        return DB::table(self::$sTableName)->where('id', $projectId)->update($projectMsg);
    }

    public static function delAppProject($projectId) {
        if(is_array($projectId))
            return DB::table(self::$sTableName)->whereIn('id', $projectId)->update([
                'is_delete' => 1,
                'update_time' => time()
            ]);
        else
            return DB::table(self::$sTableName)->where('id', $projectId)->update([
                'is_delete' => 1,
                'update_time' => time()
            ]);
                
    }


    public static function setAppiProjectState(array $project = []) {
        $handle = DB::table(self::$sTableName)->where('id', $project['pro_id']);
        switch($project['type'])
        {
            case 0:
                return $handle->update(['weight' => $project['state']]);
                break;
            case 1:
                return $handle->update(['is_show' => intval($project['state'])]);
                break;
            case 2:
                return $handle->update(['if_recommended' => $project['state']]);
                break;
        }
    }

    public static function createAppointProjectMsg(array $projectMsg = []) {
        
        return DB::table(self::$sTableName)->insertGetId($projectMsg);
    }


    public static function getAppointIdProMsg($proId) {
        return DB::table(self::$sTableName)->where('id', $proId)->first();
    }



}