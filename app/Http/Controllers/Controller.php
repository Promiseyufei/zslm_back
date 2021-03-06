<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

define('EXPLODE_STR',',');

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected function findAddress($id,$provice){
        if($provice != null)
            for($i = 0;$i<sizeof($provice);$i++){
                if($id==$provice[$i]->id){
                    return $provice[$i]->name;
                }
            }
    }
}
