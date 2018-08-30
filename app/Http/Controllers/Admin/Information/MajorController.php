<?php

/**
 * 院校专业管理
 */

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;
use App\Http\Requests\MajorPostRequest;
use Illuminate\Http\Request;
use App\Models\zslm_major as ZslmMajor;
use App\Models\dict as Dict;
use Validator;
use DB;

class MajorController extends Controller 
{



    /**
     * @api {post} admin/information/getMajorPageMessage 获取院校专业列表页分页数据
     * @apiGroup information
     * 
     * 
     * @apiParam {String} majorNameKeyword 专业名称关键字
     * @apiParam {Number} screenType 筛选方式(0按展示状态；1按推荐状态;2全部)
     * @apiParam {Number} screenState 筛选状态(0展示/推荐；1不展示/不推荐;2全部)
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
     *              "name":"xxxxxxxxxxxx",
     *              "weight":"xxxxxxxxxxxx",
     *              "is_show":"xxxxxx",
     *              "if_recommended":"xxxxxxxxxxxx",
     *              "student_project_count":"xxx",
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
    public function getMajorPageMessage(Request $request) {

        if($request->isMethod('post')) return responseToJson(2, '请求方式失败');

        $rules = [
            'majorNameKeyword' => 'nullable|string|max:255',
            'screenType'       => 'numeric',
            'screenState'      => 'numeric',
            'sortType'         => 'nullable|numeric',
            'pageCount'        => 'numeric',
            'pageNumber'       => 'numeric'
        ];
        $message = [
            'majorNameKeyword.max'=>'搜索关键字超过最大长度',
            'screenType.*'   =>'参数错误',
            'screenState.*'  =>'参数错误',
            'sortType.*'     => '参数错误',
            'pageCount.*'    => '参数错误',
            'pageNumber.*'   => '参数错误'
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $get_msg = ZslmMajor::getMajorPageMsg($request->all());

        return $get_msg ? responseToJson(0, '', $get_msg) : responseToJson(1, '查询失败');
        
    }



    /**
     * @api {post} admin/information/getMajorPageCount 获取院校专业列表页分页数据总数
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
     * @apiError　{Object[]} error　 这里是失败时返回实例numeric
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
    public function getMajorPageCount(Request $request) {
        try {
            if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
            if(isset($request->conditionArr) &&  is_array($request->conditionArr))
                return responseToJson(0, '', ZslmMajor::getMajorAppiCount($request->conditionArr));
            else throw new \Exception('上传失败');
        } catch(\Exception $e) {
            return responseToJson(1, $e->getMessage());
        }
    }



    /**
     * @api {post} admin/information/setMajorState 设置院校专业的状态(权重，展示状态，推荐状态)
     * @apiGroup information
     *
     * @apiParam {Number} majorId 指定院校专业的id
     * @apiParam {Number} type 要修改的状态类型(0修改权重；１修改展示状态；2修改推荐状态)
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
    public function setMajorState(Request $request) {
        if($request->isMethod('post')) {
            $major_id = (isset($request->majorId) && is_numeric($request->majorId)) ? $request->majorId : 0;
            $type = (isset($request->type) && is_numeric($request->type)) ? $request->type : -1;
            $state = (isset($request->state) && is_numeric($request->state)) ? $request->state : -1;

            if($major_id > 0 && $type != -1 && $state != -1) {
                if($type > 0 && $state > 1) return responseToJson(1, '状态值错误');
                $is_update = ZslmMajor::setAppiMajorState([
                    'major_id' => $major_id,
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
     * @api {get} admin/information/selectReception 跳转到前台对应的院校专业主页
     * @apiGroup information
     *
     * @apiParam {Number} majorId 指定院校专业的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * 重定向到前台对应的院校专业主页
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
    public function selectReception(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $major_id = (isset($request->majorId) && is_numeric($request->majorId)) ? $request->majorId : 0;
        if($major_id != 0) {
            $major = ZslmMajor::getAppointMajorMsg($major_id);
            return is_object($major) ? responseToJson(0, '', $major) : responseToJson(1, '获取信息失败');
        }
    }



    /**
     * @api {post} admin/information/updateMajorMsg 修改院校专业的信息
     * @apiGroup information
     *
     * @apiParam {Number} majorId 指定院校专业的id
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
    public function updateMajorMsg(MajorPostRequest $request) {

    }



    /**
     * @api {post} admin/information/deleteMajor 删除指定的院校专业
     * @apiGroup information
     *
     * @apiParam {Number} majorId 指定院校专业的id
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
    public function deleteMajor(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $major_id = (isset($request->majorId) && is_numeric($request->majorId)) ? $request->majorId : 0;

        if($major_id != 0) {
            $is_del = ZslmMajor::delMajor($major_id);
            return $is_del ? responseToJson(0, '删除成功') : responseToJson(1, '删除失败');
        }
        else return responseToJson(1, '参数错误');

    }


    /**
     * @api {post} admin/information/updateMajorInformationTime 更新院校专业信息的更新时间  
     * @apiGroup information
     *
     * @apiParam {Number} majorId 指定院校专业的id
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
    public function updateMajorInformationTime(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $major_id = (isset($request->majorId) && is_numeric($request->majorId)) ? $request->majorId : 0;

        if($major_id != 0) {
            $is_del = ZslmMajor::updateMajorTime($major_id);
            return $is_del ? responseToJson(0, '更新成功') : responseToJson(1, '更新失败');
        }
        else return responseToJson(1, '参数错误');
    }


    /**
     * @api {post} admin/information/createMajor 新建院校专业
     * @apiGroup information
     *
     * @apiParam {String} approval 审批年限
     * @apiParam {Number} majorAuth 院校专业认证
     * @apiParam {Number} majorNature 院校性质
     * @apiParam {String} indexWeb 院校官网
     * @apiParam {String} majorProvince 所在省市
     * @apiParam {String} majorAddress 院校地址
     * @apiParam {String} phone 咨询电话
     * @apiParam {String} admissionsWeb 招生专题
     * @apiParam {FileData} wcImage 院校官方微信公众号
     * @apiParam {FileData} wbImage 院校官方新浪微博帐号
     * @apiParam {Number} schoolId 院校关联
     * @apiParam {String} majorName 专业名称
     * @apiParam {Number} majorType 专业类型
     * @apiParam {FileData} magorLogo 院校专业封面图
     * 
     * @apiParam {String} title 页面优化
     * @apiParam {String} keywords 页面优化
     * @apiParam {String} description 页面优化
     * 
     * 
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "上传成功"
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
    public function createMajor(MajorPostRequest $request) {
        if($request->isMethod('post'))  return responseToJson(2, '请求方式错误');

        try {
            DB::beginTransaction();
            $is_create = ZslmMajor::createOneMajor($request->all());
            //文件上传

            //回滚
            if(true) {
                DB::commit();
                return responseToJson(0, '上传成功'); 
            }
            else if(true) {
                throw new \Exception($is_create_img[1]);
            }
            return $is_create ? responseToJson(0, '新建成功') : responseToJson(1,'新建失败');
        } catch(\Exception $e) {
            DB::rollback();//事务回滚
        }
        
    }


    /**
     * @api {post} admin/information/getMajorAuthentication 获得院校专业认证字典
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
    public function getMajorAuthentication(Request $request) {
        return responseToJson(0, '', Dict::dictMajorConfirm());
    }




    /**
     * @api {post} admin/information/getMajorNature 获得院校性质字典
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
    public function getMajorNature(Request $request) {
        return responseToJson(0, '', Dict::dictMajorFollow());
    }


    /**
     * @api {post} admin/information/getMajorType 获得专业类型字典
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
    public function getMajorType(Request $request) {
        return responseToJson(0, '', Dict::dictMajorType());
    }



    /**
     * @api {post} admin/information/getMajorProvincesAndCities 获得所在省市字典表（注意按省分组）
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
     *              "father_id":"0"
     *              "name":"xx省",
     *              "citys":{
     *                  {
     *                      "id":"xx",
     *                      "name":"xx市"
     *                      "father_id":"xx"
     *                  },
     *                  {
     *                      "id":"xx",
     *                      "name":"xx市",
     *                      "father_id":"xx"
     *                  }
     *              }
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
    public function getMajorProvincesAndCities(Request $request) {

            $region = Dict::dictRegion();

            foreach($region[0] as $key=>$item) {
                $item->citys = $region[$item->id];
                unset($region[$item->id]);
            }

            return responseToJson(0, '', $region);
    }



    /**
     * @api {post} admin/information/getAllSchoolName 获得院校名称字典
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
    public function getAllSchoolName(Request $request) {
        return responseToJson(0, '', Dict::getSchoolName());
    }


    private function createDirImg() {

    }

    private function updateDirImgName() {

    }




}