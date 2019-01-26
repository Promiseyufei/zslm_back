<?php

/**
 * 历史消息
 */

namespace App\Http\Controllers\Admin\News;


use App\Http\Controllers\Admin\News\SendNewsController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\news as News;
use DB;

class HistoricalNewsController extends Controller 
{


    /**
     * @api {post} admin/news/getScreenNews 获得筛选的消息(注意分页)
     * 
     * @apiGroup news
     * 
     * @apiParam {String} newTitleKeywords 消息标题关键字
     * @apiParam {Time} startTime 开始时间
     * @apiParam {Time} endTime 结束时间
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
     *              "carrier":"消息载体类型",
     *              "type":"消息类型",
     *              "news_title":"消息标题",
     *              "create_time":"发送时间",
     *              "success":"发送状态(0失败，1成功)"
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
    public function getScreenNews(Request $request) {

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $keywords = (isset($request->newTitleKeywords) && is_string($request->newTitleKeywords)) ? trim($request->newTitleKeywords) : '';
        $start_time = !empty($request->startTime) ? strtotime($request->startTime) : 0;
        // dd($start_time);
        // dd(date("Y-m-d",$start_time+1*24*60*60));

        $end_time = !empty($request->endTime) ? strtotime($request->endTime) : 0;
        // dd($end_time);
        $page_count = (isset($request->pageCount) && is_numeric($request->pageCount)) ? $request->pageCount : 0;
        $page_num = (isset($request->pageNumber) && is_numeric($request->pageNumber)) ? $request->pageNumber : -1;
        // if($keywords == '' || $start_time == 0 || $end_time == 0 || ($start_time > $end_time) || $page_count == 0 || $page_num < 0) return responseToJson(1, '参数错误');
        if($page_count == 0 || $page_num < 0) return responseToJson(1, '参数错误');
        $get_all_news_msg = News::selectAllNewsMsg($keywords, $start_time, $end_time, $page_count, $page_num);

        if(!empty($get_all_news_msg['his_news'])) 
            foreach($get_all_news_msg['his_news'] as $key => $item) {
                // 1：个人助手类；2：系统消息类；3：院校动态类（只能发站内信））
                // （0：短信形式；1：站内信形式；2：短信+站内信）
                // (0失败，1成功)
                $get_all_news_msg['his_news'][$key]->type = ($item->type == 1) ? '个人助手类' : ($item->type == 2 ? '系统消息类' : '默认类型');
                $get_all_news_msg['his_news'][$key]->carrier = ($item->carrier == 0) ? '短信' : ($item->carrier == 1 ? '站内信' : '短信、站内信');
                $get_all_news_msg['his_news'][$key]->success = $item->success == 0 ? '成功' : '失败';
            }

        return ((is_array($get_all_news_msg['his_news']) || is_object($get_all_news_msg['his_news']))) ? responseToJson(0, '', $get_all_news_msg) : responseToJson(1, '查询失败');



    }

    /**
     * @api {post} admin/news/getAppointNews 获得指定的消息详情
     * 
     * @apiGroup news
     * 
     * @apiParam {Number} newsId 消息id
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
     *              "news_title":"消息标题",
     *              "context":"消息内容",
     *              "url":"相关链接",
     *              "carrier":"消息载体类型",
     *              "type":"消息类型",
     *              "create_time":"发送时间",
     *              "success":"发送状态"
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
    public function getAppointNews(Request $request) {

        $news_id = (isset($request->newsId) && is_numeric($request->newsId)) ? $request->newsId : 0;


        if($news_id == 0) return responseToJson(1, '参数错误');

        $news = News::getAppointNewsMsg($news_id);

        return (is_object($news) && !empty($news)) ? responseToJson(0, '', $news) : responseToJson(1, '未查询到相关信息');
        
    }

    //admin/news/getAppointUser
    public function getAppointUser(Request $request) {
        $count = (isset($request->pageCount) && is_numeric($request->pageCount)) ? $request->pageCount : 1;
        $num = (isset($request->pageNum) && is_numeric($request->pageNum)) ? $request->pageNum : 10;
        $news_id = (isset($request->newsId) && is_numeric($request->newsId)) ? $request->newsId : 0;

        if($news_id == 0) return responseToJson(1, '参数错误');

        $news_users = News::getAppointNewsToUsers($count, $num, $news_id);

        SendNewsController::setProvinceCity($news_users);

        return ((is_object($news_users['map']) || is_array($news_users['map'])) && !empty($news_users['map'])) ? responseToJson(0, '', $news_users) : responseToJson(1, '未查询到相关信息');
    }


    //获取发送失败消息信息
    public function getFailSendNews(Request $request) {

        $get_fail = News::getAllFailNews();

        return responseToJson(0, 'success', $get_fail);

        // dd($get_fail);



    }


    //导出发送失败的消息信息　
    public function exportNewsExcel(Request $request) {

    }
}