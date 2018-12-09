<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class information_major
{
    public static $sTableName = 'information_major';


    public static function setAppointRelevantMajor($infoId = 0, array $majorArr = []) {

        $msg_arr = [];
        foreach($majorArr as $key => $major_id)
            array_push($msg_arr,[
                'zx_id' => $infoId,
                'xg_sc_id' => $major_id
            ]);
        
        return DB::table(self::$sTableName)->insert($msg_arr);
    }

    public static function selectAppointRelation($infoId) {

        return DB::table(self::$sTableName)->where('zx_id', $infoId)->pluck('xg_sc_id');

    }

    public static function getDynamicInfo($infoId) {
        return DB::table(self::$sTableName)
            ->leftJoin('zslm_major', self::$sTableName . '.xg_sc_id', '=', 'zslm_major.id')
            ->leftJoin('zslm_information', self::$sTableName . '.zx_id', '=', 'zslm_information.id')
            ->where(self::$sTableName . '.zx_id', $infoId)->where([
                ['zslm_major.is_delete', '=', 0],
                ['zslm_information.is_delete', '=', 0]
            ])->select(
                'zslm_major.z_name', 
                'zslm_major.magor_logo_name', 
                'zslm_information.id', 
                'zslm_information.zx_name', 
                'zslm_information.z_image',
                'zslm_information.create_time', 
                'zslm_information.brief_introduction'
            )->get()->map(function($item) {
                $item->magor_logo_name = splicingImgStr('admin', 'info', $item->magor_logo_name);
                $item->z_image = splicingImgStr('admin', 'info', $item->z_image);
                $item->create_time = date("Y-m-d", $item->create_time);
                $item->publisher = '专硕联盟';
                return $item;
            });

            // dd()
    }
    
    /**
     * 获取院校的推荐咨询
     * @param $id 院校专业id
     * @param $page 页码
     * @param $page_size 页面大小
     * @param $fields 获取的字段数组
     */
    public static function getMajorInformation($id,$page,$page_size,$fields){
        return DB::table(self::$sTableName)
            ->where('xg_sc_id',$id)
            ->offset(($page-1)*$page_size)
            ->limit($page_size)
            
            ->get($fields);
    }

}