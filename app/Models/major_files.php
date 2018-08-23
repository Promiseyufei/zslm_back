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
        
        public static function uploadFile(Request $request){
            
            $insertResult = DB::table(self::$sTableName)
                ->insert(['file_name'=>$request->fileName,
                    'file_type'=>$request->fileType,
                    'file_alt'=>$request->fileDescribe,
                    'file_year'=>$request->fileYear,
                    'is_show'=>$request->isShow,
                    'create_time'=>time(),
                    'update_time'=>time()]);
            return $insertResult;
        }
        
        public static function updateFile(Request $request){
            $updateResult = DB::table(self::$sTableName)
                ->where('id',$request->fileId)
                ->update(['file_name'=>$request->fileName,
                    'file_type'=>$request->fileType,
                    'file_alt'=>$request->fileType,
                    'is_show'=>$request->isShow,
                    'update_time'=>time()]);
            return $updateResult;
        }
        
        public static function delteFile(Request $request){
            $fileId = $request->fileId;
            $updateResult = DB::table(self::$sTableName)->where('id',$fileId)->update(['is_delete'=>1]);
            return $updateResult;
        }
        
        public static function getFileName($fileId){
            $fileName = DB::table(self::$sTableName)->where('id',$fileId)->where('is_delete',0)->first(['file_name']);
            return empty($fileName) ? null : $fileName->file_name;
        }
    
        /**
         * crushingFiles
         * 彻底删除文件
         */
        public static function crushingFiles(){
        
        }
        
    }