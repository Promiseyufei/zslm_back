<?php

/**
 * 文件管理控制器
 */

namespace App\Http\Controllers\Admin\Files;

use App\Http\Controllers\Controller;

use App\Models\zslm_major as zslmMajor;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Models\major_files as MajorFiles;
use App\Models\dict_region as dictRegion;
use DB;

use Illuminate\Support\Facades\Storage;


/**
 * 错误提示
 * METHOD_ERROR 请求错误 请求方式与规定不一样
 * FORMAT_ERROR 数据格式错误
 *
 */
define('METHOD_ERROR','The request type error');
define('FORMAT_ERROR','The data format error');

class FilesController extends Controller 
{

    private  $fileUrl = 'public/major_file/';
    public function test(){
       MajorFiles::getCountData();
    }
    
    /**
     * @api {get} /admin/files/getUploadFile?page=1&pageSize=5 获取上传过的文件信息
     * @apiName getUploadFile
     * @apiGroup Files
     *
     * @apiParam {Number} page 页码.
     * @apiParam {Number} pageSize 单个页面请求的数据个数.
     *
     * @apiSuccess {String} code 返回程序的状态码 0 表示成功 1表示失败.
     * @apiSuccess {String} message  成功就是success.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "code":0,
     *          "message":'success',
     *          "data":{
     *              array[
     *                    0 => {
     *                       "id": 1
     *                       "show_weight": 1
     *                       "file_name": "test"
     *                       "file_type": 0
     *                       "file_year": "2018"
     *                       "is_show": 0
     *                       "create_time": 11111
     *                       }
     *              ]
     *           }
     *     }
     *
     * @apiError dataError
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code":1,
     *       "message":'No data or Application error ',
     *     }
     */
    public function getUploadFile(Request $request){
        if(!$request->isMethod("get"))
            return responseToJson(1,METHOD_ERROR);
        if(!isset($request->page))
            return responseToJson(1,'no page');
        if(!isset($request->pageSize))
            return responseToJson(1,'no pageSize');
        
        if(!is_numeric(intval($request->page)) || !is_numeric(intval($request->pageSize)))
            return responseToJson(1,FORMAT_ERROR);
        
        $serachData = MajorFiles::getUploadFile($request);
        $zhaosheng = MajorFiles::getCountZhaos();
        return $serachData != null ? responseToJson(0,'success',['data'=>$serachData[0],'dataCount'=>$serachData[1],'zhaos'=>$zhaosheng]) : responseToJson(1,'no data');
    }
    
    public function info(){
        $all = MajorFiles::getAllFile();
    }
    
    /**
     * @api {post} /admin/files/uploadFile 上传文件
     * @apiName uploadFile
     * @apiGroup Files
     *
     * @apiParam {File} uploadFile 上传的文件.
     * @apiParam {String} fileName 文件名称.
     * @apiParam {int} fileType 文件类型
     * @apiParam {String} fileYear 文件年份
     * @apiParam {String} fileDescribe 文件描述
     * @apiParam {int} isShow 文件是否展示
     *
     * @apiSuccess {String} code 返回程序的状态码 0 表示成功 1表示失败.
     * @apiSuccess {String} message  成功就是success.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "code":0,
     *          "message":'success'
     *     }
     *
     * @apiError dataError
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code":1,
     *       "message":'文件名称未填写（举个例子） or Application error ',
     *     }
     */
    
    public function isDataIntegrity(Request $request,$isDataIntegrity){
        if($isDataIntegrity != 'yes')
            return responseToJson(1,'The lack of '.$isDataIntegrity);
        $pregNumbers = preg_match_all('/^[0-9]+.?[0-9]*$/',$request->fileYear);
        if($pregNumbers == 0 || !$pregNumbers)
            return responseToJson(1,'file_year must be in number');
        if(!is_numeric($request->fileType))
            return responseToJson(1,'file_type must be in number');
        return null;
    }
    
    public function uploadFile(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1,METHOD_ERROR);
        $isDataIntegrity = judgeRequest(2,['fileType','fileYear','fileDescribe','isShow']);
        $judgeResult = $this->isDataIntegrity($request,$isDataIntegrity);
        if(!empty($judgeResult))
            return $judgeResult;
        
