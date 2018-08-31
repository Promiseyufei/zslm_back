<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class major_recruit_project
{
    public static $sTableName = 'major_recruit_project';



    public static function getAppointProject($majorId, $pageNum = 0, $pageCount = 10) {

        return DB::table(self::$sTableName)->where([
            ['major_id', '=', $majorId],
            ['is_delete', '=', 0]
        ])->offset($pageNum * $pageCount)->limit($pageCount)
        ->select('id', 'weight', 'project_name', 'is_show', 'if_recommend', 'update_time')
        ->get()->toArray()->map(function($item) {
            $item->update_time = date("Y-m-d H:i",$item->update_time);
            return $item;
        });
    }


    public static function updateAppointProjectMsg($projectId = 0, array $projectMsg = []) {

        return DB::table(self::$sTableName)->where('id', $projectId)->update($projectMsg);
    }

    public static function delAppProject($projectId = 0) {
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
                return $handle->update(['is_show' => $project['state']]);
                break;
            case 2:
                return $handle->update(['if_recommended' => $project['state']]);
                break;
        }
    }

    public static function createAppointProjectMsg(array $projectMsg = []) {
        
        return DB::table(self::$sTableName)->insertGetId($projectMsg);
    }



}