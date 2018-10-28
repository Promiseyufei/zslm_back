<?php
namespace App\Http\Controllers;
 
use App\Http\Requests;
use App\Http\Controllers\Controller;
 
use Illuminate\Http\Request;
 
//引用对应的命名空间
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Session;
class codeController extends Controller{
    public function captcha($temp) {
        $builder = new CaptchaBuilder();
        $builder->build(150,32);
        $phrase = $builder->getPhrase();

        // echo($phrase);
        //把内容存入session
        Session::flash('milkcaptcha', $phrase); //存储验证码
        ob_clean();

        return response($builder->output())->header('Content-type','image/jpeg');

        // if(extension_loaded('gd')) {
        //     echo '你可以使用gd<br>';
        //     foreach(gd_info() as $cate=>$value)
        //         echo "$cate: $value<br>";
        // }else
        //     echo '你没有安装gd扩展';
    }
    // public function captcha($tmp)
    // {

    //     $phrase = new PhraseBuilder;
    //     // 设置验证码位数
    //     $code = $phrase->build(6);
    //     // 生成验证码图片的Builder对象，配置相应属性
    //     $builder = new CaptchaBuilder($code, $phrase);
    //     // 设置背景颜色
    //     $builder->setBackgroundColor(220, 210, 230);
    //     $builder->setMaxAngle(25);
    //     $builder->setMaxBehindLines(0);
    //     $builder->setMaxFrontLines(0);
    //     // 可以设置图片宽高及字体
    //     $builder->build($width = 100, $height = 40, $font = null);
    //     // 获取验证码的内容
    //     $phrase = $builder->getPhrase();
    //     // 把内容存入session
    //     \Session::flash('code', $phrase);
    //     // 生成图片   此处要设置浏览器不要缓存
    //     header("Cache-Control: no-cache, must-revalidate");
    //     header("Content-Type:image/jpeg");
    //     $builder->output();
    // }
 
}