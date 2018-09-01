<?php

/**
 * 辅导机构管理
 */

namespace App\Http\Controllers\Admin\Information;

use App\Http\Requests\CoachCreateRequest;
use App\Http\Requests\CoachUpdateRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CoachOrganizeController extends Controller 
{
    

    /**
     * @api {post} admin/information/getPageCoachOrganize 获取活动列表页分页数据
     * @apiGroup information
     * 
     * 
     * @apiParam {String} soachNameKeyword 辅导机构名称关键字
     * @apiParam {Number} screenType 筛选方式(0按展示状态；1按推荐状态;2是否支持优惠券；3是否支持退款；4全部)
     * @apiParam {Number} screenState 筛选状态(0展示/推荐/支持优惠券/支持退款；1不展示/不推荐/不支持优惠券/不支持退款;2全部)
     * @apiParam {Number} sortType 排序类型(0按权重升序；1按权重降序;2按信息更新时间)
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
     *              "coach_name":"辅导机构名称",
     *              "weight":"辅导机构权重",
     *              "is_show":"是否展示",
     *              "is_recommend":"是否推荐",
     *              "father_id":"辅导结构类别(０是总部，非零为分校)",
     *              "province":"所在省市",
     *              "phone":"联系电话",
     *              "address":"具体地址",
     *              "web_url":"网址",
     *              "coach_type":"辅导形式",
     *              "if_coupons":"是否支持优惠券",
     *              "if_back_money":"是否支持退款",
     *              "update_time":"信息更新时间"
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
    public function getPageCoachOrganize(Request $request) {

    }



    /**
     * @api {post} admin/information/getPageCoachCount 获取辅导机构列表页分页数据总数
     * @apiGroup information
     * 
     * 
     * @apiParam {Array} conditionArr 筛选条件
     * 
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *         count:240
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
    public function getPageCoachCount(Request $request) {

    }




    /**
     * @api {post} admin/information/setAppointCoachState 设置辅导机构状态(权重，展示状态，推荐状态)
     * @apiGroup information
     *
     * @apiParam {Number} coachId 指定辅导机构的id
     * @apiParam {Number} type 要修改的状态类型(0修改权重；１修改展示状态；２修改推荐状态)
     * @apiParam {Number} state 要修改的值
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "更新成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setAppointCoachState(Request $request) {

    }



    /**
     * @api {get} admin/information/selectCoachReception 跳转到前台对应的辅导机构主页
     * @apiGroup information
     *
     * @apiParam {Number} coachId 指定辅导机构的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * 重定向到前台对应的活动详情页
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '跳转失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function selectCoachReception(Request $request) {

    }




    /**
     * @api {post} admin/information/updateCoachMessage 编辑辅导机构的信息
     * @apiGroup information
     *
     * @apiParam {Number} coachId 指定辅导机构的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "更新成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function updateCoachMessage(CoachUpdateRequest $request) {

    }




    /**
     * @api {post} admin/information/deleteAppointCoach 删除指定的辅导机构(注意删除总校时所有的分校也需要删除)
     * @apiGroup information
     *
     * @apiParam {Number} coachId 指定辅导机构的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "删除成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function deleteAppointCoach(Request $request) {

    }




    /**
     * @api {get} admin/information/getAllBranchCoach 查看指定总校的所有分校，注意分页
     * 
     * @apiGroup information
     * 
     * @apiParam {Number} totalCoachId 总部id
     * @apiParam {Number} pageNum 下标
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
     *              "name":"xxxxxxxxxxxx",
     *              "weight":"xxxxxxxxxxxx",
     *              "is_show":"xxxx"
     *              "update_time":"xx"
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
    public function getAllBranchCoach(Request $request) {

    }




        /**
     * @api {post} admin/information/createCoach 创建辅导机构(注意分校/总校的判定)
     * @apiGroup information
     *
     * @apiParam {String} projectName 招生项目名称
     * @apiParam {Float} minCost 招生项目最小费用
     * @apiParam {Float} maxCost 招生项目最大费用
     * @apiParam {String} cost 招生项目费用
     * @apiParam {String} studentCount 招生名额
     * @apiParam {String} language 授课语言
     * @apiParam {String} classSituation 班级情况
     * @apiParam {Number} eductionalSystme 学制
     * @apiParam {String} canConditions 报考条件
     * @apiParam {String} scoreDescribe 分数线描述
     * @apiParam {String} graduationCertificate 毕业证书
     * @apiParam {Number} recruitmentPattern 统招模式
     * @apiParam {Number} enrollmentMode 招生模式
     * @apiParam {Number} professionalDirection 专业方向
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "创建成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */ 
    public function createCoach(CoachCreateRequest $request) {

    }


    private function createDirImg() {

    }


    private function updateDirImgName() {

    }


}