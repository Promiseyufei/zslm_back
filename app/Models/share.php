<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;



// 分享表
// id（int）
// 关联id(int)
// type(tinyint) 0咨询　1活动　2专业主页
// wx_count 通过微信分享次数(int)
// wb_count 通过微博分享次数(int)
// wx_browse 微信浏览量(int)
// wb_browse 微博浏览量(int)


// 排序类型
/**
 * 按总浏览量０
 * 按总引流（分享次数）１
 * 按微信分享次数２
 * 按微博分享次数３
 * 按微信浏览量４
 * 按微信浏览量５
 * 
 * 升序０
 * 降序１
 */


class share 
{

    public static $sTableName = 'share';

    //获得指定页面的分享记录
    public static function getAppointToAllShareMsg(array $dataArr) {
        if($dataArr['content_type'] < 3) {
            $join_name = '';
            $join_title = '';
            switch($dataArr['content_type'])
            {
                case 0 :
                    $handel = DB::table(self::$sTableName)
                        ->leftJoin('zslm_major', self::$sTableName.'.relation_id', '=', 'zslm_major.id')
                        ->where([
                            [self::$sTableName.'.relation_type', '=', 2],
                            ['zslm_major.z_name', 'like', '%'.$dataArr['title_keyword'].'%']
                        ]);
                    $join_name = 'zslm_major';
                    $join_title = 'z_name';
                    break;
                case 1 :
                    $handel = DB::table(self::$sTableName)
                        ->leftJoin('zslm_activitys', self::$sTableName.'.relation_id', '=', 'zslm_activitys.id')
                        ->where([
                            [self::$sTableName.'.relation_type', '=', 1],
                            ['zslm_activitys.active_name', 'like', '%'.$dataArr['title_keyword'].'%']
                        ]);
                    $join_name = 'zslm_activitys';
                    $join_title = 'active_name';
                    break;
                case 2 :
                    $handel = DB::table(self::$sTableName)
                        ->leftJoin('zslm_information', self::$sTableName.'.relation_id', '=', 'zslm_information.id')
                        ->where([
                            [self::$sTableName.'.relation_type', '=', 0],
                            ['zslm_information.name', 'like', '%'.$dataArr['title_keyword'].'%']
                        ]);
                    $join_name = 'zslm_information';
                    $join_title = 'name';
                    break;
            }

            $select_data = self::selectSort($dataArr, $handel)
            ->offset($dataArr['page_num'] * $dataArr['page_count'])
            ->limit($dataArr['page_count'])
            ->select(
                $join_name.'.'.$join_title, 
                self::$sTableName . '.id',
                self::$sTableName . '.wx_count',
                self::$sTableName . '.wb_count',
                self::$sTableName . '.wx_browse',
                self::$sTableName . '.wb_browse',
                self::$sTableName . '.total_count',
                self::$sTableName . '.total_browse'
            )->get();
        }
        else {
            var_dump(self::selectSort($dataArr, DB::table(self::$sTableName)));
            $select_data = self::selectSort($dataArr, DB::table(self::$sTableName))
            ->offset($dataArr['page_num'] * $dataArr['page_count'])
            ->limit($dataArr['page_count'])
            ->select('id', 'wx_count', 'wb_count', 'wx_browse', 'wb_browse', 'total_count', 'total_browse')
            ->get()->toArray()->map(function($item, $key) {
                switch($item->relation_type) 
                {
                    case 0 :
                        $item->name = $DB::table('zslm_information')->where('id', $item->relation_id)->value('name');
                        break;
                    case 1 :
                        $item->name = DB::table('zslm_activitys')->where('id', $item->relation_id)->value('active_name');
                        break;
                    case 2 :
                        $item->name = DB::table('zslm_major')->where('id', $item->relation_id)->value('z_name');
                        break;
                }
                return $item;
            });
        }

        return count($select_data) > 0 ? $select_data : [];
    }




    private static function selectSort($dataArr, $handel) {
        // var_dump($handel);

        switch($dataArr['sort_type'])
        {
            case 0:
                $handel = $dataArr['rise_or_drop'] ? $handel->orderBy('total_browse','desc') : $handel->orderBy('total_browse','asc');
                break;
            case 1:
                $handel = $dataArr['rise_or_drop'] ? $handel->orderBy('total_count','desc') : $handel->orderBy('total_count','asc');
                break;
            case 2:
                $handel = $dataArr['rise_or_drop'] ? $handel->orderBy('wx_count','desc') : $handel->orderBy('wx_count','asc');
                break;
            case 3:
                $handel = $dataArr['rise_or_drop'] ? $handel->orderBy('wb_count','desc') : $handel->orderBy('wb_count','asc');
                break;
            case 4:
                $handel = $dataArr['rise_or_drop'] ? $handel->orderBy('wx_browse','desc') : $handel->orderBy('wx_browse','asc');
                break;
            case 5:
                $handel = $dataArr['rise_or_drop'] ? $handel->orderBy('wb_browse','desc') : $handel->orderBy('wb_browse','asc');
                break;
        }
        

        return $handel;

    }



    /**
     * 3总量
     * 0院校专业主页
     * 1活动详情
     * 2资讯详情
     */
    public static function getPageCount($type = 3) {
        if($type >2)
            $count = DB::table(self::$sTableName)->count();
        else 
            $count = DB::table(self::$sTableName)->where('relation_type',$type)->count();

        return ($count > 0) ? $count : 0;
    }
}

