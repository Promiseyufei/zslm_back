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

    class MajorController extends Controller
    {
        public function getMajor(Request $request){
//            dd($request->all());
            $provice = '';
            if(!empty($request->provice) && $request->provice !='')
                $provice = dictRegion::getProvinceIdByName($request->provice);
            $majors = zslmMajor::getMajorBySelect($request->z_type,$request->z_name,$request->provice,$request->page,$request->page_size);
            if(empty($majors))
                return responseToJson(1,"暂无数据");
            for($i = 0;$i < sizeof($majors);$i++){
                $majors[$i]->create_time =  date("Y-m-d",$majors[$i]->create_time );
                $addressArr = strChangeArr( $majors[$i]->province,EXPLODE_STR);
                $majors[$i]->province = dictRegion::getOneArea($addressArr[0])[0]->name;
                $majors[$i]->city = '';
                if(sizeof($addressArr)>1)
                    $majors[$i]->city = dictRegion::getOneArea($addressArr[1])[0]->name;
    
              $majors[$i]->product =   majorRecruitProject::getProjectByMid($majors[$i]->id,$request->min,$request->max,$request->money_ordre,$request->score_type,$request->enrollment_mode);
                
            }
            dd($majors);
            
        }
    }