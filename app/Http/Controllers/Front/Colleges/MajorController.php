<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/18
     * Time: 18:00
     */
    
    namespace App\Http\Controllers\Front\Colleges;
    
 
    use App\Http\Controllers\Front\Activity\ActivityController;
    use App\Models\activity_relation;
    use App\Models\dict_fraction_type;
    use App\Models\dict_major_direction;
    use App\Models\dict_major_type;
    use App\Models\dict_recruitment_pattern;
    use App\Models\information_major;
    use App\Models\user_activitys;
    use App\Models\user_follow_major;
    use App\Models\zslm_information;
    use function Couchbase\defaultDecoder;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    
    use App\Models\dict_region as dictRegion;
    use App\Models\zslm_major as zslmMajor;
    use App\Models\major_recruit_project as majorRecruitProject;
    use App\Models\dict_major_confirm as majorConfirm;
    use App\Models\dict_major_follow as majorFollow;
    use App\Models\major_files as majorFiles;
    use App\Models\activity_relation as activityRelation;
    use App\Models\zslm_activitys as ZslmActivitys;
    
    
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
                
                $fileds = ['project_name','cost','language','class_situation','student_count'];
                $majors[$i]->product = majorRecruitProject::getProjectByMid($majors[$i]->id,
                    $request->min, $request->max, $request->money_ordre,
                    $request->score_type, $request->enrollment_mode, $request->project_count,$fileds);
                
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
    
        /**
         * 获取院校专业详情
         *
         * @param Request $request
         */
        
        public function getMajorDetails(Request $request){
        
            if(!$request->isMethod("get"))
                return responseToJson(1,"请求错误");
            
            if(!isset($request->id) && !is_numeric($request->id))
                return responseToJson(1,"院校id不存在，或者不为数字");
            if(!isset($request->u_id) && !is_numeric($request->u_id))
                return responseToJson(1,"U_id错误");
    
            $felds = ['id', 'z_name', 'magor_logo_name',
                'major_follow_id', 'province','index_web',
                'admissions_web','address','phone', 'major_confirm_id',
                'access_year','wc_image','wb_image'];
            
            $major = zslmMajor::getMajorById($request->id,$felds);
            if(sizeof($major) == 0)
                return responseToJson(1,'没有数据');
    
            $major[0]->file = majorFiles::getMajorFile($request->id);
            $fileds = ['id','project_name','student_count','language','eductional_systme',
                'can_conditions','score_describe','score_type','recruitment_pattern',
                'graduation_certificate','other_explain','cost',"enrollment_mode",'class_situation'];
            $major[0]->project = majorRecruitProject::getProjectByMid($request->id,0,
                0,0,'','',0,$fileds);
            $is_guanzhu =  user_follow_major::getIfUsesMajor($request->u_id,$request->id);
            $major[0]->is_guanzhu = $is_guanzhu == 0 ? false : true;
            return $major;
        }
    
        /**
         * 获取相关活动
         * @param Request $request
         *
         * @return mixed
         */
        
        public function getMajorActive(Request $request){
    
            if(!$request->isMethod("get"))
                return responseToJson(1,"请求错误");
    
            if(!isset($request->id) && !is_numeric($request->id))
                return responseToJson(1,"院校id不存在，或者不为数字");
    
            if (!isset($request->page) || !isset($request->page_size) || !is_numeric($request ->page) || !is_numeric($request->page_size))
                return responseToJson(1, '没有页码、页面大小或者页码、页面大小不是数字');
            //返回关联活动查询结果
            //创建 ActivityController 对象
    
            $get_activitys = ZslmActivitys::getFrontActiListById($request->id,$request->page,$request->page_size);
            if(sizeof($get_activitys['info']) == 0)
                return responseToJson(1,'暂无数据');
            
            $get_activitys['info'] = $get_activitys['info']->toArray();
            
            foreach ($get_activitys['info'] as $key => $item) {
                $now_time = time();
                $get_activitys['info'][$key]->start_state = $now_time < $item->begin_time ? 0 : $now_time > $item->end_time ? 2 : 1;
                $get_activitys['info'][$key]->begin_time = date("m-d",$item->begin_time);
                $get_activitys['info'][$key]->end_time = date("m-d", $item->end_time);
                if($item->province !== '')
                    $get_activitys['info'][$key]->province = getProCity($item->province);
            }
            
            return responseToJson(0,'success',$get_activitys);
            
        }
    
        /**
         * 获取推荐咨询
         */
        
        public function getMajorInformation(Request $request){
    
            if(!isset($request->id) && !is_numeric($request->id))
                return responseToJson(1,"院校id不存在，或者不为数字");
    
            if (!isset($request->page) || !isset($request->page_size) || !is_numeric($request ->page) || !is_numeric($request->page_size))
                return responseToJson(1, '没有页码、页面大小或者页码、页面大小不是数字');
            $fileds = ['zx_id'];
           $inf =  information_major::getMajorInformation($request->id,$request->page,$request->page_size,$fileds);
           $len = sizeof($inf) ;
           if($len== 0)
               return responseToJson(1,'暂无数据');
            //咨询id数组
            $inf_ids = [];
            for($i = 0;$i<$len;$i++)
                $inf_ids[$i] = $inf[$i]->zx_id;
    
            $fileds = ['id','zx_name','z_image','z_alt','brief_introduction','z_from','update_time'];
            $information = zslm_information::getInfoByIds($inf_ids,$fileds);
            return responseToJson(0,'success',$information);
    
        }
        /**
         * 获取活动的主办院校
         */
        
        public function getActiveMajor(Request $request){
            
            if(!isset($request->a_id) || !is_numeric($request->a_id))
                return responseToJson(1,'a_id 错误');
            if(!isset($request->u_id) || !is_numeric($request->u_id))
                return responseToJson(1,'a_id 错误');
            
           $major =  activity_relation::getOneMajorActivity($request->a_id);
      
           if(sizeof($major) == 0)
               return responseToJson('1','暂无数据');
           //判断用户是否关注了该院校，0表示没有，大于0表示关注
           $if_guanzhu = user_follow_major::getIfUsesMajor($request->u_id,$major[0]->host_major_id);
            $felds = ['id','province','z_name','magor_logo_name','major_cover_name'];
            $major_msg = zslmMajor::getMajorById($major[0]->host_major_id, $felds);
            $major_msg[0]->is_guanzhu = $if_guanzhu == 0 ? false : true;
            //获取文字的省市
            $addressArr = strChangeArr($major_msg[0]->province, EXPLODE_STR);
            $major_msg[0]->province = dictRegion::getOneArea($addressArr[0])[0]->name;
            $major_msg[0]->city = '';
            if (sizeof($addressArr) > 1)
                $major_msg[0]->city = dictRegion::getOneArea($addressArr[1])[0]->name;
            return responseToJson(0,'success',$major_msg);
           
        }
    
        /**
         * 用户关注院校
         * @param Request $request
         */
        public function setUserMajor(Request $request){
            if(!isset($request->m_id) || !is_numeric($request->m_id))
                return responseToJson(1,'a_id 错误');
            if(!isset($request->u_id) || !is_numeric($request->u_id))
                return responseToJson(1,'a_id 错误');
            
           $result =  user_follow_major::setUserMajor($request->u_id,$request->m_id);
           if($result == 1)
               return responseToJson(0,'success');
           else
               return responseToJson(1,'关注失败');
        }
        
        
    }