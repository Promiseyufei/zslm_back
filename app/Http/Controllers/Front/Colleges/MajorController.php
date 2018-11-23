<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/18
     * Time: 18:00
     */
    
    namespace App\Http\Controllers\Front\Colleges;
    
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    
    use App\Models\dict_region as dictRegion;
    use App\Models\zslm_major as zslmMajor;
    use App\Models\major_recruit_project as majorRecruitProject;
    use App\Models\dict_major_confirm as majorConfirm;
    use App\Models\dict_major_follow as majorFollow;
    
    class MajorController extends Controller
    {
        public function getMajor(Request $request)
        {
            $provice = '';
            if (!empty($request->provice) && $request->provice != '')
                $provice = dictRegion::getProvinceIdByName($request->provice);
            $felds = ['id', 'province', 'magor_logo_name',
                'z_name', 'update_time', 'major_confirm_id', 'major_follow_id'];
            
            $majors = zslmMajor::getMajorBySelect($request->z_type, $request->z_name,
                $provice, $request->page, $request->page_size, $felds, $request->major_order);
            
            if (empty($majors))
                return responseToJson(1, "暂无数据");
            
            $major_confirms = majorConfirm::getAllMajorConfirm();
            $major_follows = majorFollow::getAllMajorFollow();
            for ($i = 0; $i < sizeof($majors); $i++) {
                $majors[$i]->update_time = date("Y-m-d", $majors[$i]->update_time);
                $addressArr = strChangeArr($majors[$i]->province, EXPLODE_STR);
                $majors[$i]->province = dictRegion::getOneArea($addressArr[0])[0]->name;
                $majors[$i]->city = '';
                if (sizeof($addressArr) > 1)
                    $majors[$i]->city = dictRegion::getOneArea($addressArr[1])[0]->name;
                
                $majors[$i]->product = majorRecruitProject::getProjectByMid($majors[$i]->id,
                    $request->min, $request->max, $request->money_ordre,
                    $request->score_type, $request->enrollment_mode,$request->project_count);
                
                $majors[$i]->major_confirm_id = $major_confirms[$majors[$i]->major_confirm_id];
                $majors[$i]->major_follow_id = $major_follows[$majors[$i]->major_follow_id];
            }
            $count = zslmMajor::getMajorBySelectCount($request->z_type, $request->z_name, $provice);
            $majors->count = $count;
            return responseToJson(0, 'success', $majors);
        }
    }