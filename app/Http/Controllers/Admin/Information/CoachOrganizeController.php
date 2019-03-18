<?php

/**
 * 辅导机构管理
 */

namespace App\Http\Controllers\Admin\Information;


use App\Models\coach_organize as CoachOrganize;
use App\Http\Requests\CoachCreateRequest;
use App\Http\Requests\CoachUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\dict_region as dictRegion;
use App\Models\zslm_coupon as ZslmCoupon;
use App\Models\zslm_activitys as ZslmActivitys;
use App\Models\dict_activity_type as DictActivityType;
use App\Models\system_setup as SystemSetup;
use Illuminate\Http\Request;
use App\Models\dict as Dict;
use Storage;
use Validator;
use DB;

class CoachOrganizeController extends Controller 
{
    
    public function getPageInfo(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,'request error');
            
        $provice = dictRegion::getProvice();
        $coach = CoachOrganize::getFatherCoach();
        if(($provice != null && sizeof($provice)>0) && ($coach != null && sizeof($coach)>0))
            return responseToJson(0,'success',['provice'=>$provice,'coach'=>$coach]);
        else
            return responseToJson(1,'error');
    }

    /**
     * @api {post} admin/information/getPageCoachOrganize 获取辅导机构列表页分页数据
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
     *              "coach_type":"辅导形式(0线上，1线下，2线上＋线下)",
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

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式失败');

        $rules = [
            'soachNameKeyword' =>'nullable|string|max:255',
            'sortType' => 'numeric',
            'pageCount' => 'numeric',
            'pageNumber' => 'numeric'
        ];

        $message = [
            'soachNameKeyword.max' =>'搜索关键字超过最大长度',
            'pageCount.*'             => '参数错误',
            'pageNumber.*'            => '参数错误'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()) return responseToJson(1, $validator->getMessageBag()->toArray()[0]);
        
        $data = CoachOrganize::getCoachPageMsg($request->all());
        $data[0] = $data[0]->toArray();
        $this->setProvice($data[0]);

        // $province = $this->getMajorProvincesAndCities($request);

        // foreach($coachs_msg as $key => $item) {
        //     $coachs_msg[$key]->province = strChangeArr($item->province, ',');
        //     foreach($province[$item->province[0]]->citys as $value) 
        //         if($item->province[1] == $value->id) $coachs_msg[$key]->province[1] = $value->name;

        //     $coachs_msg[$key]->province[0] = $province[$item->province[0]]->name;

        //     $coachs_msg[$key]->update_time = date("Y-m-d H:i:s",$item->update_time);
        // }

        return count($data[0]) >= 0 ? responseToJson(0, '', $data) : responseToJson(1, '查询失败');



    }

    
    public function getMajorP(){
        return getMajorProvincesAndCity();
    }
    
    public function getMajorProvincesAndCities() {
        // $region = Dict::dictRegion();

        // foreach($region[0] as $key=>$item) {
        //     $item->citys = $region[$item->id];
        //     unset($region[$item->id]);
        // }

        return responseToJson(0, '', getMajorProvincesAndCity());
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
        try {
            if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
            if(isset($request->conditionArr) &&  is_array($request->conditionArr))
                return responseToJson(0, '', CoachOrganize::getCoachAppiCount($request->conditionArr));
            else throw new \Exception('查询失败');
        } catch(\Exception $e) {
            return responseToJson(1, $e->getMessage());
        }
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
        if($request->isMethod('post')) {
            $coach_id = (isset($request->coachId) && is_numeric($request->coachId)) ? $request->coachId : 0;
            $type = (isset($request->type) && is_numeric($request->type)) ? $request->type : -1;
            $state = (isset($request->state) && is_numeric($request->state)) ? $request->state : -1;

            if($coach_id > 0 && $type != -1 && $state != -1) {
                if($type > 0 && $state > 1) return responseToJson(1, '状态值错误');
                $is_update = CoachOrganize::setAppiCoachState([
                    'coach_id'  => $coach_id,
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
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $coach_id = (isset($request->coachId) && is_numeric($request->coachId)) ? $request->coachId : 0;
        if($coach_id != 0) {
            $coach = CoachOrganize::getAppointCoachMsg($coach_id);
            return is_object($coach) ? responseToJson(0, '', $coach) : responseToJson(1, '获取信息失败');
        }
    }




    /**
     * @api {post} admin/information/updateCoachMessage 编辑辅导机构的信息(注意是编辑分校还是总部)
     * @apiGroup information
     *
     * @apiParam {Number} coachId 指定辅导机构的id
     * @apiParam {Number} coachName 指定辅导机构的id
     * @apiParam {Number} coachType 指定辅导机构的id
     * @apiParam {Number} provice 指定辅导机构的id
     * @apiParam {Number} phone 指定辅导机构的id
     * @apiParam {Number} address 指定辅导机构的id
     * @apiParam {Number} webUrl 指定辅导机构的id
     * @apiParam {Number} CoachForm 指定辅导机构的id
     * @apiParam {Number} totalCoachId 指定辅导机构的id
     * @apiParam {Number} backMoneyType 指定辅导机构的id
     * @apiParam {Number} coverName 指定辅导机构的id
     * @apiParam {Number} logoName 指定辅导机构的id
     * @apiParam {Number} title 指定辅导机构的id
     * @apiParam {Number} keywords 指定辅导机构的id
     * @apiParam {Number} description 指定辅导机构的id
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
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
           if(!isset($request->coachId) && !is_array($request->coachId))
               return responseToJson(1,'no id or id is not array');

        if($request->coachId != null && sizeof($request->coachId) > 0) {
            $is_del = CoachOrganize::delAppointCoach($request->coachId);
            return $is_del ? responseToJson(0, '删除成功') : responseToJson(1, '删除失败');
        }
        else 
            return responseToJson(1, '参数错误');
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

        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $total_id = (isset($request->totalCoachId) && is_numeric($request->totalCoachId)) ? $request->totalCoachId : 0;
        $page_num = (isset($request->pageNum) && is_numeric($request->pageNum)) ? $request->pageNum : -1; 

        if($total_id == 0 || $page_num < 0) return responseToJson(1, '参数错误');

        $coachs_msg = CoachOrganize::getBranchCoachMsg($total_id, $page_num)->toArray();

        $this->setProvice($coachs_msg);

        return is_array($coachs_msg) ? responseToJson(0, '', $coachs_msg) : responseToJson(1, '查询失败');

    }

    private function setProvice(array &$msg = []) {
        
        $province = $this->getMajorP()[0];
        foreach($msg as $key => $item) {
            $msg[$key]->province = strChangeArr($item->province, ',');
     
            if($province != null)
                for($i = 0;$i<sizeof($province);$i++){
                    if( $msg[$key]->province[0] == $province[$i]->id){
                        $msg[$key]->province = $province[$i]->name;
                    }
                    
                }
            
            $msg[$key]->update_time = date("Y-m-d H:i:s",$item->update_time);
        }
    }




        /**
     * @api {post} admin/information/createCoach 创建辅导机构(注意分校/总校的判定)
     * @apiGroup information
     *
     * @apiParam {String} coachName 辅导机构名称
     * @apiParam {Number} provice 所在省市
     * @apiParam {String} phone 联系方式
     * @apiParam {String} address 地址
     * @apiParam {String} webUrl 网址
     * @apiParam {Number} CoachForm 辅导形式(0是总部，１是分校)
     * @apiParam {Number} totalCoachId 辅导总部id(CoachForm为1的情况下，传过来分校的父级id)
     * @apiParam {Number} couponsType 是否支持优惠券(０支持，１不支持)
     * @apiParam {String} backMoneyType 是否支持退款(0支持，１不支持)
     * @apiParam {File} coverName 辅导机构的封面图
     * @apiParam {File} logoName 辅导机构logo
     * @apiParam {String} title 页面优化
     * @apiParam {String} keywords 页面优化
     * @apiParam {String} description 页面优化
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
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');

        $cover_handle = $request->file('coachCover');
        $logo_handle  = $request->file('coachLogo');
        $cover_name = getFileName('coach', $cover_handle->getClientOriginalExtension());
        $logo_name = getFileName('coach', $logo_handle->getClientOriginalExtension());
        $msg = [
            'coach_name'    => trim($request->coach_name),
            'province'      => $request->provice,
            'phone'         => trim($request->phone),
            'address'       => trim($request->address),
            'web_url'       => trim($request->web_url),
            'father_id'     => $request->father_id,
            'if_coupons'    => $request->if_coupons,
            'if_back_money' => $request->if_back_money,
            'coach_type'    => $request->coach_type,
            'cover_name'    => $cover_name,
            'logo_name'     => $logo_name
        ];

        try {
            DB::beginTransaction();
     
            $is_create = CoachOrganize::createCoach($msg);
            $is_create_cover = $this->createDirImg($cover_name, $cover_handle);
            $is_create_logo = $this->createDirImg($logo_name, $logo_handle);
    
            if($is_create && $is_create_cover == true && $is_create_logo == true) {
                DB::commit();
                return responseToJson(0, '新建成功',$is_create);
            }
            else if(is_array($is_create_cover) && $is_create_cover[0] == 1) 
                throw new \Exception($is_create_cover[1]);
            else if(is_array($is_create_logo) && $is_create_logo[0] == 1) 
                throw new \Exception('上传失败');
        }catch(\Exception $e) {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }
    }
    
    public function getOneCoach(Request $request){
        if(!$request->isMethod('get'))
            return responseToJson(1,'request error');
        if(!isset($request->id) && !is_numeric($request->id))
            return responseToJson('1','no id or id is not number');
        
        $one = CoachOrganize::getOne($request->id);
        if(!empty($one->logo_name))
            $one->coach_logo_img_name = splicingImgStr('admin', 'info', $one->logo_name);
        if(!empty($one->cover_name))
            $one->coach_cover_img_name = splicingImgStr('admin', 'info', $one->cover_name);

        dd($one);

        return ($one != null && count($one) == 1) ? responseToJson(0,'success',$one) : responseToJson(1,'no date');
        
    }
    
    public function setNewKTD(Request $request){
        if(!isset($request->title)){
            return responseToJson(1,'no title');
        }else if(!isset($request->keywords)){
            return responseToJson(1,'no keywords');
        }else if(!isset($request->description)){
            return responseToJson(1,'no description');
        }else if(!isset($request->id)){
            return responseToJson(1,'no id');
        }
        $result = CoachOrganize::createKTD($request);
        if($result == 1){
            return responseToJson(0,'success');
        }else{
            return responseToJson(1,'添加失败');
        }
        
    }

    public function setD(Request $request){
        if(!isset($request->describe)){
            return responseToJson(1,'no describe');
        }else if(!isset($request->id)){
            return responseToJson(1,'no id');
        }
        $result = CoachOrganize::createD($request);
        if($result == 1){
            return responseToJson(0,'success');
        }else{
            return responseToJson(1,'error',$result);
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


    private function updateDirImgName() {

    }
    
    public function updateWeight(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1, '请求方式错误');
        if(!isset($request->id))
            return responseToJson(1, 'no id');
        if(!isset($request->weight))
            return responseToJson(1, 'no weight');
        $result = CoachOrganize::setWeight($request);
        if($result == 1)
            return responseToJson(0,'success',$request->all());
        else
            responseToJson(1,'update error please try again');
    }
    
    public function  updateCoachWeight(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1, '请求方式错误');
        if(!isset($request->id))
            return responseToJson(1, 'no id');
        if(!isset($request->weight))
            return responseToJson(1, 'no weight');
        $result = CoachOrganize::setWeight($request);
        if($result == 1)
            return responseToJson(0,'success');
        else
            responseToJson(1,'update error please try again');
    }
    
    public function  updateCoachShow(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1, '请求方式错误');
        if(!isset($request->id))
            return responseToJson(1, 'no id');
        if(!isset($request->state))
            return responseToJson(1, 'no weight');
        $result = CoachOrganize::setShow($request);
        if($result == 1)
            return responseToJson(0,'success');
        else
            responseToJson(1,'update error please try again');
    }
    
    public function  updateCoachRec(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1, '请求方式错误');
        if(!isset($request->id))
            return responseToJson(1, 'no id');
        if(!isset($request->state))
            return responseToJson(1, 'no weight');
        $result = CoachOrganize::setCouponsRec($request->id,$request->state);
        if($result == 1)
            return responseToJson(0,'success');
        else
            responseToJson(1,'update error please try again');
    }


    public function updateCoachCon(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1, '请求方式错误');
        if(!isset($request->id))
            return responseToJson(1, 'no id');
        if(!isset($request->state))
            return responseToJson(1, 'no state');
        $result = CoachOrganize::setCouponsState($request->id,$request->state);
        if($result == 1)
            return responseToJson(0,'success');
        else
            responseToJson(1,'update error please try again');
    }
    
    public function updateCoachTui(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1, '请求方式错误');
        if(!isset($request->id))
            return responseToJson(1, 'no id');
        if(!isset($request->state))
            return responseToJson(1, 'no state');
        $result = CoachOrganize::setback($request->id,$request->state);
        if($result == 1)
            return responseToJson(0,'success');
        else
            responseToJson(1,'update error please try again');
    }
    
    public function updateShow(Request $request){
        if(!$request->isMethod('post'))
            return responseToJson(1, '请求方式错误');
        if(!isset($request->id))
            return responseToJson(1, 'no id');
        if(!isset($request->state))
            return responseToJson(1, 'no weight');
        $result = CoachOrganize::setShow($request);
        if($result == 1)
            return responseToJson(0,'success',$request->all());
        else
            responseToJson(1,'update error please try again');
    }
    



    /**
     * 更新辅导机构主要信息
     */
    public function updateCoach(Request $request){
    
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
    
        $coach_id = (!empty($request->id) && $request->id > 0) ? $request->id : 0;
        // return responseToJson(0, '', $coach_id);
        // if(!isset($request->id)) return responseToJson(1, 'no id');

        $logo_file_handle = !empty($request->file('logo_img')) ? $request->file('logo_img') : null;
        $cover_file_handle = !empty($request->file('cover_img')) ? $request->file('cover_img') : null;

        // $cover_handle = $request->file('coachCover');
        // $logo_handle  = $request->file('coachLogo');
        // $cover_name = getFileName('coach', $cover_handle->getClientOriginalExtension());
        // $logo_name = getFileName('coach', $logo_handle->getClientOriginalExtension());

        $msg = [
            'coach_name'    => trim($request->coach_name),
            'province'      => $request->provice,
            'phone'         => trim($request->phone),
            'address'       => trim($request->address),
            'web_url'       => trim($request->web_url),
            'father_id'     => $request->father_id,
            'if_coupons'    => $request->if_coupons,
            'if_back_money' => $request->if_back_money,
            'coach_type'    => $request->coach_type,
            'logo_alt'      => trim($request->logo_img_describe),
            'cover_alt'     => trim($request->cover_img_describe),
            'update_time'    => time()
        ];

        //修改logo图片名称
        if($is_update_logo_name_bool = (!empty($request->logo_img_name) && $logo_file_handle == null)) {
            $coach_logo_old_name = CoachOrganize::getCoachLogoOrCoverName($request->id, 'logo_name');
            $arr = strChangeArr($coach_logo_old_name, '.');
            $coach_logo_new_name = $request->logo_img_name . '.' . end($arr);
            $msg['logo_name'] = trim($coach_logo_new_name);
        }
        else if($logo_file_handle != null) {
            $logo_img_name = ($logo_file_handle != null) 
            ? (!empty($request->logo_img_name) 
            ? trim($request->logo_img_name) . '.' . $logo_file_handle->getClientOriginalExtension() 
            : getFileName('coach', $logo_file_handle->getClientOriginalExtension())) : null;
            $msg['logo_name'] = $logo_img_name;
        } 

        //修改cover图片名称
        if($is_update_cover_name_bool = (!empty($request->cover_img_name) && $cover_file_handle == null)) {
            $coach_cover_old_name = CoachOrganize::getCoachLogoOrCoverName($request->id, 'cover_name');
            $arr = strChangeArr($coach_cover_old_name, '.');
            $coach_cover_new_name = $request->cover_img_name . '.' . end($arr);
            $msg['cover_name'] = trim($coach_cover_new_name);
        }
        else if($cover_file_handle != null) {
            $cover_img_name = ($cover_file_handle != null) 
            ? (!empty($request->cover_img_name) 
            ? trim($request->cover_img_name) . '.' . $cover_file_handle->getClientOriginalExtension() 
            : getFileName('coach', $cover_file_handle->getClientOriginalExtension())) : null;
            $msg['cover_name'] = $cover_img_name;
        } 
    
        try {
            DB::beginTransaction();
            if($coach_id != 0) {
                $is_create = CoachOrganize::updateCoach($request->id, $msg);
            }
            else if($coach_id == 0) {
                $msg['create_time'] = time();
                $is_create = CoachOrganize::createCoach($msg);
            }
            if($is_update_logo_name_bool) $is_logo_update = updateDirImgName($coach_logo_old_name, $coach_logo_new_name, 'info', 'admin/info');
            if($logo_file_handle != null) $is_create_logo_img = createDirImg($logo_img_name, $logo_file_handle, 'info');
            if($is_update_cover_name_bool) $is_cover_update = updateDirImgName($coach_cover_old_name, $coach_cover_new_name, 'info', 'admin/info');
            if($cover_file_handle != null) $is_create_cover_img = createDirImg($cover_img_name, $cover_file_handle, 'info');

            if($is_create) {
                if(((!empty($is_logo_update) && $is_logo_update == true) || (!empty($is_create_logo_img) && $is_create_logo_img == true)) || (!empty($is_cover_update) && $is_cover_update == true) || (!empty($is_create_cover_img) && $is_create_cover_img == true)) {
                    DB::commit();
                    
                    return $coach_id == 0 ? responseToJson(0, '添加成功',$is_create) : responseToJson(0, '修改成功');
                }
                else throw new \Exception('修改失败');
            }
            else throw new \Exception('修改失败');
            // $is_create_cover = $this->createDirImg($cover_name, $cover_handle);
            // $is_create_logo = $this->createDirImg($logo_name, $logo_handle);
            
            // if($is_create > 0 && $is_create_cover == true && $is_create_logo == true) {
            //     DB::commit();
            //     return responseToJson(0, '新建成功',$is_create);
            // }
            // else if(is_array($is_create_cover) && $is_create_cover[0] == 1)
            //     throw new \Exception($is_create_cover[1]);
            // else if(is_array($is_create_logo) && $is_create_logo[0] == 1)
            //     throw new \Exception('上传失败');
        }catch(\Exception $e) {
            DB::rollback();//事务回滚
            return responseToJson(1, $e->getMessage());
        }
        
    }



    //更新辅导机构的更新时间
    public function updateCoachTime(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, '请求方式错误');
        $coach_id = (isset($request->coachId) && is_numeric($request->coachId)) ? $request->coachId : 0;

        if($coach_id != 0) {
            $now_time = time();
            $is_update = CoachOrganize::updateCoachTime($coach_id, $now_time);
            return $is_update ? responseToJson(0, '更新成功', date("Y-m-d H:i:s",$now_time)) : responseToJson(1, '更新失败');
        }
        else return responseToJson(1, '参数错误');
    }



    //获取指定辅导机构的优惠劵
    public function getAppointCoachCoupon(Request $request) {
        if(!$request->isMethod('get')) return responseToJson(2, '请求方式错误');

        $coach_id = (isset($request->coachId) && is_numeric($request->coachId)) ? $request->coachId : 0;

        $coupon_arr = ZslmCoupon::getAppoinCoachAllCoupon($coach_id, ['id', 'name', 'type', 'is_enable'])->map(function($item) {
            $item->type = $item->type === 0 ? '满减型' : $item->type === 1 ? '优惠型' : '未设置';
            return $item;
        })->toArray();

        return count($coupon_arr) >= 0 ? responseToJson(0, 'success', $coupon_arr) : responseToJson(1, 'error');
    }



    /**
     * 获得指定辅导机构的相关活动信息
     * $coachId
     */
    public function getAppoinCoachRelevantActivity(Request $request) {
        if(!$request->isMethod('get')) return responseToJson(2, 'request type error');
        $coach_id = !empty($request->coachId) && is_numeric($request->coachId) ? $request->coachId : null;
        if($coach_id == null) return responseToJson(1, '参数错误');
        $relevan_activity_id_arr = CoachOrganize::getCoachLogoOrCoverName($coach_id, 'coach_id');
        $relevan_activity_id_arr = ($relevan_activity_id_arr != null || $relevan_activity_id_arr != 0) ? strChangeArr($relevan_activity_id_arr, ',') : [];
        if(count($relevan_activity_id_arr) < 1) return responseToJson(0, '', $relevan_activity_id_arr);
        $relevan_activity_id_arr = ZslmActivitys::getActiveByids($relevan_activity_id_arr)->toArray();
        $activity_type_arr = DictActivityType::getType()->toArray();
        foreach($relevan_activity_id_arr as $key => $item) {
            $relevan_activity_id_arr[$key]->create_time = date("Y-m-d H:i:s",$item->create_time);
            foreach ($activity_type_arr as $keys => $value) 
                if($item->active_type == $value->id) $relevan_activity_id_arr[$key]->active_type = $value->name;
        }
        return responseToJson(0, '', $relevan_activity_id_arr);
    }


    /**
     * 取消辅导机构的指定相关活动推荐
     */
    public function cancelRelevanActivity(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, 'request type error');
        
        if(!isset($request->coachId)) return responseToJson(1, 'no coachId');
        if(!isset($request->activityId)) 
            return responseToJson(1, 'no activityId');
            
        $activity_id_arr = strChangeArr(CoachOrganize::getCoachLogoOrCoverName($request->coachId, 'coach_id'), ',');
        if(empty($activity_id_arr) || count($activity_id_arr) < 1) return responseToJson(1, '该辅导机构为关联相关活动，操作错误');
        
        $is_update = CoachOrganize::updateCoach($request->coachId, ['coach_id' => strChangeArr(deleteArrValue($activity_id_arr, $request->activityId), ','), 'update_time' => time()]);
        return $is_update ? responseToJson(0, '取消成功') : responseToJson(1, '取消失败');
    }


    /**
     * 取消指定辅导机构的所有相关活动推荐
     */
    public function cancelAllReActivity(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, 'request type error');
        if(!isset($request->coachId)) return responseToJson(1, 'no coachId');
        $is_update = CoachOrganize::updateCoach($request->coachId, ['coach_id' => '', 'update_time' => time()]);
        return $is_update ? responseToJson(0, '取消成功') : responseToJson(1, '取消失败');
    }



    /**
     * 设置指定辅导机构的相关活动推荐
     * coachId
     * acIdArr
     */
    public function setCoachActivity(Request $request) {
        if(!$request->isMethod('post')) return responseToJson(2, 'request type error');
        if(!isset($request->coachId)) return responseToJson(1, 'no coachId');
        if(!isset($request->acIdArr) || (!is_array($request->acIdArr) && count($request->acIdArr) < 1)) return responseToJson(1, 'no Activity Array');

        $sys_count = SystemSetup::getContent('coach_choice_activity');


        if(count($request->acIdArr) > $sys_count) return responseToJson(1, '选择的关联活动数大于最多关联数');
        $coach_id = CoachOrganize::getCoachLogoOrCoverName($request->coachId, 'coach_id');

        $coach_ac_arr = ($coach_id != '' || $coach_id!= null) ? strChangeArr($coach_id, ',') : [];
        $arr = array_keys(array_flip($request->acIdArr)+array_flip($coach_ac_arr));
        // $arr = array_intersect($request->acIdArr, $coach_ac_arr);
        $arr = count($arr) > $sys_count ? array_slice($arr, 0, $sys_count) : $arr;

        // return responseToJson(0, '', $arr);

        $is_set = CoachOrganize::updateCoach($request->coachId, ['coach_id' => strChangeArr($arr, ','), 'update_time' => time()]);

        return $is_set ? responseToJson(0, '添加成功') : responseToJson(1, '添加失败');



    }



}