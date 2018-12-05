<?php
/**
 * Created by PhpStorm.
 * User: shanlei
 * Date: 1/6/2017
 * Time: 11:34 AM
 */

namespace App\Http\Controllers\Auto\ThirdLogin;

use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SocialiteProviders\WeixinWeb\Provider;

class WeixinController extends Controller{
    public function redirectToProvider(Request $request)
    {   
        return Socialite::with('weixinweb')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user_data = Socialite::with('weixinweb')->stateless()->user();
        dd($user_data);
    }
}
