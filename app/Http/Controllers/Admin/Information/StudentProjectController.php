<?php

/**
 * 招生项目管理
 */

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\major_recruit_project as MajorRecruitProject;

use App\Http\Requests\StudentProjectUpdateRequest;
use App\Http\Requests\StudentProjectCreateRequest;
use Validator;
use DB;

class StudentProjectController extends Controller 
{



    /**
     * @api {get} admin/information/getAllProject 获得指定专业的招生项目（注意需要分页）
     * @apiGroup information
     * 
     * 
     * @apiParam {Number} majorId 专业id
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
    public function getAllProject(Request $request) {
        if(!$request->isMethod('get')) return responseToJson(2, '请求方式错误');
        $major_id = (isset($request->majorId) && is_numeric($request->majorId)) ? $request->majorId : 0;
        $page_num = (isset($request->pageNum) && is_numeric($request->pageNum)) ? $request->pageNum : 0;

        if(!empty($major_id)) {
            $app_proect = MajorRecruitProject::getAppointProject($major_id, $page_num);

            return is_array($app_proect) ? responseToJson(0, '', $app_proect) : responseToJson(1, '查询失败');
        }
        else 
            return responseToJson(1, '参数错误');
    } 



    /**
     * @api {post} admin/information/updateAppointProjectMsg 编辑指定招生项目信息
     * @apiGroup information testbbb
     * 
     * 
     * @apiParam {Number} projectId 招生项目id
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
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "更新成功",
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
    public function updateAppointProjectMsg(StudentProjectUpdateRequest $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        try {
            $updateMsg = [
                'project_name'           => $request->projectName,
                'min_cost'               => $request->minCost,
                'max_cost'               => $request->maxCost,
                'cost'                   => $request->cost,
                'student_count'          => $request->studentCount,
                'language'               => $request->language,
                'class_situation'        => $request->classSituation,
                'eductional_systme'      => $request->eductionalSystme,
                'can_conditions'         => $request->canConditions,
                'score_describe'         => $request->scoreDescribe,
                'graduation_certificate' => $request->graduationCertificate,
                'recruitment_pattern'    => $request->recruitmentPattern,
                'enrollment_mode'        => $request->enrollmentMode,
                'professional_direction' => $request->professionalDirection,
                'update_time'            => time()
            ];
    
            $is_update = MajorRecruitProject::updateAppointProjectMsg($request->projectId, $updateMsg);
            if($is_update) return responseToJson(0, '更新成功');
            throw new \Exception('更新失败');
        } catch(\Exception $e)  {
            return responseToJson(1, $e->getMessage());
        }

    } 


    /**
     * @api {get} admin/information/deleteAppointProject 删除指定的招生项目
     * 
     * @apiGroup information
     *
     * @apiParam {Number} projectId 指定招生项目的id
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
    public function deleteAppointProject(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $pro_id = (isset($request->projectId) && is_numeric($request->projectId)) ? $request->projectId : 0;

        if($pro_id) {
            $is_del = MajorRecruitProject::delAppProject($pro_id);
            return $is_del ? responseToJson(0, '删除成功') : responseToJson(1, '删除失败');
        }
    }


    /**
     * @api {post} admin/information/setProjectState 设置招生项目的状态(权重，展示状态)
     * @apiGroup information
     *
     * @apiParam {Number} projectId 指定招生项目的id
     * @apiParam {Number} type 要修改的状态类型(0修改权重；１修改展示状态;2修改推荐状态)
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
    public function setProjectState(Request $request) {
        if($request->isMethod('post')) {
            $pro_id = (isset($request->projectId) && is_numeric($request->projectId)) ? $request->projectId : 0;
            $type = (isset($request->type) && is_numeric($request->type)) ? $request->type : -1;
            $state = (isset($request->state) && is_numeric($request->state)) ? $request->state : -1;

            if($pro_id > 0 && $type != -1 && $state != -1) {
                if($type > 0 && $state > 1) return responseToJson(1, '状态值错误');
                $is_update = MajorRecruitProject::setAppiProjectState([
                    'pro_id' => $major_id,
                    'type'     => $type,
                    'state'    => $state
                ]);

                return $is_update ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
            }
        }
        else
            return responseToJson(2, '请求方式错误');
    }




    /**
     * @api {post} admin/information/createProject 新创建招生项目
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
    public function createProject(StudentProjectCreateRequest $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        try {
            $createMsg = [
                'project_name'           => $request->projectName,
                'min_cost'               => $request->minCost,
                'max_cost'               => $request->maxCost,
                'cost'                   => $request->cost,
                'student_count'          => $request->studentCount,
                'language'               => $request->language,
                'class_situation'        => $request->classSituation,
                'eductional_systme'      => $request->eductionalSystme,
                'can_conditions'         => $request->canConditions,
                'score_describe'         => $request->scoreDescribe,
                'graduation_certificate' => $request->graduationCertificate,
                'recruitment_pattern'    => $request->recruitmentPattern,
                'enrollment_mode'        => $request->enrollmentMode,
                'professional_direction' => $request->professionalDirection,
                'create_time'            => time()
            ];
    
            $is_create = MajorRecruitProject::createAppointProjectMsg($createMsg);
            if($is_update) return responseToJson(0, '添加成功');
            throw new \Exception('添加失败');
        } catch(\Exception $e)  {
            return responseToJson(1, $e->getMessage());
        }
    }



    /**
     * @api {post} admin/information/getMajorDirection 获得专业方向字典
     * @apiGroup information
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
     *              "name":"xxxxxxxxxxxx"
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
    public function getMajorDirection(Request $request) {
        return responseToJson(0, '', Dict::dictMajorDirection());
    }




    /**
     * @api {post} admin/information/getFractionLineType 获得分数线类型字典
     * @apiGroup information
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
     *              "name":"xxxxxxxxxxxx"
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
    public function getFractionLineType(Request $request) {
        
        return responseToJson(0, '', Dict::dictFractionType());
    }


    /**
     * @api {post} admin/information/getUnifiedRecruitPattern 获得统招模式字典
     * @apiGroup information
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
     *              "name":"xxxxxxxxxxxx"
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
    public function getUnifiedRecruitPattern(Request $request) {
        
        return responseToJson(0, '', Dict::dictRecruitmentPattern());
    }


    private function createDirImg() {

    }

    private function updateDirImgName() {

    }

}