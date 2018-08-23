<?php

/**
 * 文件管理控制器
 */

namespace App\Http\Controllers\Admin\Files;

use App\Http\Controllers\Controller;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Models\major_files as MajorFiles;
use DB;

use Illuminate\Support\Facades\Storage;

class FilesController extends Controller 
{

    private  $fileUrl = 'public/major_file/';
    public function test(){
        Storage::putFileAS($this->fileUrl,new File('D:\media.html'),'test.html');
    }
    
    public function test1(Request $request){
//        Storage::move($this->fileUrl.'/test.html',$this->fileUrl.'/ttt.html');
    }
    
    public function index(Request $request) {
        var_dump('test');
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
            return responseToJson(1,'The request type error');
        if(!isset($request->page) || !isset($request->pageSize))
            return responseToJson(1,'The lack of data');
        if(!is_numeric($request->page) || !is_numeric($request->pageSize))
            return responseToJson(1,'The data format error');
        $serachData = MajorFiles::getUploadFile($request);
        return $serachData != null ? responseToJson(0,'success',$serachData) : responseToJson(1,'no data');
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
    public function uploadFile(Request $request){
        
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
            return responseToJson('1','The request type error');
        if(!isset($request->fileId))
            return responseToJson(1,"No file id");
        if(!is_numeric($request->fileId))
            return responseToJson(1,'FileId is not Numbers');
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
    
    }
    
}