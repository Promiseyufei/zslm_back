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
use SocialiteProviders\WeixinWeb\Provider;

class WeixinController extends Controller{
    public function redirectToProvider(Request $request)
    {   
        // $driver = Socialite::driver('weixinweb');
        return Socialite::with('weixinweb')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user_data = Socialite::with('weixinweb')->stateless()->user();
        dd($user_data);
        //todo whatever
    }
}
