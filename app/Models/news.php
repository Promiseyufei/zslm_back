<?php

namespace App\Models;
use DB;
use App\Models\user_accounts as UserAccounts;
use Illuminate\Http\Request;

class news
{
    public static $sTableName = 'news';




    public static function createNews(array $newsMsg = []) {

        $create_id = DB::table(self::$sTableName)->insertGetId($newsMsg);
        return $create_id ? $create_id : 0;
    }

    public static function updateStatus($newsId) {
        return DB::table(self::$sTableName)->where('id', $newsId)->update(['success' => 1, 'update_time' => time()]);
    }

    public static function selectAllNewsMsg($keywords, $startTime, $endTime, $pageCount, $pageNum) {

        $handle = DB::table(self::$sTableName)->where('is_delete', 0);
           
        if($startTime != 0 && $endTime == 0) {
            $handle = $handle->where('create_time', '>=', $startTime);
        }
        else if($startTime == 0 && $endTime != 0) 
            $handle = $handle->where('create_time', '<=', $endTime);
        else if($startTime != 0 && $endTime != 0) 
            $handle = $handle->whereBetween('create_time', [$startTime, $endTime]);
        
        $handle = $handle->where('context', 'like', '%' . $keywords . '%');

        $total = $handle->count();

        $his_news = $handle->orderBy('create_time', 'desc')
        ->offset($pageCount * ($pageNum - 1))
        ->limit($pageCount)
        ->select('id', 'carrier', 'news_title', 'create_time', 'success', 'type')
        ->get()->map(function($item) {
            $item->create_time = date('Y-m-d H:i:s', $item->create_time);
            return $item; 
        });
        return ['total' => $total, 'his_news' => $his_news];
    }


    public static function getAppointNewsMsg($newsId) {
        $news = DB::table(self::$sTableName)
        ->where('id', $newsId)
        ->select('news_title', 'context', 'url', 'carrier', 'type', 'create_time', 'success')
        ->first();

        $news->create_time = date('Y-m-d H:i:s', $news->create_time);

        return $news;

    }

    public static function getAppointNewsToUsers($count, $num, $newsId) {
        // var_dump(DB::table('news_users')->where('news_id', $newsId)->pluck('user_id')->toArray());
        return UserAccounts::getAllAccounts($count, $num, DB::table('news_users')->where('news_id', $newsId)->pluck('user_id')->toArray());

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