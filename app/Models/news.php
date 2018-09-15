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


    


}