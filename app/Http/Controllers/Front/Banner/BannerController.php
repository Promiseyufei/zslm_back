<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2019/2/14
     * Time: 15:50
     */
    
    namespace App\Http\Controllers\Front\Banner;
    
    
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\urls_bt as UrlsBt;
    use App\Models\banner_ad as BannerAd;
    class BannerController extends Controller
    {
    
        /**
         * 根据get请求参数b_name获取相应页面的banner或者广告，limit参数决定其获取图片多少，type决定是返回banner还是广告
         * @param Request $request
         *
         * @return mixed
         */
        public function getBanner(Request $request){
            if(!isset($request->b_name) || !isset($request->limit) || !isset($request->type))
                return responseToJson(1,'参数错误');
            
            $bt_id = UrlsBt::getBannerByName($request->b_name);
            if(!isset($bt_id))
                return responseToJson(1,'广告位名称错误');
            $banners = BannerAd::getBannerByById($bt_id->id,$request->limit,$request->type);
            if(!empty($banners)){
                for($i = 0;$i<sizeof($banners);$i++){
                    $banners[$i]->img = splicingImgStr('admin','operate', $banners[$i]->img);
                }
            }
            return responseToJson(0,'success',$banners);
        }
    
   
        
    }