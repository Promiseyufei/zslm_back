<?php
namespace App\Http\Controllers\Login\Front;
 
use Cookie;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Auto\Sms\SmsController;

use App\Models\user_accounts as UserAccounts;
class FrontLoginController extends Controller{


    /**
     * 用户登录
     * @param $type 登录类型 0是账号密码登录; 1是短信验证码登录
     * @param $agree 是否同意注册　0不同意;1同意
     */
    public function login(Request $request) {
        $user_phone = $request->userPhone;

        if($request->type == 0) {
            $user = UserAccounts::getAppointUser($user_phone);
            if($user) {
                if($user->password == encryptPassword($request->userPassword)) {
                    $this->loginSuccess($request, $user_phone);
                    return responseToJson(0, 'success');
                }
                else {
                    return responseToJson(1, '账号或密码错误');
                }
            }
            else {
                if(isset($request->agree) && $request->agree == 0) {
                    return responseToJson(1, '退出');
                }
                else if(isset($request->agree) && $request->agree ==1) {
                    $insert_id = UserAccounts::insertUserAccount($user_phone);
                    return $insert_id ? responseToJson(0, '创建成功') : responseToJson(1, '创建用户失败');
                }
            }
        }
        else if($type == 1) {

        }
        
    }

    private function loginSuccess($request, $userPhone) {
        Redis::set(getUserStatusString($userPhone, 0), 1);

        if(!Redis::exists(getUserStatusString($userPhone, 0))) {
            $session = $request->session();
            $session->put(getUserStatusString($userPhone, 0), 1);
            Cookie::queue(getUserStatusString($userPhone, 0),1,time()+60*60*60*24);
        }

        return true;
    }

    public function loginOut(Request $request) {
        if(Redis::exists(getUserStatusString($request->userPhone, 0))) {
            Redis::del(getUserStatusString($request->userPhone, 0));
        }
        else {
            $session = $request->session();
            $session->forget(getUserStatusString($request->UserPhone, 0));
        }
        return true;
    }

    public function sendSmsCode(Request $request) {
        $pattern = '/^1[3456789]{1}\d{9}$/';
        if(preg_match($pattern, $request->userPhone)) {
            $code = generateCode();
            Redis::setex(getUserStatusString($request->userPhone, 60, 1));
            $is_send = SmsController::sendSms($request->userPhone, ['code' => $code], config('sms.templateCode')['MBA小助手短信验证'], strRand());
            if($is_send->Message == 'OK' && $is_send == 'OK') {
                return responseToJson(0, '发送成功');
            }
            else return responseToJson(1, '发送失败');

        }
        else return responseToJson(1, '手机号格式不正确');
    }


    public function register(Request $request) {

    }


}