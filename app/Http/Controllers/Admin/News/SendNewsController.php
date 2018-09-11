<?php

/**
 * 发消息
 */

namespace App\Http\Controllers\Admin\News;

use App\Models\zslm_activitys as ZslmActivitys;
use App\Models\user_accounts as UserAccounts;
use App\Models\zslm_major as ZslmMajor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class NewsController extends Controller 
{


    //将三个方法合一,注意用户过滤




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
    public function getAllAccounts(Request $request) {

        $page_count = (isset($request->pageCount) && is_numeric($request->pageCount)) ? $request->pageCount : 0;
        $page_num = (isset($request->pageNumber) && is_numeric($request->pageNumber)) ? $request->pageNumber : 10;

        $get_all_user = UserAccounts::getAllAccounts($page_count, $page_num);

        $province = $this->getMajorProvincesAndCities($request);

        foreach($get_all_user as $key => $item) {
            $get_all_user[$key]->address = strChangeArr($item->address, ',');
            foreach($province[$item->address[0]]->citys as $value) 
                if($item->address[1] == $value->id) $get_all_user[$key]->address[1] = $value->name;

            $get_all_user[$key]->address[0] = $province[$item->address[0]]->name;
        }

        return (is_array($get_all_user) && count($get_all_user) > 0) ? responseToJson(0, '', $get_all_user) : responseToJson(1, '未查询到用户数据');

    }




    /**
     * @api {post} admin/news/batchScreenAccounts 批量筛选用户
     * @apiGroup news
     * 
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

        $major_arr = (isset($request->majorIdArr) && is_array($request->majorIdArr)) ? $request->majorIdArr : [];

        $activity_arr = (isset($request->activityIdArr) && is_array($request->activityIdArr)) ? $request->activityIdArr : [];
        
        $condition  = (isset($request->condition) && is_numeric($request->condition)) ? $request->condition : -1;
        
        $page_count = ($request->pageCount ?? false) ? $request->pageCount : 10;
        
        $page_num = ($request->pageNumber ?? false) ? $request->pageNumber : 0;
        if(count($major_arr) && count($activity_arr)) return responseToJson(1, '请选择数据');
        
        if(isset($major_arr) && isset($activity_arr) && $condition < 0) return responseToJson(1, '请选择专业和活动的关系');

        UserAccounts::getBatchAccounts();



    }



    //


    /**
     * @api {post} admin/news/batchScreenAccounts 手动选择
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


    //注意消息载体类型和消息类型的关系，当发送短信时需要调用短信接口
    //当进行站内信的时候开启事务，如果一条发送失败，则这条消息插入数据库，但是这条消息发送状态为失败．对于短信，发送状态不随短信的全部发送成功有关系，看看能不能调用短信查询接口
    public function sendNews() {

    }



    //批量筛选时获得所有院校专业
    public function getAllMajorDict(Request $request) {

        return responseToJson(0, '', ZslmMajor::getAllDictMajor());
    }



    //批量筛选时获得所有的活动
    public function getAllActivityDict(Request $request) {
        return responseToJson(0, '', ZslmActivitys::getAllActivity(['id', 'active_name']));
    }









}