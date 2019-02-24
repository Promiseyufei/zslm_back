<?php

namespace App\Models;
use DB;
use App\Models\urls_bt as UrlsBt;
use Illuminate\Http\Request;

class banner_ad
{
    public static $sTableName = 'banner_ad';
    public static $sRoute = '';

    public static function getIndexBt($indexId = 1, $btType = 0) {
        $index_banners = DB::table(self::$sTableName)->where([
            ['url_id', '=', $indexId],
            ['is_delete','=',0],
            ['type', '=', $btType],
        ])->select('id', 'img', 'img_alt', 're_url', 're_alt','show_weight','create_time')
        ->get()->toArray();
        
        if(isset($index_banners) && count($index_banners) >= 0) {
            return $index_banners;
        }
        else 
            return [];
    }


    public static function setBannerAdWeight($btId = 0, $weight = 0) {
        $is_update_weight = DB::table(self::$sTableName)
        ->where('id',$btId)
        ->update(['show_weight' => $weight]);
        return isset($is_update_weight) ? true : false;
    }

    public static function getBannerAdImgName($img_id) {
        return DB::table(self::$sTableName)
        ->where('id', $img_id)
        ->value('img');
    }

    public static function setBannerAdMessage($btId = 0,$btMsgArr = []) {
        if($btId == 0 || count($btMsgArr) < 1) return false;

        $if_update = DB::table(self::$sTableName)->where('id', $btId)->update([
            'img' => $btMsgArr['bt_name'],
            'img_alt' => $btMsgArr['bt_img_alt'],
            're_url' => $btMsgArr['re_url'],
            'update_time' => time()
        ]);
        return $if_update > 0 ? true : false;
    }


    public static function delBannerBt($btId) {
        if(is_array($btId)) 
            $if_del = DB::table(self::$sTableName)->whereIn('id', $btId)->update([
                'is_delete' => 1,
                'update_time' => time()
            ]);
        else
            $if_del = DB::table(self::$sTableName)->where('id', $btId)->update([
                'is_delete' => 1,
                'update_time' => time()
            ]);
        return $if_del ? true : false;
    }

    public static function createBanAd($imgMessage = []) {
        $create_id = DB::table(self::$sTableName)->insertGetId(array_merge($imgMessage,[
            'create_time' => time()
        ]));

        return (isset($create_id) && $create_id > 0) ? true : false;
    }


    /**
     * 获得指定页面的广告
     */
    public static function getFrontConBt($url) {
        $url_id = UrlsBt::getUrlId($url);
        return DB::table(self::$sTableName)->where([
            ['url_id','=', $url_id],
            ['is_delete','=', 0],
            ['type', '=', 1]
        ])->select('id', 'img', 'img_alt', 're_url', 're_alt')->get();
    }
    
    /**
     * 通过广告位id获取指定广告位的广告
     * @param $bt_id 广告位id
     * @param $limit 获取的广告数量
     * @param $type 获取广告的类型 0表示banner图 1表示普通广告
     */
    public static function getBannerByById($bt_id,$limit,$type){
        
        return DB::table(self::$sTableName)
            ->where([['url_id',$bt_id],['is_delete',0],['type',$type]])
            ->orderBy('show_weight','desc')
            ->limit($limit)
            ->get(['img','img_alt','re_url','re_alt']);
        
    }



    /**
     * 获得指定页面的Banner
     * $pageId 前台路由id
     * $type 类型
     */ 
    public static function getPageBanner($pageId, $type = 0) {
        return DB::table(self::$sTableName)->where([
            ['url_id', $pageId],
            ['is_delete', 0],
            ['type', $type]
        ])->orderBy('create_time', 'desc')->orderBy('show_weight', 'desc')->select('id', 'img', 'img_alt', 're_url')->first();
    }

  

}