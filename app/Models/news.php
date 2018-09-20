<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class news
{
    public static $sTableName = 'news';




    public static function createNews(array $newsMsg = []) {

        $create_id = DB::table(self::$sTableName)->insertGetId($newsMsg);
        return $create_id ? $create_id : 0;
    }

    public static function updateStatus($newsId) {
        return DB::table(self::$sTableName)->update(['success' => 1, 'update_time' => time()]);
    }

    public static function selectAllNewsMsg($keywords, $startTime, $endTime, $pageCount, $pageNum) {

        return DB::table(self::$sTableName)
        ->where('is_delete', 0)
        ->where('news_title', 'like', '%' . $keywords . '%')
        ->whereBetween('create_time', [$startTime, $endTime])
        ->orderBy('create_time', 'desc')
        ->offset($pageCount * $pageNum)
        ->limit($pageCount)
        ->select('id', 'carrier', 'news_title', 'create_time', 'success', 'type')
        ->get()->toAyyay()->map(function($item) {
            $item->create_time = date('Y-m-d H:i:s', $item->create_time);
            return $item; 
        });
    }


    public static function getAppointNewsMsg($newsId) {
        $news = DB::table(self::$sTableName)
        ->where('id', $newsId)
        ->select('news_title', 'context', 'url', 'carrier', 'type', 'create_time', 'success')
        ->first();

        $news->create_time = date('Y-m-d H:i:s', $item->create_time);

        return $news;

    }



    //获得所有失败的消息
    public static function getAllFailNews() {
        return DB::table(self::$sTableName)
        ->leftJoin('news_users', self::$sTableName . '.id', '=', 'news_users.news_id')
        ->where([
            [self::$sTableName .'.is_delete', '=', 0],
            ['success', '=', 0]
        ])
        ->select(self::$sTableName.'.id', self::$sTableName . '.type')
        ->get()->groupBy(self::$sTableName.'.id');
    }


    


}