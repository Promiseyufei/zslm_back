<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/23
     * Time: 4:34
     */
    
    namespace App\Http\Controllers\Front\UserCore;
    use DB;
    use App\Http\Controllers\Front\Colleges\MajorController;
    use App\Models\news_users as newUsers;
    use App\Models\opinion_feedback;
    use App\Models\refund_apply;
    use App\Models\user_activitys as userActivitys;
    use App\Models\user_coupon as userCoupon;
    use App\Models\user_follow_major as userFollowMajor;
    use App\Models\user_information as user;

    use App\Models\dict_region as dictRegion;
    use App\Models\major_recruit_project as majorRecruitProject;
    use App\Models\dict_major_confirm as majorConfirm;
    use App\Models\dict_major_follow as majorFollow;
    use Illuminate\Support\Facades\Storage;

    use Illuminate\Support\Facades\Validator;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class userController extends Controller
    {
        /**
         * 获取用户的初始信息，名称，地区，关注院校等
         * @param Request $request
         *
         * @return mixed
         */
        public function getUserInfo(Request $request){
            
            if(!$request->isMethod("get"))
                return responseToJson(1,'请求错误');
            else if(!isset($request->id))
                return responseToJson(1,'缺少id');
            $user = user::getUserFrontMsg($request->id,['user_name','head_portrait','address']);
            
            if($user == null || sizeof($user) == 0)
                return responseToJson(1,'没有该用户');
            
            if($user[0]->address != ""){
                $addr = getProCity($user[0]->address);
                unset($user[0]->address);
                $user[0]->provice = $addr['province'];
                if($addr != null && sizeof($addr)>1)
                    $user[0]->city = $addr['city'];
            }else{
                $user[0]->provice = "";
                $user[0]->city = "";
            }
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
    
        /**
         *
         */
        
        public function getDing(Request $request){
            if(!isset($request->id))
                return responseToJson(1,'缺少id');
            $newCount = newUsers::getCountUserNews($request->id,0);
            return responseToJson(0,'success',$newCount);
        }

        /**
         * 获取用户关注的院校
         * @param Request $request
         *
         * @return mixed
         */
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
                    ['major_id','z_name','province','major_follow_id','major_confirm_id','magor_logo_name','major_logo_alt','major_follow','major_confirm','index_web','is_focus']);
                if($userMajor == null || sizeof($userMajor) == 0){
                    return responseToJson(1,'无数据');
                }
                
                $major_confirms = majorConfirm::getAllMajorConfirm();
                $major_follows = majorFollow::getAllMajorFollow();
                $major_c = new MajorController();

                if($userMajor != null)
                    for ($i = 0; $i < sizeof($userMajor); $i++) {
                        $addressArr = strChangeArr($userMajor[$i]->province, EXPLODE_STR);
                        $userMajor[$i]->province = dictRegion::getOneArea($addressArr[0])[0]->name;
                        $userMajor[$i]->city = '';
                        if ($addressArr != null && sizeof($addressArr) > 1)
                            $userMajor[$i]->city = dictRegion::getOneArea($addressArr[1])[0]->name;
                        // dd($userMajor);
        
                        $fileds = ['project_name','cost','language','class_situation','student_count'];
                        $userMajor[$i]->product = majorRecruitProject::getProjectByMid($userMajor[$i]->major_id,
                            $request->min, $request->max, $request->money_ordre,
                            $request->score_type, $request->enrollment_mode,$request->project_count,$fileds);
        
                        $major_confirms_str = strChangeArr($userMajor[$i]->major_confirm,EXPLODE_STR);
                        $major_confirms_str = changeStringToInt($major_confirms_str);
                        $major_follow_str = strChangeArr($userMajor[$i]->major_follow,EXPLODE_STR);
                        $major_follow_str = changeStringToInt($major_follow_str);
        
                        $major_confirm = $major_c->getConfirmsOrFollow($major_confirms_str,$major_confirms);
                        $major_follow = $major_c->getConfirmsOrFollow($major_follow_str,$major_follows);
                        $userMajor[$i]->major_confirm_id = $major_confirm;
                        $userMajor[$i]->major_follow_id = $major_follow;
                        $userMajor[$i]->magor_logo_name = splicingImgStr('admin', 'info', $userMajor[$i]->magor_logo_name);
                        unset($userMajor[$i]->major_confirm);
                        unset($userMajor[$i]->major_follow);
                    }
                return responseToJson(0,'success',$userMajor);
            
            }else
                return responseToJson(1,'没有页数、页码或者页数、页码不为数字');
        }
    
        /**
         * 用户反馈
         * @param Request $request
         *
         * @return mixed
         */
        
        public function userOpinion(Request $request){
    
            if(!isset($request->id) || !is_numeric($request->id)){
                return responseToJson(1,'id错误');
            }
    
      
            if(!isset($request->text)){
                return responseToJson(1,'没有 内容');
            }
            
            $result = opinion_feedback::addOpinion($request->id,$request->name,$request->text);
            if($result == 1)
                return responseToJson(0,'success');
            else
                return responseToJson(1,'添加失败');
            
        }
    
        /**
         * 退款
         * @param Request $request
         *
         * @return mixed
         */
        public function userRefund(Request $request){
            $messages = [
                'required' => ' :attribute 为空.',
                'numeric' => ':attribute 不是数字'
            ];

            $v = Validator::make($request->all(), [
                'c_name' => 'required',
                'money' => 'required|numeric',
                'is_coupon' => 'required|numeric',
                'time'=>'required|numeric',
                'phone'=>'required',
                'refund_type'=>'required|numeric',
                'alipay_account'=>'required',
                'name'=>'required',
                'card'=>'required',
                'blank_addr'=>'required',
                'message'=>'required',
                'u_id'=>'required|numeric',
                'f_id'=>'required|numeric',
                'cou_id'=>'required|numeric',
            ],$messages);

            $errors = $v->errors();

            $g = "/^1[34578]\d{9}$/";

            if($errors != null && sizeof($errors) > 0 ){
                return responseToJson(1,$errors->first());
            }

            if(!preg_match($g,$request->phone)){
                return responseToJson(1,'请输入正确格式的手机号');
            }
            if(!validataBankCard($request->card)){
                return responseToJson(1,'请输入正确格式的银行卡号');
            }

            if(!empty($request->cou_id)){ // 如果有优惠卷序列号 判断是否有申请过退款 有就不能在申请
                $id = DB::table('refund_apply')->where('coupon_id' , $request->cou_id)
                ->where('account_id' , $request->u_id)->value('id');

                if($id){
                    return responseToJson(1,'已有相同的优惠卷序列号退款信息，请不要重复提交');
                }
            }
            
            $request->c_name =preg_replace('# #','',$request->c_name);
            $request->alipay_account =preg_replace('# #','',$request->alipay_account);
            $request->name =preg_replace('# #','',$request->name);
            $request->blank_addr =preg_replace('# #','',$request->blank_addr);
            $request->message =preg_replace('# #','',$request->message);
            $fileUrl = 'public/refund/';
     
            $i = 0;
    
            $ext = ['jpg','jpeg','png'];
            DB::beginTransaction();
            try{
                $file_names='';
                foreach($_FILES as $key => $value){
                    $file = $request->file($key);
                    $file_ext = $file->getClientOriginalExtension();
                    $name = getFileName('refund',$file_ext);
                    $file_names .= $name.',';
                }
                $file_names = rtrim($file_names, ',');
                $request->imgs_name = $file_names;
                $result =  refund_apply::addRefund($request);
                $img_index = 1;
             
               foreach($_FILES as $key => $value){
                  $file = $request->file($key);
                   $file_ext = $file->getClientOriginalExtension();
                   $name = getFileName('refund',$file_ext);
                   if(!in_array($file_ext,$ext))
                       throwException("文件格式错误");
                    Storage::putFileAs($fileUrl,$file ,$name);
                    
               }
                DB::commit();
                if($result == 1)
                    return responseToJson(0,'success');
                return responseToJson(1,'失败');
            }catch (\Exception $e){
                DB::rollBack();
                return responseToJson(1,$e->getMessage());
            }
            
            
        
        }
        
    }