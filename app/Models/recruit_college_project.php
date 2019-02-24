<?php

    namespace App\Models;
    
    use Illuminate\Support\Facades\DB;

    class recruit_college_project
    {
        private static $sTableName = 'recruit_college_project';



        /**
         * 获取招生服务院校信息
         */
        public static function getRecruitMsg($proSimple, array $selectArr, $isMobile = false) {


            return DB::table(self::$sTableName)->where('pro_simple', $proSimple)->select(...$select_arr)->first();

        }

        public static function getRecruitAppointMsg($recruitId, $valName) {
            return DB::table(self::$sTableName)->where('id', $recruitId)->value($valName);
        }


        /**
         * 判断该招生服务院校是否开启官方群服务
         */
        public static function isOpenGroupService($recruitId) {
            $group_msg = ['is_open_group', 'group_number', 'group_password'];
            $is_open = DB::table(self::$sTableName)->where('id', $recruitId)->select(...$group_msg)->first();
            return $is_open;
        }


        
    }