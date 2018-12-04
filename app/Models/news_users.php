<?php

namespace App\Models;
use DB;
use App\Models\user_accounts as UserAccounts;
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

    public static function getUserNews($userId, $pageCount = 6, $pageNumber = 0, $newsType = 1) {
        return DB::table(self::$sTableName)
            ->leftJoin('news', self::$sTableName . '.news_id', '=', 'news.id')
            ->where(self::$sTableName . '.user_id', $userId)->where([
                ['news.success', '=', 1],
                ['news.is_delete', '=', 0],
                ['news.type', '=', $newsType]
            ])->offset($pageCount * $pageNumber)->limit($pageCount)->select(
                self::$sTableName . '.create_time',
                self::$sTableName . '.status',
                'news.news_title',
                'news.context',
                'news.url'
            )->get()->map(function($item) {
                $item->create_time = date("Y-m-d", $item->create_time);
                return $item;
            });
    }


    public static function changeNewsState($newsId, $userPhone, $status = 1) {
        $user_id = UserAccounts::getAppointUser($userPhone)->id;
        return DB::table(self::$sTableName)->where([
            ['news_id', $newsId],
            ['user_id', $user_id]
        ])->update([
            'status' => $status
        ]);
    }
}