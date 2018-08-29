<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class zslm_information
{
    public static $sTableName = 'zslm_information';

    public static function getInformIdToData($id = 0) {
        $data = DB::table(self::$sTableName)
        ->leftJoin('dict_information_type', self::$sTableName.'.z_type', '=', 'dict_information_type.id')
        ->where('id', $id)
        ->select(
            'dict_information_type.id', 
            self::$sTableName.'.weight', 
            self::$sTableName.'.zx_name', 
            'dict_information_type.name',
            self::$sTableName.'.create_time'
        )->first();

        return empty($data) ? $data : [];
    }



    public static function setInformWeight($informId = 0, $weight = 0) {
        return DB::table(self::$sTableName)->where('id', $informId)->update([
            'weight'      => $weight,
            'update_time' => time()
        ]);
    }


    public static function getInformPageData(array $dataArr = []) {
        $handel = DB::table(self::$sTableName)->where([
            ['is_delete', '=', 0],
            ['is_show', '=', 0]
        ]);
        if(!empty($dataArr['inform_type_id']))
            $handel = $handel->where('z_type', $$dataArr['inform_type_id']);

        $handel = $handel->where('zx_name', 'like', '%'.$dataArr['title_keyword']);

        if($dataArr['sort_type'])
            $handel = $handel->orderBy('create_time', 'desc');
        else
            $handel = $handel->orderBy('create_time', 'asc');

        $handel = $handel
            ->offset($dataArr['page_count'] * $dataArr['page_number'])
            ->limit($dataArr['page_count'])
            ->select('id', 'zx_name', 'z_type', 'create_time')
            ->get()
            ->toArray();

        return $handel;
    }

}