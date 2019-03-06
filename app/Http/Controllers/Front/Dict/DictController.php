<?php
/**
 * Created by PhpStorm.
 * User: jinzhao
 * Date: 2019/3/5
 * Time: 4:45 PM
 */

namespace App\Http\Controllers\Front\Dict;


use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class DictController extends Controller
{
    /**
     * 获取有院校的专业方向字典
     * @return $this
     */
    public function getMajorDirection(){
        // 获取学校项目
        $professional_directions = DB::table('zslm_major')->where('is_delete' , 0)
            ->where('professional_direction' , '>' , 0)
            ->groupBy('professional_direction')->get(['professional_direction']);

        if(count($professional_directions)){
            // 遍历获取到需要的字段存到数组里
            $professionalDirections = [];
            foreach($professional_directions as $v){
                $professionalDirections[] = $v->professional_direction;
            }

            $info =DB::table('dict_major_direction')->whereIn('id' , $professionalDirections)->orderBy('id' , 'asc')->get();
            return responseToJson(0 , '查询成功' , $info);
        }

        return responseToJson(0 , '查询成功' , []);
    }

    /**
     * 获取省市字典
     * @return $this
     */
    public function getRegion(Request $request){
        if(!isset($request->type) || $request->type == 1){
            // 获取学校所在省
            $provinces = DB::table('zslm_major')->where('is_delete' , 0)
                ->where('province' , '>' , 0)
                ->groupBy('province')->get(['province']);
        }elseif($request->type == 2){
            // 获取辅导机构所在省
            $provinces = DB::table('coach_organize')->where('is_delete' , 0)
                ->where('province' , '>' , 0)
                ->groupBy('province')->get(['province']);
        }

        if(count($provinces)){
            // 遍历获取到需要的字段存到数组里
            $province = [];
            foreach($provinces as $v){
                $province[] = $v->province;
            }

            $info =DB::table('dict_region')->whereIn('id' , $province)->orderBy('id' , 'asc')->get(['id' , 'name']);
            return responseToJson(0 , '查询成功' , $info);
        }

        return responseToJson(0 , '查询成功' , []);
    }

    /**
     * 获取有院校的专业类型字典
     * @return $this
     */
    public function getMajorType(){
        // 获取学校专业类型
        $majorTypes = DB::table('zslm_major')->where('is_delete' , 0)
            ->where('z_type' , '>' , 0)
            ->groupBy('z_type')->get(['z_type']);

        if(count($majorTypes)){
            // 遍历获取到需要的字段存到数组里
            $majorType = [];
            foreach($majorTypes as $v){
                $majorType[] = $v->z_type;
            }

            $info =DB::table('dict_major_type')->whereIn('id' , $majorType)->orderBy('id' , 'asc')->get(['id' , 'name']);
            return responseToJson(0 , '查询成功' , $info);
        }

        return responseToJson(0 , '查询成功' , []);
    }

    /**
     * 获取有院校的统招模式字典
     * @return $this
     */
    public function getRecruitmentPattern(){
        // 获取学校统招模式
        $recruitmentPatterns = DB::table('major_recruit_project')->where('is_delete' , 0)
             ->where('is_show' , 0)
             ->where('recruitment_pattern' , '>' , 0)
             ->groupBy('recruitment_pattern')->get(['recruitment_pattern']);

        if(count($recruitmentPatterns)){
             // 遍历获取到需要的字段存到数组里
             $recruitmentPattern = [];
             foreach($recruitmentPatterns as $v){
                 $recruitmentPattern[] = $v->recruitment_pattern;
             }

             $info =DB::table('dict_recruitment_pattern')->whereIn('id' , $recruitmentPattern)->orderBy('id' , 'asc')->get(['id' , 'name']);
             return responseToJson(0 , '查询成功' , $info);
         }

        return responseToJson(0 , '查询成功' , []);
    }

    /**
     * 获取有院校的分数线字典
     * @return $this
     */
    public function getFractionType(){
        // 获取学校分数线
        $scoreTypes = DB::table('major_recruit_project')->where('is_delete' , 0)
            ->where('is_show' , 0)
            ->where('score_type' , '>' , 0)
            ->groupBy('score_type')->get(['score_type']);

        if(count($scoreTypes)){
            // 遍历获取到需要的字段存到数组里
            $scoreType = [];
            foreach($scoreTypes as $v){
                $scoreType[] = $v->score_type;
            }

            $info =DB::table('dict_fraction_type')->whereIn('id' , $scoreType)->orderBy('id' , 'asc')->get(['id' , 'name']);
            return responseToJson(0 , '查询成功' , $info);
        }

        return responseToJson(0 , '查询成功' , []);
    }
}