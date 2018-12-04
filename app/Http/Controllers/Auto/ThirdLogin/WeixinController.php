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
<<<<<<< HEAD
    {
	//return Socialite::with($provider)->redirect();
=======
    {   
        // $driver = Socialite::driver('weixinweb');
>>>>>>> bd5799ad083c3cbffd31c3aadb1ff08a25074652
        return Socialite::with('weixinweb')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user_data = Socialite::with('weixinweb')->user();
        dd($user_data);
        //todo whatever
    }
}
