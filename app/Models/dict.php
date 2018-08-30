<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class dict
{


    public static function dictMajorConfirm() {
        return DB::table('dict_major_confirm')->get();
    }

    public static function dictMajorFollow() {
        return DB::table('dict_major_follow')->get();
    }

    public static function dictMajorType() {
        return DB::table('dict_major_type')->get();
    }

    public static function dictRegion() {
        return DB::table('dict_region')
        ->select('id','father_id','name')
        ->get()
        ->groupBy('father_id')
        ->toArray();
    }

    public static function getSchoolName() {
        return DB::table('college')->select('id', 'name', 'logo_name')->get();
    }



}