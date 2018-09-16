<?php

/**
 * 账户管理
 */

namespace App\Http\Controllers\Admin\Accounts;

use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\user_information as UserInformation;
use App\Models\dict_region as DictRegion;
use App\Models\dict_education as DictSchooling;
use App\Models\dict_industry as DictInsutry;

class AccountsController extends AccountControllerBase
{

    /**
    * @api {get} index.php?i=  测试一
    * @apiGroup test
    * @apiVersion 0.0.1
    * @apiDescription 这是第一个测试
    * @apiParam {String} token 登录token
    * @apiParamExample 请求样例
    * /index.php?i=8888
    *  @apiSuccess {int} type 类型 0：上行 1：下行
    * @apiExample 请求成功数据
    * {
    *    "status": "1",
    *    "data": {
    *               "first": 1,
    *               "last": 3,
    *    },
    *    "msg": "操作成功"
    * } 
    * @apiExample {json} 失败返回样例:
    *     {"code":"0","msg":"修改成功"}
    */
    public function index(Request $request) {
        $a = test();
        var_dump($a);
    }
    
    public function getActivityUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $key  = isset($request->key) ? $request->key : '';
        $queryKey = isset($result->queryKey) ? $request->queryKey : '';
        $result = UserInformation::getInformation($key,$request->page,$request->pageSize,$queryKey,0);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getMajorUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $key  = isset($request->key) ? $request->key : '';
        $queryKey = isset($result->queryKey) ? $request->queryKey : '';
        $result = UserInformation::getInformation($key,$request->page,$request->pageSize,$queryKey,1);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getCouponUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $key  = isset($request->key) ? $request->key : '';
        $queryKey = isset($result->queryKey) ? $request->queryKey : '';
        $result = UserInformation::getInformation($key,$request->page,$request->pageSize,$queryKey,2);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        $key  = isset($request->key) ? $request->key : '';
        $queryKey = isset($result->queryKey) ? $request->queryKey : '';
        $result = UserInformation::getInformation($key,$request->page,$request->pageSize,$queryKey,3);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getActivityOneUser(Request $request){
        
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
        
        $user = $this->getUserId($request);
        $activity_names = $this->getActivityNames($request);
        return !empty($user) ? responseToJson(0,[$user,$activity_names]) : responseToJson(1,'no data');
    }
    
    
    public function getMajorOneUser(Request $request){
    
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
        
        $user = $this->getUserId($request);
        $major_names = $this->getMajorNames($request);
    
        return !empty($user) ? responseToJson(0,[$user,$major_names]) : responseToJson(1,'no data');
    }
    
    public function getCouponOneUser(Request $request){
    
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
    
        $user = $this->getUserId($request);
        $coupon_names = $this->getCouponNames($request);
        
        return !empty($user) ? responseToJson(0,[$user,$coupon_names]) : responseToJson(1,'no data');
    }
    
    public function getOneUser(Request $request){
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
    
        $user = $this->getUserId($request);
        $activity_names = $this->getActivityNames($request);
        $major_names = $this->getMajorNames($request);
        $coupon_names = $this->getCouponNames($request);
        $data = [$user,$activity_names,$major_names,$coupon_names];
        return !empty($user) ? responseToJson(0,[$data]) : responseToJson(1,'no data');
    }
    
    public function createActivityExcel(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $provice = DictRegion::getAllArea();
        $schooling = DictSchooling::getAllSchooling();
        $insutrys = DictInsutry::getAllIndustry();
        $data = $result = UserInformation::getInformation('',$request->page,$request->pageSize,'',0);
        
        $datas = [['活动id','活动名称','账户id',
                    '电话号码','头像','用户名',
                    '真实姓名','性别','地址',
                    '学历','毕业院校','行业','工作年限']];
        
        $datas =  $this->resultObjToArray($data,$datas,$provice,$schooling,$insutrys);
        $this->createExcel($datas);
    }
    
    public function createMajorExcel(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1,METHOD_ERROR);
        
        $provice = DictRegion::getAllArea();
        $schooling = DictSchooling::getAllSchooling();
        $insutrys = DictInsutry::getAllIndustry();
        $data = $result = UserInformation::getInformation('',$request->page,$request->pageSize,'',1);
        
        $datas = [['院校专业id','院校专业名称','账户id',
            '电话号码','头像','用户名',
            '真实姓名','性别','地址',
            '学历','毕业院校','行业','工作年限']];
    
        $datas =  $this->resultObjToArray($data,$datas,$provice,$schooling,$insutrys);
        
        $this->createExcel($datas);
    }
    
    public function createCouponExcel(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1,METHOD_ERROR);
        
        $provice = DictRegion::getAllArea();
        $schooling = DictSchooling::getAllSchooling();
        $insutrys = DictInsutry::getAllIndustry();
        $data = $result = UserInformation::getInformation('',$request->page,$request->pageSize,'',2);
        
        $datas = [['优惠券id','优惠券名称','账户id',
            '电话号码','头像','用户名',
            '真实姓名','性别','地址',
            '学历','毕业院校','行业','工作年限']];
    
        $datas =  $this->resultObjToArray($data,$datas,$provice,$schooling,$insutrys);
        
        $this->createExcel($datas);
    }
    
    public function createUserExcel(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $provice = DictRegion::getAllArea();
        $schooling = DictSchooling::getAllSchooling();
        $insutrys = DictInsutry::getAllIndustry();
        $data = $result = UserInformation::getInformation('',$request->page,$request->pageSize,'',3);
        
        $datas = [['账户id',
            '电话号码','头像','用户名',
            '真实姓名','性别','地址',
            '学历','毕业院校','行业','工作年限']];
    
        $datas =  $this->resultObjToArray($data,$datas,$provice,$schooling,$insutrys);
        
        $this->createExcel($datas);
    }
}