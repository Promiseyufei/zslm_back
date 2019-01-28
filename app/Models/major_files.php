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
    use App\Models\zslm_major as ZslmMajor;
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
         *
         * @param Request $request 前台请求的数据信息 有 page 和pageSzie 两个必须字段
         *
         * @return 查询结果或者null
         */
        public static function getUploadFile(Request $request)
        {
            $nexgPage = $request->page;
            $pageSize = $request->pageSize;
            $offsetPostion = ($nexgPage - 1) * $pageSize;
            if ($request->fileType < 2)
                $queryWhere = self::$sTableName . '.is_delete = 0 and (file_name like ' . "'%" .
                    $request->fileName . "%'" .
                    ' and file_type = ' . $request->fileType .
                    ' and file_year like' . "'%" . $request->fileYear . "%'" .
                    ' and z_name like ' . "'%" . $request->majorName . "%')";
            else
                $queryWhere = self::$sTableName . '.is_delete = 0 and (file_name like ' . "'%" .
                    $request->fileName . "%'" .
                    ' and file_year like' . "'%" . $request->fileYear . "%'" .
                    ' and z_name like ' . "'%" . $request->majorName . "%')";
            
            $searchData = DB::table(self::$sTableName)
                ->whereRaw($queryWhere)
                ->join('zslm_major', self::$sTableName . '.major_id', '=', 'zslm_major.id')
                ->offset($offsetPostion)
                ->limit($pageSize)
                ->get([self::$sTableName . '.id',
                    'show_weight',
                    'file_name',
                    'file_type',
                    'file_year',
                    self::$sTableName . '.is_show',
                    self::$sTableName . '.create_time',
                    'z_name',
                    'show_weight',
                    'file_alt',
                    'file_url']);
            
            $count = DB::table(self::$sTableName)
                ->whereRaw($queryWhere)
                ->join('zslm_major', self::$sTableName . '.major_id', '=', 'zslm_major.id')
                ->count(self::$sTableName . '.major_id');
            
            return empty($searchData) ? null : [$searchData, $count];
            
            
        }
        
        public static function getOneMajorFile(Request $request)
        {
            $queryWhere = self::$sTableName . '.is_delete = 0 and zslm_major.id = ' . $request->majorId;
            
            $searchData = DB::table(self::$sTableName)
                ->whereRaw($queryWhere)
                ->join('zslm_major', self::$sTableName . '.major_id', '=', 'zslm_major.id')
                ->get([self::$sTableName . '.id',
                    'show_weight',
                    'file_name',
                    'file_type',
                    'file_year',
                    self::$sTableName . '.is_show',
                    self::$sTableName . '.create_time',
                    'z_name',
                    'show_weight',
                    'file_alt',
                    'file_url']);
            
            
            return empty($searchData) ? null : $searchData;
            
            
        }
        
        public static function getCountData()
        {
            $countNum = DB::table(self::$sTableName)->where('is_delete', 0)->count('id');
            return $countNum;
        }
        
        public static function getCountZhaos()
        {
            $countNum = DB::table(self::$sTableName)->where('file_type', 0)->where('is_delete', 0)->count('id');
            return $countNum;
        }
        
        /**
         * 获取全部文件数量
         */
        public static function getAllFile()
        {
            $countNum = DB::table(self::$sTableName)->where('is_delete', 0)->count('id');
        }
        
        /**
         * 获取招生简章文件数量
         */
        public static function getZFile()
        {
            $countNum = DB::table(self::$sTableName)->where('is_delete', 0)->where('file_type', 0)->count('id');
        }
        
        public static function uploadFile(Request $request)
        {
            
            $insertResult = DB::table(self::$sTableName)
                ->insert(['file_name' => $request->fileName,
                    'file_type' => $request->fileType,
                    'file_alt' => $request->fileDescribe,
                    'file_year' => $request->fileYear,
                    'is_show' => $request->isShow,
                    'major_id' => $request->majorId,
                    'create_time' => time(),
                    'update_time' => time(),
                    'file_url' => $request->file_url]);
            return $insertResult;
        }
        
        /**
         * 更新文件
         *
         * @param Request $request
         *
         * @return mixed
         */
        public static function updateFile(Request $request)
        {
            $updateResult = DB::table(self::$sTableName)
                ->where('id', $request->fileId)
                ->update(['file_name' => $request->fileName,
                    'file_type' => $request->fileType,
                    'file_alt' => $request->fileDescribe,
                    'is_show' => $request->isShow,
                    'file_year' => $request->fileYear,
                    'update_time' => time()]);
            return $updateResult;
        }
        
        /**
         * 删除该院校的所有有关文件
         *
         * @param Request $request
         *
         * @return mixed
         */
        
        public static function deletetMajorAllFiles(Request $request)
        {
            $result = DB::table(self::$sTableName)->where('major_id', $request->mid)->update(['is_delete' => 1]);
        }
        
        /**
         * 检查一个院校的所有文件是否删除，返回值为0则成功，否则不成功需要回滚
         *
         * @param Request $request
         *
         * @return mixed
         */
        public static function checkAllDel($id)
        {
            $count = DB::table(self::$sTableName)->where('major_id', $id)->where('is_delete', 0)->count('id');
            return $count;
        }
        
        public static function delteFile(Request $request)
        {
            $fileId = $request->fileId;
            $updateResult = DB::table(self::$sTableName)->whereIn('id', $fileId)->update(['is_delete' => 1]);
            return $updateResult;
        }
        
        public static function getFileName($fileId)
        {
            $fileName = DB::table(self::$sTableName)->where('id', $fileId)->where('is_delete', 0)->first(['file_name']);
            return empty($fileName) ? null : $fileName->file_name;
        }
        
        /**
         * crushingFiles
         * 彻底删除文件
         */
        public static function crushingFiles()
        {
        
        }
        
        /**
         *
         */
        public static function updateShowWeight($id, $weight)
        {
            
            $updateResult = DB::table(self::$sTableName)->where('id', $id)->update(['show_weight' => $weight]);
            return $updateResult;
        }
        
        public static function getMajorFile($id)
        {
            $files = DB::table(self::$sTableName)->where('major_id', $id)->where('is_delete', 0)->get(['file_name', 'file_alt']);
            return $files;
        }
        
        public static function getZSJZFile($id, $year)
        {
            
            $files = DB::table(self::$sTableName)->where('major_id', $id)->where('is_delete', 0)->where('file_type', 0);
            if ($year != '' && !empty($year)) {
                $files = $files->where('file_year', 'like', '%' . $year . '%');
            }
            $result = $files->get(['file_name', 'file_alt']);
            return $result;
        }
    }