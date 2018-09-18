<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class news_users
{
    public static $sTableName = 'news_users';

    public static function createNewsRelationUser(array $create_data = []) 
    {
        return DB::table(self::$sTableName)->insert($create_data);
    }
}