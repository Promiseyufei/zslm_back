<?php

/**
 * 用户账户表
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class user_accounts
{
    public static $sTableName = 'user_accounts';


    public static function getAllUsersId() {
        
        return DB::table(self::$sTableName)->pluck('id');

    }


    public static function getAllAccounts() {
        // DB::table(self::$sTableName)
        // ->leftJoin('user_information', self::$sTableName . '.id', '=', 'user_information.user_account_id')
        // ->where(self::$sTableName . '.is_delete', 0)
        // ->select(
        //     self::$sTableName . '.id',
        //     self::$sTableName . '.phone',
        //     'user_information.phone',
        //     ''
        // )->get();
    }



}