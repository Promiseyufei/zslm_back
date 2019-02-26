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
    use GeoIP;
    define('METHOD_ERROR','The request type error');
    define('EXCEL_NAME','账户信息导出表');
    define('MAX_INTEGER',2147483647);
    class AccountControllerBase extends Controller
    {
        protected function findAddress($id,$provice){
            if($provice != null)
                for($i = 0;$i<sizeof($provice);$i++){
                    if($id==$provice[$i]->id){
                        return $provice[$i]->name;
                    }
                }
        }
    
        protected function findSchooling($id,$shcooling){
            if($shcooling != null)
                for($i = 0;$i<sizeof($shcooling);$i++){
                    if($shcooling[$i]->id == $id){
                        return $shcooling[$i]->name;
                    }
                }
        }
    
        function GetIp(){
            $realip = '';
            $unknown = 'unknown';
            if (isset($_SERVER)){
                if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)){
                    $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                    foreach($arr as $ip){
                        $ip = trim($ip);
                        if ($ip != 'unknown'){
                            $realip = $ip;
                            break;
                        }
                    }
                }else if(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)){
                    $realip = $_SERVER['HTTP_CLIENT_IP'];
                }else if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)){
                    $realip = $_SERVER['REMOTE_ADDR'];
                }else{
                    $realip = $unknown;
                }
            }else{
                if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)){
                    $realip = getenv("HTTP_X_FORWARDED_FOR");
                }else if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)){
                    $realip = getenv("HTTP_CLIENT_IP");
                }else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)){
                    $realip = getenv("REMOTE_ADDR");
                }else{
                    $realip = $unknown;
                }
            }
            $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
            return $realip;
        }
    
        function GetIpLookup($ip = ''){
            if(empty($ip)){
                $ip = $this->GetIp();
            }
            $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
            if(empty($res)){ return false; }
            $jsonMatches = array();
            preg_match('#\{.+?\}#', $res, $jsonMatches);
            if(!isset($jsonMatches[0])){ return false; }
            $json = json_decode($jsonMatches[0], true);
            if(isset($json['ret']) && $json['ret'] == 1){
                $json['ip'] = $ip;
                unset($json['ret']);
            }else{
                return false;
            }
            return $json;
        }
        
    
        protected function findIndustry($id,$industry){
            if($industry != null)
                for($i = 0;$i<sizeof($industry);$i++){
                    if($id==$industry[$i]->id){
                        return $industry[$i]->name;
                    }
                }
        }
    
        protected function createExcel($datas){
            ob_end_clean();
            ob_start();
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
            if($activity_ids != null)
                for($i = 0;$i<sizeof($activity_ids);$i++){
                    $ids[$i] = $activity_ids[$i]->activity_id;
                }
            $activity_names = ZslmActivitys::getUserActivitys($ids);
            return $activity_names;
        }
    
        protected function getMajorNames(Request $request){
    
            $major_ids = UserFollowMajor::getMajorId($request->id);
            $ids  = [];
            if($major_ids != null)
                for($i = 0;$i<sizeof($major_ids);$i++){
                    $ids[$i] = $major_ids[$i]->major_id;
                }
            $major_names = ZslmMajor::getMajorName($ids);
            return $major_names;
        }
    
        protected function getCouponNames(Request $request){
            $coupon_ids = UserCoupon::getCouponId($request->id,0);
            $ids  = [];
            if($coupon_ids != null)
                for($i = 0;$i<sizeof($coupon_ids);$i++){
                    $ids[$i] = $coupon_ids[$i]->coupon_id;
                }
            $coupon_names = ZslmCoupon::getCouponName($ids);
            return $coupon_names;
        }
        
        protected function resultObjToArray($data,$datas,$provice,$schooling,$insutrys){
            if($data != null)
                for($i = 0;$i<sizeof($data);$i++){
                    $j = 0;
                    foreach ($data[$i] as $key => $value){
    //                    print_r($key);
                        if($key == 'address'){
                            $addressArr = strChangeArr($data[$i]->address,EXPLODE_STR);
                            $proviceName = $this->findAddress(intval($addressArr[0]),$provice);
                            $cityName = $this->findAddress(intval($addressArr[1]),$provice);
                            $datas[$i+1][$j] = $proviceName.$cityName;
                        }else if($key == 'industry'){
                            
                            $insutry = strChangeArr($data[$i]->industry,EXPLODE_STR);
                            $return_ins = '';
                            $lenght = $insutry!=null ? count($insutry) : 0;
                        
                for($z = 0;$z<$lenght;$z++){
                        
                                $return_ins.= $this->findIndustry(intval($insutry[$z]),$insutrys);
                            }
                            
                            $datas[$i+1][$j] = $return_ins;
                        
                        }else if($key == 'schooling_id'){
                            $schoolingName = $this->findSchooling(intval($data[$i]->schooling_id),$schooling);
                            $datas[$i+1][$j] = $schoolingName;
                        
                        }else if($key == 'create_time'){
                            $datas[$i+1][$j] = date("Y-m-d",$data[$i]->create_time) ;
                        }
                        else{
                            $datas[$i+1][$j] = $value;
                        }
                        
                        $j++;
                    }
                    
                }
            return $datas;
        }
        
    }
