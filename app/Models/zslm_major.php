<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/8/22
     * Time: 16:59
     */
    
    namespace App\Models;
    
    
    use Illuminate\Http\Request;

    class zslm_major
    {
        private static $sTableName = 'zslm_major';
        
        public static function getAppointMajorMsg($majorId){
            return DB::table(self::$sTableName)->where('id',$majorId)->get();
        }

        public static function getAllDictMajor() {
            return DB::table(self::$sTableName)->where('is_delete', 0)->select('id', 'z_name', 'magor_logo_name');
        }


        public static function getMajorAppiCount(array $condition = []) {

            return DB::table(self::$stableName)->where('is_delete', 0)->where($condition)->count();
        }

        public static function setAppiMajorState(array $major) {
            $handle = DB::table(self::$sTableName)->where('id', $major['major_id']);
            switch($major['type'])
            {
                case 0:
                    return $handle->update(['weight' => $major['state']]);
                    break;
                case 1:
                    return $handle->update(['is_show' => $major['state']]);
                    break;
                case 2:
                    return $handle->update(['if_recommended' => $major['state']]);
                    break;
            }
        }


        public static function delMajor($majorId) {
            return DB::table(self::$sTableName)->where('id', $majorId)->update(['is_delete' => 1, 'update_time'=> time()]);
        }

        public static function updateMajorTime($majorId) {
            return DB::table(self::$sTableName)->where('id', $majorId)->update(['update_time'=> time()]);
        }



        private static function judgeScreenState($screenState, $title, &$handle) {
            switch($screenState) {
                case 0:
                    $handle = $handle->where($title, '=', 0);
                    break;
                case 1:
                    $handle = $handle->where($title, '=', 1);
                    break;
                default :
                    break;
            }
        }

        public static function getMajorPageMsg(array $val = []) {

            $handle = DB::table(self::$sTableName)->where('is_delete', 0);
            $sort_type = [0=>['weight','desc'], 1=>['weight','asc'], 2=>['update_time','desc']];
            if(isset($val['majorNameKeyword'])) $handle = $handle->where('z_name', 'like', '%' . $val['majorNameKeyword'] . '%');

            switch($val['screenType'])
            {
                case 0:
                    self::judgeScreenState($val['screenState'], 'is_show', $handle);
                    break;
                case 1:
                    self::judgeScreenState($val['screenState'], 'if_recommended', $handle);
                    break;
                default :
                    break;
            }

            $get_page_msg = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])
            ->offset($val['pageCount'] * $val['pageNumber'])
            ->limit($val['pageCount'])->get();

            return count($get_page_msg >= 0) ? $get_page_msg : false;
        }



        public static function getAutoRecommendMajors($recomMajorCount = 8) {
            return DB::table(self::$sTableName)->where([
                ['is_delete', '=', 0],
                ['is_show', '=', 0],
                ['if_recommended', '=', 0]
            ])->orderBy('weight','desc')->skip($recomMajorCount)->pluck('id');
        }









    }