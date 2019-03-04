<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class urls_bt
{
    public static $sTableName = 'urls_bt';

    public static function getIndexUrlName($type = 0) {
        if($type == 0)
            $index_name = DB::table(self::$sTableName)
            ->where('page_type', 1)
            ->select('id','name','url')
            ->get();
        else 
            $index_name = DB::table(self::$sTableName)
            ->select('id', 'name', 'url')
            ->get();


        if(count($index_name) > 0) return $index_name;
        else return false;
    }

    public static function getUrlId($url) {
        return DB::table(self::$sTableName)->where('url', 'like', '%' . $url . '%')->value('id');
    }
    
    /**
     * 通过广告位名称获取广告位的id
     * @param $b_name 广告位名称
     *
     * @return mixed 广告位对象，包含广告位的id
     */
    public static function getBannerByPath($b_name){
        return DB::table(self::$sTableName)->where('url',$b_name)->orWhere('name',$b_name)->first(['id']);
    }

}