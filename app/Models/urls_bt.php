<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class urls_bt
{
    public static $sTableName = 'urls_bt';

    public static function getIndexUrlName() {
        $index_name = DB::table(self::$sTableName)
        ->where('page_type', 1)
        ->select('id','name','url')
        ->get();

        if(count($index_name) > 0) return $index_name;
        else return false;
    }


}