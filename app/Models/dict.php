<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class dict
{


    /**
     * 专业认证字典表表
     */
    public static function dictMajorConfirm() 
    {
        return DB::table('dict_major_confirm')->get();
    }



    /**
     * 院校性质字典表
     */
    public static function dictMajorFollow() 
    {
        return DB::table('dict_major_follow')->get();
    }



    /**
     * 专业类型字典表
     */
    public static function dictMajorType() 
    {
        return DB::table('dict_major_type')->get();
    }


    /**
     * 获取指定的专业类型名称
     */
    public static function getAppointDictMajorType($typeId) {
        return DB::table('dict_major_type')->where('id', $typeId)->value('name');
    }



    /**
     * 地区字典表
     */
    public static function dictRegion() 
    {
        return DB::table('dict_region')
        ->select('id','father_id','name')
        ->get()
        ->groupBy('father_id')
        ->toArray();
    }

    // public static function dictRegionList() {
    //     return DB::table('dict_region')
    //     ->select('id as','father_id','name')
    //     ->get()
    //     ->groupBy('father_id')
    //     ->toArray();
    // }

    /**
     * 获取指定地区的名称
     */
    public static function getAppoinDictRegion($regionId) {
        return DB::table('dict_region')->where('id', $regionId)->value('name');
    }



    /**
     * 学校字典表
     */
    public static function getSchoolName() 
    {
        return DB::table('college')->select('id', 'name', 'logo_name')->get();
    }

    /**
     * 获取指定的学校名称
     */
    public static function getAppointSchoolName($schoolId) {
        return DB::table('college')->where('id', $schoolId)->value('name');
    }



    /**
     * 专业方向字典表
     */
    public static function dictMajorDirection() 
    {
        return DB::table('dict_major_direction')->get();
    }




    /**
     * 分数线类型字典表
     */
    public static function dictFractionType() 
    {
        return DB::table('dict_fraction_type')->get();
    }



    /**
     * 统招模式字典表
     */
    public static function dictRecruitmentPattern() 
    {
        return DB::table('dict_recruitment_pattern')->get();
    }



    /**
     * 活动类型表
     */
    public static function getActivityType() 
    {
        return DB::table('dict_activity_type')->get();
    }



    /**
     * 资讯类型表
     */
    public static function dictInformationType() 
    {
        return DB::table('dict_information_type')->get();
    }




    /**
     * 学历字典表
     */
    public static function dictEducation() 
    {
        return DB::table('dict_education')->get();
    }



    /**
     * 行业字典表
     */
    public static function dictIndustry() 
    {
        return DB::table('dict_industry')->get();
    }



    /**
     * 工作年限表
     */
    public static function workYears() 
    {
        return DB::table('work_years')->get();
    }



}