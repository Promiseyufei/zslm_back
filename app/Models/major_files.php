<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/8/22
     * Time: 9:53
     * major_files 表的model
     */
    
    namespace App\Models;

    use DB;
    use Illuminate\Http\Request;

    /**
     * Class file
     * 文件管理model
     * @package App\Models
     */
    class major_files
    {
        public static $sTableName = 'major_files';
    
        /**
         * getUploadFile 获取上传过的文件信息
         * @param Request $request 前台请求的数据信息 有 page 和pageSzie 两个必须字段
         * @return 查询结果或者null
         */
        public static function getUploadFile(Request $request){
            $nexgPage = $request->page;
            $pageSize = $request->pageSize;
            $offsetPostion = ($nexgPage-1)*$pageSize;
            $searchData=DB::table(self::$sTableName)
                        ->where('is_delete',0)
                        ->offset($offsetPostion)
                        ->limit($pageSize)
                        ->get(['id','show_weight','file_name','file_type','file_year','is_show','create_time']);
            dd($searchData);
            return empty($searchData) ? null:$searchData;
        }
        
        public function uploadFile(){
        
        }
        
        public function updateFile(){
        
        }
        
        public function delteFile(){
        
        }
        
    }