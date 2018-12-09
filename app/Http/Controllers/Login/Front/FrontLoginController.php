<?php
namespace App\Http\Controllers\Login\Front;
 
use Cookie;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Auto\Sms\SmsController;

use App\Models\user_accounts as UserAccounts;
use App\Models\user_information as UserInformation;
class FrontLoginController extends Controller {


    /**
     * 用户登录
     * @param $userPhone 用户手机号
     * @param $userPassword 密码
     * @param $smsCode 手机验证码
     * @param $type 登录类型 0是账号密码登录; 1是短信验证码登录
     * @param $agree 是否同意注册　0不同意;1同意
     */
    public function login(Request $request) {
        $user_phone = $request->userPhone;
        $user = UserAccounts::getAppointUser($user_phone);
        
        if($request->type == 0) {
            if($user) {
                if($user->password == encryptPassword($request->userPassword)) {
                    loginSuccess($request, $user_phone);
                    $user_info = UserInformation::getUserViewsInfo($user->id);
                    if($user_info->head_portrait != '') $user_info->head_portrait = splicingImgStr('front', 'user', $user_info->head_portrait);
                    return responseToJson(0, 'success', $user_info);
                }
                else {
                    return responseToJson(1, '账号或密码错误');
                }
            }
            else {
                return $this->judgeAgree($request, $user_phone);
            }
        }
        else if($request->type == 1) {
            if($request->smsCode == Redis::get(getUserStatusString($user_phone, 1))) {
                if($user) {
                    loginSuccess($request, $user_phone);
                    $user_info = UserInformation::getUserViewsInfo($user->id);
                    if($user_info->head_portrait != '') $user_info->head_portrait = splicingImgStr('front', 'user', $user_info->head_portrait);
                    return responseToJson(0, 'success', $user_info);
                }
                else {
                    return $this->judgeAgree($request, $user_phone);
                }
            }
            else {
                return responseToJson(1, '验证码错误');
            }
        }
    }


    /**
     * 用户是否同意注册
     * 
     */
    private function judgeAgree($request, $userPhone) {
        if(isset($request->agree) && $request->agree == 0) {
            return responseToJson(3, '您没有注册，确定注册吗？');
        }
        else if(isset($request->agree) && $request->agree == 1) {
            $insert_id = UserAccounts::insertUserAccount($userPhone);
            if($insert_id) {
                loginSuccess($request, $userPhone);
                return responseToJson(0, '创建成功', $insert_id);
            }
            else return responseToJson(1, '创建用户失败');
        }
    }


    /**
     * 登录成功存储用户会话状态
     */
    // private function loginSuccess($request, $userPhone) {
    //     Redis::set(getUserStatusString($userPhone, 0), 1);

    //     if(!Redis::exists(getUserStatusString($userPhone, 0))) {
    //         $session = $request->session();
    //         $session->put(getUserStatusString($userPhone, 0), 1);
    //         Cookie::queue(getUserStatusString($userPhone, 0),1,time()+60*60*60*24);
    //     }

    //     return true;
    // }


    /**
     * 消除用户的会话状态
     */
    public function loginOut(Request $request) {
        // dd(Redis::exists(getUserStatusString($request->userPhone, 0))); 
        if(Redis::exists(getUserStatusString($request->userPhone, 0))) {
            Redis::del(getUserStatusString($request->userPhone, 0));
        }
        else {
            $session = $request->session();
            if($session->get(getUserStatusString($request->userPhone, 0))) {
                $session->forget(getUserStatusString($request->userPhone, 0));
            }
        }
        return responseToJson(0, '退出成功');
    }


    /**
     * 用于向用户发送短信验证码
     */
    public function sendSmsCode(Request $request) {
        if($this->judgeIsPhone($request->userPhone)) {
            $code = generateCode();
            Redis::setex(getUserStatusString($request->userPhone, 1), 1000, $code);
            $is_send = SmsController::sendSms($request->userPhone, ['code' => $code], 'MBA小助手短信验证');
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
     * 用户手机号注册
     * @param $userPhone　用户手机号
     * @param $smsCode 短信验证码
     * @param $agree 是否同意注册　0不同意;1同意
     */
    public function register(Request $request) {
        return $this->verificationCallBack(function($request) {
            $user = UserAccounts::getAppointUser($request->userPhone);
            if($user) {
                loginSuccess($request, $request->userPhone);
                return responseToJson(2, '已注册');
            }
            else {
                return $this->judgeAgree($request, $request->userPhone);
            }
        }, $request);

    }



    /**
     * 对于重置密码和注册用户接口的封装
     */
    private function verificationCallBack(callable $callback, $request) {
        if($this->judgeIsPhone($request->userPhone)) {
            if(Redis::exists(getUserStatusString($request->userPhone, 1))) {
                if($request->smsCode == Redis::get(getUserStatusString($request->userPhone, 1))) {
                    return $callback($request);
                }
                else return responseToJson(1, '验证码不正确');
            }
            else return responseToJson(1, '短信验证码失效');
        }
        else return responseToJson(1, '手机号格式不正确');
    }

    /**
     * 用户重置设置密码
     * @param $userPhone 用户手机号
     * @param $smsCode 短信验证码
     * @param $newPass 新密码
     * @param $againNewPass 再次输入新密码
     */
    public function resetUserPassWord(Request $request) {
        return $this->verificationCallBack(function($request) {
            try {
                if(trim($request->newPass) == trim($request->againNewPass)) {
                    if(mb_strlen($request->againNewPass, 'utf-8') >= 8 && mb_strlen($request->againNewPass, 'utf-8') <= 16) {
                        $user = UserAccounts::getAppointUser($request->userPhone);
                        if($user) {
                            if($user->password != encryptPassword(trim($request->againNewPass))) {
                                $is_update = UserAccounts::updateUserPassword($request->userPhone, trim($request->againNewPass));
                                if($is_update) return responseToJson(0, '修改成功');
                                else throw new \Exception('密码修改失败，请重新尝试');
                            }
                            else throw new \Exception('新密码不应与之前的密码相同');
                        }
                        else throw new \Exception('没有该用户');
                    }
                    else throw new \Exception('新密码应该在8-16位之间');
                }
                else throw new \Exception('两次输入的密码不同');
            } catch(\Exception $e) {
                return responseToJson(1, $e->getMessage());
            }
        }, $request);

    }


}