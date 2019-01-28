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


        public static function insertThirdAccount($userOpenid, $thirdType = 0, $userThInfo = []) {
            if($userThInfo == []) 
                return DB::table(self::$sTableName)->insertGetId([
                    'thirdAccount' => $userOpenid,
                    'create_time' => time(),
                    'third_account_type' => $thirdType
                ]);
            else 
                return DB::table(self::$sTableName)->insertGetId($userThInfo);
        }

        public static function judgeThirdUser($userOpenId, $type = 0) {
            if(!DB::table(self::$sTableName)->where('thirdAccount', $userOpenId)->count()) {
                self::insertThirdAccount($userOpenId, $type);
            }

            return DB::table(self::$sTableName)->where('thirdAccount', $userOpenId)->where('third_account_type', $type)->value('user_account_id');
            
        }

        public static function updateThirdBind($userOpenId, $userId) {
            // dd(DB::table(self::$sTableName)->where('thirdAccount', $userOpenId)->get());
            return DB::table(self::$sTableName)->where('thirdAccount', $userOpenId)->where('is_delete', 0)->update([
                'user_account_id' => $userId,
                'update_time' => time()
            ]);
        }




        // public static function judgeIfBinding($user_id) {
        //     $handle = DB::table(self::$sTableName)->where('user_account_id', $user_id);
        //     switch ($handle->count()) {
        //         case 0:
        //             return '未绑定';
        //             break;
        //         case 1:
        //             if($handle->value('third_account_type') == 0 || )
                    
        //         default:
        //             # code...
        //             break;
        //     }
        //     // if() return '未绑定';
            
        // }
    }