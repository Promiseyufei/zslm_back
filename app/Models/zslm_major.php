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
    
    define('ADDRESS_SEPARATOR', ',');
    
    class zslm_major
    {
        private static $sTableName = 'zslm_major';
        
        /**
         * 通过省的id获取院校专业
         *
         * @param Request $request
         */
        public static function getMajorByP($provice, $name)
        {
            return DB::table(self::$sTableName)
                ->where('is_delete', 0)
                ->where('province', 'like', $provice)
                ->where('z_name', 'like', '%' . $name . '%')
                ->get(['id', 'z_name']);
        }
        
        public static function getMajorIdByName($name)
        {
            $result = DB::table(self::$sTableName)
                ->where('z_name', $name)
                ->first(['id']);
            return $result;
        }
        
        public static function getMajorName($ids)
        {
            
            $result = DB::table(self::$sTableName)
                ->whereIn('id', $ids)
                ->get(['z_name']);
            return $result;
        }
        
        
        public static function getMajorId($name)
        {
            
            return DB::table(self::$sTableName)->where('z_name', 'like', '%' . $name . '%')->get(['id']);
        }
        
        
        public static function getAppointMajorMsg($majorId)
        {
            return DB::table(self::$sTableName)->where('id', $majorId)->first();
        }
        
        public static function getAllDictMajor($type = 0, array $majorIdArr = [])
        {
            if ($type == 0)
                return DB::table(self::$sTableName)->where('is_delete', 0)->select('id', 'z_name', 'magor_logo_name')->get();
            else if ($type == 1 && count($majorIdArr) > 0)
                return DB::table(self::$sTableName)->whereIn('id', $majorIdArr)->where('is_delete', 0)->select('id', 'z_name', 'magor_logo_name')->get();
        }
        
        // public static function getAppointInfoRelevant() {
        //     return DB::table()
        // }
        
        
        public static function getMajorAppiCount(array $condition = [])
        {
            
            return DB::table(self::$stableName)->where('is_delete', 0)->where($condition)->count();
        }
        
        public static function setAppiMajorState(array $major)
        {
            $handle = DB::table(self::$sTableName)->where('id', $major['major_id']);
            switch ($major['type']) {
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
        
        public static function delMajor($majorId)
        {
            return DB::table(self::$sTableName)->where('id', $majorId)->update(['is_delete' => 1, 'update_time' => time()]);
        }
        
        public static function updateMajorTime($majorId, $nowTime)
        {
            
            return DB::table(self::$sTableName)->where('id', $majorId)->update(['update_time' => $nowTime]);
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
        
        public static function getMajorPageMsg(array $val = [])
        {
            
            $handle = DB::table(self::$sTableName)->where('is_delete', 0);
            $sort_type = [0 => ['weight', 'desc'], 1 => ['weight', 'asc'], 2 => ['update_time', 'desc']];
            
            if (isset($val['majorNameKeyword'])) $handle = $handle->where('z_name', 'like', '%' . $val['majorNameKeyword'] . '%');
            
            switch ($val['screenType']) {
                case 0:
                    $handle = $handle->where('is_show', 0);
                    break;
                case 1:
                    $handle = $handle->where('is_show', 1);
                    break;
                default :
                    break;
            }
            switch ($val['screenState']) {
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
                ->map(function ($item) {
                    $item_student_project_count = DB::table('major_recruit_project')->where('major_id', $item->id)->count();
                    $item->student_project_count = $item_student_project_count;
                    
                    return $item;
                })->toArray();
            
            return $count >= 0 ? ['count' => $count, 'get_page_msg' => $get_page_msg] : [];
        }
        
        public static function getAutoRecommendMajors($recomMajorCount = 8)
        {
            // $handle = DB::table(self::$sTableName)->where([
            //     ['is_delete', '=', 0],
            //     ['is_show', '=', 0],
            //     ['if_recommended', '=', 0]
            // ]);
            // if ($handle->count() < $recomMajorCount) {
            //     return $handle->orderBy('weight', 'desc')->pluck('id');
            // } else {
            //     return $handle->orderBy('weight', 'desc')->skip($recomMajorCount)->pluck('id');
            // }
            return DB::table(self::$sTableName)->where([
                ['is_delete', '=', 0],
                ['is_show', '=', 0],
                ['if_recommended', '=', 0]

            ])->orderBy('weight', 'desc')->orderBy('update_time','desc')->limit($recomMajorCount)->pluck('id');
        }
        
        
        public static function getMajorByids(array $id)
        {
            $data = DB::table(self::$sTableName)->where('is_delete', 0)->whereIn('id', $id)->get(['z_name', 'id', 'weight', 'update_time', 'province']);
            return $data;
        }
        
        public static function getImg($id)
        {
            
            $data = DB::table(self::$sTableName)->where('is_delete', 0)->where('id', $id)->first(['magor_logo_name', 'z_name']);
            return $data;
        }
        
        public static function getAppointInfoReMajor(array $majorIdArr)
        {
            return DB::table(self::$sTableName)->whereIn('id', $majorIdArr)->where('is_delete', 0)->select('id', 'z_name', 'weight as show_weight', 'create_time', 'province')->get()->map(function ($item) {
                $item->create_time = date("Y-m-d H:i", $item->create_time);
                return $item;
            });
        }
        
        
        public static function createOneMajor($majorMsg = [], $type = 0, $majorId = 0)
        {
            
            if ($type == 0)
                return DB::table(self::$sTableName)->insertGetId(array_merge($majorMsg, [
                    'create_time' => time()
                ]));
            else if ($type == 1 && $majorId != 0) {
                return DB::table(self::$sTableName)->where('id', $majorId)->update(array_merge($majorMsg, [
                    'update_time' => time()
                ]));
            }
        }
        
        // font
        public static function getMajorBySelect($z_type, $z_name, $provice, $professional_direction, $page, $page_size, $felds, $order = 0)
        {
            
            $query = DB::table(self::$sTableName)->where("is_show", 0)->where('is_delete', 0);
            if ($z_type != '' && !empty($z_type)) {
                $types = strChangeArr($z_type, EXPLODE_STR);
                $query = $query->whereIn('z_type', $types);
                
            }
            
            if ($z_name != '' && !empty($z_name))
                $query = $query->where('z_name', 'like', '%' . $z_name . '%');
            
            if ($professional_direction != '' && !empty($professional_direction)) {

                $professional_directions = strChangeArr($professional_direction, EXPLODE_STR);
                $query = $query->whereIn('professional_direction', $professional_directions);
            }
            
            $desc = $order == 0 ? 'desc' : "asc";
            $query = $query->orderBy('weight', $desc)
                ->offset(($page - 1) * $page_size)
                ->limit($page_size);
            
            $result = $query->get($felds);
            
            return ($result != null && sizeof($result) > 0) ? $result : null;
        }
        
        public static function getMajorBySelectCount($z_type, $z_name, $provice)
        {
            $query = DB::table(self::$sTableName)->where("is_show", 0)->where('is_delete', 0);
            if ($z_type != 0 && !empty($z_type))
                $query = $query->where('z_type', $z_type);
            if ($z_name != '' && !empty($z_name))
                $query = $query->where('z_name', 'like', '%' . $z_name . '%');
            if ($provice != '')
                $query = $query->where('province', 'like', $provice . '%');
            $result = $query->count('id');
            return $result;
        }

        // 查询学校列表
        public static function getMajorByYearSelect($z_name,$year, $page, $page_size, $felds, $order = 0)
        {
        
            $query = DB::table(self::$sTableName)->where("is_show", 0)->where('is_delete', 0);
           
        
            if ($z_name != '' && !empty($z_name))
                $query = $query->where('z_name', 'like', '%' . $z_name . '%');
        
            if($year != '' && !empty($year)){
                $query = $query->where('access_year', 'like', '%' . $year . '%');
            }
        
            $desc = $order == 0 ? 'desc' : "asc";
            $query = $query->orderBy('weight', $desc)
                ->offset(($page - 1) * $page_size)
                ->limit($page_size);
        
            $result = $query->get($felds);
        
            return  $result;
        }
    
        public static function getMajorByYearSelectCount($year, $z_name)
        {
            $query = DB::table(self::$sTableName)->where("is_show", 0)->where('is_delete', 0);
            if ($year != 0 && !empty($year))
                $query = $query->where('access_year', $year);
            if ($z_name != '' && !empty($z_name))
                $query = $query->where('z_name', 'like', '%' . $z_name . '%');
            $result = $query->count('id');
            return $result;
        }

        //获得指定院校专业的指定信息
        public static function getMjorInfo($majorId, $fieldArr = []) {
            return DB::table(self::$sTableName)->where('id', $majorId)->where('is_delete', 0)->select(...$fieldArr)->first();
        }
        
        public static function getMajorById($id,$felds){
            $data = DB::table(self::$sTableName)->where('is_delete', 0)->where('id', $id)->limit(1)->get($felds);
            return $data;
        }
    
        public static function getVsMajorsByIds($id,$felds){
            $data = DB::table(self::$sTableName)->where('is_delete', 0)->whereIn('id', $id)->get($felds);
            return $data;
        }

        // 获取学校列表
        public static function getSchoolList($request){
            // 查询数量
            $size = !empty($request->page_size)?(int)$request->page_size:12;
            // 页码
            $page = !empty($request->page)?(int)$request->page:1;

            // 总数量
            $count = self::getGroupSelectSql('count' , '' , $request->provice ,
                $request->z_name , $request->z_type , $request->professional_direction ,
                $request->score_type , $request->enrollment_mode , $request->major_order ,
                $request->min , $request->max , $page , $size);


            $select = [
                self::$sTableName.'.id',
                self::$sTableName.'.province',
                self::$sTableName.'.magor_logo_name',
                self::$sTableName.'.z_name',
                self::$sTableName.'.update_time',
//                self::$sTableName.'.city',
                self::$sTableName.'.major_confirm',
                self::$sTableName.'.major_follow',
            ];

            // 列表
            $list = self::getGroupSelectSql('list' , $select , $request->provice ,
                $request->z_name , $request->z_type , $request->professional_direction ,
                $request->score_type , $request->enrollment_mode , $request->major_order ,
                $request->min , $request->max , $page , $size);


            foreach($list as $k=>$v){
                $list[$k]->product = self::getMajorRecruitProject($v->id , $request->score_type , $request->enrollment_mode  , $request-> money_order , $request->min , $request->max);
                $list[$k]->major_confirm = self::getMajorConfirm($v->major_confirm);
                $list[$k]->major_follow = self::getMajorConfirm($v->major_follow);
                $list[$k]->magor_logo_name = splicingImgStr('admin', 'info' , $v->magor_logo_name);

            }

            return  [
                'list'  =>  $list,
                'count' =>  $count,
            ];
        }

        // 根据条件组合查询学校专业信息
        public static function getGroupSelectSql($type , $select = '', $provice , $z_name , $z_type , $professional_direction , $score_type , $enrollment_mode , $major_order , $min , $max , $page , $size){
            $where = [
                self::$sTableName.'.is_delete'  => 0,
            ];

            $ModelObject = DB::table(self::$sTableName)->where($where);

            // 省份
            if(!empty($provice)){
                $arr = explode(',' , $provice);
                $provice = [];
                foreach($arr as $v){
                    $provice[] = DB::table('dict_region')->where('name' , $v)->value('id');
                }

                $ModelObject->whereIn(self::$sTableName.'.province' , $provice);
            }

            // 名称
            if(!empty($z_name)){
                $ModelObject->where(self::$sTableName.'.z_name', 'like', '%' . $z_name . '%');
            }

            // 专业类型
            if(!empty($z_type)){
                $ModelObject->whereIn(self::$sTableName.'.z_type' , explode(',' , $z_type));
            }

            // 专业方向
            if(!empty($professional_direction)){
                $ModelObject->whereIn(self::$sTableName.'.professional_direction', explode(',' , $professional_direction));
            }

            // 分数线
            if(!empty($score_type)){
                $ModelObject->whereIn('major_recruit_project.score_type', explode(',' , $score_type));
            }

            // 统招模式
            if(!empty($enrollment_mode)){
                $ModelObject->whereIn('major_recruit_project.recruitment_pattern', explode(',' , $enrollment_mode));
            }

            // 学习费用
            if(!empty($max) && empty($min)) {
                $ModelObject->where('max_cost', '<', $max);
            }elseif(!empty($max) && !empty($min)) {
                $ModelObject->where('major_recruit_project.min_cost', '>=',$min)->where('major_recruit_project.max_cost','<=',$max);
            }

            if($type == 'count'){
                $list =  $ModelObject->leftJoin('major_recruit_project' , 'major_recruit_project.major_id' , '=' , self::$sTableName.'.id')
                    ->select([self::$sTableName.'.id'])
                    ->groupBy(self::$sTableName.'.id')
                    ->get();

                return count($list);
            }elseif($type == 'list'){

                $list = $ModelObject->leftJoin('major_recruit_project' , 'major_recruit_project.major_id' , '=' , self::$sTableName.'.id')
                    ->select($select)
                    ->groupBy(self::$sTableName.'.id')
                    ->offset(($page - 1) * $size)
                    ->limit($size)
                    ->orderBy(self::$sTableName.'.weight' , $major_order == 0?'DESC':'ASC')
                    ->orderBy(self::$sTableName.'.id' , 'DESC')
                    ->get()->toArray();

                return $list;
            }
        }

        // 获取院校专业招生项目
        public static function getMajorRecruitProject($major_id , $score_type , $enrollment_mode , $money_order , $min , $max){
            $where = [
                'major_id'  =>  $major_id,
            ];

            $select = [
                'project_name',
                'cost',
                'language',
                'class_situation',
                'class_situation',
                'student_count',
            ];

            $ModelObject = DB::table('major_recruit_project')->where($where);

            // 分数线
            if(!empty($score_type)){
                $ModelObject->whereIn('major_recruit_project.score_type', explode(',' , $score_type));
            }

            // 统招模式
            if(!empty($enrollment_mode)){
                $ModelObject->whereIn('major_recruit_project.recruitment_pattern', explode(',' , $enrollment_mode));
            }

            // 学费
            if(!empty($max) && empty($min)) {
                $ModelObject->where('max_cost', '<', $max);
            }elseif(!empty($max) && !empty($min)) {
                $ModelObject->where('min_cost', '>=',$min)->where('max_cost','<=',$max);
            }

            $info = $ModelObject->select($select)
                ->orderBy('major_recruit_project.min_cost' , $money_order == 0?'DESC':'ASC')
                ->get()->toArray();

            return $info;
        }

        // 专业认证
        public static function getMajorConfirm($major_confirm_id){
            $name = DB::table('dict_major_confirm')->whereIn('id' , explode(',' , $major_confirm_id))->select('name')->get()->toArray();

            $major_confirm = [];
            foreach($name as $v){
                $major_confirm[] = $v->name;
            }

            return implode(',' , $major_confirm);
        }

        // 院校性质
        public static function getMajorFollow($major_follow_id){
            $name = DB::table('dict_major_follow')->whereIn('id' , explode(',' , $major_follow_id))->select('name')->get()->toArray();

            $major_follow = [];
            foreach($name as $v){
                $major_follow[] = $v->name;
            }

            return implode(',' , $major_follow);
        }
    }