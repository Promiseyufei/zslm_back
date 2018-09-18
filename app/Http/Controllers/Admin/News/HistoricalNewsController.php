<?php

/**
 * 历史消息
 */

namespace App\Http\Controllers\Admin\News;

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

        $keywords = (($request->newTitleKeywords ?? false) && is_string($request->newTitleKeywords)) ? trim($request->newTitleKeywords) : '';
        $start_time = isset($request->startTime) ? strtotime($request->startTime) : 0;
        $end_time = isset($request->endTime) ? strtotime($request->endTime) : 0;
        $page_count = (isset($request->pageCount) && is_numeriic($request->pageCount)) ? $request->pageCount : 0;
        $page_num = (isset($request->pageNumber) && is_numeric($request->pageNumber)) ? $request->pageNumber : -1;

        if($keywords == '' || $start_time == 0 || $end_time == 0 || ($start_time > $end_time) || $page_count == 0 || $page_num < 0) return responseToJson(1, '参数错误');

        $get_all_news_msg = News::selectAllNewsMsg($keywords, $start_time, $end_time, $page_count, $page_num);
        dd($get_all_news_msg);

        return (is_array($get_all_news_msg) && !empty($get_all_news_msg)) ? responseToJson(0, '', $get_all_news_msg) : responseToJson(1, '查询失败');



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