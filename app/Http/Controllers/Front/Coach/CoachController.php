<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/21
     * Time: 10:14
     */
    
    namespace App\Http\Controllers\Front\Coach;
    
    
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    
    use App\Models\coach_organize as coachOrganize;
    
    
    class CoachController extends Controller
    {
        public function getSelectCoach(Request $request)
        {
            if(!$request->method('get'))
                return responseToJson(1,'请求方式错误');
            if(!isset($request->page) || !isset($request->page_size) || !is_numeric($request->page) || !is_numeric($request->page_size))
                return responseToJson(1,'没有页码、页面大小或者页码、也买你大小不是数字');
            $provice = '';
            
//            if (!empty($request->provice) && $request->provice != '')
//                $provice = dictRegion::getProvinceIdByName($request->provice);
            
            $fields = ['id', 'coach_name', 'province', 'if_coupons', 'if_back_money', 'cover_name', 'cover_alt', 'logo_name', 'logo_alt'];
            $coachs = coachOrganize::getSelectCoach($provice, $request->coach_type,
                $request->coach_name, $request->page, $request->page_size,
                $request->if_back, $request->if_coupon, $fields);
        
            if (sizeof($coachs) == 0)
                return responseToJson(1, '暂时没有数据');
            $len = sizeof($coachs);
            for ($i = 0; $i < $len; $i++) {
                $coachs[$i]->son_coachs = coachOrganize::getSonCoach($coachs[$i]->id);
            }
            $count = coachOrganize::getSelectCoachCount($provice, $request->coach_type,
                $request->coach_name, $request->if_back, $request->if_coupon);
            $coachs->count = $count;
            return responseToJson(0,'success',$coachs);
        }
        
        public function getCoachByName(Request $request){
            if(!$request->isMethod('get'))
                return responseToJson('1','请求错误');
    
            if(!isset($request->page) || !isset($request->page_size) || !is_numeric($request->page) || !is_numeric($request->page_size))
                return responseToJson(1,'没有页码、页面大小或者页码、也买你大小不是数字');
            
            $coachs = $this->getIndexInfo($request->name,$request->page,$request->page_size);
            if(sizeof($coachs) == 0)
                return responseToJson(1,'没有数据');
            return responseToJson(0,'success',$coachs);
        }
        
        public function getIndexInfo($name,$page = 1,$page_size = 3){
            $fields = ['id', 'coach_name', 'if_coupons', 'if_back_money', 'cover_name', 'cover_alt', 'logo_name', 'logo_alt'];
            $coachs = coachOrganize::getSelectCoach('', null,
                $name, $page, $page_size,
                null,null, $fields);
            return $coachs;
        }
    }