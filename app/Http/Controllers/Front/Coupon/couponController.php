<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/30
     * Time: 8:38
     */
    
    namespace App\Http\Controllers\Front\Coupon;
    
    
    use App\Http\Controllers\Controller;
    use App\Models\user_coupon;
    use Symfony\Component\HttpFoundation\Request;

    class couponController extends Controller
    {
        public function userCoupon(Request $request){
            if(!isset($request->u_id) || !is_numeric($request->u_id))
                return responseToJson(1,"id 错误");
            if(!isset($request->c_id) || !is_numeric($request->c_id))
                return responseToJson(1,"c_id 错误");
            
            $result = user_coupon::useCoupon($request->uid,$request->c_id);
        }
        
    }