<?php

/**
 * 院校专业管理
 */

namespace App\Http\Controllers\Admin\Information;

use App\Models\zslm_major as ZslmMajor;
use App\Http\Requests\MajorPostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
     * @apiParam {Number} screenType 展示状态(0按展示；1按不展示;2全部)
     * @apiParam {Number} screenState 推荐状态(0推荐；1不推荐;2全部)
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
     *              "z_name":"xxxxxxxxxxxx",
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

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式失败');

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

        foreach($get_msg['get_page_msg'] as $key => $value) {
            $get_msg['get_page_msg'][$key]->is_show = $value->is_show ? false : true;
            $get_msg['get_page_msg'][$key]->if_recommended = $value->if_recommended ? false : true;
            $get_msg['get_page_msg'][$key]->update_time = date('Y-m-d H:i:s', $value->update_time);
        }

        return isset($get_msg) ? responseToJson(0, '', $get_msg) : responseToJson(1, '查询失败');
        
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
            $type = (is_numeric($request->type)) ? $request->type : -1;
            $state = (is_numeric($request->state)) ? $request->state : -1;
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
            if(isset($major->province)) {
                $major->province = Dict::getAppoinDictRegion(strChangeArr($major->province, ',')[1]);
            }
            
            if($major->school_id !== '')
                $major->school_id = Dict::getAppointSchoolName($major->school_id);

            if($major->z_type != 0)
                $major->z_type = Dict::getAppointDictMajorType($major->z_type);

            $major->wc_image = strChangeArr($major->wc_image, ',');
            $major->wb_image = strChangeArr($major->wb_image, ',');
            $major->magor_logo_name = 'http://localhost:81/zslm_back/storage/app/admin/info/' . $major->magor_logo_name;
            $major->major_cover_name = 'http://localhost:81/zslm_back/storage/app/admin/info/' . $major->major_cover_name;
            foreach($major->wb_image as $key => $val)
                $major->wb_image[$key] = 'http://localhost:81/zslm_back/storage/app/admin/info/' . $val;
            foreach($major->wc_image as $key => $val)
                $major->wc_image[$key] = 'http://localhost:81/zslm_back/storage/app/admin/info/' . $val;
                
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
    public function updateMajorMsg(Request $request) {
        var_dump($request->wc_image);
    }


    /**
     * admin/information/updateMajorExtendMsg 更新院校专业的扩展信息
     */
    public function updateMajorExtendMsg(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $major_id = isset($request->majorId) && is_numeric($request->majorId) ? $request->majorId : 0;
        $title = (isset($request->title) && mb_strlen($request->title, 'utf-8') < 255) ? $request->title : '';
        $keywords = (isset($request->keywords) && mb_strlen($request->keywords, 'utf-8') < 255) ? $request->keywords : '';
        $descciption = isset($request->descciption) ? $request->descciption : '';

        if($major_id == 0 || $title == '' || $keywords == '' || $descciption == '') return responseToJson(1, '参数错误');

        $major_extend_msg_arr = [
            'title' => $title,
            'keywords' => $keywords,
            'descciption' => $descciption
        ];
        $is_update = ZslmMajor::createOneMajor($major_extend_msg_arr, 1, $major_id);

        return $is_update ? responseToJson(0, '更新成功') : responseToJson(1, '更新失败');

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
            $now_time = time();
            $is_update = ZslmMajor::updateMajorTime($major_id, $now_time);
            return $is_update ? responseToJson(0, '更新成功', date("Y-m-d H:i:s",$now_time)) : responseToJson(1, '更新失败');
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
     * @apiParam {FileData} majorLogo 院校专业logo图
     * @apiParam {FileData} majorCover 院校专业封面图
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
    public function createMajor(Request $request) {
        if(!$request->isMethod('post'))  return responseToJson(2, '请求方式错误');
        // var_dump($request->all());
        try {
            DB::beginTransaction();
            $wx_img_name_arr = [];
            $wb_img_name_arr = [];
            $major_logo_name = getFileName('info', $request->file('majorLogo')->getClientOriginalExtension());
            // var_dump($major_logo_name);
            $major_cover_name = getFileName('info', $request->file('majorCover')->getClientOriginalExtension());
            foreach($request->wcImage as $key => $wximg) {
                
                $wx_img_name_arr[getFileName('info', $wximg->getClientOriginalExtension())] = $wximg;
            }
            // var_dump($request->wcImage);
            foreach($request->wbImage as $key => $wbimg) {
                $wb_img_name_arr[getFileName('info', $wbimg->getClientOriginalExtension())] = $wbimg;
            }
            unset($request->wcImage);
            unset($request->wbImage);
            
            $major_msg = [
                'z_name' => $request->majorName,
                'z_type' => $request->majorType,
                'access_year' => $request->approval,
                'major_follow_id' => $request->majorNature,
                'index_web' => $request->indexWeb,
                'province' => $request->majorProvince,
                'address' => $request->majorAddress,
                'phone' => $request->phone,
                'admissions_web' => $request->admissionsWeb,
                'school_id' => $request->schoolId,
                'major_cover_name' => $major_cover_name,
                'magor_logo_name'=> $major_cover_name,
                'major_confirm_id' => $request->majorAuth,
                'wc_image' => strChangeArr(array_keys($wx_img_name_arr), ','),
                'wb_image' => strChangeArr(array_keys($wb_img_name_arr), ',')
            ];
            
            $is_create = ZslmMajor::createOneMajor($major_msg);
            

            //文件上传
            if($is_create) {
                $is_upload_major_logo = createDirImg($major_logo_name, $request->file('majorLogo'), 'info');
                if($is_upload_major_logo === true)
                    $is_upload_major_cover = createDirImg($major_cover_name, $request->file('majorCover'), 'info');
                else throw new \Exception($is_upload_major_logo[1]); 
                
                if($is_upload_major_cover === true) {
                    $is_no_wx_upload = false;
                    foreach($wx_img_name_arr as $key => $wximage) {
                        $is_upload = createDirImg($key, $wximage, 'info');
                        if(is_array($is_upload) && $is_upload[0] == 1) {
                            $is_no_wx_upload = true;
                            break;
                        }
                    }
                    if($is_no_wx_upload == false) {
                        $is_no_wb_upload = false;
                        foreach($wb_img_name_arr as $key => $wbimage) {
                            $is_upload2 = createDirImg($key, $wbimage, 'info');
                            if(is_array($is_upload2) && $is_upload2[0] == 1) {
                                $is_no_wb_upload = true;
                                break;
                            }
                        }
                        if($is_no_wb_upload == false) {
                            DB::commit();
                            return responseToJson(0, '创建成功', $is_create); 
                        }
                        else throw new \Exception($is_upload2[1]);
                    }
                    else throw new \Exception($is_upload[1]);
                }
                else throw new \Exception($is_upload_major_cover[1]);
            }
            else return responseToJson(1, '新建失败');
        } catch(\Exception $e) {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
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
     * @api {post} admin/information/getMajorProvincesAndCities 获得所在省市字典表(注意按省分组)
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
     *      }
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

            // $region = Dict::dictRegion();

            
            // foreach($region[0] as $key=>$item) {
            //     $item->citys = $region[$item->id];
            //     unset($region[$item->id]);
            // }
            // var_dump($region);

            return responseToJson(0, '', getMajorProvincesAndCity());
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