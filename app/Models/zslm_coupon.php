<?php
    
    namespace App\Models;
    
    use DB;
    use Illuminate\Http\Request;
    
    class zslm_coupon
    {
        public static $sTableName = 'zslm_coupon';
        
        public static function getCouponPageMsg(array $msg = [])
        {
            $handle = DB::table('coach_organize')->leftJoin(self::$sTableName, 'coach_organize.id', '=', self::$sTableName . '.coach_id')->where('coach_organize.is_delete', 0);
            if (isset($val['soachNameKeyword'])) $handle = $handle->where('coach_organize.coach_name', 'like', '%' . $val['soachNameKeyword'] . '%');
            
            switch ($val['screenType']) {
                case 0:
                    self::judgeScreenState($val['screenState'], 'coach_organize.if_coupons', $handle);
                    break;
                case 1:
                    self::judgeScreenState($val['screenState'], 'coach_organize.father_id', $handle);
                    break;
                default :
                    break;
            }
            
            // $select_msg = $handle->offset($val['pageCount'] * $val['pageNumber'])->limit($val['pageCount'])
            // ->select('coach_organize.id', 'coach_organize.coach_name', 'coach_organize.father_id', 'coach_organize.f_coupons', 'DB::raw(count() as coupon_count'))
            // ->get()->groupBy();
            
            return count($get_page_msg) >= 0 ? $get_page_msg : false;
        }
        
        public static function getCouponByCoachId(Request $request)
        {
            $handle = DB::table('coach_organize')
                ->join(self::$sTableName, 'coach_organize.id', '=', self::$sTableName . '.coach_id')
                ->where(self::$sTableName . '.coach_id', $request->id)
                ->where('coach_organize.is_delete', 0)
                ->get([self::$sTableName . '.id', 'coach_name', 'name', 'is_show', 'coach_organize.weight']);
            return $handle;
        }
        
        
        private static function judgeScreenState($screenState, $title, &$handle)
        {
            switch ($screenState) {
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
        
        
        public static function getcoachAppiCount(array $condition = [])
        {
            return DB::table('coach_organize')->where($condition)->count();
        }
        
        public static function getCoachAppointCoupon($coachId = 0, $pageCount, $pageNumber)
        {
            return DB::table(self::$sTableName)
                ->where('coach_id', $coachId)
                ->select('id', 'name', 'type', 'context', 'zslm_couponcol', 'is_enable')
                ->offset($pageCount * $pageNumber)->limit($pageCount)->get();
        }
        
        
        public static function setAppointCoipon($couponId = 0, $state)
        {
            return DB::table(self::$sTableName)->where('id', $couponId)->update(['is_enable' => $state, 'update_time' => time()]);
        }
        
        public static function createCoupon(array $createMsg = [])
        {
            return DB::table(self::$sTableName)->insertGetId([
                'coach_id' => $createMsg['coachId'],
                'name' => $createMsg['couponName'],
                'type' => $createMsg['couponType'],
                'context' => $createMsg['context'],
                'zslm_couponcol' => $createMsg['couponcol'],
                'create_time' => time()
            ]);
        }
        
        
        public static function updateCoupon(array $updateMsg = [])
        {
            return DB::table(self::$sTableName)->where('id', $updateMsg['couponId'])->update([
                'name' => $updateMsg['couponName'],
                'type' => $updateMsg['couponType'],
                'context' => $updateMsg['context'],
                'zslm_couponcol' => $updateMsg['couponcol'],
                'update_time' => time()
            ]);
        }
        
        public static function getCouponByCoach(Request $request)
        {
            return DB::table(self::$sTableName)
                ->leftjoin('coach_name', 'coach_id', '=', 'coach_name.id')
                ->where('coach_id', $request->id)
                ->get(['weight', 'is_show', self::$sTableName . '.id', 'coach_name', 'name']);
        }
        
        public static function getCouponName($coupon_id)
        {
            return DB::table(self::$sTableName)->whereIn('id', $coupon_id)->where('is_enable', 0)->get(['name']);
        }
        
        
        //front
        public static function getFrontCouponByCoach($c_id, $fields)
        {
            return DB::table(self::$sTableName)->where('coach_id', $c_id)->get($fields);
        }
        
        public static function getCoachByCoupon($c_ids, $page, $page_size, $type)
        {
            $result = DB::table(self::$sTableName)
                ->where('is_enable', $type)
                ->whereIn('id', $c_ids)
                ->groupBy('coach_id')
                ->offset(($page - 1) * $page_size)
                ->limit($page_size)
                ->select('coach_id')
                ->get();
            return $result;
        }
        
        public static function getUserCoachCoupon($u_id, $c_id, $type, $is_use)
        {
            $query = DB::table(self::$sTableName)
                ->join('user_coupon', self::$sTableName . '.id', '=', 'user_coupon.coupon_id')
                ->where('coach_id', $c_id)
                ->where('user_id', $u_id)
                ->where('is_enable', $type)
                 ->where( self::$sTableName . '.is_delete', 0);
            if ($is_use == 0)
                $query = $query->where('use_time', 0);
            else if ($is_use == 1)
                $query = $query->where('use_time', '>', 0);
            
            return $query->get([self::$sTableName.'.id',self::$sTableName.'.name',self::$sTableName.'.type']);
        }
        
    }