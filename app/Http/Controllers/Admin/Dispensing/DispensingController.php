<?php

namespace App\Http\Controllers\Admin\Dispensing;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Models\dispensing_major as DispensingMajor;
use App\Models\dict_region as DictRegion;
use App\Models\dict_major_type as DictMajorType;
use App\Models\dispensing_special as DispensingSpecial;
use App\Models\dict_major_confirm as majorConfirm;
use App\Models\dict_major_follow as majorFollow;
use App\Models\dispensing_project as DispensingProject;
use App\Http\Controllers\Auto\Sms\SmsController;

define('TYPE_ERROR','The request type error');
define('DATA_ERROR','The data format error');

class DispensingController extends Controller{


    /**
     * 获得地区(所有省份)的列表数据
     */
    public function getProvinces(Request $request) {
        if($request->isMethod("get")) {
            return responseToJson(0, '', DictRegion::getDispenProvince());
        }
        else return responseToJson(2, TYPE_ERROR);
    }
    

    /**
     * 获得所有项目(专业类型)的列表数据
     */
    public function getDisPro(Request $request) {
        if($request->isMethod("get")) {
            return responseToJson(0, '', DictMajorType::getDispenMajor());
        }
        else return responseToJson(2, TYPE_ERROR);
    }


    /**
     * 在调剂总页面上订阅调剂通知
     */
    public function subscribe(Request $request) {
        if($request->isMethod("post")) {
            if(count($request->proArr) < 1 || count($request->proArr) > 3) return responseToJson(1, '所选地区最少应最少一个，最多三个');
            else if(count($request->jectArr) < 1 || count($request->jectArr) > 3) return responseToJson(1, '所限项目最少应为一个，最多为两个');
            else if(!preg_match("/^1[345678]{1}\d{9}$/",$request->phone)) return responseToJson(1, '填写正确的手机号');
            $msg = [
                'provinces' => strChangeArr($request->proArr, ','),
                'major_types' => strChangeArr($request->jectArr, ',')
            ];
            $is_set = DispensingSpecial::judgePhone($request->phone, $request->grade) 
                ? DispensingSpecial::updatePhone($request->phone, $request->grade, $msg)
                : DispensingSpecial::insertPhone($request->phone, $request->grade, $msg);
            
            return $is_set ? responseToJson(0, '订阅成功') : responseToJson(1, '订阅失败');
        }
        else return responseToJson(2, TYPE_ERROR);
    }


    /**
     * 获取当前院校专业的信息
     */
    public function getCurrentMajorMsg(Request $request) {
        if($request->isMethod('get')) {
            $major_id = !empty($request->majorId) ? $request->majorId : 0;
            if($major_id == 0) return responseToJson(1, DATA_ERROR);


            $felds = ['id as majorId', 'z_name as major_name', 'magor_logo_name as major_logo',
                'major_follow_id as major_follow', 'major_confirm_id as major_confirm','address', 'telephone', 'wc_image', 'mode', 'mode_intro', 'online_application', 'file_download', 'index_web', 'pg_index_web'];
            
            $major = DispensingMajor::getDiMajorById($major_id,$felds);
            if(sizeof($major) == 0)
                return responseToJson(1,'没有数据');
    
            $fileds = ['id as projectId','project_name','student_count','language','eductional_systme',
                'can_conditions','score_describe','score_type','recruitment_pattern',
                'graduation_certificate','other_explain','cost',"enrollment_mode",
                'class_situation'];
    
            $major_confirms = majorConfirm::getAllMajorConfirm();
            $major_follows = majorFollow::getAllMajorFollow();
            
            if($major[0]->major_confirm != null) {
                $major_confirms_str = strChangeArr($major[0]->major_confirm,EXPLODE_STR);
                $major_confirms_str = changeStringToInt($major_confirms_str);
                $major_confirm = $this->getConfirmsOrFollow($major_confirms_str,$major_confirms);
                $major[0]->major_confirm_id = strChangeArr($major_confirm, ',');
            }
            if($major[0]->major_follow != null) {
                $major_follow_str = strChangeArr($major[0]->major_follow,EXPLODE_STR);
                $major_follow_str = changeStringToInt($major_follow_str);
                $major_follow = $this->getConfirmsOrFollow($major_follow_str,$major_follows);
                $major[0]->major_follow_id = strChangeArr($major_follow, ',');
            }
    
            $major[0]->major_logo = splicingImgStr('admin', 'dispensing', $major[0]->major_logo);
            $major[0]->wc_image = splicingImgStr('admin', 'dispensing', $major[0]->wc_image);
            $major[0]->project = DispensingProject::getDiProjectByMid($major_id, $fileds);
            return responseToJson(0,'success',$major);

        }
        else return responseToJson(2, TYPE_ERROR);
    }


    /**
     * 通过id数组获取院校性质，或者专业认证
     * @param $val_arrl
     * @param $get_arr
     */
    private function getConfirmsOrFollow($val_arrl,$get_arr){
        $result = '';
        for($i = 0;$i < sizeof($val_arrl);$i++){
            $result.=$get_arr[$val_arrl[$i]].',';
        }
        $result =  substr($result, 0, -1) ;
        return $result;
    }



    /**
     * 在调剂院校专业页面上订阅调剂通知
     */
    public function setMajorSubscribe(Request $request) {
        if($request->isMethod('post')) {
            if(!preg_match("/^1[345678]{1}\d{9}$/", $request->phone)) return responseToJson(1, '填写正确的手机号');
            $msg = [
                'major_name' => $request->majorName
            ];
            $is_set = DispensingSpecial::judgePhone($request->phone, $request->grade) 
                ? DispensingSpecial::updatePhone($request->phone, $request->grade, $msg)
                : DispensingSpecial::insertPhone($request->phone, $request->grade, $msg);
            
            return $is_set ? responseToJson(0, '订阅成功') : responseToJson(1, '订阅失败');
        }
        else return responseToJson(2, TYPE_ERROR);
    }


    /**
     * 用于向手机发送短信验证码
     */
    public function sendSmsCode(Request $request) {
        if($this->judgeIsPhone($request->phone)) {
            $code = generateCode();
            Redis::setex(getUserStatusString($request->phone, 1), 1000, $code);
            $is_send = SmsController::sendSms($request->phone, ['code' => $code], 'MBA小助手短信验证');
            if($is_send->Message == 'OK' || $is_send->Code == 'OK') {
                return responseToJson(0, '发送成功');
            }
            else return responseToJson(1, '发送失败');
        }
        else return responseToJson(1, '手机号格式不正确');
    }

    /**
     * 正则验证手机号是否正确
     */
    private function judgeIsPhone($userPhone) {
        $pattern = '/^1[3456789]{1}\d{9}$/';

        return preg_match($pattern, $userPhone) ? true : false;
    }


    /**
     * 判断短信验证码是否正确且有效
     */
    public function judgeSms(Request $request) {
        if($request->isMethod('post')) {
            if($request->smCode == '') return responseToJson(1, "验证码为空!");
            if(Redis::exists(getUserStatusString($request->phone, 1))) {
                if($request->smCode == Redis::get(getUserStatusString($request->phone, 1))) 
                    return responseToJson(0, 'success');
                else return responseToJson(1, '验证码错误');
            }
            else return responseToJson(1, '验证码已过期');
        }
        else return responseToJson(2, TYPE_ERROR);
    }




}
