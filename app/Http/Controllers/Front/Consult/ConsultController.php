<?php
namespace App\Http\Controllers\Front\Consult;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\dict as Dict;
use App\Models\banner_ad as BannerAd;
use App\Models\zslm_information as ZslmInformation;
use App\Models\information_relation as InfomationRelation;

class ConsultController extends Controller{


    /**
     * 获取前台搜索页面的资讯查询数据getAppointRead
     * @param $keyword 关键字
     * @param $pageNumber 页面下标
     * @param $pageCount 页面显示行数
     * 
     * @return 
     * 资讯标题
     * 发布时间
     * 资讯首部部分内容字段
     * 资讯封面图片
     * 发布人
     */
    public function getSearchConsult(Request $request) {
        if($request->isMethod('get')) {
            $keyword = !empty($request->keyword) ? trim($request->keyword) : '';
            $get_consult_info = ZslmInformation::getSearchConsults($keyword, $request->pageNumber, $request->pageCount);
            foreach ($get_consult_info['info'] as $key => $item) {
                $get_consult_info['info'][$key]->time = date("Y.m.d",$item->time);
                $get_consult_info['info'][$key]->img = splicingImgStr('admin', 'info', $item->img);
                $get_consult_info['info'][$key]->content = changeString(strip_tags($item->content), 0, 100, '...');
                $get_consult_info['info'][$key]->author = 'MBA  Helper';
            }
            if(empty($get_consult_info['info'])) return responseToJson(1, '没有查询到数据');
            return responseToJson(0, 'success', $get_consult_info);
        }
        else return responseToJson(2, '请求方式错误');
    }

    /**
     * 推荐阅读模块或行业列表组件的后端接口
     * @param $pageNumber 页面下标
     * @param $type 1获得行业列表咨询推荐模块数据
     */
    public function getRecommendRead(Request $request) {
        if($request->isMethod('get')) {
            // if(isset($request->type) && $request->type == 1)
            $get_recommend_read = ZslmInformation::getRecommendReads($request->pageNumber, $request->type);
            foreach ($get_recommend_read['info'] as $key => $item) {
                $get_recommend_read['info'][$key]->create_time = date("Y.m.d", $item->create_time);
                if(!empty($get_recommend_read['info'][$key]->z_image))
                    $get_recommend_read['info'][$key]->z_image = splicingImgStr('admin', 'info', $get_recommend_read['info'][$key]->z_image);
            }
            return responseToJson(0, 'success', $get_recommend_read);
        }
        else return responseToJson(2, '请求方式错误');
    }



    /**
     * 获得咨询类型
     */
    public function getConsultType(Request $request) {
        if($request->isMethod('get')) {
            $info_type_list = Dict::dictInformationType()->toArray();
            array_unshift($info_type_list, (object)['id' => 0, 'name' => 'All']);
            return responseToJson(0, 'success', $info_type_list);
        }
    }

    /**
     * 看资讯获取首部咨询轮播
     */
    public function getConsultListBroadcast(Request $request) {
        if($request->isMethod('get')) {
            $get_broadcast = ZslmInformation::getConsultListBroadcasts();
            return responseToJson(0, 'success', $get_broadcast);
        }
        else return responseToJson(2, '请求方式错误');
    }


    

    /**
     * 看资讯列表页获得咨询数据
     * @param $infoTypeId 咨询类型id
     * @param $pageNumber 页面下标
     * @param $pageCount 页面显示行数
     */
    public function getConsultListInfo(Request $request) {
        if($request->isMethod('get')) {
            $pageCount = isset($request->pageCount) ? $request->pageCount : 9;
            $pageNumber = isset($request->pageNumber) ? $request->pageNumber : 1;
            $get_consult_info_list = ZslmInformation::getConsultListInfos($request->infoTypeId, $pageCount, $pageNumber);
            foreach ($get_consult_info_list['info'] as $key => $item) {
                $get_consult_info_list['info'][$key]->publisher = '专硕联盟';
                $get_consult_info_list['info'][$key]->create_time = date("Y.m.d", $item->create_time);
                $get_consult_info_list['info'][$key]->z_image = splicingImgStr('admin', 'info', $item->z_image);
                $get_consult_info_list['info'][$key]->brief_introduction = changeString($item->brief_introduction, 0, 90, '...');
            }
            return responseToJson(0, 'success', $get_consult_info_list);
        }
        else return responseToJson(2, 'error');
    }

    public function getIndexConsult($page,$page_size){
        $get_consult_info_list = ZslmInformation::getConsultListInfos(0, $page_size, $page);
        foreach ($get_consult_info_list['info'] as $key => $item) {
            $get_consult_info_list['info'][$key]->publisher = '专硕联盟';
            $get_consult_info_list['info'][$key]->create_time = date("Y.m.d", $item->create_time);
            $get_consult_info_list['info'][$key]->z_image = splicingImgStr('admin', 'info', $item->z_image);
            $get_consult_info_list['info'][$key]->brief_introduction = changeString($item->brief_introduction, 0, 90, '...');
        }
        return $get_consult_info_list;
    }


    /**
     * 资讯详情页获取资讯详情信息
     */
    public function getConsultDeyail(Request $request) {
        if($request->isMethod('get')) {
            $consult_id = !empty($request->consultId) ? $request->consultId : 0;
            if($consult_id == 0) return responseToJson(1, '参数错误');
            $consult_info = ZslmInformation::getAppointInfoMsgss($consult_id, ['zslm_information.id','zslm_information.title', 'zslm_information.zx_name', 'zslm_information.z_text','zslm_information.create_time', 'zslm_information.z_image', 'zslm_information.z_alt', 'is_delete', 'dict_information_type.name as type_name']);
            if(empty($consult_info) || $consult_info->is_delete == 1) return responseToJson(1, '不存在该咨询');
            if(!empty($consult_info->z_image)) $consult_info->z_image = splicingImgStr('admin', 'info', $consult_info->z_image);
            $consult_info->publisher = '专硕联盟';
            $consult_info->create_time = date("Y.m.d", $consult_info->create_time);
            return responseToJson(0, 'success', $consult_info);
        }
        else return responseToJson(2, '请求方式错误');
    }

    /**
     * 获得指定页面的广告信息
     * @param $url 指定页面的路由
     */
    public function getBt(Request $request) {
        if($request->isMethod('get')) {
            $url = !empty($request->url) ? $request->url : '';
            if($url == '') return responseToJson(1, '参数错误');
            $get_bt = BannerAd::getFrontConBt($url)->toArray();
            return responseToJson(0, 'success', $get_bt);
        }
        else return responseToJson(2, '请求方式错误');
    }

    /**
     * 活动详情页获得热门(推荐)活动数据列表
     */
    public function getAppointRead(Request $request) {
        if($request->isMethod('get')) {
            $consult_id = !empty($request->consultId) ? $request->consultId : 0;
            $page_number = !empty($request->pageNumber) ? $request->pageNumber : 0;
    
            if($consult_id == 0) return responseToJson(1, '参数错误');

            $info_read = InfomationRelation::getAppointInfoContent($consult_id, 'tj_yd_id');
            $info_read_arr = !empty($info_read) ? strChangeArr($info_read, ',') : [];

            
            $get_read_info = ZslmInformation::getFrontAppointRead($info_read_arr, $page_number);
            if(count($get_read_info['info']))
                foreach ($get_read_info['info'] as $key => $item) {
                    $get_read_info['info'][$key]->create_time = date("Y.m.d", $item->create_time);
                }
            return responseToJson(0, 'success', $get_read_info);

        }
        else return responseToJson(2, '请求方式错误');
    }




    
}