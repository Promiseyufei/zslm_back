<?php
namespace App\Http\Controllers;
 
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller{


    public function showProfile(Request $request) {
        $a = Redis::set('key3', 'Taylor');
        var_dump($a);
    }  
}