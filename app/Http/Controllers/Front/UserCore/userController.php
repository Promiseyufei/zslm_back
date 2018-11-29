<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/23
     * Time: 4:34
     */
    
    namespace App\Http\Controllers\Front\UserCore;

    use App\Models\news_users as newUsers;
    use App\Models\user_activitys as userActivitys;
    use App\Models\user_coupon as userCoupon;
    use App\Models\user_follow_major as userFollowMajor;
    use App\Models\user_information as user;

    use App\Models\dict_region as dictRegion;
    use App\Models\major_recruit_project as majorRecruitProject;
    use App\Models\dict_major_confirm as majorConfirm;
    use App\Models\dict_major_follow as majorFollow;
    
    
    
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class userController extends Controller
    {
        public function getUserInfo(Request $request){
            
            if(!$request->isMethod("get"))
                return responseToJson(1,'请求错误');
            else if(!isset($request->id))
                return responseToJson(1,'缺少id');
            $user = user::getUserFrontMsg($request->id,['user_name','head_portrait','address']);
            
            if(sizeof($user) == 0)
                return responseToJson(1,'没有该用户');
            
            $addr = getProCity($user[0]->address);
            unset($user[0]->address);
            $user[0]->provice = $addr['province'];
            if(sizeof($addr)>1)
                $user[0]->city = $addr['city'];
            $majorCount = userFollowMajor::getCountUserMajor($request->id);
            $activeCount = userActivitys::getCountUserActivity($request->id);
            $newCount = newUsers::getCountUserNews($request->id,0);
            $couponCount = userCoupon::getCountUserCoupon($request->id,0);

            $user[0]->majorCount = $majorCount;
            $user[0]->activeCount = $activeCount;
            $user[0]->newCount = $newCount;
            $user[0]->couponCount = $couponCount;
            return responseToJson(0,'success',$user);
            
        }
        
        public function getUserMajor(Request $request){
            if(!$request->isMethod('get')){
                return responseToJson(1,'请求错误');
            }
            if(!isset($request->id)){
                return responseToJson(1,'没有 id');
            }
         
            if(isset($request->page) && isset($request->page_size) && is_numeric($request->page) && is_numeric($request->page_size) ){
            
                $userMajor = userFollowMajor::getUserFollowMajors($request->id,
                    $request->page,$request->page_size,
                    ['major_id','z_name','province','major_follow_id','major_confirm_id','magor_logo_name','major_logo_alt']);
                if(sizeof($userMajor) == 0){
                    return responseToJson(1,'无数据');
                }
                
                $major_confirms = majorConfirm::getAllMajorConfirm();
                $major_follows = majorFollow::getAllMajorFollow();
                for ($i = 0; $i < sizeof($userMajor); $i++) {
                    $addressArr = strChangeArr($userMajor[$i]->province, EXPLODE_STR);
                    $userMajor[$i]->province = dictRegion::getOneArea($addressArr[0])[0]->name;
                    $userMajor[$i]->city = '';
                    if (sizeof($addressArr) > 1)
                        $userMajor[$i]->city = dictRegion::getOneArea($addressArr[1])[0]->name;
    
                    $fileds = ['project_name','cost','language','class_situation','student_count'];
                    $userMajor[$i]->product = majorRecruitProject::getProjectByMid($userMajor[$i]->major_id,
                        $request->min, $request->max, $request->money_ordre,
                        $request->score_type, $request->enrollment_mode,$request->project_count,$fileds);
    
                    $userMajor[$i]->major_confirm_id = $major_confirms[$userMajor[$i]->major_confirm_id];
                    $userMajor[$i]->major_follow_id = $major_follows[$userMajor[$i]->major_follow_id];
                }
                return responseToJson(0,'success',$userMajor);
            
            }else
                return responseToJson(1,'没有页数、页码或者页数、页码不为数字');
        }
        
    }