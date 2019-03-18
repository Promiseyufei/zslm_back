<?php

/**
 * 账户管理
 */

namespace App\Http\Controllers\Admin\Accounts;

use App\Models\admin_accounts;
use App\Models\dict_education;
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
        $active = isset($request->active) ? $request->active : '';
        $realname = isset($request->realname) ? $request->realname : '';
        $sorting = isset($request->sorting) ? $request->sorting : '';
        $sorting = $sorting == '' ? 0 : $sorting;
    
        if($sorting == 0)
            $sorting = 'asc';
        else if($sorting == 1)
            $sorting ='desc';
        else
            $sorting = 'else';
    
        $result = UserInformation::getInformation($name,$active,$realname,$request->page,$request->pageSize,0,$sorting);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getMajorUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $name  = isset($request->name) ? $request->name : '';
        $major = isset($request->major) ? $request->major : '';
        $realname = isset($request->realname) ? $request->realname : '';
        $sorting = isset($request->sorting) ? $request->sorting : '';
        $sorting = $sorting == '' ? 0 : $sorting;
        
        if($sorting == 0)
            $sorting = 'asc';
        else if($sorting == 1)
            $sorting ='desc';
        else
            $sorting = 'else';
        
        $result = UserInformation::getInformation($name,$major,$realname,$request->page,$request->pageSize,1,$sorting);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getCouponUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
    
        $phone[0]  = isset($request->cid) ? $request->cid : '';
        $phone[1]  = isset($request->cname) ? $request->cname : '';
        $name = isset($request->name) ? $request->name : '';
        $realname = isset($request->realname) ? $request->realname : '';
        $sorting = isset($request->sorting) ? $request->sorting : '';
        $sorting = $sorting == '' ? 0 : $sorting;
    
        
        if($sorting == 0)
            $sorting = 'asc';
        else if($sorting == 1)
            $sorting ='desc';
        else
            $sorting = 'else';
        $result = UserInformation::getInformation($name,$phone,$realname,$request->page,$request->pageSize,2,$sorting);
        return !empty($result) ? responseToJson(0,'success',$result) : responseToJson(1,'no data');
    }
    
    public function getUser(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        $phone  = isset($request->phone) ? $request->phone : '';
        $name = isset($request->name) ? $request->name : '';
        $realname = isset($request->realname) ? $request->realname : '';
        $sorting =  isset($request->sorting) ? $request->sorting : '';
        $sorting = $sorting == '' ? 0 : $sorting;
        $sorting = $sorting == 0 ? 'desc' : 'asc';
   
        $result = UserInformation::getInformation($name,$phone,$realname,$request->page,$request->pageSize,3,$sorting);
        $id = [];
        if($result[0] != null)
            for($i = 0;$i<sizeof($result[0]);$i++){
                $id[$i] = $result[0][$i]->user_account_id;
            }
        
        $thread =  user_third_accounts::getTypeOfThread($id);
    
        $school = dict_education::getAllSchooling();
        $school_arr = [];
        if($school != null)
            for($i = 0;$i<sizeof($school);$i++){
                $school_arr[$school[$i]->id] = $school[$i]->name;
            }

        if($result[0] != null)
            for($i = 0;$i<sizeof($result[0]);$i++){
                $provice_name = '';
                $city_name = '';
                $return_ins = '';
                $result[0][$i]->weixin = '未绑定';
                $result[0][$i]->weibo = '未绑定';

                if($result[0][$i]->schooling_id){
                    $result[0][$i]->schooling_id = $school_arr[$result[0][$i]->schooling_id];
                }

                if($thread != null)
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
                    $provice_name= isset($provice_arr[0])?$this->findAddress($provice_arr[0],$provice):'';
                    $city_name = isset($provice_arr[1])?$this->findAddress($provice_arr[1],$provice):'';
                }
                if($result[0][$i]->industry != null){
                    $insutry = strChangeArr($result[0][$i]->industry,EXPLODE_STR);
                    $insutrys = DictInsutry::getAllIndustry();
                    if($insutry != null)
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
    
        $thread =  user_third_accounts::getTypeOfThread([$request->id]);
        $user->weixin = '未绑定';
        $user->weibo = '未绑定';
        if($thread != null)
            for($j = 0;$j<sizeof($thread);$j++){
                if($user->user_account_id == $thread[$j]->user_account_id)
                    if($thread[$j]->third_account_type == 1)
                        $user->weixin = '绑定';
                    else if($thread[$j]->third_account_type == 2)
                        $user->weibo = '绑定';
            }
        
        if($user->address != null) {
            $provice_arr = strChangeArr($user->address,EXPLODE_STR);
            $provice = DictRegion::getAllArea();
            $provice_name=$this->findAddress($provice_arr[0],$provice);
            $city_name = $this->findAddress($provice_arr[1],$provice);
        }
        if($user->industry != null){
            $insutry = strChangeArr($user->industry,EXPLODE_STR);
            $insutrys = DictInsutry::getAllIndustry();
            if($insutry != null)
                for($i = 0;$i<sizeof($insutry);$i++){
                    $return_ins.= $this->findIndustry(intval($insutry[$i]),$insutrys);
                }
        }
        $sname = DictSchooling::getSchoolingById($user->schooling_id);
        $user->schooling_id = empty($sname) ? '' : $sname->name;
        
        $user->address = $provice_name.$city_name;
        $user->industry = $return_ins;
        $user->head_portrait = splicingImgStr('front','user',$user->head_portrait);
        return !empty($user) ? responseToJson(0,'success',[$user,$activity_names]) : responseToJson(1,'no data');
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
    
        $thread =  user_third_accounts::getTypeOfThread([$request->id]);
        $user->weixin = '未绑定';
        $user->weibo = '未绑定';
        if($thread != null)
            for($j = 0;$j<sizeof($thread);$j++){
                if($user->user_account_id == $thread[$j]->user_account_id)
                    if($thread[$j]->third_account_type == 1)
                        $user->weixin = '绑定';
                    else if($thread[$j]->third_account_type == 2)
                        $user->weibo = '绑定';
            }
        if($user->address != null) {
            $provice_arr = strChangeArr($user->address,EXPLODE_STR);
            $provice = DictRegion::getAllArea();
            $provice_name=$this->findAddress($provice_arr[0],$provice);
            $city_name = $this->findAddress($provice_arr[1],$provice);
        }
        if($user->industry != null){
            $insutry = strChangeArr($user->industry,EXPLODE_STR);
            $insutrys = DictInsutry::getAllIndustry();
            if($insutry != null)
                for($i = 0;$i<sizeof($insutry);$i++){
                    $return_ins.= $this->findIndustry(intval($insutry[$i]),$insutrys);
                }
        }
        $user->address = $provice_name.$city_name;
        $user->industry = $return_ins;
        $user->head_portrait = splicingImgStr('front','user',$user->head_portrait);
        return !empty($user) ? responseToJson(0,'success',[$user,$major_names]) : responseToJson(1,'no data');
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
    
        $thread =  user_third_accounts::getTypeOfThread([$request->id]);
        $user->weixin = '未绑定';
        $user->weibo = '未绑定';

        if($thread != null)
            for($j = 0;$j<sizeof($thread);$j++){
                if($user->user_account_id == $thread[$j]->user_account_id)
                    if($thread[$j]->third_account_type == 1)
                        $user->weixin = '绑定';
                    else if($thread[$j]->third_account_type == 2)
                        $user->weibo = '绑定';
            }
        if($user->address != null) {
            $provice_arr = strChangeArr($user->address,EXPLODE_STR);
            $provice = DictRegion::getAllArea();
            $provice_name=$this->findAddress($provice_arr[0],$provice);
            $city_name = $this->findAddress($provice_arr[1],$provice);
        }
        if($user->industry != null){
            $insutry = strChangeArr($user->industry,EXPLODE_STR);
            $insutrys = DictInsutry::getAllIndustry();
            if($insutry != null)
                for($i = 0;$i<sizeof($insutry);$i++){
                    $return_ins.= $this->findIndustry(intval($insutry[$i]),$insutrys);
                }
        }
        $user->address = $provice_name.$city_name;
        $user->industry = $return_ins;
        $user->head_portrait = splicingImgStr('front','user',$user->head_portrait);
        return !empty($user) ? responseToJson(0,'success',[$user,$coupon_names]) : responseToJson(1,'no data');
    }
    
    public function getOneUser(Request $request){
        $judge = $this->judgeGetOneMsg($request);
        if(!empty($judge))
            return $judge;
    
    
        $school = dict_education::getAllSchooling();
        $school_arr = [];
        if($school != null)
            for($i = 0;$i<sizeof($school);$i++){
                $school_arr[$school[$i]->id] = $school[$i]->name;
            }
        
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
    
        $thread =  user_third_accounts::getTypeOfThread([$request->id]);
        $user->weixin = '未绑定';
        $user->weibo = '未绑定';
        if($thread != null)
            for($j = 0;$j<sizeof($thread);$j++){
                if($user->user_account_id == $thread[$j]->user_account_id)
                    if($thread[$j]->third_account_type == 1)
                        $user->weixin = '绑定';
                    else if($thread[$j]->third_account_type == 2)
                        $user->weibo = '绑定';
            }
        if($user->industry != null){
            $insutry = strChangeArr($user->industry,EXPLODE_STR);
            $insutrys = DictInsutry::getAllIndustry();
            if($insutry != null)
                for($i = 0;$i<sizeof($insutry);$i++){
                    $return_ins.= $this->findIndustry(intval($insutry[$i]),$insutrys);
                }
        }
        $user->address = $provice_name.$city_name;
        $user->industry = $return_ins;
        $user->schooling_id = $school_arr[$user->schooling_id];
        $user->head_portrait = splicingImgStr('front','user',$user->head_portrait);
        $activity_names = $this->getActivityNames($request);
        $major_names = $this->getMajorNames($request);
        $coupon_names = $this->getCouponNames($request);
        $data = [$user,$activity_names,$major_names,$coupon_names];
        return !empty($user) ? responseToJson(0,'success',$data) : responseToJson(1,'no data');
    }
    
    public function createActivityExcel(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $provice = DictRegion::getAllArea();
        $schooling = DictSchooling::getAllSchooling();
        $insutrys = DictInsutry::getAllIndustry();
        $data = $result = UserInformation::getInformation('','','',1,MAX_INTEGER,0)[0];
        
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
        $data = $result = UserInformation::getInformation('','','',1,MAX_INTEGER,'',1)[0];
//        dd($data);
        $datas = [['院校专业id','院校专业名称','账户id',
            '电话号码','头像','用户名',
            '真实姓名','性别','地址',
            '学历','毕业院校','行业','工作年限','创建时间']];
    
        $datas =  $this->resultObjToArray($data,$datas,$provice,$schooling,$insutrys);
//        dd($datas);
        $this->createExcel($datas);
    }
    
    public function createCouponExcel(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,METHOD_ERROR);
        
        $provice = DictRegion::getAllArea();
        $schooling = DictSchooling::getAllSchooling();
        $insutrys = DictInsutry::getAllIndustry();
        $data = $result = UserInformation::getInformation('','','',1,MAX_INTEGER,2)[0];
        
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
        $data = $result = UserInformation::getInformation('','','',1,MAX_INTEGER,3)[0];
        
        $datas = [['账户id',
            '电话号码','头像','用户名',
            '真实姓名','性别','地址',
            '学历','毕业院校','行业','工作年限']];
    
        $datas =  $this->resultObjToArray($data,$datas,$provice,$schooling,$insutrys);
        
        $this->createExcel($datas);
    }
    
    
    public function getAccountLoginMsg(Request $request){
        
        if(!isset($request->account))
            return responseToJson(1,'没有账号');
        
        $account =  admin_accounts::getLoginTime($request->account);
        date_default_timezone_set("Asia/Shanghai");
        $last_time =  date('Y-m-d H:i:s',$account->last_login);
        $now_time =date('Y-m-d H:i:s',$account->now_login);
//      $request->getClientIp()
//       dd( $this->GetIpLookup('47.105.38.74'));
        $ip =$request->ip();
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip={$ip}";//淘宝
        //$res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);//新浪
        $ipmsg = geoip($ip);
        
        return responseToJson(0,'success',['last_time'=>$last_time,'now_time'=>$now_time,'city'=>$ipmsg['city'],'ip'=>$ip]);
    }
    
    public function  getAllArea(){
        return responseToJson(0,'success',[DictRegion::getAllArea()]);
    }
}