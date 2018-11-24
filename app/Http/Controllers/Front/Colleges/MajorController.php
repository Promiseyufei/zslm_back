<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/18
     * Time: 18:00
     */
    
    namespace App\Http\Controllers\Front\Colleges;
    
    use App\Models\dict_fraction_type;
    use App\Models\dict_major_direction;
    use App\Models\dict_major_follow;
    use App\Models\dict_major_type;
    use App\Models\dict_recruitment_pattern;
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
            if (!$request->method('get')) {
                return responseToJson(1, '请求方式错误');
            }
            if (!isset($request->page) || !isset($request->page_size) || !is_numeric($request ->page) || !is_numeric($request->page_size))
                return responseToJson(1, '没有页码、页面大小或者页码、页面大小不是数字');
            $provice = '';
            // if (!empty($request->provice) && $request->provice != '')
            //     $provice = dictRegion::getProvinceIdByName($request->provice)
            //;
            $felds = ['id', 'province', 'magor_logo_name',
                'z_name', 'update_time', 'major_confirm_id', 'major_follow_id'];
            
            $majors = zslmMajor::getMajorBySelect($request->z_type, $request->z_name,
                $provice, $request->professional_direction, $request->page, $request->page_size, $felds, $request->major_order);
            
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
                    $request->score_type, $request->enrollment_mode, $request->project_count);
                
                $majors[$i]->major_confirm_id = $major_confirms[$majors[$i]->major_confirm_id];
                $majors[$i]->major_follow_id = $major_follows[$majors[$i]->major_follow_id];
            }
            $count = zslmMajor::getMajorBySelectCount($request->z_type, $request->z_name, $provice);
            $majors->count = $count;
            return responseToJson(0, 'success', [$majors,0]);
        }
        
        public function getInfo(Request $request)
        {
            if (!$request->method('get')) {
                return responseToJson(1, '请求方式错误');
            }
            $major_type = dict_major_type::getAllMajor();
            $major_fangxiang = dict_major_direction::getAllDirection();
            $socre_type = dict_fraction_type::getAllType();
            $tongzhao_type = dict_recruitment_pattern::getAllPattern();
            return responseToJson(0, 'success', ['type' => $major_type, 'direction' => $major_fangxiang, 'socre' => $socre_type, 'pattern' => $tongzhao_type]);
        }
        
        
        public function getMajorByName(Request $request)
        {
            if (!$request->method('get')) {
                return responseToJson(1, '请求方式错误');
            }
            if (!isset($request->page) || !isset($request->page_size) || !is_numeric($request ->page) || !is_numeric($request->page_size))
                return responseToJson(1, '没有页码、页面大小或者页码、也买你大小不是数字');
            $name = defined($request->name) ? trim($request->name) : '';
            $majors = $this->getMajorToIndex($name, $request->page, $request->page_size);
            if (sizeof($majors) == 0)
                return responseToJson(1, '没有数据');
            return responseToJson(0, 'success', $majors);
        }
        
        
        public function getMajorToIndex($name, $page = 1, $page_size = 7)
        {
            $felds = ['id', 'province', 'magor_logo_name',
                'z_name', 'major_cover_name', 'major_confirm_id', 'major_follow_id'];
            $zero = null;
            $major_confirms = majorConfirm::getAllMajorConfirm();
            $major_follows = majorFollow::getAllMajorFollow();
            
            $majors = zslmMajor::getMajorBySelect($zero, $name,
                '', null, $page, $page_size, $felds, 0);
            if(empty($majors))
                return [];
          
            for ($i = 0; $i < sizeof($majors); $i++) {
                $majors[$i]->major_confirm_id = $major_confirms[$majors[$i]->major_confirm_id];
                $majors[$i]->major_follow_id = $major_follows[$majors[$i]->major_follow_id];
                if($majors[$i]->province !== '')
                    $majors[$i]->province = getProCity($majors[$i]->province);
            }

            

            return $majors;
            
        }
    }