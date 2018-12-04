<?php
/**
 * Created by PhpStorm.
 * User: shanlei
 * Date: 1/6/2017
 * Time: 11:34 AM
 */

namespace App\Http\Controllers\Auto\ThirdLogin;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Log;
use Exception;
use Illuminate\Http\Request;
use Socialite;
use SocialiteProviders\Weixin\Provider;

class WeixinController extends Controller{
    public function redirectToProvider(Request $request)
    {
        return Socialite::with('weixin')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user_data = Socialite::with('weixin')->user();
        //todo whatever
    }
}
