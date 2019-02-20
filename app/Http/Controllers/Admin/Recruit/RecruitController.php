<?php
namespace App\Http\Controllers\Admin\Recruit;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Auto\Sms\SmsController;

use App\Models\recruit_user as RecruitUser;
use App\Models\recruit_college_project as RecruitCollegeProject;

define('TYPE_ERROR','The request type error');

class RecruitController extends Controller{


    /**
     * 获得招生服务院校信息
     */
    public function getRecruitInfo(Request $request) {
        if($request->isMethod('get')) {
            $pro_simple = !empty($request->pro_simple) ? $request->pro_simple : '';
            if($pro_simple == '') return responseToJson(1, '没有相关招生服务项目的缩略名');
            $re_msg = RecruitCollegeProject::getRecruitMsg($pro_simple);
            if(empty($re_msg)) return responseToJson(1, '没有相关招生服务项目的信息'); 

            $re_msg->back_img = splicingImgStr('admin', 'recruit', $re_msg->back_img);
            $re_msg->pro_logo = splicingImgStr('admin', 'recruit', $re_msg->pro_logo);
            $re_msg->wx_img = splicingImgStr('admin', 'recruit', $re_msg->wx_img);
            $re_msg->pro_auto_logo = splicingImgStr('admin', 'recruit', $re_msg->pro_auto_logo);

            return responseToJson(0, 'success', $re_msg);

        }
        else return responseToJson(2, TYPE_ERROR);
    }


    /**
     * 发送招生服务专题的短信验证码
     */
    public function sendRecruitSmsCode(Request $request) {

        if($request->isMethod('post')) {

            if($this->judgeIsPhone($request->phone)) {
                $code = generateCode();
                Redis::setex(getUserStatusString($request->phone, 3), 1000, $code);
                $is_send = SmsController::sendSms($request->phone, ['code' => $code], 'MBA小助手短信验证');
                if($is_send->Message == 'OK' || $is_send->Code == 'OK') {
                    return responseToJson(0, '发送成功');
                }
                else return responseToJson(1, '发送失败');
            }
            else return responseToJson(1, '手机号格式不正确');
        }
        else return responseToJson(2, TYPE_ERROR);
    }


    /**
     * 正则验证手机号是否正确
     */
    private function judgeIsPhone($userPhone) {
        $pattern = '/^1[3456789]{1}\d{9}$/';

        return preg_match($pattern, $userPhone) ? true : false;
    }



    /**
     * 招生服务专题提交订阅申请
     */
    public function sendRecruit(Request $request) {
        if($request->isMethod('post')) {
            if(empty($request->recruirId)) return responseToJson(1, '没有相关招生服务项目的id');
            else if(!$this->judgeIsPhone($request->phone)) return responseToJson(1, '手机号格式不正确');
            else if(empty($request->smsCode)) return responseToJson(1, '请填写收到的短信验证码');
            else if(($sms_msg = $this->judgeSms($request->phone, $request->smsCode)) && $sms_msg != 'success') return responseToJson(1, $sms_msg);
            else if(empty($request->recruitArr) || !is_array($request->recruitArr)) return responseToJson(1, '请选择招生服务类型');

            $is_set = RecruitUser::judgePhone($request->phone, $request->recruirId) 
                ? RecruitUser::updateRecruitUser($request->phone, $request->recruirId, [
                    'sub_type'   => strChangeArr($request->recruitArr, ','),
                    'sub_time'   => time()
                ]) 
                : RecruitUser::insertRecruitUser([
                    'user_phone' => $request->phone,
                    'pro_id'     => $request->recruirId,
                    'sub_type'   => strChangeArr($request->recruitArr, ','),
                    'sub_time'   => time()
                ]);

            if(!empty($is_set)) {
                $major_name = RecruitCollegeProject::getRecruitAppointMsg($request->recruirId, 'pro_name');
                $open_group = RecruitCollegeProject::isOpenGroupService($request->recruirId);
                // dd($open_group->is_open_group == 0);
                if($open_group->is_open_group == 0) {
                    $is_send = SmsController::sendSms($request->phone, ['major_name' => $major_name], '招生服务专题通知订阅用户');
                    // if($is_send->Message == 'OK' || $is_send->Code == 'OK') {
                    //     return responseToJson(0, '发送成功');
                    // }
                    // else return responseToJson(1, '发送失败');
                }
                else if($open_group->is_open_group == 1) {
                    $is_send = SmsController::sendSms($request->phone, [
                        'major_name' => $major_name, 
                        'gn' => $open_group->group_number, 
                        'gp' => $open_group->group_password
                    ], '招生服务发送入群信息');
                }
                return responseToJson(0, '提交成功');
            }
            else return responseToJson(1, '提交失败');
        }
        else return responseToJson(2, TYPE_ERROR);
    }

    private function judgeSms($phone, $smscode) {
        if(Redis::exists(getUserStatusString($phone, 3))) {
            if($smscode == Redis::get(getUserStatusString($phone, 3))) 
                return 'success';
            else return '验证码错误';
        }
        else return '验证码已过期';
    }

}