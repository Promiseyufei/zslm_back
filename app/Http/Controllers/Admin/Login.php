<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2019/1/26
     * Time: 20:05
     */
    
    namespace App\Http\Controllers\Admin;
    
    
    use App\Http\Controllers\Controller;
    use App\Models\admin_accounts;
    use Illuminate\Http\Request;
    use Gregwar\Captcha\CaptchaBuilder;
    use Validator;
    use UUID;
    use Illuminate\Support\Facades\Redis;
    class Login extends Controller
    {
    
        protected function findAddress($id,$provice){
            for($i = 0;$i<sizeof($provice);$i++){
                if($id==$provice[$i]->id){
                    return $provice[$i]->name;
                }
            }
        }
        
        public function validateLogin(Request $request)
        {
            $messages = [
                'account.required' => '账号不能为空',
                'password.required' => '密码不能为空',
                'captcha.required' => '验证码不能为空',
                'account.between'=> '账号必须在6到20个字符之间',
                'password.between'=> '密码必须在6到20个字符之间'
            ];
            
            $validator = Validator::make($request->all(), [
                'account' => 'required|between:6,20',
                'password' => 'required|between:6,20',
                'captcha' => 'required'
            ],$messages);
    
    
            if ($validator->fails()) {
                $errors = $validator->errors();
                return responseToJson(1,$errors->first());
            }
            $UUID = $request->header('UUID');
            
            if($request->captcha != Redis::get($request->header('UUID').'milkcaptcha')){
                return responseToJson(1,'验证码错误，注意验证码英文要用小写英文');
            }
    
            $request->password = md5($request->password);
            $login = admin_accounts::selectAccountByPass($request);
            admin_accounts::updateLoginTime($request);
            if(sizeof($login) == 1){
                session(['admin_account'=>$request->account]);
                Redis::setex($request->header('UUID'),86400000,'login');
                return responseToJson(0,'success');
            }else{
                return responseToJson(1,"账户或者密码错误");
            }
        }
        
     
        
        public function createUUID(){
            return responseToJson(0,'success',UUID::generate()->string);
        }
    
       
    }