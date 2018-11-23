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
    
    public static function getCountUserNews($id,$status){
        return DB::table(self::$sTableName)->where('user_id',$id)->where('status',$status)->count('id');
    }
}