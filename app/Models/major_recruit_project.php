<?php

namespace App\Models;
use function Couchbase\defaultDecoder;
use DB;
use Illuminate\Http\Request;

class major_recruit_project
{
    public static $sTableName = 'major_recruit_project';



    public static function getAppointProject($majorId, $pageNum = 0, $pageCount = 10) {

        $select_handle = DB::table(self::$sTableName)->leftJoin('zslm_major', self::$sTableName . '.major_id', '=', 'zslm_major.id')->where([
            [self::$sTableName . '.major_id', '=', $majorId],
            [self::$sTableName . '.is_delete', '=', 0]
        ]);
        $sel_count = $select_handle->count();
        $select_page = $select_handle->offset(($pageNum-1) * $pageCount)->limit($pageCount)
        ->select(self::$sTableName . '.id', self::$sTableName . '.weight', self::$sTableName . '.project_name', self::$sTableName . '.is_show', self::$sTableName . '.if_recommend', self::$sTableName . '.update_time', 'zslm_major.z_name')
        ->get()->map(function($item) {
            $item->update_time = date("Y-m-d H:i",$item->update_time);
            return $item;
        })->toArray();
        return ['total' => $sel_count, 'data' => $select_page];
    }


    public static function updateAppointProjectMsg($projectId = 0, array $projectMsg = []) {

        return DB::table(self::$sTableName)->where('id', $projectId)->update($projectMsg);
    }

    public static function delAppProject($projectId) {
        if(is_array($projectId))
            return DB::table(self::$sTableName)->whereIn('id', $projectId)->update([
                'is_delete' => 1,
                'update_time' => time()
            ]);
        else
            return DB::table(self::$sTableName)->where('id', $projectId)->update([
                'is_delete' => 1,
                'update_time' => time()
            ]);
                
    }


    public static function setAppiProjectState(array $project = []) {
        $handle = DB::table(self::$sTableName)->where('id', $project['pro_id']);
        switch($project['type'])
        {
            case 0:
                return $handle->update(['weight' => $project['state']]);
                break;
            case 1:
                return $handle->update(['is_show' => intval($project['state'])]);
                break;
            case 2:
                return $handle->update(['if_recommended' => $project['state']]);
                break;
        }
    }

    public static function createAppointProjectMsg(array $projectMsg = []) {
        
        return DB::table(self::$sTableName)->insertGetId($projectMsg);
    }


    public static function getAppointIdProMsg($proId) {
        return DB::table(self::$sTableName)->where('id', $proId)->first();
    }
    
    
    
    //front
    public static function getProjectByMid($id,$min,$max,$order = 0,$sorce_type,$enrollment_mode,$size = 3,$fileds){
        $query =  DB::table(self::$sTableName)->where('is_delete',0)->where('is_show',0)->where('major_id',$id);
        if(!empty($max) && empty($min)) {
            $query = $query->where('max_cost', '<', $max);
        }
        else if(!empty($max) && !empty($min)) {
            $query = $query->where('min_cost', '>=',$min)->where('max_cost','<=',$max);
        }
        if($sorce_type != '' && !empty($sorce_type)){
            $types = strChangeArr($sorce_type, EXPLODE_STR);
            $query = $query->whereIn('score_type',$types);
        }
       
        if($enrollment_mode != '' && !empty($enrollment_mode)){
            $enrollment_modes = strChangeArr($enrollment_mode, EXPLODE_STR);
            $query = $query->whereIn('recruitment_pattern',$enrollment_modes);
        }
        // dd($enrollment_modes);
        $desc = $order == 0 ? 'desc':'asc';
        
        $query = $query->orderBy("min_cost",$desc);
        if($size !=0){
          $query =  $query->limit($size);
        }
        $result = $query->get($fileds);
        
        return $result;
    }

    //front
    public static function getProjectByMids($id,$min,$max,$order = 0,$sorce_type,$enrollment_mode,$size = 3,$fileds){
        $query =  DB::table(self::$sTableName)
        ->leftJoin('dict_recruitment_pattern', self::$sTableName . '.recruitment_pattern', '=', 'dict_recruitment_pattern.id')
        ->leftJoin('dict_fraction_type', self::$sTableName . '.score_type', '=', 'dict_fraction_type.id')
        ->where(self::$sTableName . '.is_delete',0)->where(self::$sTableName . '.is_show',0)->where(self::$sTableName . '.major_id',$id);
        if($min != 0 && $max != 0 && !empty($min) && !empty(!$max))
            $query = $query->where('min_cost'>$min)->where('max_cost','<',$max);
        if($sorce_type != '' && !empty($sorce_type)){
            $types = strChangeArr($sorce_type, EXPLODE_STR);
            $query = $query->whereIn(self::$sTableName . '.score_type',$types);
        }
        // dd($enrollment_modes);
        if($enrollment_mode != '' && !empty($enrollment_mode)){
            $enrollment_modes = strChangeArr($enrollment_mode, EXPLODE_STR);
            $query = $query->whereIn('recruitment_pattern',$enrollment_modes);
        }
        $desc = $order == 0 ? 'desc':'asc';
        
        $query = $query->orderBy("min_cost",$desc);
        if($size !=0){
          $query =  $query->limit($size);
        }
        $result = $query->get($fileds);
        
        return $result;
    }
    
    
    
    /**
     * @param     $id 项目id数组
     * @param int $order 排序方式 0降序，其他升序
     * @param     $size 获取的数据数量
     * @param     $fileds 获取的字段
     *
     * @return mixed
     */
    public static function getProjectById($id,$order = 0,$size,$fileds){
        $query =  DB::table(self::$sTableName)->where('is_delete',0)->where('is_show',0)->whereIn('id',$id);
        $desc = $order == 0 ? 'desc':'asc';
        if($size !=0){
            $query =  $query->limit($size);
        }
        $result = $query->get($fileds);
        return $result;
        
    }
    
    public static function getProjectByMidNoMoney($id,$size = 3){
        $query =  DB::table(self::$sTableName)->where('is_delete',0)->where('is_show',0)->where('major_id',$id);
    
        $result = $query->orderBy("min_cost",'desc')->limit($size)->get(['project_name','cost','language','class_situation','student_count']);
        return $result;
    }



}