<?php

namespace App\Models;
use DB;
use App\Models\activity_relation as ActivityRelation;
use App\Models\information_major as InformationMajor;

class dynamic_news
{
    public static $sTableName = 'dynamic_news';


    //获取用户的院校动态消息
    public static function getMajorDynamic($userId, $pageCount = 6, $pageNumber = 0) {
        $get_dynamic = DB::table(self::$sTableName)->where('user_id', $userId)->where('status', 0)
            ->orderBy('create_time', 'desc')->offset($pageCount * $pageNumber)->limit($pageCount)
            ->select('content_id', 'content_type', 'create_time as dynamic_create_time')->get()->map(function($item) {
                $item->dynamic_create_time = date("Y-m-d H:i", $item->dynamic_create_time);
                return $item;
            })->toArray();
        foreach($get_dynamic as $key => &$dynamic) {
                $dynamic->content_type == '1' 
                    ? $dynamic->content_id = InformationMajor::getDynamicInfo($dynamic->content_id)->toArray() 
                    : $dynamic->content_id = ActivityRelation::getDynamicActivity($dynamic->content_id)->toArray();
        }
        return $get_dynamic;

    }
}