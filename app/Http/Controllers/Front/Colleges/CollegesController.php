<?php
namespace App\Http\Controllers\Front\Colleges;
 
use App\Models\dict as Dict;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollegesController extends Controller{


    /**
     * 获得专业类型
     */
    public function getCollegesType(Request $request) {
        return responseToJson(0, '', Dict::dictMajorType());
    }

    /**
     * 获得专业方向
     */
    public function getCollegesDirection(Request $request) {
        return responseToJson(0, Dict::dictMajorDirection());
    }
}