<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class dispensing_project
{

    public static $sTableName = 'dispensing_project';

    public static function getDiProjectByMid($id, $fileds){
        $query =  DB::table(self::$sTableName)->where('major_id',$id)->get($fileds);

        return $query;
    }
}