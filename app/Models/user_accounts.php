<?php

/**
 * 用户账户表
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;
use App\Models\dict as Dict;

class user_accounts
{
    private static $sEducation = null;

    private static $sIndustry = null;
    
    private static $sWorkYears = null;
    
    public static $sTableName = 'user_accounts';


    public static function getAllUsersId() {
        
        return DB::table(self::$sTableName)->pluck('id');

    }


    public static function getAllAccounts($pageCount, $pageNum) {

        self::initialization();

        DB::table(self::$sTableName)
        ->leftJoin('user_information', self::$sTableName . '.id', '=', 'user_information.user_account_id')
        ->where(self::$sTableName . '.is_delete', 0)
        ->select(
            self::$sTableName . '.id',
            self::$sTableName . '.phone　as account',
            'user_information.sex',
            'user_information.phone',
            'user_information.address',
            'user_information.industry',
            'user_information.user_name',
            'user_information.real_name',
            'user_information.worked_year',
            'user_information.schooling_id',
            'user_information.graduate_school'
        )->distinct()
         ->offset($pageCount * $pageNum)
         ->limit($pageCount)
         ->get()->toAyyay()->map(function($item) {
            deepInArray($item);
            return $item;
        });
    }


    private static function initialization() {

        if(slef::$sEducation == null) 
            self::$sEducation = Dict::dictEducation()->toArray();

        else if(self::$sIndustry == null) 
            self::$sIndustry = Dict::dictIndustry()->toAyyay();

        else if(self::$sWorkYears == null) 
            self::$sWorkYears = Dict::workYears()->toAyyay();
    }


    private static function deepInArray(&$item) {

        foreach(self::$sEducation as $key => $value)
            if($value->id == $item->schooling_id) $item->schooling_id = $value->name;

        foreach(self::$sIndustry as $key => $value)
            if($value->id == $item->industry) $item->industry = $value->name;

        foreach(self::$sWorkYears as $key => $value)
            if($value->id == $item->worked_year) $item->worked_year = $value->name;
    }


}