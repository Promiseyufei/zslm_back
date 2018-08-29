<?php

/**
 * 分享记录管理
 */

namespace App\Http\Controllers\Admin\Operate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\share as Share;
use DB;

class ShareAdminController extends Controller 
{
    
    /**
     * @api {post} admin/operate/getPagingData 获取分页数据
     * @apiGroup operate
     *
     * @apiParam {Number} pageNumber 跳转页面下标
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} sortType 排序类型(按总浏览量０;按总引流（分享次数）１;按微信分享次数２;按微博分享次数３;按微信浏览量４;按微博浏览量５)
     * @apiParam {NUmber} riseOrDrop 排序方式(0升序；1降序)
     * @apiParam {NUmber} contentType 内容类型(0院校专业主页；1活动详情；2资讯详情；3总量) 
     * @apiParam {String} titleKeyword 标题关键字
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
     *              "name":"xxxxxxxxxxxx",
     *              "wx_count":"xxxxxxxxxxxx",
     *              "wb_count":"xxxxxxxxxxxx",
     *              "wx_browse":"xxxxxxxxxxxx",
     *              "wb_browse":"xxxxxxxxxxxx"
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
    public function getPagingData(Request $request) {

        $page_num = (isset($request->pageNumber) && is_numeric($request->pageNumber)) ? $request->pageNumber : 0; 
        $page_count = (isset($request->pageCount) && is_numeric($request->pageCount)) ? $request->pageCount : 10;
        $sort_type = (isset($request->sortType) && is_numeric($request->sortType)) ? $request->sortType : 0;
        $rise_or_drop = (isset($request->riseOrDrop) && is_numeric($request->riseOrDrop)) ? $request->riseOrDrop : 0;
        $content_type = (isset($request->contentType) && is_numeric($request->contentType)) ? $request->contentType : 3;

        $title_keyword = isset($request->titleKeyword) ? trim($request->titleKeyword) : '';


        $page_data = Share::getAppointToAllShareMsg([
            'page_num'      => $page_num, 
            'page_count'    => $page_count, 
            'sort_type'     => $sort_type, 
            'rise_or_drop'  => $rise_or_drop,
            'content_type'  => $title_keyword,
            'title_keyword' => $title_keyword 
        ]);

        return isset($page_data) ? responseToJson(0, '', $page_data) : responseToJson(1, '请求失败', $page_count);

    }




    /**
     * @api {post} admin/operate/getPagingCount 获得不同类别的分享总数
     * @apiGroup operate
     *
     * @apiParam {Number} type 分享类别
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *      5
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
    public function getPagingCount(Request $request) {
        if($request->isMethod('post')) {
            $type = (isset($request->type) && is_numeric($request->type)) ? $request->type : 3;
            $count = Share::getPageCount($type);
            return $count ? responseToJson(0, '', $count) : responseToJson(1,'请求失败');
        }
        else 
            return responseToJson(2, '请求方式错误');
    }





    
}