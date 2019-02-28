<?php
    
    namespace App\Models;
    
    use DB;
    use Illuminate\Http\Request;
    use phpDocumentor\Reflection\Types\Self_;
    
    class coach_organize
    {
        public static $sTableName = 'coach_organize';
        
        
        private static function judgeScreenState($screenState, $title, &$handle)
        {
            switch ($screenState) {
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
        
        public static function getFatherCoach()
        {
            return DB::table(self::$sTableName)->where('is_delete', 0)->where('father_id', 0)->get(['id', 'coach_name']);
        }
        
        public static function getCoachNameById($id)
        {
            return DB::table(self::$sTableName)->where('is_delete', 0)->where('id', $id)->first(['coach_name']);
        }
        

        //获取后台辅导机构列表信息
        public static function getCoachPageMsg(array $val = [])
        {
            
            $handle = DB::table(self::$sTableName)->where('is_delete', 0);
            $sort_type = [0 => ['weight', 'asc'], 1 => ['weight', 'desc'], 2 => ['update_time', 'desc']];
            if (isset($val['soachNameKeyword'])) $handle = $handle->where('coach_name', 'like', '%' . $val['soachNameKeyword'] . '%');
            if ($val['showType'] != 2)
                self::judgeScreenState($val['showType'], 'is_show', $handle);
            if ($val['recommendType'] != 2)
                self::judgeScreenState($val['recommendType'], 'is_recommend', $handle);
            if ($val['couponsType'] != 2)
                self::judgeScreenState($val['couponsType'], 'if_coupons', $handle);
            if ($val['moneyType'] != 2)
                self::judgeScreenState($val['moneyType'], 'if_back_money', $handle);

            $count = $handle->count();
            
            $get_page_msg = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])
                ->offset($val['pageCount'] * ($val['pageNumber'] - 1))
                ->limit($val['pageCount'])->get();
            return count($get_page_msg) >= 0 ? [$get_page_msg, $count] : false;
        }
        
        public static function getCoachAppiCount(array $condition = [])
        {
            return DB::table(self::$stableName)->where($condition)->count();
        }
        
        
        public static function setAppiCoachState(array $coach = [])
        {
            
            $handle = DB::table(self::$sTableName)->where('id', $coach['coach_id']);
            switch ($activity['type']) {
                case 0:
                    return $handle->update(['weight' => $coach['state'], 'update_time' => time()]);
                    break;
                case 1:
                    return $handle->update(['is_show' => $coach['state'], 'update_time' => time()]);
                    break;
                case 2:
                    return $handle->update(['is_recommend' => $coach['state'], 'update_time' => time()]);
                    break;
            }
        }
        
        public static function getAppointCoachMsg($coachId = 0, $msgName = '')
        {
            if (empty($msgName))
                return DB::table(self::$sTableName)->where('id', $coachId)->first();
            else
                return DB::table(self::$sTableName)->where('id', $coachId)->select($msgName)->first();
        }
        
        
        public static function delAppointCoach(array $coachId)
        {
            return DB::table(self::$sTableName)->whereIn('id', $coachId)->update(['is_delete' => 1, 'update_time' => time()]);
        }
        
        public static function getBranchCoachMsg($totleId = 0, $pageNum = 0, $pageCount = 10)
        {
            return DB::table(self::$sTableName)->where('father_id', $totleId)
                ->offset($pageNum * $pageCount)->limit($pageCount)
                ->select('id', 'weight', 'is_show', 'is_recommend', 'coach_name', 'province', 'phone', 'address', 'web_url', 'coach_type', 'if_coupons', 'if_back_money', 'update_time')
                ->get();
        }
        
        
        public static function createCoach(array $createCoachMsg = [])
        {
            
            return DB::table(self::$sTableName)->insertGetId($createCoachMsg);
        }
        
        
        public static function updateCoach($id, array $createCoachMsg = [])
        {
            
            return DB::table(self::$sTableName)->where('id', $id)->update($createCoachMsg);
        }
        
        
        public static function createKTD(Request $request)
        {
            return DB::table(self::$sTableName)
                ->where('id', $request->id)
                ->update([
                    'title' => $request->title,
                    'keywords' => $request->keywords,
                    'description' => $request->description]);
        }
        
        public static function createD(Request $request)
        {
            return DB::table(self::$sTableName)
                ->where('id', $request->id)
                ->update([
                    'describe' => $request->describe]);
        }
        
        public static function setCouponsRec($coachId = 0, $state = -1)
        {
            return DB::table(self::$sTableName)->where('id', $coachId)->update(['is_recommend' => $state, 'update_time' => time()]);
        }
        
        public static function setCouponsState($coachId = 0, $state = -1)
        {
            return DB::table(self::$sTableName)->where('id', $coachId)->update(['if_coupons' => $state, 'update_time' => time()]);
        }
        
        public static function setback($coachId = 0, $state = -1)
        {
            return DB::table(self::$sTableName)->where('id', $coachId)->update(['if_back_money' => $state, 'update_time' => time()]);
        }
        
        
        public static function setWeight(Request $request)
        {
            
            return DB::table(self::$sTableName)->where('id', $request->id)->update(['weight' => intval($request->weight), 'update_time' => time()]);
            
        }
        
        public static function setShow(Request $request)
        {
            return DB::table(self::$sTableName)->where('id', $request->id)->update(['is_show' => $request->state, 'update_time' => time()]);
        }
        
        public static function getOne($id)
        {
            return DB::table(self::$sTableName)->where('id', $id)->first();
        }
        
        
        //front
        
        private static function getSqlQuery($provice, $type, $name, $if_back, $if_coupon)
        {
            $query = DB::table(self::$sTableName)->where('is_show', 0)->where('is_delete', 0)->where('father_id', 0);
            if ($provice != '')
                $query = $query->where('province', 'like', $provice . '%');
            if ($type != '' && !empty($type) && $type != '2'){
                $types = strChangeArr($type, EXPLODE_STR);
                $query = $query->whereIn("coach_type", $types);
            }
            if ($name != '' && !empty($name))
                $query = $query->where('coach_name', 'like', '%' . $name . '%');
            if ($if_back != 2 && !empty($if_back))
                $query = $query->where("if_back_money", $if_back);
            if ($if_coupon != 2 && !empty($if_coupon))
                $query = $query->where("if_coupons", $if_coupon);
            return $query;
        }
        
        public static function getSelectCoach($provice, $type, $name, $page, $page_size, $if_back, $if_coupon, $fields)
        {
            
            $query = self::getSqlQuery($provice, $type, $name, $if_back, $if_coupon);
            $result = $query->offset(($page - 1) * $page_size)->limit($page_size)->get($fields)->map(function($item) {
                $item->logo_name = splicingImgStr('admin', 'info', $item->logo_name);
                $item->cover_name = splicingImgStr('admin', 'info', $item->cover_name);
                return $item;
            });
            return $result;
            
        }
        
        public static function getSonCoach($f_id,$fields)
        {
            $result = DB::table(self::$sTableName)->where('is_show', 0)->where('is_delete', 0)
                ->where('father_id', $f_id)->get($fields);
            return $result;
        }
        
        public static function getSelectCoachCount($provice, $type, $name, $if_back, $if_coupon)
        {
            $query = self::getSqlQuery($provice, $type, $name, $if_back, $if_coupon);
            $count = $query->count('id');
            return $count;
        }
    
        public static function getCoachById($id,$fields)
        {
            $result = DB::table(self::$sTableName)->where('is_show', 0)->where('is_delete', 0)
                ->where('id',$id)
                ->where('father_id', 0)
                ->limit(1)
                ->get($fields);
            return $result;
        }

        /**
         * 查询指定建值的辅导机构信息
         * @param $id
         * @param $fields
         * @return mixed
         */
        public static function getAllCoachByIds($id,$fields)
        {
            $result = DB::table(self::$sTableName)
                ->where('is_delete', 0)
                ->whereIn('id',$id)
                ->get($fields);
            return $result;
        }
    
        public static function getAllCoupon(){
            return DB::table(self::$sTableName)->where('is_delete',0)->where('is_show',0)->where('father_id',0)->get(['id','coach_name','logo_name','cover_name']);
        
        }


        public static function updateCoachTime($coachId, $nowTime) {
            return DB::table(self::$sTableName)->where('id', $coachId)->update(['update_time' => $nowTime]);
        }

        public static function getCoachLogoOrCoverName($id, string $name) {
            return DB::table(self::$sTableName)->where('id', $id)->value($name);
        }




        
    }