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
    define('ADDRESS_SEPARATOR',',');
    
    class zslm_major
    {
        private static $sTableName = 'zslm_major';
    
        /**
         * 通过省的id获取院校专业
         * @param Request $request
         */
        public static function getMajorByP(Request $request){
            DB::table(self::$sTableName)
                ->where('province','like',$request->provinceId.ADDRESS_SEPARATOR.'%')
                ->orWhere('z_name','like',$request->word)
                ->whereIn()
                ->offset(($request->page-1)*$request->pageSize)
                ->limit($request->pageSize)
                ->get(['id','z_name']);
        }
        
        public static function getMajorId($name){
        
            return  DB::table(self::$sTableName)->where('z_name','like','%'.$name.'%')->get(['id']);
        }
        
        
    }