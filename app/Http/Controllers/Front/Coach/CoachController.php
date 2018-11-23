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
            $provice = '';
            if (!empty($request->provice) && $request->provice != '')
                $provice = dictRegion::getProvinceIdByName($request->provice);
            
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
    }