<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/9
     * Time: 9:43
     */
    
    namespace App\Models;
    
    use DB;
    use Illuminate\Http\Request;

    class user_information
    {
        private static $sTableName = 'user_information';
        
        public static function getInformation($key = '',$page,$pageSize,$queryKey = '',$type){
            $key = $key != ''? '%'.$key.'%' : '%';
            $queryKey = $queryKey != '' ? '%'.$queryKey.'%' : '%';
            $queryString = "zslm_activitys.active_name like '$key'
                        or phone like '$queryKey'
                        or user_name like '$queryKey'
                        or real_name like '$queryKey'";
            switch ($type){
                case 0:
                    return self::getActiveUser($queryString,$page,$pageSize);
                    break;
                case 1:
                    return self::getMajorUser($queryString,$page,$pageSize);
                    break;
                case 2:
                    return self::getCouponUser($queryString,$page,$pageSize);
                    break;
                case 3:
                    $queryString = "phone like '$queryKey'
                                or user_name like '$queryKey'
                                or real_name like '$queryKey'";
                    return self::getUser($queryString,$page,$pageSize);
                    break;
            }
        }
        
        public static function getActiveUser($queryString,$page,$pageSize){
            
            $result =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_activitys','user_activitys.user_id','=', 'user_information.id')
                ->join('zslm_activitys','zslm_activitys.id','=', 'user_activitys.activity_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                ->offset(($page-1)*$pageSize)
                ->limit($pageSize)
                ->get(['activity_id','active_name','user_account_id',
                    'phone','head_portrait','user_name',
                    'real_name','sex','user_information.address',
                    'schooling_id','graduate_school','industry',
                    'worked_year','user_information.create_time']);
             
            return $result;
        }
        
        public static function getMajorUser($queryString,$page,$pageSize){
    
            $result =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_follow_major','user_follow_major.user_id','=', 'user_information.id')
                ->join('zslm_major','zslm_major.id','=', 'user_follow_major.major_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                ->offset(($page-1)*$pageSize)
                ->limit($pageSize)
                ->get(['major_id','z_name','user_account_id',
                    'phone','head_portrait','user_name',
                    'real_name','sex','user_information.address',
                    'schooling_id','graduate_school','industry',
                    'worked_year','user_information.create_time']);
    
            return $result;
        }
        
        public static function getCouponUser($queryString,$page,$pageSize){
            
            $result =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_coupon','user_coupon.user_id','=', 'user_information.id')
                ->join('zslm_coupon','zslm_coupon.id','=', 'user_coupon.coupon_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                ->offset(($page-1)*$pageSize)
                ->limit($pageSize)
                ->get(['coupon_id','zslm_coupon.name','user_account_id',
                    'phone','head_portrait','user_name',
                    'real_name','sex','user_information.address',
                    'schooling_id','graduate_school','industry',
                    'worked_year','user_information.create_time']);
            
            return $result;
        }
        
        public static function getUser($queryString,$page,$pageSize){
    
            $result =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                ->offset(($page-1)*$pageSize)
                ->limit($pageSize)
                ->get(['user_account_id','phone','head_portrait','user_name',
                    'real_name','sex','user_information.address',
                    'schooling_id','graduate_school','industry',
                    'worked_year','user_information.create_time']);
    
            return $result;
        }
        
        public static function getUserById($id){
        
            $result = DB::table(self::$sTableName)
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->where('id',$id)
                ->where('is_delete',0)
                ->frist(['user_account_id','phone','user_name',
                    'real_name','sex','head_portrait',
                    'user_information.address','schooling_id','graduate_school',
                    'worked_year','user_information.update_time']);
            
            return $result;
            
        }
        
    }

