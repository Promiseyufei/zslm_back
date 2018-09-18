<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/9/15
     * Time: 15:19
     */
    
    namespace App\Http\Controllers\Admin\Login;
    
    
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Validator;
    
    define('METHOD_ERROR','The request type error');
    
    class LoginControllerBase extends Controller
    {
        
        protected function getPassword($password){
            return md5(md5($password));
        }
        
        protected function judgeAccount(Request $request){
            $validator = Validator::make($request->all(),[
                'account'=>'required',
                'password'=>'required'
            ]);
    
            if($validator->fails()){
                return responseToJson(1,$validator->errors()->first());
            }
            return null;
        }
        
    }