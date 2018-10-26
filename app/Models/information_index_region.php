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


    public static function deleteRegionInformation($regionId = 0, $informId) {
        $region_data = self::getinformIndexRegionData($regionId, ['zx_id']);
        if(is_numeric($informId)) {
            $arr = ($region_data->zx_id != null) 
            ? (strpos(trim($region_data->zx_id), ',') > 0 
            ? explode(',', trim($region_data->zx_id)) : [$region_data->zx_id]) : null;
            $arr = deleteArrValue($arr, $informId);
            $str = '';
            if(count($arr) > 0) 
                foreach($arr as $key => $value) 
                    ($key == (count($arr)-1)) ? ($str .= $value) : ($str = $value . ',');

            return DB::table(self::$sTableName)->where('id', $regionId)->update(['zx_id' => $str]);
        }
        else if(is_array($informId) && count($informId) > 0) {
            return DB::table(self::$sTableName)->where('id', $regionId)->update(['zx_id' => '']);
        }

        
        

    }


    public static function addRegionInform($regionId = 0, $informArr = []) {
        $region_data = self::getinformIndexRegionData($regionId, ['zx_id']);
        print_r($regionId);
        $arr = ($region_data->zx_id != null)
        ? (strpos(trim($region_data->zx_id), ',') > 0
        ? explode(',', trim($region_data->zx_id)) : [$region_data->zx_id]) : [];
        
        $arr2 = array_unique(array_merge($arr, $informArr));
        $str = '';
        if(count($arr2) > 0)
            foreach($arr2 as $key => $value)
                ($key == (count($arr2)-1)) ? ($str .= $value) : ($str = $value . ',');

        return DB::table(self::$sTableName)->where('id', $regionId)->update(['zx_id' => $str]);
    }



}