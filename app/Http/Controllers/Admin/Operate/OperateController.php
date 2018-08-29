<?php

/**
 * 运营管理
 */

namespace App\Http\Controllers\Admin\Operate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class OperateController extends Controller 
{

    /**
     * postman post test
     */
    public function thisIsTest(Request $request) {
        $a = $request->name;
        $b = $request->age;
        var_dump([$a, $b]);
    }

}