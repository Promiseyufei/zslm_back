<?php

/**
 * 发消息
 */

namespace App\Http\Controllers\Admin\News;


use App\Http\Controllers\Auto\Sms\SmsController;
use App\Models\zslm_activitys as ZslmActivitys;
use App\Models\user_accounts as UserAccounts;
use App\Models\zslm_major as ZslmMajor;
use App\Models\news_users as NewsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\news as News;

use DB;

class SendNewsController extends Controller 
{



    /**
     * @api {post} admin/news/getAllAccounts 获取全部用户
     * 
     * @apiGroup news
     * 
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} pageNumber 跳转页面下标
     * 
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "account":"账号(手机号)",
     *              "user_name":"用户昵称",
     *              "real_name":"真实姓名",
     *              "sex":"性别",
     *              "address":"居住省市(常住地)",
     *              "schooling_id":"最高学历",
     *              "graduate_school":"毕业学校",
     *              "industry":"所属行业",
     *              "worked_year":"工作年限",
     *              "is_weixin":"0/1(是/否)",
     *              "is_weibo":"0/1(是/否)",
     *              "create_time":"账户创建时间",
     *              "update_time":"信息更新时间",
     *              "head_portrait":"头像:自定义/系统默认"
     *              
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function getAllAccounts(Request $request) {

        $page_count = (isset($request->pageCount) && is_numeric($request->pageCount)) ? $request->pageCount : 0;
        $page_num = (isset($request->pageNumber) && is_numeric($request->pageNumber)) ? $request->pageNumber : 10;

        $get_all_user = UserAccounts::getAllAccounts($page_count, $page_num);

        SendNewsController::setProvinceCity($get_all_user);

        return ((is_array($get_all_user) || is_object($get_all_user)) && count($get_all_user) > 0) ? responseToJson(0, '', $get_all_user) : responseToJson(1, '未查询到用户数据');

    }

    public static function setProvinceCity(&$get_all_user) {

        $province = getMajorProvincesAndCity()[0];

        foreach($get_all_user['map'] as $key => $item) {
            if($item->address != null) {
                $get_all_user['map'][$key]->address = strChangeArr($item->address, ',');
                foreach($province[$item->address[0]]->citys as $value) 
                    if($item->address[1] == $value->id) $get_all_user['map'][$key]->address[1] = $value->name;
    
                $get_all_user['map'][$key]->address[0] = $province[$item->address[0]]->name;
                $get_all_user['map'][$key]->address = $get_all_user['map'][$key]->address[0] . '-' . $get_all_user['map'][$key]->address[1];
            }
            $get_all_user['map'][$key]->create_time = date("Y-m-d H:i",$item->create_time);
            if($item->update_time != null)  $get_all_user['map'][$key]->update_time = date("Y-m-d H:i",$item->update_time);
            ($item->head_portrait != "") ? ($get_all_user['map'][$key]->head_portrait = "自定义") : ($get_all_user['map'][$key]->head_portrait = "系统默认");
        }

    }




    /**
     * @api {post} admin/news/batchScreenAccounts 批量筛选用户
     * @apiGroup news
     * 
     * @apiParam {Array} majorIdArr 院校专业id数组
     * @apiParam {Array} activityIdArr 活动id数组
     * @apiParam {Number} condition 筛选条件(当同时选择院校专业和活动时进行选择筛选条件．０需同时满足两个条件；１满足以上任意一个条件即可)
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} pageNumber 跳转页面下标
     * 
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "account":"账号(手机号)",
     *              "user_name":"用户昵称",
     *              "real_name":"真实姓名",
     *              "sex":"性别",
     *              "address":"居住省市(常住地)",
     *              "schooling_id":"最高学历",
     *              "graduate_school":"毕业学校",
     *              "industry":"所属行业",
     *              "worked_year":"工作年限"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function batchScreenAccounts(Request $request) {

        $major_arr = is_array($request->majorIdArr) ? $request->majorIdArr : [];

        $activity_arr = is_array($request->activityIdArr) ? $request->activityIdArr : [];
        
        $condition  = is_numeric($request->condition) ? $request->condition : -1;
        
        $page_count = ($request->pageCount ?? false) ? $request->pageCount : 10;
        
        $page_num = ($request->pageNumber ?? false) ? $request->pageNumber : 0;
        // dd($activity_arr);
        if(count($major_arr) < 1 && count($activity_arr) < 1) return responseToJson(1, '请选择数据');
        
        if(isset($major_arr) && isset($activity_arr) && $condition < 0) return responseToJson(1, '请选择专业和活动的关系');

        var_dump([
            'page_num'      => $page_num,
            'condition'     => $condition,
            'major_arr'     => $major_arr,
            'page_count'    => $page_count,
            'activity_arr'  => $activity_arr
        ]);
        $get_users_msg = UserAccounts::getBatchAccounts([
            'page_num'      => $page_num,
            'condition'     => $condition,
            'major_arr'     => $major_arr,
            'page_count'    => $page_count,
            'activity_arr'  => $activity_arr
        ]);

        return (is_array($get_users_msg) && count($get_users_msg) > 0) ? responseToJson(0, '', $get_users_msg) : responseToJson(1, '没有指定的用户');

    }




    /**
     * @api {post} admin/news/manualSelectionAccounts 手动选择用户
     * 
     * @apiGroup news
     * 
     * @apiParam {String} keyWord 账号/昵称/真实姓名关键字
     * @apiParam {Number} sex 用户性别id
     * @apiParam {Number} condition 筛选条件(当同时选择院校专业和活动时进行选择筛选条件．０需同时满足两个条件；１满足以上任意一个条件即可)
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} pageNumber 跳转页面下标
     * 
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "account":"账号(手机号)",
     *              "user_name":"用户昵称",
     *              "real_name":"真实姓名",
     *              "sex":"性别",
     *              "address":"居住省市(常住地)",
     *              "schooling_id":"最高学历",
     *              "graduate_school":"毕业学校",
     *              "industry":"所属行业",
     *              "worked_year":"工作年限"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function manualSelectionAccounts(Request $request) {

    }





    /**
     * @api {post} admin/news/getNewNewsMessage 获得新消息的信息并发送
     * 
     * @apiGroup news
     * 
     * @apiParam {Array} userArr 发送用户的id数组
     * @apiParam {Number} carrier 消息载体类型(0：短信形式；1：站内信形式；2：短信+站内信)
     * @apiParam {Number} type 消息类型(0：无，默认；1：个人助手类；2：系统消息类；3：院校动态类（只能发站内信）)
     * @apiParam {String} title 消息标题
     * @apiParam {String} context 消息正文
     * @apiParam {String} url 相关链接
     * 
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "account":"账号(手机号)",
     *              "user_name":"用户昵称",
     *              "real_name":"真实姓名",
     *              "sex":"性别",
     *              "address":"居住省市(常住地)",
     *              "schooling_id":"最高学历",
     *              "graduate_school":"毕业学校",
     *              "industry":"所属行业",
     *              "worked_year":"工作年限"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function getNewNewsMessage(Request $request) {


        if(!$request->isMethod('post')) return responseToJson(2, '请求方式失败');

        $user_arr = (isset($request->userArr) && is_array($request->userArr)) ? $request->userArr : [];

        $carrier = (($request->carrier ?? false) && is_numeric($request->carrier)) ? $request->carrier : -1;

        $type = (($request->type ?? false) && is_numeric($request->type)) ? $request->type : -1;
        
        $title = (trim($request->title) ?? false) ? trim($request->title) : null;
        $context = (trim($request->context) ?? false) ? trim($request->context) : null;

        $url = (trim($request->url) ?? false) ? trim($request->url) : null;

        $pattern='@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|([\s()<>]+|(\([\s()<>]+))*\))+(?:([\s()<>]+|(\([\s()<>]+))*\)|[^\s`!(){};:\'".,<>?«»“”‘’]))@';

        if(count($user_arr) < 1 || $carrier < 0 || $type < 0 || empty($title) || empty($context) || empty($url)) 
            return responseToJson(1, '请将信息进行完善');
        else if(!preg_match($pattern, $url)) 
            return responseToJson(1, '网址格式不正确');
        else if($carrier > 0 && $type <1) 
            return responseToJson(1, '请选择消息类型');
        else if($carrier == 2 && $type == 3)
            return responseToJson(1, '院校动态类消息只能发站内信');
        
        $create_news_id = News::createNews([
            'carrier'       => $carrier,
            'news_title'    => $title,
            'context'       => $context,
            'url'           => $url,
            'type'          => $type,
            'create_time'   => time()
        ]);

        $msg = [
            'user_arr'       => $user_arr,
            'carrier'        => $carrier,
            'type'           => $type,
            'title'          => $title,
            'context'        => $context,
            'create_news_id' => $create_news_id
        ];

        return $create_news_id ? $this->sendNews($msg) : responseToJson(1, '发送失败');

        
        

    }
    
    /**
     * 先向信息表中插入消息，并得到id
     * 根据用户id数组向news_user中插入多条记录
     * 首先在消息表中插入记录，但是这时候这条消息的状态为未发送成功．
     * 然后开启事务，如果多条信息插入到news_user中成功，并调用回调将消息记录的状态改为发送成功，若失败返回，但是消息记录中还是存在该条消息
     * 如果有短信根据状态码进行判断
     * １．如果只发短信，插入数据库，进行群发，然后判断状态码，如果成功则回调将消息状态改为成功
     * ２．如果发站内信，则看上面
     * ３．短信＋站内信，同时成功才改变状态
     * 
     */
    //注意消息载体类型和消息类型的关系，当发送短信时需要调用短信接口
    //当进行站内信的时候开启事务，如果一条发送失败，则这条消息插入数据库，但是这条消息发送状态为失败．对于短信，发送状态不随短信的全部发送成功有关系，看看能不能调用短信查询接口
    private function sendNews($newsMsg) {
        $user_phone_arr = UserAccounts::getAppointUserPhone($newsMsg['user_arr']);

        $sms_message = [];

        if(count($user_phone_arr) == 1)
            array_merge($sms_message, [
                'title' => $newsMsg['title'],
                'context' => (strip_tags(mb_strlen($newsMsg['context']), 'utf-8') > 20) ? (strip_tags(mb_substr($newsMsg['context']), 0, 20, 'gb2312') . '...') : strip_tags($newsMsg['context']),
                // 'url' => $url
            ]);
        else
            for($i = 0; $i < count($user_phone_arr); $i++) 
                array_push($sms_message, [
                    'title' => $newsMsg['title'],
                    'context' => (strip_tags(mb_strlen($newsMsg['context']), 'utf-8') > 20) ? (strip_tags(mb_substr($newsMsg['context']), 0, 20, 'gb2312') . '...') : strip_tags($newsMsg['context']),
                    // 'url' => $url
                ]);
        
        switch($newsMsg['carrier'])
        {
            case 0:
                $status = $this->sendSms($user_phone_arr, $sms_message, $newsMsg) && $this->updateNewsStatus($newsMsg['create_news_id']);
                return $status ? responseToJson(0, '发送成功') : responseToJson(1, '发送失败');
            case 1:
                $status = $this->createNewsUser($newsMsg) && $this->updateNewsStatus($newsMsg['create_news_id']);
                return $status ? responseToJson(0, '发送成功') : responseToJson(1, '发送失败');
            case 2:
                $status = $this->createNewsUser($newsMsg) && $this->sendSms($user_phone_arr, $sms_message, $newsMsg) && $this->updateNewsStatus($newsMsg['create_news_id']);
                return $status ? responseToJson(0, '发送成功') : responseToJson(1, '发送失败');
        }
        
    }

