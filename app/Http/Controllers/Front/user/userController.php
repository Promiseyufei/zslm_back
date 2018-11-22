<?php
    /**
     * Created by PhpStorm.
     * User: star
     * Date: 2018/11/23
     * Time: 4:34
     */
    
    namespace App\Http\Controllers\Front\user;

    use App\Models\user_information as user;
    
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class userController extends Controller
    {
        public function getUserInfo(Request $request){
    
            user::getUserFrontMsg($request->id,['user_name','head_portrait','address']);
            
        }
        
    }