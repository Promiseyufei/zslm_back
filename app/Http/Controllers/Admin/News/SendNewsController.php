<?php

/**
 * 发消息
 */

namespace App\Http\Controllers\Admin\News;

use App\Models\user_accounts as UserAccounts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NewsController extends Controller 
{


    //将三个方法合一,注意用户过滤

    //获取全部用户
    public function getAllAccounts(Request $request) {
        $get_all_user = UserAccounts::getAllAccounts();

    }



    //批量筛选用户
    public function batchScreenAccounts(Request $request) {

    }



    //手动选择
    public function manualSelectionAccounts(Request $request) {

    }


    //注意消息载体类型和消息类型的关系，当发送短信时需要调用短信接口
    //当进行站内信的时候开启事务，如果一条发送失败，则这条消息插入数据库，但是这条消息发送状态为失败．对于短信，发送状态不随短信的全部发送成功有关系，看看能不能调用短信查询接口
    public function sendNews() {

    }









}