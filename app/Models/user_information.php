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
        
        public static function getInformation($name = '',$phone = '',$realname='',$page,$pageSize,$type){
            $name = $name != ''? '%'.$name.'%' : '%%';
            if($type == 2){
//                print_r($phone);
                $phone[0] = $phone[0] != '' ? '%'.$phone[0].'%' : '%%';
                $phone[1] = $phone[1] != '' ? '%'.$phone[1].'%' : '%%';
            }else{
                $phone = $phone != '' ? '%'.$phone.'%' : '%%';
            }
            
           
            $realname = $realname != '' ? '%'.$realname.'%' : '%%';
        
            switch ($type){
                case 0:
                    $queryString = " zslm_activitys.active_name like '$phone'
                        and user_name like '$name'
                        and real_name like '$realname'";
                    return self::getActiveUser($queryString,$page,$pageSize);
                    break;
                case 1:
                    $queryString = " user_accounts.phone like '$phone'
                        and user_name like '$name'
                        and real_name like '$realname'";
                    return self::getMajorUser($queryString,$page,$pageSize);
                    break;
                case 2:
                    $queryString = " zslm_coupon.id like '$phone[0]'
                        and zslm_coupon.name like '$phone[1]'
                        and user_name like '$name'
                        and real_name like '$realname'";
                    return self::getCouponUser($queryString,$page,$pageSize);
                    break;
                case 3:
                    $queryString = " user_accounts.phone like '$phone'
                            and user_name like '$name'
                            and real_name like '$realname'";
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
    
            $count =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_activitys','user_activitys.user_id','=', 'user_information.id')
                ->join('zslm_activitys','zslm_activitys.id','=', 'user_activitys.activity_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                -> count('activity_id');
             
            return [$result,$count];
        }
        
        public static function getMajorUser($queryString,$page,$pageSize){
            
            
            $result =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_follow_major','user_follow_major.user_id','=', 'user_information.user_account_id')
                ->join('zslm_major','zslm_major.id','=', 'user_follow_major.major_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->where('is_focus',0)
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                ->offset(($page-1)*$pageSize)
                ->limit($pageSize)
                ->get(['z_name','user_account_id', 'user_name',
                    'real_name','sex']);
            $count = DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_follow_major','user_follow_major.user_id','=', 'user_information.id')
                ->join('zslm_major','zslm_major.id','=', 'user_follow_major.major_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->where('is_focus',0)
                ->count('major_id');
    
            return [$result,$count];
        }
        
        public static function getCouponUser($queryString,$page,$pageSize){
            
            $result =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_coupon','user_coupon.user_id','=', 'user_information.user_account_id')
                ->join('zslm_coupon','zslm_coupon.id','=', 'user_coupon.coupon_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->where('is_enable',0)
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                ->offset(($page-1)*$pageSize)
                ->limit($pageSize)
                ->get(['coupon_id','zslm_coupon.name','user_account_id',
                    'phone','head_portrait','user_name',
                    'real_name','sex','user_information.address',
                    'schooling_id','coach_id','industry',
                    'worked_year','user_information.create_time']);
            
            for($i = 0;$i<sizeof($result);$i++){
             
               $name=coach_organize::getCoachNameById($result[$i]->coach_id);
               if(!empty($name))
                   $result[$i]->coach_id = $name->coach_name;
               else
                   $result[$i]->coach_id  = '';
               
            }
            $count =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_coupon','user_coupon.user_id','=', 'user_information.id')
                ->join('zslm_coupon','zslm_coupon.id','=', 'user_coupon.coupon_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                ->count('coupon_id');
            
            return [$result,$count];
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
                    'worked_year','user_information.create_time','user_information.update_time']);
            
            return [$result,self::getUserCount($queryString)];
        }
        public static function getUserCount($queryString){
        
            $result =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->orderBy('user_information.create_time')
                ->count('user_account_id');
        
            return $result;
        }
        
        public static function getUserById($id){
        
            $result = DB::table(self::$sTableName)
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->where('user_accounts.id',$id)
                ->where('user_accounts.is_delete',0)
                ->where('user_information.is_delete',0)
                ->first(['user_account_id','phone','user_name',
                    'real_name','sex','head_portrait',
                    'user_information.address','schooling_id','graduate_school',
                    'worked_year','user_information.update_time','industry']);
            
            return $result;
            
        }
        
    }
    
