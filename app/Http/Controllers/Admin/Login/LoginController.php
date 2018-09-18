<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/15
     * Time: 15:19
     */
    
    namespace App\Http\Controllers\Admin\Login;
    
    use Illuminate\Http\Request;

    use App\Models\admin_accounts as AdminAccount;
    
    class LoginController extends LoginControllerBase
    {
        
        public function login(Request $request){
            
            if(!$request->isMethod('get'))
                return responseToJson(1,METHOD_ERROR);
            
            $judge = $this->judgeAccount($request);
            if(!empty($judge))
                return $judge;
            
            $request->password = $this->getPassword($request->password);
//            dd($request->password);
            $account = AdminAccount::selectAccountByPass($request);
            
            if($account == 1){
                session(['user_account'=>$request->account]);
                return responseToJson(0,'success');
            }
            else
                return responseToJson(1,'no user');
        }
    
    }