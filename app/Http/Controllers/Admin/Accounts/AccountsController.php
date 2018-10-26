<?php

/**
 * 账户管理
 */

namespace App\Http\Controllers\Admin\Accounts;

use App\Models\user_third_accounts;
use Illuminate\Http\Request;
use Validator;
use Excel;

use App\Models\user_information as UserInformation;
use App\Models\dict_region as DictRegion;
use App\Models\dict_education as DictSchooling;
use App\Models\dict_industry as DictInsutry;

class AccountsController extends AccountControllerBase
{
    
    public function getActivityUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
    
        $name  = isset($request->name) ? $request->name : '';
        $active = isset($result->active) ? $request->active : '';
        $realname = isset($result->realname) ? $request->realname : '';
        $result = UserInformation::getInformation($name,$active,$realname,$request->page,$request->pageSize,0);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getMajorUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $name  = isset($request->name) ? $request->name : '';
        $phone = isset($result->phone) ? $request->phone : '';
        $realname = isset($result->realname) ? $request->realname : '';
        $result = UserInformation::getInformation($name,$phone,$realname,$request->page,$request->pageSize,1);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getCouponUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
    
        $phone[0]  = isset($request->cid) ? $request->cid : '';
        $phone[1]  = isset($request->cname) ? $request->cname : '';
        $name = isset($request->name) ? $request->name : '';
        $realname = isset($request->realname) ? $request->realname : '';
        $result = UserInformation::getInformation($name,$phone,$realname,$request->page,$request->pageSize,2);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        $phone  = isset($request->phone) ? $request->phone : '';
        $name = isset($request->name) ? $request->name : '';
        $realname = isset($request->realname) ? $request->realname : '';
        $result = UserInformation::getInformation($name,$phone,$realname,$request->page,$request->pageSize,3);
        $id = [];
        
        for($i = 0;$i<sizeof($result[0]);$i++){
            $id[$i] = $result[0][$i]->user_account_id;
        }

        $thread =  user_third_accounts::getTypeOfThread($id);
    
    
    
        for($i = 0;$i<sizeof($result[0]);$i++){
            $provice_name = '';
            $city_name = '';
            $return_ins = '';
            $result[0][$i]->weixin = '未绑定';
            $result[0][$i]->weibo = '未绑定';
            for($j = 0;$j<sizeof($thread);$j++){
                if($result[0][$i]->user_account_id == $thread[$j]->user_account_id)
                    if($thread[$j]->third_account_type == 1)
                        $result[0][$i]->weixin = '绑定';
                    else if($thread[$j]->third_account_type == 2)
                        $result[0][$i]->weibo = '绑定';
            }
//
            if($result[0][$i]->address != null) {
                $provice_arr = strChangeArr($result[0][$i]->address,EXPLODE_STR);
                $provice = DictRegion::getAllArea();
                $provice_name=$this->findAddress($provice_arr[0],$provice);
                $city_name = $this->findAddress($provice_arr[1],$provice);
            }
            if($result[0][$i]->industry != null){
                $insutry = strChangeArr($result[0][$i]->industry,EXPLODE_STR);
                $insutrys = DictInsutry::getAllIndustry();
                for($j = 0;$j<sizeof($insutry);$j++){
                    $return_ins.= $this->findIndustry(intval($insutry[$j]),$insutrys);
                }
            }
            $result[0][$i]->address = $provice_name.$city_name;
            $result[0][$i]->industry = $return_ins;
            $result[0][$i]->test = '';
        }
        return !empty([$result]) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getActivityOneUser(Request $request){
        
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
        
        $user = $this->getUserId($request);
        $activity_names = $this->getActivityNames($request);
    
        $provice_name = '';
        $city_name = '';
        $return_ins = '';
        if($user->address != null) {
            $provice_arr = strChangeArr($user->address,EXPLODE_STR);
            $provice = DictRegion::getAllArea();
            $provice_name=$this->findAddress($provice_arr[0],$provice);
            $city_name = $this->findAddress($provice_arr[1],$provice);
        }
        if($user->industry != null){
            $insutry = strChangeArr($user->industry,EXPLODE_STR);
            $insutrys = DictInsutry::getAllIndustry();
            for($i = 0;$i<sizeof($insutry);$i++){
                $return_ins.= $this->findIndustry(intval($insutry[$i]),$insutrys);
            }
        }
        $sname = DictSchooling::getSchoolingById($user->schooling_id);
        $user->schooling_id = empty($sname) ? '' : $sname->name;
        
        $user->address = $provice_name.$city_name;
        $user->industry = $return_ins;
        
        return !empty($user) ? responseToJson(0,[$user,$activity_names]) : responseToJson(1,'no data');
    }
    
    
    public function getMajorOneUser(Request $request){
    
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
        
        $user = $this->getUserId($request);
        $major_names = $this->getMajorNames($request);
        $provice_name = '';
        $city_name = '';
        $return_ins = '';
        if($user->address != null) {
            $provice_arr = strChangeArr($user->address,EXPLODE_STR);
            $provice = DictRegion::getAllArea();
            $provice_name=$this->findAddress($provice_arr[0],$provice);
            $city_name = $this->findAddress($provice_arr[1],$provice);
        }
        if($user->industry != null){
            $insutry = strChangeArr($user->industry,EXPLODE_STR);
            $insutrys = DictInsutry::getAllIndustry();
            for($i = 0;$i<sizeof($insutry);$i++){
                $return_ins.= $this->findIndustry(intval($insutry[$i]),$insutrys);
            }
        }
        $user->address = $provice_name.$city_name;
        $user->industry = $return_ins;
        
        return !empty($user) ? responseToJson(0,[$user,$major_names]) : responseToJson(1,'no data');
    }
    
