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


    private static function judgeScreenState($screenState, $title, &$handle) {
        switch($screenState) {
            case 0:
                $handle = $handle->where($title, '=', 0);
                break;
            case 1:
                $handle = ($title == 'father_id') ? $handle->where($title, '<>', 0) : $handle->where($title, '=', 1);
                break;
            default :
                break;
        }
    }

    private static function judgeInfoType($infoType, $title, &$handle) {
        switch($infoType) 
        {
            case 0:
                break;
            default :
                $handle->where($title, $infoType);
                break;
        }
    }

    public static function getInformationPageMsg(array $selectMsg = []) {

        $handle = DB::table(self::$sTableName)->where('is_delete', 0);

        $sort_type_arr = [['weight', 'desc'], ['weight', 'asc'], ['update_time', 'desc']];

        switch($selectMsg['screenType'])
        {
            case 0:
                self::judgeScreenState($selectMsg['screenState'], 'is_show', $handle);
                break;
            case 1:
                self::judgeScreenState($selectMsg['screenState'], 'is_recommend', $handle);
                break;
            case 2:
                self::judgeInfoType()($selectMsg['infoType'], 'z_type', $handle);
                break;
            default :
                break;
        }

        $handle = ($selectMsg['infoNameKeyword'] ?? '') ? $handle->where('zx_name', 'like', '%' . $selectMsg['infoNameKeyword'] . '%') : $handle;

        return $handel->orderBy(...$sort_type_arr[$selectMsg['sortType']])
        ->offset($selectMsg['pageCount'] * $selectMsg['pageNumber'])->limit($selectMsg['pageCount'])
        ->slect('id', 'zx_name', 'weight', 'is_show', 'is_recommend', 'z_type', 'z_from', 'update_time')->get();
        
    }


    public static function getInfoAppiCount(array $conditionArr = []) {

        return DB::table(self::$sTableName)->where($conditionArr)->count();
    }

    public static function setAppiInfoState(array $updateMsg = []) {
        $handle = DB::table(self::$sTableName)->where('id', $activity['info_id']);
        switch($activity['type'])
        {
            case 0:
                return $handle->update(['weight' => $activity['state'], 'update_time' => time()]);
                break;
            case 1:
                return $handle->update(['is_show' => $activity['state'], 'update_time' => time()]);
                break;
            case 2:
                return $handle->update(['is_recommend' => $activity['state'], 'update_time' => time()]);
                break;
        }
    }


    public static function getAppointInfoMsg($infoId = 0, $msgName = '') {
        if(empty($msgName))
            return DB::table(self::$sTableName)->where('id', $infoId)->first();
        else
            return DB::table(self::$sTableName)->where('id', $infoId)->select($msgName)->first();
    }

    public static function delAppointInfo($infoId = 0) {
        return DB::table(self::$sTableName)->where('id', $infoId)->update(['is_delete' => 1, 'update_time' => time()]);
    }

}