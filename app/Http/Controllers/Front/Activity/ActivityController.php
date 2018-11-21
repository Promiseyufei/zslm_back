<?php
namespace App\Http\Controllers\Front\Activity;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\zslm_activitys as ZslmActivitys;

class ActivityController extends Controller{


    /**
     * 搜索页面请求活动
     * @param $keyword 关键字
     * @param $pageCount 页面显示行数
     * @param $pageNumber 页面显示下标
     * 
     * return :
     * 活动id
     * 活动名称
     * 活动地点（城市）
     * 活动日期范围
     * 活动开始状态
     * 活动封面
     * 活动类型
     * 活动主办院校名称
     * 
     */
    public function getSearchActivity(Request $request) {

        if($request->isMethod('get')) {
            $keyword = defined($request->keyword) ? trim($request->keyword) : '';
            // if(!defined($request->pageCount) || !isset($requesst->pageNumber)) return responseToJson(1, '参数错误');
            $get_activity_info = ZslmActivitys::getSearchActivitys($keyword, $request->pageNumber, $request->pageCount)->toArray();
            // dd($get_activity_info);
            foreach ($get_activity_info as $key => $item) {
                $now_time = time();
                $get_activity_info[$key]->startState = $now_time < $item->begin_time ? 0 : $now_time > $item->end_time ? 2 : 1;
                $get_activity_info[$key]->begin_time = date("m-d",$item->begin_time);
                $get_activity_info[$key]->end_time = date("m-d", $item->end_time);
                if($item->province !== '')
                    $get_activity_info[$key]->province = getProCity($item->province);
            }
            return responseToJson(0, 'success', $get_activity_info);
        }
        else return responseToJson(2, '请求方式错误');
    }
}