<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class information_index_region
{
    public static $sTableName = 'information_index_region';

    public static function getinformIndexRegionData($regionId = 0, array $arr) {
        $region_data = DB::table(self::$sTableName)->where('id', $regionId)->select(...$arr)->first();
        return !empty($region_data) ? $region_data : false;

    }


    public static function setRegionName($regionId = 0, $regionName = '') {
        return DB::table(self::$sTableName)->where('id', $regionId)->update([
            'region_name' => $regionName
        ]);
    }


    public static function deleteRegionInformation($regionId = 0, $informId = 0) {
        $region_data = self::getinformIndexRegionData(['zx_id']);
        $arr = explode($region_data->zx_id);
        $arr = deleteArrValue($arr, $informId);
        $str = '';
        if(count($arr) > 0) 
            foreach($arr as $key => $value) 
                ($key == (count($arr)-1)) ? ($str .= $value) : ($str = $value . ',');
        
        return DB::table(self::$sTableName)->where('id', $regionId)->update(['zx_id' => $str]);

    }



}