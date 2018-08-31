<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class user_accounts
{
    public static $sTableName = 'user_accounts';


    public static function getAllUsersId() {
        
        return DB::table(self::$sTableName)->pluck('id');

    }



}