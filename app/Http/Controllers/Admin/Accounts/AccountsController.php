<?php

/**
 * 账户管理
 */

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AccountsController extends Controller 
{

    /**
    * @api {get} index.php?i=  测试一
    * @apiGroup test
    * @apiVersion 0.0.1
    * @apiDescription 这是第一个测试
    * @apiParam {String} token 登录token
    * @apiParamExample 请求样例
    * /index.php?i=8888
    *  @apiSuccess {int} type 类型 0：上行 1：下行
    * @apiExample 请求成功数据
    * {
    *    "status": "1",
    *    "data": {
    *               "first": 1,
    *               "last": 3,
    *    },
    *    "msg": "操作成功"
    * } 
    * @apiExample {json} 失败返回样例:
    *     {"code":"0","msg":"修改成功"}
    */
    public function index(Request $request) {
        $a = test();
        var_dump($a);
    }
}