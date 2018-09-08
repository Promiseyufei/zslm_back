<?php

/**
 * 历史消息
 */

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NewsController extends Controller 
{





    //获得筛选的消息(注意分页)
    public function getScreenNews(Request $request) {

    }


    //获取发送失败消息信息
    public function getFailSendNews(Request $request) {

    }


    //导出发送失败的消息信息　
    public function exportNewsExcel(Request $request) {

    }
}