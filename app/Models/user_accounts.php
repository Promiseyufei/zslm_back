<?php

/**
 * 用户账户表
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;
use App\Models\dict as Dict;
use App\Models\user_information as UserInformation;

class user_accounts
{
    private static $sEducation = null;

    private static $sIndustry = null;
    
    private static $sWorkYears = null;
    
    public static $sTableName = 'user_accounts';




    public static function getAllUsersId() {
        
        return DB::table(self::$sTableName)->pluck('id');

    }


    public static function getAllAccounts($pageCount, $pageNum, $usersArr = []) {

        self::initialization();

        $map_handle = DB::table(self::$sTableName)
            ->leftJoin('user_information', self::$sTableName . '.id', '=', 'user_information.user_account_id')
            ->where(self::$sTableName . '.is_delete', 0);
        
        if($usersArr != []) {
            $map_handle = $map_handle->whereIn(self::$sTableName . '.id', $usersArr);
        }

        $map_total = $map_handle->count();

        $map = $map_handle->select(...self::getAppointUsersField())->distinct()
         ->offset($pageCount * ($pageNum - 1))
         ->limit($pageCount)
         ->get();

        return ['total' => $map_total, 'map' => self::setDeepArray($map)];
    }


    private static function getAppointUsersField() {
        return array(
            self::$sTableName . '.id',
            self::$sTableName . '.create_time',
            self::$sTableName . '.update_time',
            self::$sTableName . '.phone as account',
            'user_information.sex',
            'user_information.address',
            'user_information.industry',
            'user_information.user_name',
            'user_information.real_name',
            'user_information.worked_year',
            'user_information.schooling_id',
            'user_information.head_portrait',
            'user_information.graduate_school'
        );
    }


    private static function setDeepArray($map) {
        return $map->map(function($item) {
            self::deepInArray($item);
            return $item;
        });
    }

    private static function initialization() {

        if(self::$sEducation == null) 
            self::$sEducation = Dict::dictEducation()->toArray();

        if(self::$sIndustry == null) 
            self::$sIndustry = Dict::dictIndustry()->toArray();

        if(self::$sWorkYears == null) 
            self::$sWorkYears = Dict::workYears()->toArray();
    }


    private static function deepInArray(&$item) {

        foreach(self::$sEducation as $key => $value)
            if($value->id == $item->schooling_id) $item->schooling_id = $value->name;

        foreach(self::$sIndustry as $key => $value)
            if($value->id == $item->industry) $item->industry = $value->name;

        foreach(self::$sWorkYears as $key => $value)
            if($value->id == $item->worked_year) $item->worked_year = $value->name;
    }


    public static function getBatchAccounts(array $parameter = []) {

        switch($parameter['condition'])
        {
            case 0:
                $users_id = DB::table('user_follow_major')
                ->join('user_activitys', 'user_follow_major.user_id', '=', 'user_activitys.user_id')
                ->whereExists(function($query) {
                    $query->whereIn('user_follow_major.major_id', $parameter['major_arr'])
                    ->whereIn('user_activitys.activity_id', $parameter['activity_arr'])
                    ->where([
                        ['user_follow_major.is_focus', 0],
                        ['user_activitys.status', 0]
                    ]);
                })->pluck('user_follow_major.user_id');
                $user_info = self::getAppointUserInfo($users_id, $parameter);
                break;
            case 1:
                $users_id = DB::table('user_follow_major')
                ->join('user_activitys', 'user_follow_major.user_id', '=', 'user_activitys.user_id')
                ->whereExists(function($query) use ($parameter) {
                    $query->whereIn('user_follow_major.major_id', $parameter['major_arr'])
                    ->orWhere(function($item) {
                        $item->whereIn('user_activitys.activity_id', $parameter['activity_arr']);
                    })
                    ->where('user_follow_major.is_focus', 0)
                    ->orWhere('user_activitys.status', 0);
                })->pluck('user_follow_major.user_id');
                $user_info = self::getAppointUserInfo($users_id, $parameter);
                break;
            default :
                if(isset($parameter['major_arr']))
                    $users_id = DB::table('user_follow_major')->whereIn('major_id', $parameter['major_arr'])->where('is_focus', 0)->pluck('user_id');
                else
                    $users_id = DB::table('user_activitys')->whereIn('activity_id', $parameter['activity_arr'])->where('status', 0)->pluck('user_id');
                    
                $user_info = self::getAppointUserInfo($users_id, $parameter);
                break;
        }
        return self::setDeepArray($user_info);
    }


    private static function getAppointUserInfo(array $users_id, array $parameter) {
        return DB::table(self::$sTableName)
        ->leftJoin('user_information', self::$sTableName . '.id', '=', 'user_information.user_account_id')
        ->whereIn(self::$sTableName . '.id', $users_id)
        ->where(self::$sTableName . '.is_delete', 0)
        ->select(...self::getAppointUsersField())
        ->offset($parameter['page_num'] * $parameter['page_count'])
        ->limit($parameter['page_count'])
        ->get();
    }

    public static function getAppointUserPhone(array $userIdArr = []) {

        return DB::table(self::$sTableName)->whereIn('id', $userIdArr)->pluck('phone');
    }


    /**
     * 以用户手机号获得指定用户
     */
    public static function getAppointUser($userPhone) {
        return DB::table(self::$sTableName)->where('phone', $userPhone)->where('is_delete', 0)->first();
    }

    public static function insertUserAccount($userPhone = '') {
        if(!DB::table(self::$sTableName)->where('phone', $userPhone)->count()) {
            return DB::table(self::$sTableName)->insertGetId([
                'phone'         => $userPhone,
                'password'      => encryptPassword(mb_substr($userPhone, -1, 6)),
                'create_time'   => time()
            ]);
        }
    }

    public static function updateUserPassword($userPhone, $password) {
        return DB::table(self::$sTableName)->where('phone', $userPhone)->update([
            'password' => encryptPassword($password),
            'update_time' => time()
        ]);
    }
    
    //通过手机号修改用户指定值
    public static function updateUserInfo($userPhone, $userInfoArr = []) {
        // dd($userInfoArr);
        if(!DB::table('user_information')->where('user_account_id', DB::table(self::$sTableName)->where('phone', $userPhone)->value('id'))->count()) {
            UserInformation::insertUserInfo(DB::table(self::$sTableName)->where('phone', $userPhone)->value('id'));
        }

        return DB::table('user_information')->where('user_account_id', DB::table(self::$sTableName)->where('phone', $userPhone)->value('id'))->update($userInfoArr);

    }


    //个人中心－账户管理　获得用户个人信息
    public static function getUserInfo($userPhone) {
        // dd(!DB::table('user_information')->where('user_account_id', DB::table(self::$sTableName)->where('phone', $userPhone)->value('id'))->count());
        if(!DB::table('user_information')->where('user_account_id', DB::table(self::$sTableName)->where('phone', $userPhone)->value('id'))->count()) {
           
            UserInformation::insertUserInfo(DB::table(self::$sTableName)->where('phone', $userPhone)->value('id'));
        }
        // dd('aa');
        if(DB::table(self::$sTableName)->where('phone', $userPhone)->count() || DB::table(self::$sTableName)->where('phone', $userPhone)->value('is_delete') == 1) {
            return DB::table(self::$sTableName)
                ->leftJoin('user_information', self::$sTableName . '.id', '=', 'user_information.user_account_id')
                ->where(self::$sTableName . '.phone', $userPhone)->select(
                    self::$sTableName . '.create_time',
                    self::$sTableName . '.phone',
                    'user_information.user_name',
                    'user_information.head_portrait',
                    'user_information.real_name',
                    'user_information.sex',
                    'user_information.address',
                    'user_information.schooling_id',
                    'user_information.graduate_school',
                    'user_information.industry',
                    'user_information.worked_year'
                )->first();
        }
        else return null;
    }



}