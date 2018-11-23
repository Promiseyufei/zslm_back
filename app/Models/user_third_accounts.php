<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/10/10
     * Time: 22:15
     */
    
    namespace App\Models;
    use DB;
    use Illuminate\Http\Request;
    
    class user_third_accounts
    {
        private static $sTableName = 'user_third_accounts';
        
        
        public static function getTypeOfThread(array $ids){
            
         return   DB::table(self::$sTableName)
                 ->whereIn('user_account_id',$ids)
                 ->get(['user_account_id','third_account_type']);
        }
    }