<?php

/**
 * 活动管理
 */

namespace App\Http\Controllers\Admin\Information;


use App\Models\activity_relation as ActivityRelation;
use App\Models\zslm_activitys as ZslmActivitys;
use App\Models\user_accounts as UserAccounts;
use App\Http\Requests\ActivityCreateRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Models\system_setup as SystemSetup;
use App\Models\zslm_major as ZslmMajor;
use App\Models\news_users as NewsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\dict as Dict;
use App\Models\news as News;
use DB;

class ActivityController extends Controller 
{

    /**
     * @api {post} admin/information/getActivityPageMessage 获取活动列表页分页数据
     * @apiGroup information
     * 
     * 
     * @apiParam {String} activityNameKeyword 活动名称关键字
     * @apiParam {Number} screenType 筛选方式(0按展示状态；1按推荐状态;2活动状态；3全部)
     * @apiParam {Number} screenState 筛选状态(0展示/推荐；1不展示/不推荐;2全部)
     * @apiParam {Number} activityState 活动状态(0未开始；1进行中;2已结束；3全部)
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
     *              "name":"活动名称",
     *              "weight":"活动权重",
     *              "is_show":"是否展示",
     *              "if_recommended":"是否推荐",
     *              "active_type":"活动类型",
     *              "major_type":"专业类型",
     *              "province":"所在省市",
     *              "address":"活动地址",
     *              "begin_time":"活动开始时间",
     *              "end_time":"活动结束时间",
     *              "host_school":"活动主办院校",
     *              "sign_up_state":"报名状态",
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
    public function getActivityPageMessage(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式失败');

        $rules = [
            'activityNameKeyword'   => 'nullable|string|max:255',
            'screenType'            => 'numeric',
            'screenState'           => 'numeric',
            'sortType'              => 'nullable|numeric',
            'pageCount'             => 'numeric',
            'pageNumber'            => 'numeric'
        ];
        $message = [
            'activityNameKeyword.max' =>'搜索关键字超过最大长度',
            'screenType.*'            =>'参数错误',
            'screenState.*'           =>'参数错误',
            'sortType.*'              => '参数错误',
            'pageCount.*'             => '参数错误',
            'pageNumber.*'            => '参数错误'
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);

        $get_msg = ZslmActivitys::getActivityPageMsg($request->all())->toArray();

        $province = $this->getMajorProvincesAndCities($request);

        foreach($get_msg as $key => $item) {
            $get_msg[$key]->province = strChangeArr($item->province, ',');
            foreach($province[$item->province[0]]->citys as $value) 
                if($item->province[1] == $value->id) $get_msg[$key]->province[1] = $value->name;

            $get_msg[$key]->province[0] = $province[$item->province[0]]->name;
            $get_msg[$key]->begin_time = date("Y-m-d",$item->begin_time);
            $get_msg[$key]->end_time = date("Y-m-d",$item->end_time);
            $get_msg[$key]->update_time = date("Y-m-d H:i:s",$item->update_time);
        }

        return $get_msg ? responseToJson(0, '', $get_msg) : responseToJson(1, '查询失败');
    }


    /**
     * @api {post} admin/information/getActivityPageCount 获取活动列表页分页数据总数
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
    public function getActivityPageCount(Request $request) {
        try {
            if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
            if(isset($request->conditionArr) &&  is_array($request->conditionArr))
                return responseToJson(0, '', ZslmActivitys::getActivityAppiCount($request->conditionArr));
            else throw new \Exception('查询失败');
        } catch(\Exception $e) {
            return responseToJson(1, $e->getMessage());
        }
    }

    /**
     * @api {post} admin/information/setActivityState 设置活动的状态(权重，展示状态，推荐状态)
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
     * @apiParam {Number} type 要修改的状态类型(0修改权重；１修改展示状态；２修改推荐状态;3修改活动状态)
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
    public function setActivityState(Request $request) {
        if($request->isMethod('post')) {
            $act_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
            $type = (isset($request->type) && is_numeric($request->type)) ? $request->type : -1;
            $state = (isset($request->state) && is_numeric($request->state)) ? $request->state : -1;

            if($act_id > 0 && $type != -1 && $state != -1) {
                if($type > 0 && $type != 3 && $state > 1) return responseToJson(1, '状态值错误');
                if($type == 3 && $state > 2) return responseToJson(1, '状态值错误');
                $is_update = ZslmActivitys::setAppiActivityState([
                    'act_id'  => $act_id,
                    'type'    => $type,
                    'state'   => $state
                ]);

                return $is_update ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
            }
        }
        else
            return responseToJson(2, '请求方式错误');
    }


    /**
     * @api {get} admin/information/selectActivityReception 跳转到前台对应的活动主页
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
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
    public function selectActivityReception(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        if($activity_id != 0) {
            $activity = ZslmActivitys::getAppointActivityMsg($activity_id);
            return is_object($activity) ? responseToJson(0, '', $activity) : responseToJson(1, '获取信息失败');
        }
    }



    /**
     * @api {post} admin/information/updateActivityMsg 修改活动的信息
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
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
    public function updateActivityMsg(ActivityUpdateRequest $request) {

    }


    /**
     * @api {post} admin/information/deleteActivity 删除指定的活动
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
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
    public function deleteActivity(Request $request) {
        if(!$request->isMethod('get')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;

        if($activity_id > 0) {
            $is_del = ZslmActivitys::delAppointActivity($activity_id);
            return $is_del ? responseToJson(0, '删除成功') : responseToJson(1, '删除失败');
        }
        else 
            return responseToJson(1, '参数错误');


    }


    /**
     * @api {post} admin/information/updateActivityInformationTime 更新活动信息的更新时间  
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定活动的id
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
    public function updateActivityInformationTime(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;

        if($activity_id != 0) {
            $is_del = ZslmActivitys::updateActivityTime($activity_id);
            return $is_del ? responseToJson(0, '更新成功') : responseToJson(1, '更新失败');
        }
        else return responseToJson(1, '参数错误');
    }



    /**
     * @api {post} admin/information/createActivity 新建活动
     * @apiGroup information
     *
     * @apiParam {String} activityName 活动名称
     * @apiParam {Number} activityType 活动类型
     * @apiParam {Number} majorType 专业类型
     * @apiParam {String} province 活动省市
     * @apiParam {String} address 活动地址
     * @apiParam {timeInt} beginTime 开始时间
     * @apiParam {timeInt} endTime 结束时间
     * @apiParam {NUmber} signUpState 报名状态
     * @apiParam {FormData} activeImg 活动封面图
     * @apiParam {String} title 主页优化
     * @apiParam {String} keywords 主页优化
     * @apiParam {String} description 主页优化
     * @apiParam {String} introduce 活动介绍
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
    public function createActivity(ActivityCreateRequest $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        try {
            DB::beginTransaction();
            $file_handle = $request->file('activeImg');
            $img_name = getFileName('activity', $file_handle->getClientOriginalExtension());
            $create_msg = [
                'active_name'    => trim($request->activityName),
                'active_type'    => $request->activityType,
                'major_type'     => $request->majorType,
                'province'       => $request->province,
                'address'        => trim($request->address),
                'begin_time'     => strtotime($request->beginTime),
                'end_time'       => strtotime($request->endTime),
                'sign_up_state'  => $request->signUpState,
                'active_img'     => $img_name,
                'title'          => !empty($request->title) ? trim($request->title) : '',
                'keywords'       => !empty($request->keywords) ? trim($request->keywords) : '',
                'description'    => !empty($request->description) ? trim($request->description) : '',
                'introduce'      => trim($request->enrollmentMode),
                'create_time'    => time()
            ];
    
            $is_create = ZslmActivitys::createAppointActivityMsg($create_msg);

            $is_create_img = $this->createDirImg($img_name, $file_handle);

            if($is_create && ($is_create_img === true)) {
                DB::commit();
                return responseToJson(0, '上传成功'); 
            }
            else if(is_array($is_create_img) && $is_create_img[0] == 1) {
                throw new \Exception($is_create_img[1]);
            }
            else throw new \Exception('上传失败');

        } catch(\Exception $e)  {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }
    }


    private function createDirImg($imgName, &$imgHandle) {
        if($imgHandle->isValid()) {
            $originalName = $imgHandle->getClientOriginalName(); //源文件名
            $ext = $imgHandle->getClientOriginalExtension();    //文件拓展名

            $file_type_arr = ['png','jpg','jpeg','tif','image/jpeg'];
            $type = $imgHandle->getClientMimeType(); //文件类型
            $realPath = $imgHandle->getRealPath();   //临时文件的绝对路径
            $size = $imgHandle->getSize();

            if(!in_array(strtolower($ext), $file_type_arr)) return [1,'请上传格式为图片的文件'];
            else if(Storage::disk('info')->exists($imgName)) return [1, '图片已存在'];
            else if(getByteToMb($size) > 3) return [1, '文件超出最大限制'];

            $bool = Storage::disk('info')->put($imgName, file_get_contents($realPath));
            return $bool ? $bool : [1, '图片上传失败'];
        }
        else return [1, '图片未上传'];
    }




    /**
     * @api {post} admin/information/getActivityType 获得活动类型字典
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
    public function getActivityType(Request $request) {
        return responseToJson(0, '', Dict::getActivityType());
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
     * @api {post} admin/information/getMajorProvincesAndCities 获得活动省市字典
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
    public function getMajorProvincesAndCities(Request $request) {
        $region = Dict::dictRegion();

        foreach($region[0] as $key=>$item) {
            $item->citys = $region[$item->id];
            unset($region[$item->id]);
        }

        return responseToJson(0, '', $region);
    }



    /**
     * @api {post} admin/information/getAllMajor 获得所有专业字典
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
     *              "name":"xxxxxxxxxxxx",
     *              "xxx":"xxx"
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
    public function getAllMajor(Request $request) {
        return responseToJson(0, '', ZslmMajor::getAllDictMajor());
    }



    /**
     * @api {post} admin/information/setHostMajor 设置主办院校专业
     * @apiGroup information
     *
     * @apiParam {Number} activityId 指定院校专业的id
     * @apiParam {Number} majorId 主办院校id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
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
    public function setHostMajor(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(0, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numberic($request->activityId)) ? $request->activityId : 0;
        $major_id = (isset($request->majorId) && is_numberic($request->majorId)) ? $request->majorId : 0;

        $is_set = ActivityRelation::setAppointHostMajor($activity_id, $major_id);
        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }


    

    /**
     * @api {post} admin/information/sendActivityDynamic 活动作为院校动态更新推送给关注了主办院校的用户（插入消息表，并和用户进行关联，推送到个人中心－院校动态中）/活动作为新消息内容发送给关注了主办院校的用户（插入消息表，并和用户关联，推送到消息中心中）
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     * @apiParam {Number} majorId 主办院校id
     * @apiParam {Number} newOrDyna 设置类别(0,作为院校动态；1作为新消息)
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
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
    public function sendActivityDynamic(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numberic($request->activityId)) ? $request->activityId : 0;
        $major_id = (isset($request->majorId) && is_numberic($request->majorId)) ? $request->majorId : 0;

        $new_or_dyna = $request->newOrDyna;

        if($activity_id || $major_id || ($new_or_dyna < 0)) return responseToJson(1, '参数错误');

        try {
            DB::beginTransaction();

            $activity_msg = ZslmActivitys::getAppointActivityMsg($activity_id, 'active_name, introduce');

            $type = $new_or_dyna ? 2 : 3;

            $create_news_id = News::createNews([
                'carrier' => 1,
                'news_title' => $activity_msg->active_name,
                'context' => (mb_strlen($activity_msg->introduce, 'utf-8') > 20) ? (mb_substr($activity_msg->introduce, 0, 20, 'gb2312') . '...') : $activity_msg->introduce,
                'type' => $type,
                'create_time' => time()
            ]);

            $all_users_id = UserAccounts::getAllUsersId();
            
            $time = time();
            $data_arr = [];
            if(is_array($all_users_id) && !empty($all_users_id) && $create_news_id > 0) {
                foreach($all_users_id as $key => $user_id) {
                    array_push($data_arr,[
                        'news_id' => $create_news_id, 
                        'user_id' => $user_id, 
                        'status' => 0, 
                        'create_time' => $time
                    ]);
                }
                $is_create = NewsUsers::createNewsRelationUser($data_arr);
                if($is_create) 
                    return responseToJson(0, '发送成功');
                else 
                    throw new \Exception('发送失败');
            }
            else
                throw new \Exception('获得参数失败');
        } catch(\Exception $e) {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }

    }


    /**
     * @api {post} admin/information/getAllActivitys 获得所有的活动
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
     *              "active_name":"xxxxxxxxxxxx",
     *              "xxx":"xxx"
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
    public function getAllActivitys(Request $request) {

        return responseToJson(0, ZslmActivitys::getAllActivity('id,active_name'));
        
    }

    //


    /**
     * @api {post} admin/information/setManualRecActivitys 手动设置推荐活动
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     * @apiParam {Array} activityArr 推荐活动id的数组
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
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
    public function setManualRecActivitys(Request $request) {

        if($request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        $activity_arr = (isset($request->activityArr) && is_array($request->activityArr)) ? $request->activityArr : [];

        if($activity_id == 0 || count($activity_arr) < 1) return responseToJson(0, '参数错误');

        $recom_activity_count = SystemSetup::getContent('recommend_activity');

        $relation_activity_arr = strChangeArr(ActivityRelation::getAppointContent($activity_id, 'relation_activity'), ',');
        $merge_arr = mergeRepeatArray($activity_arr, $relation_activity_arr);
        if(count($merge_arr) > $recom_activity_count) return responseToJson(1, '关联活动条数超过最大限制');

        $rela_activity_str = strChangeArr($merge_arr, ',');

        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'relation_activity', $rela_activity_str);

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');


    }


    /**
     * @api {post} admin/information/setAutomaticRecActivitys 自动设置推荐活动
     * 
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
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
    public function setAutomaticRecActivitys(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        if($activity_id == 0) return responseToJson(0, '参数错误');
        $recom_activity_count = SystemSetup::getContent('recommend_activity');

        $get_activits_id_arr = ZslmActivitys::getAutoRecommendActivitys($recom_activity_count);

        if(count($get_activits_id_arr) < 1) return responseToJson(1, '暂无能够设置的活动');


        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'relation_activity', strChangeArr($get_activits_id_arr, ','));

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');

    }



    /**
     * @api {post} admin/information/setManualRecMajors 手动设置推荐院校
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     * @apiParam {Array} majorArr 专业id的数组
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
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
    public function setManualRecMajors(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        $major_arr = (isset($request->majorArr) && is_array($request->majorArr)) ? $request->majorArr : [];

        if($activity_id == 0 || count($major_arr) < 1) return responseToJson(0, '参数错误');

        $recom_major_count = SystemSetup::getContent('recommend_major');

        $relation_major_arr = strChangeArr(ActivityRelation::getAppointContent($activity_id, 'recommend_id'), ',');
        $merge_arr = mergeRepeatArray($major_arr, $relation_major_arr);
        if(count($merge_arr) > $recom_major_count) return responseToJson(1, '关联活动条数超过最大限制');

        $rela_major_str = strChangeArr($merge_arr, ',');

        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'recommend_id', $rela_major_str);

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }



    /**
     * @api {post} admin/information/setAutomaticRecMajors 自动设置推荐院校
     * 
     * @apiGroup information
     *
     * @apiParam {Number} activityId 活动的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "设置成功"
     * }
     *拉取代码本地查看
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
    public function setAutomaticRecMajors(Request $request) {
        if($request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $activity_id = (isset($request->activityId) && is_numeric($request->activityId)) ? $request->activityId : 0;
        if($activity_id == 0) return responseToJson(0, '参数错误');
        $recom_major_count = SystemSetup::getContent('recommend_major');

        $get_major_id_arr = ZslmMajor::getAutoRecommendMajors($recom_major_count);

        if(count($get_major_id_arr) < 1) return responseToJson(1, '暂无能够设置的院校');

        $is_set = ActivityRelation::setRecommendActivitys($activity_id, 'recommend_id', strChangeArr($get_major_id_arr, ','));

        return $is_set ? responseToJson(0, '设置成功') : responseToJson(1, '设置失败');
    }




}