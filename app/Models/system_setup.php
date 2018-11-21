<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class system_setup
{
    public static $sTableName = 'system_setup';



    public static function getContent($nameVal = '') 
    {

        return DB::table(self::$sTableName)->where('name', $nameVal)->value('content');
    }

    public static function setContent($nameVal = '', $content = '') 
    {
        return DB::table(slef::$sTableName)->where('name', $nameVal)->update(['content' => $content]);
    }




}