    public function getCouponOneUser(Request $request){
    
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
    
        $user = $this->getUserId($request);
        $coupon_names = $this->getCouponNames($request);
        $return_ins = '';
        $provice_name = '';
        $city_name = '';
        if($user->address != null) {
            $provice_arr = strChangeArr($user->address,EXPLODE_STR);
            $provice = DictRegion::getAllArea();
            $provice_name=$this->findAddress($provice_arr[0],$provice);
            $city_name = $this->findAddress($provice_arr[1],$provice);
        }
        if($user->industry != null){
            $insutry = strChangeArr($user->industry,EXPLODE_STR);
            $insutrys = DictInsutry::getAllIndustry();
            for($i = 0;$i<sizeof($insutry);$i++){
                $return_ins.= $this->findIndustry(intval($insutry[$i]),$insutrys);
            }
        }
        $user->address = $provice_name.$city_name;
        $user->industry = $return_ins;
        return !empty($user) ? responseToJson(0,'success',[$user,$coupon_names]) : responseToJson(1,'no data');
    }
    
    public function getOneUser(Request $request){
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
    
        $user = $this->getUserId($request);
        $return_ins='';
        $provice_name = '';
        $city_name = '';
        if($user->address != null) {
            $provice_arr = strChangeArr($user->address,EXPLODE_STR);
            $provice = DictRegion::getAllArea();
            $provice_name=$this->findAddress($provice_arr[0],$provice);
            $city_name = $this->findAddress($provice_arr[1],$provice);
        }
        
        if($user->industry != null){
            $insutry = strChangeArr($user->industry,EXPLODE_STR);
            $insutrys = DictInsutry::getAllIndustry();
            for($i = 0;$i<sizeof($insutry);$i++){
                $return_ins.= $this->findIndustry(intval($insutry[$i]),$insutrys);
            }
        }
        $user->address = $provice_name.$city_name;
        $user->industry = $return_ins;
        
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
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $provice = DictRegion::getAllArea();
        $schooling = DictSchooling::getAllSchooling();
        $insutrys = DictInsutry::getAllIndustry();
        $data = $result = UserInformation::getInformation('','','',0,MAX_INTEGER,'',1);
        
        $datas = [['院校专业id','院校专业名称','账户id',
            '电话号码','头像','用户名',
            '真实姓名','性别','地址',
            '学历','毕业院校','行业','工作年限','创建时间']];
    
        $datas =  $this->resultObjToArray($data,$datas,$provice,$schooling,$insutrys);
//        dd($datas);
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
    
    public function  getAllArea(){
        return responseToJson(0,'success',[DictRegion::getAllArea()]);
    }
}