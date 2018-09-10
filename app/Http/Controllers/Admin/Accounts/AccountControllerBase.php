<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/10
     * Time: 14:55
     */
    
    namespace App\Http\Controllers\Admin\Accounts;
    
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Validator;
    use Excel;
    
    use App\Models\user_information as UserInformation;
    use App\Models\user_activitys as UserActivitys;
    use App\Models\zslm_activitys as ZslmActivitys;
    use App\Models\user_follow_major as UserFollowMajor;
    use App\Models\zslm_major as ZslmMajor;
    use App\Models\user_coupon as UserCoupon;
    use App\Models\zslm_coupon as ZslmCoupon;
    
    define('METHOD_ERROR','The request type error');
    define('EXPLODE_STR',',');
    define('EXCEL_NAME','活动账户导出表');
    
    class AccountControllerBase extends Controller
    {
        protected function findAddress($id,$provice){
            for($i = 0;$i<sizeof($provice);$i++){
                if($id==$provice[$i]->id){
                    return $provice[$i]->name;
                }
            }
        }
    
        protected function findSchooling($id,$shcooling){
            for($i = 0;$i<sizeof($shcooling);$i++){
                if($shcooling[$i]->id == $id){
                    return $shcooling[$i]->name;
                }
            }
        }
    
        protected function findIndustry($id,$industry){

            for($i = 0;$i<sizeof($industry);$i++){
                if($id==$industry[$i]->id){
                    return $industry[$i]->name;
                }
            }
        }
    
        protected function createExcel($datas){
         
            Excel::create(iconv('UTF-8', 'UTF-8', EXCEL_NAME),function ($excel) use ($datas){
                $excel->sheet('score',function($sheet) use ($datas){
                    $sheet->rows($datas);
                });
            })->export('xls');
        }
    
        protected function judgeGetOneMsg(Request $request){
            if(!$request->isMethod('get'))
                return responseToJson(1,METHOD_ERROR);
            $validator = Validator::make($request->all(),[
                'id'=>'required|numeric'
            ]);
        
            if($validator->fails()){
                return responseToJson(1,$validator->errors()->first());
            }
            return null;
        }
    
        protected function getUserId(Request $request){
            return  UserInformation::getUserById($request->id);
        }
    
        protected function getActivityNames(Request $request){
            $activity_ids = UserActivitys::getActivityByUser($request->id);
            $ids  = [];
            for($i = 0;$i<sizeof($activity_ids);$i++){
                $ids[$i] = $activity_ids[$i]->activity_id;
            }
            $activity_names = ZslmActivitys::getUserActivitys($ids);
            return $activity_names;
        }
    
        protected function getMajorNames(Request $request){
    
            $major_ids = UserFollowMajor::getMajorId($request->id);
            $ids  = [];
            for($i = 0;$i<sizeof($major_ids);$i++){
                $ids[$i] = $major_ids[$i]->major_id;
            }
            $major_names = ZslmMajor::getMajorName($ids);
            return $major_names;
        }
    
        protected function getCouponNames(Request $request){
            $coupon_ids = UserCoupon::getCouponId($request->id);
            $ids  = [];
            for($i = 0;$i<sizeof($coupon_ids);$i++){
                $ids[$i] = $coupon_ids[$i]->coupon_id;
            }
            $coupon_names = ZslmCoupon::getCouponName($ids);
            return $coupon_names;
        }
        
        protected function resultObjToArray($data,$datas,$provice,$schooling,$insutrys){
    
            for($i = 0;$i<sizeof($data);$i++){
                $j = 0;
                foreach ($data[$i] as $key => $value){
                    if($key == 'address'){
                        $addressArr = strChangeArr($data[$i]->address,EXPLODE_STR);
                        $proviceName = $this->findAddress(intval($addressArr[0]),$provice);
                        $cityName = $this->findAddress(intval($addressArr[1]),$provice);
                        $datas[$i+1][$j] = $proviceName.$cityName;
                    }else if($key == 'industry'){
                        $insutry = strChangeArr($data[$i]->industry,EXPLODE_STR);
                        $fatherInsutry = $this->findIndustry(intval($insutry[0]),$insutrys);
                        $sonInsutry = $this->findIndustry(intval($insutry[1]),$insutrys);
                        $datas[$i+1][$j] =$fatherInsutry.'-'.$sonInsutry;
                    }else if($key = 'schooling_id'){
                        $schoolingName = $this->findSchooling(intval($data[$i]->schooling_id),$schooling);
                        $datas[$i+1][$j] = $schoolingName;
                    }else{
                        $datas[$i+1][$j] = $value;
                    }
                    $j++;
                }
                
            }
            return $datas;
        }
        
    }