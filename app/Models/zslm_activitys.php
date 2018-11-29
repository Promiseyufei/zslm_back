<?php

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class zslm_activitys
{
    public static $sTableName = 'zslm_activitys';



    private static function judgeScreenState($screenState, $title, &$handle) {
        switch($screenState) {
            case 0:
                $handle = $handle->where($title, '=', 0);
                break;
            case 1:
                $handle = $handle->where($title, '=', 1);
                break;
            default :
                break;
        }
    }
    
    public static function getNameById($id){
        return DB::table(self::$sTableName)->where('id',$id)->first(['active_name']);
    }

    private static function judgeActivityState($activiState, $title, &$handle) {
        switch($activiState)
        {
            case 0:
                $handle = $handle->where($title, '=', 0);
                break;
            case 1:
                $handle = $handle->where($title, '=', 1);
                break;
            case 2:
                $handle = $handle->where($title, '=', 2);
                break;
            default :
        }
    }

    public static function getActivityPageMsg(array $val = []) {
        
        $handle_c =  $handle = DB::table(self::$sTableName)->where(self::$sTableName.'.is_delete',0);
        $handle = DB::table(self::$sTableName)
            ->leftJoin('activity_relation',  self::$sTableName.'.id' , '=','activity_relation.activity_id')
            ->leftJoin('zslm_major', 'zslm_major.id', '=','activity_relation.host_major_id')
            ->leftJoin('dict_activity_type',  self::$sTableName.'.active_type', '=','dict_activity_type.id')
                ->where(self::$sTableName.'.is_delete',0);
        $sort_type = [0=>['id','desc'], 1=>['show_weight','asc'], 2=>['update_time','desc']];
        if(isset($val['activityNameKeyword'])) $handle = $handle->where('active_name', 'like', '%' . $val['activityNameKeyword'] . '%');
        if($val['showType'] != 2){
            self::judgeScreenState($val['showType'], 'show_state', $handle);
            self::judgeScreenState($val['showType'], 'show_state', $handle_c);
        }
        if($val['recommendedState'] != 2){
            self::judgeScreenState($val['recommendedState'], 'recommended_state', $handle);
            self::judgeScreenState($val['recommendedState'], 'recommended_state', $handle_c);
        }
        if($val['activityState'] != 2){
            self::judgeScreenState($val['activityState'], 'active_status', $handle);
            self::judgeScreenState($val['activityState'], 'active_status', $handle_c);
        }
        $count = $handle_c->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])->count('id');
    
 
        $get_page_msg = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])
        ->offset($val['pageCount'] * ($val['pageNumber']-1))
        ->limit($val['pageCount'])->get([self::$sTableName.'.id','active_name','active_type',
                self::$sTableName.'.province','z_name','sign_up_state', self::$sTableName.'.create_time',
                self::$sTableName.'.show_weight',self::$sTableName.'.show_state',self::$sTableName.'.recommended_state',
                'dict_activity_type.name']);
        return count($get_page_msg )>= 0 ? [$get_page_msg,$count] : false;
    }
    
    public static function getActivityAll(array $val = []) {
        
        $handle_c =  $handle = DB::table(self::$sTableName)->where(self::$sTableName.'.is_delete',0);
        $handle = DB::table(self::$sTableName)
            ->leftJoin('activity_relation',  self::$sTableName.'.id' , '=','activity_relation.activity_id')
            ->leftJoin('zslm_major', 'zslm_major.id', '=','activity_relation.host_major_id')
            ->leftJoin('dict_activity_type',  self::$sTableName.'.active_type', '=','dict_activity_type.id')
            ->where(self::$sTableName.'.is_delete',0);
        $sort_type = [0=>['show_weight','desc'], 1=>['show_weight','asc'], 2=>['update_time','desc']];
        if(isset($val['activityNameKeyword'])) $handle = $handle->where('active_name', 'like', '%' . $val['activityNameKeyword'] . '%');
        if($val['showType'] != 2){
            self::judgeScreenState($val['showType'], 'show_state', $handle);
            self::judgeScreenState($val['showType'], 'show_state', $handle_c);
        }
        if($val['recommendedState'] != 2){
            self::judgeScreenState($val['recommendedState'], 'recommended_state', $handle);
            self::judgeScreenState($val['recommendedState'], 'recommended_state', $handle_c);
        }
        if($val['activityState'] != 2){
            self::judgeScreenState($val['activityState'], 'active_status', $handle);
            self::judgeScreenState($val['activityState'], 'active_status', $handle_c);
        }
        if($val['activityState'] != -1){
            self::judgeScreenState($val['activityType'], 'active_type', $handle);
            self::judgeScreenState($val['activityType'], 'active_type', $handle_c);
        }
        $handle->where(self::$sTableName.'.province','like',$val['provice'].'%');
        $handle_c->where(self::$sTableName.'.province','like',$val['provice'].'%');
        $count = $handle_c->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])->count('id');
        
        
        $get_page_msg = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])
            ->offset($val['pageCount'] * ($val['pageNumber']-1))
            ->limit($val['pageCount'])->get([self::$sTableName.'.id','active_name','active_type',
                self::$sTableName.'.province','z_name','sign_up_state', self::$sTableName.'.create_time',
                self::$sTableName.'.show_weight',self::$sTableName.'.show_state',self::$sTableName.'.recommended_state',
                'dict_activity_type.name']);
        return count($get_page_msg )>= 0 ? [$get_page_msg,$count] : false;
    }
    
    public static function getActivityMsg(array $val = []) {
        
        $handle = DB::table(self::$sTableName)
            ->where(self::$sTableName.'.is_delete',0);
        $sort_type = [0=>['show_weight','desc'], 1=>['show_weight','asc'], 2=>['update_time','desc']];
        if(isset($val['activityNameKeyword'])) $handle = $handle->where('active_name', 'like', '%' . $val['activityNameKeyword'] . '%');
        if($val['screenState'] != 2){
            self::judgeScreenState($val['activityState'], 'active_status', $handle);
            self::judgeScreenState($val['activityState'], 'active_status', $handle_c);
        }
        $count = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])->count('id');
        
        
        $get_page_msg = $handle->orderBy($sort_type[$val['sortType']][0], $sort_type[$val['sortType']][1])
            ->offset($val['pageCount'] * ($val['pageNumber']-1))
            ->limit($val['pageCount'])->get([self::$sTableName.'.id','active_name','title','update_time']);
        return count($get_page_msg )>= 0 ? [$get_page_msg,$count] : false;
    }
    
    public static function getOneActivity($val) {
        
        $handle = DB::table(self::$sTableName)
            ->leftJoin('activity_relation',  self::$sTableName.'.id' , '=','activity_relation.activity_id')
            ->leftJoin('zslm_major', 'zslm_major.id', '=','activity_relation.host_major_id')
            ->leftJoin('dict_activity_type',  self::$sTableName.'.active_type', '=','dict_activity_type.id','sign_up_state')
            ->where(self::$sTableName.'.is_delete',0)
            ->where(self::$sTableName.'.id',$val);
       
        
        
        $get_page_msg = $handle->get([self::$sTableName.'.id','active_name','active_type','major_type',
                self::$sTableName.'.province','z_name','sign_up_state', self::$sTableName.'.create_time',
                self::$sTableName.'.show_weight',self::$sTableName.'.show_state',self::$sTableName.'.recommended_state',
                'dict_activity_type.name','end_time','begin_time',self::$sTableName.'.address',  self::$sTableName.'.title',
                self::$sTableName.'.keywords',  self::$sTableName.'.description',  self::$sTableName.'.introduce','activity_relation.host_major_id']);
        return count($get_page_msg )>= 0 ? $get_page_msg : false;
    }


    public static function getActivityAppiCount(array $condition = []) {
        return DB::table(self::$stableName)->where($condition)->count();
    }


    public static function setAppiActivityState(array $activity = []) {
        $handle = DB::table(self::$sTableName)->where('id', $activity['act_id']);
        switch($activity['type'])
        {
            case 0:
                return $handle->update(['show_weight' => $activity['state'], 'update_time' => time()]);
                break;
            case 1:
                return $handle->update(['show_state' => $activity['state'], 'update_time' => time()]);
                break;
            case 2:
                return $handle->update(['recommended_state' => $activity['state'], 'update_time' => time()]);
                break;
            case 3:
                return $handle->update(['active_status' => $activity['state'], 'update_time' => time()]);
                break;
        }
    }
    
    public static function setWeight ($id,$weight){
        return DB::table(self::$sTableName)
            ->where('id', $id)
            ->update(['show_weight'=>$weight]);
    }
    
    public static function setShow ($id,$weight){
        return DB::table(self::$sTableName)
            ->where('id', $id)
            ->update(['show_state'=>$weight]);
    }
    
    public static function setRec ($id,$rec){
        return DB::table(self::$sTableName)
            ->where('id', $id)
            ->update(['recommended_state'=>$rec]);
    }
    /**
     * setTKDByid
     *
     */
    public static function setTKDById(Request $request){
        return DB::table(self::$sTableName)
            ->where('id', $request->id)
            ->update(['title'=>$request->title,
                'keywords'=>$request->keywords,
                'description'=>$request->description]);
    }
    
    public static function setIntroduce(Request $request){
        return DB::table(self::$sTableName)
            ->where('id', $request->id)
            ->update(['description'=>$request->introduce]);
    }

    public static function getAppointActivityMsg($activityId = 0, $msgName = '') {
        if(empty($msgName))
            return DB::table(self::$sTableName)->where('id', $activityId)->first();
        else
            return DB::table(self::$sTableName)->where('id', $activityId)->select(...$msgName)->first();
    }

    public static function delAppointActivity($activityId = 0) {
        return DB::table(self::$sTableName)->whereIn('id', $activityId)->update(['is_delete' => 1, 'update_time' => time()]);
    }

    public static function updateActivityTime($activityId = 0) {
        return DB::table(self::$sTableName)->where('id', $activityId)->update(['update_time' => time()]);
    }


    public static function getAllActivity(array $getMsgName = []) {
        if(!empty($getMsgName))
            return DB::table(self::$sTableName)->where('is_delete', 0)->select(...$getMsgName)->get();
        else
            return DB::table(slef::$sTableName)->where('is_delete', 0)->get();
    }


    /**
     * 自动设置推荐活动时获得可以推荐的活动的id数组
     */
    public static function getAutoRecommendActivitys($recomActivityCount = 8) {
    
        
        $data =  DB::table(self::$sTableName)->where([
            ['is_delete', '=', 0],
            ['show_state', '=', 0],
            ['recommended_state', '=', 0],
            ['active_status', '<>', 2]
        ])->orderBy('active_status','desc')->orderBy('show_weight', 'desc')->limit($recomActivityCount)->pluck('id');
       
        return  $data ;
    }


    public static function createAppointActivityMsg(array $createActivityMsg = []) {
        
        return DB::table(self::$sTableName)->insertGetId($createActivityMsg);

    }
    
    public static function updateMsg($id,array $createActivityMsg = []) {
        return DB::table(self::$sTableName)->where('id',$id)->update($createActivityMsg);
        
    }
    
    public static function getUserActivitys($activity_ids){
        return DB::table(self::$sTableName)->where('is_delete',0)->whereIn('id',$activity_ids)->get(['active_name']);
    }

    public static function getActiveByids(array $id){
        return DB::table(self::$sTableName)->where('is_delete',0)->whereIn('id',$id)->get(['active_name','id','show_weight','create_time','active_type']);
    }


    /**
     * 前台搜索页面获得活动搜索结果
     */
    public static function getSearchActivitys($keyword = '', $pageNumber = 0, $pageCount = 9) {
        return DB::table(self::$sTableName)
            ->leftJoin('activity_relation', self::$sTableName . '.id', '=', 'activity_relation.activity_id')
            ->leftJoin('zslm_major', 'activity_relation.host_major_id', '=', 'zslm_major.id')
            ->leftJoin('dict_activity_type', self::$sTableName . '.active_type', '=', 'dict_activity_type.id')
            ->where(self::$sTableName . '.active_name', 'like', '%' . $keyword . '%')
            // ->orWhere(self::$sTableName . '.introduce', 'like', '%' . $keyword. '%')
            ->offset($pageCount * ($pageNumber - 1))
            ->limit($pageCount)
            ->select(
                self::$sTableName . '.id', 
                self::$sTableName . '.active_name', 
                self::$sTableName . '.province', 
                self::$sTableName . '.begin_time', 
                self::$sTableName . '.end_time', 
                self::$sTableName . '.active_img', 
                'dict_activity_type.name as activity_type', 
                'zslm_major.z_name'
            )->get();
    }



    /**
     * 前台找活动页面获得筛选结果
     */
    public static function getFrontActiListInfo($keyword, $majorType, $provinceIdArr, $activityType, $activityState, $activityDate, $pageCount, $pageNumber) {

        $handel = DB::table(self::$sTableName)
            ->leftJoin('activity_relation', self::$sTableName . '.id', '=', 'activity_relation.activity_id')
            ->leftJoin('zslm_major', 'activity_relation.host_major_id', '=', 'zslm_major.id')
            ->leftJoin('dict_activity_type', self::$sTableName . '.active_type', '=', 'dict_activity_type.id')
            ->where(self::$sTableName . '.show_state', 0)->where(self::$sTableName . '.is_delete', 0)
            ->where('active_name', 'like', '%' . $keyword . '%');

        if(!empty($majorType) && count($majorType) > 0) 
            $handel = $handel->whereIn('major_type', $majorType);

        
        if(!empty($activityType) && count($activityType))
            $handel = $handel->whereIn('active_type', $activityType);
        
        if(!empty($activityState) && count($activityState)) 
            $handel = $handel->whereIn('active_status', $activityState);

        $count = $handel->count();
        
        $get_info = $handel->orderBy('show_weight', 'desc')->offset($pageCount * ($pageNumber - 1))->limit($pageCount)->select(
            self::$sTableName . '.id', 
            self::$sTableName . '.active_name', 
            self::$sTableName . '.province', 
            self::$sTableName . '.begin_time', 
            self::$sTableName . '.end_time', 
            self::$sTableName . '.active_img', 
            'dict_activity_type.name as activity_type',
            'zslm_major.z_name',
            'zslm_major.magor_logo_name'
        )->get();

        return ['count'=> $count, 'info' => $get_info];
    }


    public static function getAppointAcInfos($acId) {
        return DB::table(self::$sTableName)
            ->leftJoin('dict_activity_type', self::$sTableName . '.active_type', '=', 'dict_activity_type.id')
            ->where(self::$sTableName . '.id', $acId)
            ->select(
                self::$sTableName . '.id', 
                self::$sTableName . '.active_name', 
                self::$sTableName . '.begin_time', 
                self::$sTableName . '.end_time',
                self::$sTableName . '.address',
                self::$sTableName . '.introduce',
                'dict_activity_type.name as active_type'
            )->first();
    }

    public static function getFrontPopularAcInfo($acIdArr = [], $pageNumber = 0) {
        $pageCount = 4;
        $handel = DB::table(self::$sTableName)
            ->whereIn('id', $acIdArr)->where('is_delete', 0)
            ->orderBy('begin_time', 'desc')->orderBy('show_weight', 'desc');
        
        $count = $handel->count();

        $ac_info = $handel->offset($pageCount * $pageNumber)->limit($pageCount)
            ->select('id', 'active_img', 'active_name', 'begin_time')->get();
            
        return ['count' => $count, 'acInfo' => $ac_info];

    }

    public static function getAcEndTime($acId) {
        return DB::table(self::$sTableName)->where('id', $acId)->where('is_delete', 0)->value('end_time');
    }
    
    
    public static function getFrontActiListInfoNoCount($keyword, $majorType, $provinceIdArr, $activityType, $activityState, $activityDate, $pageCount, $pageNumber) {
        
        $handel = DB::table(self::$sTableName)
            ->leftJoin('activity_relation', self::$sTableName . '.id', '=', 'activity_relation.activity_id')
            ->leftJoin('zslm_major', 'activity_relation.host_major_id', '=', 'zslm_major.id')
            ->leftJoin('dict_activity_type', self::$sTableName . '.active_type', '=', 'dict_activity_type.id')
            ->where(self::$sTableName . '.show_state', 0)->where(self::$sTableName . '.is_delete', 0)
            ->where('active_name', 'like', '%' . $keyword . '%');
        
        if(!empty($majorType) && count($majorType) > 0)
            $handel = $handel->whereIn('major_type', $majorType);
        
        
        if(!empty($activityType) && count($activityType))
            $handel = $handel->whereIn('active_type', $activityType);
        
        if(!empty($activityState) && count($activityState))
            $handel = $handel->whereIn('active_status', $activityState);
        
        
        $get_info = $handel->orderBy('show_weight', 'desc')->offset($pageCount * ($pageNumber - 1))->limit($pageCount)->select(
            self::$sTableName . '.id',
            self::$sTableName . '.active_name',
            self::$sTableName . '.province',
            self::$sTableName . '.begin_time',
            self::$sTableName . '.end_time',
            self::$sTableName . '.active_img',
            'dict_activity_type.name as activity_type',
            'zslm_major.z_name',
            'zslm_major.magor_logo_name'
        )->get();
        
        return ['info'=>$get_info];
        
        
    }
    
    public static function getFrontActiListById( $major_id, $pageNumber,$pageCount) {
    
        $handel = DB::table(self::$sTableName)
            ->join('activity_relation', self::$sTableName . '.id', '=', 'activity_relation.activity_id')
            ->join('zslm_major', 'activity_relation.host_major_id', '=', 'zslm_major.id')
            ->join('dict_activity_type', self::$sTableName . '.active_type', '=', 'dict_activity_type.id')
            ->where(self::$sTableName . '.show_state', 0)
            ->where(self::$sTableName . '.is_delete', 0)
            ->where('zslm_major.id',$major_id);


        $get_info = $handel->orderBy('show_weight', 'desc')->offset($pageCount * ($pageNumber - 1))->limit($pageCount)->select(
            self::$sTableName . '.id',
            self::$sTableName . '.active_name',
            self::$sTableName . '.province',
            self::$sTableName . '.begin_time',
            self::$sTableName . '.end_time',
            self::$sTableName . '.active_img',
            'dict_activity_type.name as activity_type',
            'zslm_major.z_name',
            'zslm_major.magor_logo_name'
        )->get();
        return ['info'=>$get_info];
    }
    
    public static function getFrontActiById( $province, $pageNumber,$pageCount) {
        
        $handel = DB::table(self::$sTableName)
            ->join('activity_relation', self::$sTableName . '.id', '=', 'activity_relation.activity_id')
            ->join('zslm_major', 'activity_relation.host_major_id', '=', 'zslm_major.id')
            ->join('dict_activity_type', self::$sTableName . '.active_type', '=', 'dict_activity_type.id')
            ->where(self::$sTableName . '.show_state', 0)->where(self::$sTableName . '.is_delete', 0)
            ->where(self::$sTableName . '.province','like',$province.'%');
        
        $get_info = $handel->orderBy('show_weight', 'desc')->offset($pageCount * ($pageNumber - 1))->limit($pageCount)->select(
            self::$sTableName . '.id',
            self::$sTableName . '.active_name',
            self::$sTableName . '.province',
            self::$sTableName . '.begin_time',
            self::$sTableName . '.end_time',
            self::$sTableName . '.active_img',
            'dict_activity_type.name as activity_type',
            'zslm_major.z_name',
            'zslm_major.magor_logo_name'
        )->get();
        
        return ['info'=>$get_info];
    }
    
    public static function getFrontUserActivity( $a_id, $pageNumber,$pageCount) {
      
        $handel = DB::table(self::$sTableName)
            ->join('activity_relation', self::$sTableName . '.id', '=', 'activity_relation.activity_id')
            ->join('zslm_major', 'activity_relation.host_major_id', '=', 'zslm_major.id')
            ->join('dict_activity_type', self::$sTableName . '.active_type', '=', 'dict_activity_type.id')
            ->where(self::$sTableName . '.show_state', 0)
            ->where(self::$sTableName . '.is_delete', 0)
            ->whereIn(self::$sTableName.'.id',$a_id);
        
        $get_info = $handel->orderBy('show_weight', 'desc')
            ->offset($pageCount * ($pageNumber - 1))
            ->limit($pageCount)
            ->select(
            self::$sTableName . '.id',
            self::$sTableName . '.active_name',
            self::$sTableName . '.province',
            self::$sTableName . '.begin_time',
            self::$sTableName . '.end_time',
            self::$sTableName . '.active_img',
            self::$sTableName . '.address',
            self::$sTableName . '.update_time',
            self::$sTableName . '.address',
            self::$sTableName . '.active_status',
            
            'dict_activity_type.name as activity_type',
            'zslm_major.z_name',
            'zslm_major.magor_logo_name'
        )->get();
        
        return ['info'=>$get_info];
    }
    
 
}