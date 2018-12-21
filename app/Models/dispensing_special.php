<?php

namespace App\Models;
use DB;

class dispensing_special 
{
    public static $sTableName = 'dispensing_special';

    public static function judgePhone($phone, $grade = 0) {
        return DB::table(self::$sTableName)->where('phone', $phone)->where('grade', $grade)->count();
    }

    public static function insertPhone($phone, $grade = 0, $msg) {
        if($grade == 0)
            return DB::table(self::$sTableName)->insertGetId([
                'phone' => $phone,
                'provinces' => $msg['provinces'],
                'major_types' => $msg['major_types'],
                'grade' => $grade,
                'create_time' => time()
            ]);
        else 
            return DB::table(self::$sTableName)->insertGetId([
                'phone' => $phone,
                'grade' => $grade,
                'create_time' => time(),
                'major_name' => $msg['major_name']
            ]);
    }

    public static function updatePhone($phone, $grade = 0, $msg) {
        if($grade == 0)
            return DB::table(self::$sTableName)->where('phone', $phone)->where('grade', $grade)->update([
                'provinces' => $msg['provinces'],
                'major_types' => $msg['major_types'],
                'update_time' => time()
            ]);
        else 
            return DB::table(self::$sTableName)->where('phone', $phone)->where('grade', $grade)->update([
                'update_time' => time(),
                'major_name' => $msg['major_name']
            ]);
    }

}