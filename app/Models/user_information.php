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
        
        public static function getActiveUser($key = '',$page,$pageSize,$queryKey = ''){
            $key = $key != ''? '%'.$key.'%' : '%';
            $queryKey = $queryKey != '' ? '%'.$queryKey.'%' : '%';
            $queryString = "zslm_activitys.active_name like '$key' or phone like '$queryKey' or user_name like '$queryKey' or real_name like '$queryKey'";
            $result =  DB::table(self::$sTableName)->where('user_information.is_delete',0)
                ->join('user_activitys','user_activitys.user_id','=', 'user_information.id')
                ->join('zslm_activitys','zslm_activitys.id','=', 'user_activitys.activity_id')
                ->join('user_accounts','user_accounts.id', '=' ,'user_information.user_account_id')
                ->whereRaw($queryString)
                ->offset(($page-1)*$pageSize)
                ->limit($pageSize)
                ->get(['activity_id','active_name','user_account_id','phone','head_portrait','user_name','real_name','sex','user_information.address','schooling_id','graduate_school','industry','worked_year']);
             
            return $result;
        }
        
    }