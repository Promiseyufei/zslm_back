<?php
namespace App\Http\Controllers\Front\UserCore;
 
use Session;
use Illuminate\Http\Request;
use App\Models\news as News;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Models\news_users as NewsUsers;
use App\Models\dynamic_news as DynamicNews;
use App\Models\user_accounts as UserAccounts;

class UserNewsController extends Controller{


    /**
     * 用户中心-我的消息
     * @param 
     * userPhone 用户手机号
     * userNewsType
     * 3院校动态
     * 1小助手消息
     * 2系统消息
     * 
     * pageCount 页面显示行数
     * pageNumber 页面显示标　从0开始
     * 
     */
    public function getUserNews(Request $request) {
        if($request->isMethod('get')) {
            $user_phone = !empty($request->userPhone) ? $request->userPhone : '';
            $news_type = is_numeric($request->userNewsType) ? $request->userNewsType : null;
            if($user_phone == '' || $news_type === null) return responseToJson(1, '参数错误');
            $user_id = UserAccounts::getAppointUser($user_phone)->id; 
            if(empty($user_id)) return responseToJson(1, '没有该用户');
            switch($news_type) {
                case 3: 
                    $get_dynamic = DynamicNews::getMajorDynamic($user_id, $request->pageCount, $request->pageNumber);
                    // return responseToJson(0, 'success', $get_dynamic);
                    break;
                case 1: 
                case 2:
                    $get_dynamic = NewsUsers::getUserNews($user_id, $request->pageCount, $request->pageNumber, $news_type);
                    foreach($get_dynamic as $key => $item) {
                        $get_dynamic[$key]->context = strip_tags($item->context);
                    }
                    break;
            }
            return !empty($get_dynamic) ? responseToJson(0, 'success', $get_dynamic) : responseToJson(1, '没有查询到数据');
        }
        else return responseToJson(2, '请求方式错误');
    }



    /**
     * 修改某条消息的已读状态
     */
    public function changeNewsStatus(Request $request) {
        if($request->isMethod('post')) {
            $news_id = !empty($request->newsId) ? $request->newsId : 0;
            $user_phone = !empty($request->userPhone) ? $request->userPhone : '';
            if($news_id == 0 || $user_phone == '') return responseToJson(1, '参数错误');
            if(!Redis::get(getUserStatusString($user_phone, 0)) && !Session::get(getUserStatusString($user_phone, 0))) 
                return responseToJson(3, '用户会话已过期，请重新登录');
            $is_update = NewsUsers::changeNewsState($news_id, $user_phone, 1);
            return $is_update ? responseToJson(0, 'success') : responseToJson(1, 'error');
        }
        return responseToJson(2, '请求错误');
    }

}