    private function sendSms($user_phone_arr, $sms_message, $newsMsg) {
        $response = count($user_phone_arr) == 1 ? SmsController::sendSms($user_phone_arr[0], $sms_message, '') : SmsController::sendBatchSms($user_phone_arr, '', $sms_message);

        return ($response->Message == 'OK' && $response->Code == 'OK') ? true : false;
    }

    private function createNewsUser($newsMsg) {
        $now_time = time();
        $news_user_arr = [];
        foreach($newsMsg['user_arr'] as $key => $value) 
            array_push($news_user_arr, [
                'news_id' => $newsMsg['create_news_id'], 
                'user_id' => $value, 
                'create_time' => $now_time
                ]);

        $is_create = NewsUsers::createNewsRelationUser($news_user_arr);

        return $is_create ? true : false;
    }



    //批量筛选时获得所有院校专业
    public function getAllMajorDict(Request $request) {

        return responseToJson(0, '', ZslmMajor::getAllDictMajor());
    }



    //批量筛选时获得所有的活动
    public function getAllActivityDict(Request $request) {
        return responseToJson(0, '', ZslmActivitys::getAllActivity(['id', 'active_name']));
    }


    //回调函数，用于修改消息发送状态
    private function updateNewsStatus($newsId) {

        return News::updateStatus($newsId);
    }









}