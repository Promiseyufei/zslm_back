<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/30
     * Time: 21:00
     */
    
    namespace App\Models;
    
    
    use Illuminate\Support\Facades\DB;

    class opinion_feedback
    {
        private static $sTableName = 'opinion_feedback';
        
        public static function addOpinion($id,$name,$text){
          return   DB::table(self::$sTableName)->insert(['user_id'=>$id,'user_name'=>$name,'text'=>$text,'is_delete'=>0,'create_time'=>time(),'update_time'=>time()]);
        }
        
        public static function getNoViewMsg(){
            return DB::table(self::$sTableName)->where('is_delete',0)->where('is_view',0)->count('id');
        }
    }