<?php

/**
 * 资讯频道首页管理
 */

namespace App\Http\Controllers\Admin\Operate;

use App\Models\information_index_region as InformationIndexRegion;
use App\Models\dict_information_type as DictInformType;
use App\Models\information_index_region;
use App\Models\zslm_information as ZslmInformation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class OperateIndexController extends Controller 
{

    
    /**
     * 资讯频道首页推荐
     */



    /**
     * @api {post} admin/operate/getAppointRegionData 获得指定区域的资讯内容
     * @apiGroup operate
     *
     * @apiParam {Number} regionId 指定区域的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *          {
     *              "region_name":"text",
     *              "zx_id":[
     *                  {
     *                      "id":"xxx",
     *                      "weight":"xxxxxxxxxxxx",
     *                      "zx_name":"front/test/test",
     *                      "information_type":"xxxxxxxxxxxx",
     *                      "create_time":"xxxxxxxxxxxx"
     *                  }
     *              ]
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
    public function getAppointRegionData(Request $request) {
        if($request->isMethod('post')) {

            $region_id = isset($request->regionId) && is_numeric($request->regionId) ? $request->regionId : 0;
            $region_data = InformationIndexRegion::getinformIndexRegionData($region_id, ['region_name', 'zx_id']);
            if(!$region_data) return responseToJson(1, '请求失败');
            
            $region_data->zx_id = ($region_data->zx_id != null) 
            ? (strpos(trim($region_data->zx_id), ',') > 0 
            ? explode(',', trim($region_data->zx_id)) : [$region_data->zx_id]) : null;
            
            $regions = information_index_region::getAllRegionName();
            
            if(!empty($region_data->zx_id)) {
                foreach($region_data->zx_id as $key => $value) {
                    $region_data->zx_id[$key] = ZslmInformation::getInformIdToData($value);
                    if(!empty($region_data->zx_id[$key])) {
                        $region_data->zx_id[$key]->information_type = $region_data->zx_id[$key]->name;
                        unset($region_data->zx_id[$key]->name);
                        $region_data->zx_id[$key]->create_time = date('Y-m-d H:i:s', $region_data->zx_id[$key]->create_time);
                    }
                }
            }
            $region_data->region = $regions;
            return responseToJson(0, '', $region_data);
        }
        else 
            return responseToJson(2, '请求方式错误');
    }





    /**
     * @api {post} admin/operate/setAppointRegionName 修改指定区域的名称
     * @apiGroup operate
     *
     * @apiParam {Number} regionId 指定区域的id,0是区域一;1是区域二
     * @apiParam {String} regionName　要修改的名称
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
    public function setAppointRegionName(Request $request) {
        if($request->isMethod('post')) {
            $region_id = isset($request->regionId) && is_numeric($request->regionId) ? $request->regionId : -1;
            $region_name = !empty(trim($request->regionName)) && is_string(trim($request->regionName)) ? trim($request->regionName) : '';
            if($region_name == '') return responseToJson(1, '名称不能为空');
            if($region_id >= 0 && !empty($region_name)) {
                $if_update = InformationIndexRegion::setRegionName($region_id, $region_name);
                return $if_update ? responseToJson(0, '更新成功') : responseToJson(1, '更新失败');
            }
        }
        else 
            return responseToJson(2, '  请求方式错误');
    }





    /**
     * @api {post} admin/operate/setAppoinInformationWeight 设置指定资讯的权重
     * @apiGroup operate
     *
     * @apiParam {Number} informationId 指定资讯的id
     * @apiParam {Number} weight 要修改的权重，默认为0
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
    public function setAppoinInformationWeight(Request $request) {
        if($request->isMethod('post')) {
            $information_id = is_numeric($request->informationId) ? $request->informationId : 0;
            $weight = is_numeric($request->weight) ? $request->weight : -1;
            if($information_id !== 0 && $weight >= 0) {
                $if_update = ZslmInformation::setInformWeight($information_id, $weight);
                return $if_update ? responseToJson(0, '更新成功') : responseToJson(1, '更新失败');
            }
            else 
                return responseToJson(1, '参数错误');
        }
        else 
            return responseToJson(2,'请求方式错误');
    }




    /**
     * @api {post} admin/operate/deleteAppoinInformation 删除指定区域上的指定资讯
     * @apiGroup operate
     *
     * @apiParam {Number} RegionId 指定区域的id
     * @apiParam {Number} InformationId 要删除的资讯的id
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
    public function deleteAppoinInformation(Request $request) {
        if($request->isMethod('post')) {
            $region_id = is_numeric($request->RegionId) ? $request->RegionId : 0;
            $information_id = isset($request->InformationId) ? $request->InformationId : 0;

            if(!empty($region_id) && !empty($information_id)) {
                $is_delete = InformationIndexRegion::deleteRegionInformation($region_id, $information_id);

                return $is_delete ? responseToJson(0, '删除成功') : responseToJson(1, '删除失败');
            }
        }
        else 
            return responseToJson(2, '请求方式错误');
    }


    /**
     * 资讯频道首页推荐-添加列表
     */



    /**
     * @api {post} admin/operate/getInformPagingData 获取咨询列表添加分页数据
     * @apiGroup operate
     * 
     * 
     * @apiParam {Number} informationTypeId 资讯类型id(0是总量)
     * @apiParam {String} titleKeyword 标题关键字
     * @apiParam {Number} pageCount 页面显示行数
     * @apiParam {Number} pageNumber 跳转页面下标
     * @apiParam {Number} sortType 排序类型(0按时间升序；1按时间降序)
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
     *              "z_type":"xxxxxxxxxxxx",
     *              "create_time":"xxxxxxxxxxxx"
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
     public function getInformPagingData(Request $request) {
        if($request->isMethod('post')) {
            $inform_type_id = (isset($request->informationTypeId) 
                && is_numeric($request->informationTypeId)) 
                ? $request->informationTypeId : 0; 
            $page_count = (isset($request->pageCount) && is_numeric($request->pageCount)) ? $request->pageCount : 10;
            $sort_type = (isset($request->sortType) && is_numeric($request->sortType)) ? $request->sortType : 0;
            $page_number = (isset($request->pageNumber) && is_numeric($request->pageNumber)) ? $request->pageNumber : 0;
    
            $title_keyword = isset($request->titleKeyword) ? trim($request->titleKeyword) : '';
    
            $select_data = ZslmInformation::getInformPageData([
                'inform_type_id' => $inform_type_id,
                'page_count' => $page_count,
                'sort_type' => $sort_type,
                'page_number' => $page_number,
                'title_keyword' => $title_keyword
            ]);
            if(count($select_data) > 0 && count($select_data['data']) > 0) {
                $inform_type = DictInformType::getAllInformType()->toArray();
    
                foreach($select_data['data'] as $key => $item) {
                    foreach($inform_type as $keys => $value)
                        if($select_data['data'][$key]->z_type == $value->id) $select_data['data'][$key]->z_type = $value->name;
                    $select_data['data'][$key]->create_time = date('Y-m-d H:i:s', $select_data['data'][$key]->create_time);
                }
            }
            return responseToJson(0, '', $select_data);

        }
        else 
            return responseToJson(2, '请求方式错误');
     }



     //注意添加的时候需要判断资讯是否在这两个区域中
    /**
     * @api {post} admin/operate/addAppoinInformations 向指定区域添加相关咨讯
     * @apiGroup operate
     *
     * @apiParam {Array} informArr 需要添加的资讯id数组
     * @apiParam {Number} appointId 指定区域的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "添加成功"
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
     public function addAppoinInformations(Request $request) {
        $inform_arr = isset($request->informArr) && is_array($request->informArr) ? $request->informArr : [];
        if(empty($inform_arr)) return responseToJson(1, '请选择加入推荐的咨询');
        $appoint_id = isset($request->appointId) && is_numeric($request->appointId) ? $request->appointId : -1;
        if($appoint_id > -1) {
            $is_update = InformationIndexRegion::addRegionInform($appoint_id, $inform_arr);
            return $is_update ? responseToJson(0, '添加成功') : responseToJson(1, '添加失败');
        }
        else 
            return responseToJson(1, '请选择区域');
     }





    /**
     * @api {post} admin/operate/getInformationType 获取所有资讯类型
     * @apiGroup operate
     * 
     * @apiDescription 在资讯频道首页推荐-添加列表页面调用，获得所有资讯的类型，不需要传递参数
     * 
     *
     * @apiSuccess {Object[]} obj  资讯类型名称
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
     *
     */
     public function getInformationType(Request $request) {

        if($request->isMethod('post')) 
            return responseToJson(0, '', DictInformType::getAllInformType());
        else 
            return responseToJson(1, '请求方式错误');
     }



}