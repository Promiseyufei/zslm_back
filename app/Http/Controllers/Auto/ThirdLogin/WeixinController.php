<?php
/**
 * Created by PhpStorm.
 * User: shanlei
 * Date: 1/6/2017
 * Time: 11:34 AM
 */

namespace App\Http\Controllers\Auto\ThirdLogin;

use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SocialiteProviders\WeixinWeb\Provider;
use App\Models\user_accounts as UserAccounts;
use App\Models\user_information as UserInformation;
use App\Models\user_third_accounts as UserThirdAccounts;
use App\Http\Controllers\Login\Front\FrontLoginController;

define('INDEX_URL', 'http://www.mbahelper.cn/#/front/index/');
class WeixinController extends Controller{

    public function redirectToProvider(Request $request)
    {   
        return Socialite::driver('weixinweb')->with(['reurl' => 'www.mbahelper.cn'])->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user_data = Socialite::with('weixinweb')->stateless()->user();
        if(!empty($user_data) && ($userOpenId = $user_data->getId())) {
           $data = $this->selectThirdAccount($user_data->getId(), 1, $request);
           if(!empty($data)) {
                $data = urlencode(iconv("gb2312", "UTF-8", $data));    
                echo "<script type='text/javascript'>window.location.href ='http://www.mbahelper.cn/#/front/index/"."$data';</script>";
           }
           else echo "<script type='text/javascript'>window.location.href ='http://www.mbahelper.cn/#/front/Login/thirdBind/"."$userOpenId';</script>";
        }
       else echo "<script type='text/javascript'>window.location.href = " . INDEX_URL ."'front/Login/loginRoute/shortMessage';</script>"; 
    }


    /**
     * 检查第三方账号是否已经绑定已有账号
     * 若已绑定，直接登录
     */
    private function selectThirdAccount($userOpenId = '', $type = 0, $request) {
        //已绑定账号
        $user_id = UserThirdAccounts::judgeThirdUser($userOpenId, $type);
        if(!empty($user_id) && is_numeric($user_id)) {
            $user_phone = UserAccounts::getIdToPhone($user_id);
            if(!empty($user_phone)) {
                loginSuccess($request, $user_phone);
                $user = UserInformation::getUserViewsInfo($user_id);
                if(!empty($user->head_portrait)) $user->head_portrait = splicingImgStr('front','user',$user->head_portrait);
                return [0, 'success', $user];
                // return responseToJson(0, 'success', UserInformation::getUserViewsInfo($user_id));
            }
            else return 0;
        }
        else {
            return 0;
            //如果没有绑定，前台输入手机号，然后跳转到bindAccounts()
            // return responseToJson(3, '未绑定账号', $userOpenId);
        }
    }


    /**
     * 用户输入手机号进行绑定
     */
    public function bindAccounts(Request $request) {
        if($request->isMethod('post')) {
            $phone = !empty($request->phone) ? trim($request->phone) : '';
            $user_open_id = !empty($request->userOpenId) ? $request->userOpenId : '';
            if($phone == '' || $user_open_id == '') return responseToJson(1, '参数错误');
            //该手机号已注册
            if($user = UserAccounts::getAppointUser($phone)) {
                // dd($user);
                $is_update = UserThirdAccounts::updateThirdBind($user_open_id, $user->id);
                return $is_update ? responseToJson(0, '绑定成功') : responseToJson(1, '绑定失败');
            }
            else {
                return responseToJson(3, '用户未注册');
            }
        }
        else responseToJson(2, '登录方式错误');
    }


    
}
