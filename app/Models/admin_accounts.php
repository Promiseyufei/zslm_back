<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/15
     * Time: 16:23
     */
    
    namespace App\Models;
    
    
    use Illuminate\Http\Request;
    use DB;
    
    class admin_accounts
    {
        public static $sTableName = 'admin_accounts';
        
        public static function selectAccountByPass(Request $request){
            $result =  DB::table(self::$sTableName)->where('is_delete',0)
                ->where('account',$request->account)
                ->where('password',$request->password)
                ->first(['id']);
            return sizeof($result);
        }
        
    }