<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2019/2/28
     * Time: 20:42
     */
    
    namespace App\Http\Controllers\Front\Infomation;
    
    
    use App\Models\information_index_region;
    use App\Models\information_major;
    use App\Models\zslm_information;
    use Illuminate\Http\Request;

    class InformationController
    {
    
        /**
         * 获取推荐区域咨询
         * @param Request $request
         *
         * @return mixed
         */
        public function getRecommend(Request $request){
        
            $info_regions = information_index_region::getAllRegionInfo();
            
            //若推荐区域没有推荐咨询的id，返回无数据
            if(empty($info_regions))
                return responseToJson(1,'暂无数据');
            
            //遍历info_regions数组，取得咨询的相信信息
            for($i = 0;$i<sizeof($info_regions);$i++){
                $zx_ids = strChangeArr($info_regions[$i]->zx_id,',');
                if(empty($zx_ids) || sizeof($zx_ids) == 0){
                    $info_regions[$i]->zx_info = [];
                    continue;
                }
                $info_regions[$i]->zx_info = zslm_information::getRecommendInfo($zx_ids);
                $len = 0;
                if(!empty($info_regions[$i]->zx_info) && ($len = sizeof($info_regions[$i]->zx_info)) > 0){
                    for($j = 0 ; $j < $len ; $j++){
                        $info_regions[$i]->zx_info[$j]->create_time =  date("Y-m-d",    $info_regions[$i]->zx_info[$j]->create_time);
                        $info_regions[$i]->zx_info[$j]->z_image = splicingImgStrPro('admin/info/', $info_regions[$i]->zx_info[$j]->z_image);
                    }
                }
            }
            return responseToJson(0,'success',$info_regions);
        }
    }