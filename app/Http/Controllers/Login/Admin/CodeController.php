<?php
namespace App\Http\Controllers\Login\Admin;
 
use App\Http\Requests;
use App\Http\Controllers\Controller;
 
use Illuminate\Http\Request;
 
//引用对应的命名空间
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Session;
use Illuminate\Support\Facades\Redis;
class CodeController extends Controller{
    public function captcha(Request $request)
    {
        if(extension_loaded('gd')) {
            $builder = new CaptchaBuilder();
            $builder->build(100,32);
            $phrase = $builder->getPhrase();
            //把内容存入session
            // if(Session::has('milkcaptcha') Session::forget('milkcaptcha');
//            Session::flash('milkcaptcha', $phrase); //存储验证码
            Redis::set($request->get('UUID').'milkcaptcha',$phrase);
       
         
            ob_clean();
            return response($builder->output())->header('Content-type','image/jpeg');
        }
        else {
            echo '你没有安装gd扩展';
        }
    }
 
}