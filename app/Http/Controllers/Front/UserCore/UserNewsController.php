<?php
namespace App\Http\Controllers\Front\UserCore;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserNewsController extends Controller{


    /**
     * 用户中心-我的消息
     * @param 
     * userPhone 用户手机号
     * userNewsType
     * 0院校动态
     * 1小助手消息
     * 2系统消息
     * 
     */
    public function getUserNews(Request $request) {
        if($request->isMethod('get')) {
            $user_phone = !empty($request->userPhone) ? $request->userPhone : '';
            $news_type = is_numeric($request->userNewsType) ? $request->userNewsType : null;
            if($user_phone == '' || $news_type === null) return responseToJson(1, '参数错误');

            

        }
        else return responseToJson(2, '请求方式错误');

    }

}