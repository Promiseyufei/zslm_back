<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/30
     * Time: 8:38
     */
    
    namespace App\Http\Controllers\Front\Coupon;
    
    
    use App\Http\Controllers\Auto\Sms\SmsController;
    use App\Http\Controllers\Controller;
    use App\Models\user_coupon;
    use App\Models\zslm_coupon;
    use DB;
    use Symfony\Component\HttpFoundation\Request;

    class couponController extends Controller
    {
        public function userCoupon(Request $request){
            if(!isset($request->u_id) || !is_numeric($request->u_id))
                return responseToJson(1,"id 错误");
            if(!isset($request->c_id) || !is_numeric($request->c_id))
                return responseToJson(1,"c_id 错误");
            
            $result = user_coupon::useCoupon($request->uid,$request->c_id);
            if($result == 0)
                return responseToJson(1,'用户并没有领取该优惠券');
            
        }
    
        public function useCoupon(Request $request){
        
            if(!isset($request->c_id) || !isset($request->c_id))
                return responseToJson(1,'c_id 错误');
        
            if(!isset($request->u_id) || !isset($request->u_id))
                return responseToJson(1,'u_id 错误');
        
            $result = user_coupon::checkUserCoupon($request->u_id,$request->c_id);
    
            if($result == 0)
                return responseToJson(1,'用户并没有领取该优惠券');
            $coupon = zslm_coupon::getCouponByCoachId($request->c_id);
            
            if(sizeof($coupon) == 0)
                return responseToJson(1,'优惠券错误');
            $coupon_id = $coupon[0]->id;
            $coupon_name =  $coupon[0]->name;
            $coupon_coach =  $coupon[0]->coach_name;
            $message = "您已使用 $coupon_coach 机构的 $coupon_name 优惠券，优惠券序列号为 $coupon_id";
            DB::beginTransaction();
            try {
                $result = user_coupon::useCoupon($request->uid, $request->c_id);
                SmsController::sendSms($request->phone, ['coachName' => $coupon_coach, 'couponName' => $coupon_name, 'couponId' => $coupon_id], 'MBA小助手', '');
                DB::commit();
                return responseToJson(0,"成功");
            }catch (\Exception $e){
                DB::rollBack();
                return responseToJson(1,"使用失败");
            }
            
        }
        
    }