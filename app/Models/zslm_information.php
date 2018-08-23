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

}