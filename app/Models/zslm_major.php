<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/8/22
     * Time: 16:59
     */
    
    namespace App\Models;
    
    
    use Illuminate\Http\Request;
    use DB;
    define('ADDRESS_SEPARATOR',',');
    
    class zslm_major
    {
        private static $sTableName = 'zslm_major';
    
        /**
         * 通过省的id获取院校专业
         * @param Request $request
         */
        public static function getMajorByP($provice,$name){
            return DB::table(self::$sTableName)
                        ->where('is_delete',0)
                        ->where('province','like',$provice)
                        ->where('z_name','like','%'.$name.'%')
                        ->get(['id','z_name']);
        }
        
        public static function getMajorIdByName($name){
            $result = DB::table(self::$sTableName)
                ->where('z_name',$name)
                ->first(['id']);
            return $result;
        }
        
        public static function getMajorName($ids){
            
            $result = DB::table(self::$sTableName)
                ->whereIn('id',$ids)
                ->get(['z_name']);
            return $result;
        }

        
        public static function getMajorId($name){
        
            return  DB::table(self::$sTableName)->where('z_name','like','%'.$name.'%')->get(['id']);
        }
        
        

        public static function getAppointMajorMsg($majorId){
            return DB::table(self::$sTableName)->where('id',$majorId)->first();
        }

        public static function getAllDictMajor($type = 0, array $majorIdArr = []) {
            if($type == 0)
                return DB::table(self::$sTableName)->where('is_delete', 0)->select('id', 'z_name', 'magor_logo_name')->get();
            else if($type == 1 && count($majorIdArr) > 0)
                return DB::table(self::$sTableName)->whereIn('id', $majorIdArr)->where('is_delete', 0)->select('id', 'z_name', 'magor_logo_name')->get();
        }

        // public static function getAppointInfoRelevant() {
        //     return DB::table()
        // }


        public static function getMajorAppiCount(array $condition = []) {

            return DB::table(self::$stableName)->where('is_delete', 0)->where($condition)->count();
        }

        public static function setAppiMajorState(array $major) {
            $handle = DB::table(self::$sTableName)->where('id', $major['major_id']);
            switch($major['type'])
            {
                case 0:
                    return $handle->update(['weight' => $major['state'], 'update_time' => time()]);
                    break;
                case 1:
                    return $handle->update(['is_show' => $major['state'], 'update_time' => time()]);
                    break;
                case 2:
                    return $handle->update(['if_recommended' => $major['state'], 'update_time' => time()]);
                    break;
            }
        }
        
        public static function delMajor($majorId) {
            return DB::table(self::$sTableName)->where('id', $majorId)->update(['is_delete' => 1, 'update_time'=> time()]);
        }

        public static function updateMajorTime($majorId, $nowTime) {

            return DB::table(self::$sTableName)->where('id', $majorId)->update(['update_time'=> $nowTime]);
        }
        
        // private static function judgeScreenState($screenState, $title, &$handle) {
        //     switch($screenState) {
        //         case 0:
        //             $handle = $handle->where($title, '=', 0);
        //             break;
        //         case 1:
        //             $handle = $handle->where($title, '=', 1);
        //             break;
        //         default :
        //             break;
        //     }
        // }

        public static function getMajorPageMsg(array $val = []) {

            $handle = DB::table(self::$sTableName)->where('is_delete', 0);
            $sort_type = [0=>['weight','desc'], 1=>['weight','asc'], 2=>['update_time','desc']];
            
            if(isset($val['majorNameKeyword'])) $handle = $handle->where('z_name', 'like', '%' . $val['majorNameKeyword'] . '%');

            switch($val['screenType'])
            {
                case 0:
                    $handle = $handle->where('is_show', 0);
                    break;
                case 1:
                    $handle = $handle->where('is_show', 1);
                    break;
                default :
                    break;
            }
            switch($val['screenState'])
            {
                case 0:
                    $handle = $handle->where('if_recommended', 0);
                    break;
                case 1: 
                    $handle = $handle->where('if_recommended', 1);
                    break;
                default:
                    break;
            }

            $handle = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1]);

            $count = $handle->count();

            $get_page_msg = $handle
                ->offset($val['pageCount'] * $val['pageNumber'])
                ->limit($val['pageCount'])
                ->select(
                    'id',
                    'z_name',
                    'weight',
                    'is_show',
                    'if_recommended',
                    'update_time'
                )
                ->get()
                ->map(function($item) {
                    $item_student_project_count = DB::table('major_recruit_project')->where('major_id', $item->id)->count();
                    $item->student_project_count = $item_student_project_count;
                    
                    return $item;
                })->toArray();

            return $count >= 0 ? ['count'=>$count, 'get_page_msg' => $get_page_msg] : [];
        }
        
        public static function getAutoRecommendMajors($recomMajorCount = 8) {
            $handle = DB::table(self::$sTableName)->where([
                ['is_delete', '=', 0],
                ['is_show', '=', 0],
                ['if_recommended', '=', 0]
            ]);
            if($handle->count() < $recomMajorCount) {
                return $handle->orderBy('weight','desc')->pluck('id');
            }
            else {
                return $handle->orderBy('weight','desc')->skip($recomMajorCount)->pluck('id');
            }
        }


        public static function getMajorByids(array $id){
            $data =  DB::table(self::$sTableName)->where('is_delete',0)->whereIn('id',$id)->get(['z_name','id','weight','update_time','province']);
            return $data;
        }
        
        public static function getImg($id){
           
            $data =  DB::table(self::$sTableName)->where('is_delete',0)->where('id',$id)->first(['magor_logo_name','z_name']);
            return $data;
        }

        public static function getAppointInfoReMajor(array $majorIdArr) {
            return DB::table(self::$sTableName)->whereIn('id', $majorIdArr)->where('is_delete', 0)->select('id', 'z_name', 'weight as show_weight', 'create_time', 'province')->get()->map(function($item) {
                $item->create_time = date("Y-m-d H:i", $item->create_time);
                return $item;
            });
        }


        public static function createOneMajor($majorMsg = [], $type = 0,$majorId = 0) {

            if($type == 0)
                return DB::table(self::$sTableName)->insertGetId(array_merge($majorMsg, [
                    'create_time' => time()
                ]));
            else if($type == 1 && $majorId != 0) {
                return DB::table(self::$sTableName)->where('id', $majorId)->update(array_merge($majorMsg, [
                    'update_time' => time()
                ]));
            }
        }

    }