        $file = $request->file('uploadFile');
       $filename = getFileName($request->fileName,$file->getClientOriginalExtension());
       $request->file_url = $filename;
        DB::beginTransaction();
        try{
            MajorFiles::uploadFile($request);
            Storage::putFileAs($this->fileUrl,$file,$filename);
            DB::commit();
            return responseToJson(0,'success');
        }catch (\Exception $e){
            DB::rollBack();
            return responseToJson(1,'upload error');
        }
        
    }
    /**
     * @api {post} /admin/files/deleteFile 删除文件
     * @apiName deleteFile
     * @apiGroup Files
     *
     * @apiParam {number} fileId 删除文件的id.
     *
     * @apiSuccess {String} code 返回程序的状态码 0 表示成功 1表示失败.
     * @apiSuccess {String} message  成功就是success.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "code":0,
     *          "message":'success'
     *     }
     *
     * @apiError dataError
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code":1,
     *       "message":'文件id缺失（举个例子） or Application error ',
     *     }
     */
    public function deleteFile(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson('1',METHOD_ERROR);
        if(!isset($request->fileId))
            return responseToJson(1,"No file id");
        foreach ($request->fileId as $key => $value ){
            if(!is_numeric($value))
                return responseToJson(1,'FileId is not Numbers');
        }
    
        $isDelete =  MajorFiles::delteFile($request);
        return  $isDelete>0 ? responseToJson(0,'success'):responseToJson(1,'No data to be deleted');
    }
    
    
    
    /**
     * @api {post} /admin/files/updateFile 更新文件
     * @apiName updateFile
     * @apiGroup Files
     *
     * @apiParam {number} fileId 文件id
     * @apiParam {String} fileName 文件名称.
     * @apiParam {int} fileType 文件类型
     * @apiParam {String} fileYear 文件年份
     * @apiParam {String} fileDescribe 文件描述
     * @apiParam {int} isShow 文件是否展示
     *
     * @apiSuccess {String} code 返回程序的状态码 0 表示成功 1表示失败.
     * @apiSuccess {String} message  成功就是success.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "code":0,
     *          "message":'success'
     *     }
     *
     * @apiError dataError
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code":1,
     *       "message":'文件名称未填写（举个例子） or Application error ',
     *     }
     */
    public function updateFile(Request $request){
        

        if(!$request->isMethod('post'))
            return responseToJson(1,METHOD_ERROR);
//        $isDataIntegrity = judgeRequest(2,['fileId','fileName','fileType','fileYear','fileDescribe','isShow']);
//        $judgeResult = $this->isDataIntegrity($request,$isDataIntegrity);
//        if(!empty($judgeResult))
//            return $judgeResult;
        if(!isset($request->fileId) || !isset($request->fileName) || !isset($request->fileType) || !isset($request->fileYear) || !isset($request->fileDescribe) || !isset($request->isShow))
            return responseToJson(1,"error");
    
       $result =  MajorFiles::updateFile($request);
       if($result>0)
           return responseToJson(0,"success");
       else
           return responseToJson(1,"修改失败");
//        $lastFileName = MajorFiles::getFileName($request->fileId);
//        $nextFileName = $request->fileName=getFileName($request->fileName);
//        DB::beginTransaction();
//        try{

//            Storage::move($this->fileUrl.$lastFileName,$this->fileUrl.$nextFileName);
//            DB::commit();
//        }catch (\Exception $e){
//            DB::rollBack();
//            return responseToJson(1,'upload error');
//        }
    }
    
    public function updateShowWeight(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1,METHOD_ERROR);
        $result =  MajorFiles::updateShowWeight($request->fileId,$request->weight);
        return $result == 1 ? responseToJson(1,'success') : responseToJson(1,'no data update');
    }
    
    public function getProvice(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        $provice = dictRegion::getProvince();
        if(!empty($provice))
            return responseToJson(0,'success',$provice);
        else
            return responseToJson(1,'no provice data');
    }
    
    
    public function getMajorByRegion(Request $request){
        
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        if(!isset($request->provice))
            return responseToJson(1,'No provice is selected,please try again');
        $provice_id = [];
        $provice_id[0] = dictRegion::getProvinceIdByNameOne($request->provice[0])[0];
        $provice_id[1] = dictRegion::getProvinceIdByNameOne($request->provice[1])[0];
        if(empty($provice_id))
            return responseToJson(1,'something was wrong ,please try again');
        
        $provice_id_bash = [];
        $lenght = sizeof($provice_id);
        for($i = 0;$i<$lenght;$i++){
            $provice_id_bash[] = $provice_id[$i]->id;
        }
        $majors = [];
        for($i = 0;$i < $lenght;$i++){
            $major = zslmMajor::getMajorByP($provice_id_bash[$i],$request->majorname);
            $majors[$i] = $major;
        }
        return responseToJson('0','success',$majors);
    }
    
    
    
}