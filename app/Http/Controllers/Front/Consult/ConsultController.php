<?php
namespace App\Http\Controllers\Front\Consult;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\dict as Dict;
use App\Models\zslm_information as ZslmInformation;

class ConsultController extends Controller{


    /**
     * 获取前台搜索页面的资讯查询数据
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
            $keyword = defined($request->keyword) ? trim($request->keyword) : '';
            $get_consult_info = ZslmInformation::getSearchConsults($keyword, $request->pageNumber, $request->pageCount)->toArray();
            foreach ($get_consult_info as $key => $item) {
                $get_consult_info[$key]->create_time = date("Y.m.d",$item->create_time);
                $get_consult_info[$key]->z_text = changeString(strip_tags($item->z_text), 0, 100, '...');
                $get_consult_info[$key]->publisher = '专硕联盟';
            }
            return responseToJson(0, 'success', $get_consult_info);
        }
        else return responseToJson(2, '请求方式错误');
    }

    /**
     * 推荐阅读模块组件的后端接口
     * @param $pageNumber 页面下标
     * @param $type 1获得行业列表咨询推荐模块数据
     */
    public function getRecommendRead(Request $request) {
        if($request->isMethod('get')) {
            // if(isset($request->type) && $request->type == 1)
            $get_recommend_read = ZslmInformation::getRecommendReads($request->pageNumber, $request->type);
            foreach ($get_recommend_read['info'] as $key => $item) {
                $get_recommend_read['info'][$key]->create_time = date("Y.m.d", $item->create_time);
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
            array_push($info_type_list, (object)['id' => 0, 'name' => 'All']);
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
            // if(defined($request->infoTypeId)) return responseToJson(1, '参数错误');
            // dd($request->infoTypeId);
            $pageCount = isset($request->pageCount) ? $request->pageCount : 9;
            $pageNumber = isset($request->pageNumber) ? $request->pageNumber : 1;
            $get_consult_info_list = ZslmInformation::getConsultListInfos($request->infoTypeId, $pageCount, $pageNumber)->toArray();
            foreach ($get_consult_info_list as $key => $item) {
                $get_consult_info_list[$key]->publisher = '专硕联盟';
                $get_consult_info_list[$key]->create_time = date("Y.m.d", $item->create_time);
                $get_consult_info_list[$key]->brief_introduction = changeString($item->brief_introduction, 0, 90, '...');
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
            $get_consult_info_list['info'][$key]->brief_introduction = changeString($item->brief_introduction, 0, 90, '...');
        }
        return $get_consult_info_list;
    }

    
}