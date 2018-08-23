<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class dict_information_type
{
    public static $sTableName = 'dict_information_type';

    public static function getAllInformType() {
        return DB::table(self::$sTableName)->get();
    }
}