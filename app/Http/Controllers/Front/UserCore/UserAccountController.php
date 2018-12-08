<?php
/**
 * 个人中心-账户管理
 * shanlei
 */
namespace App\Http\Controllers\Front\UserCore;
 
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Models\dict as Dict;
use App\Models\user_accounts as UserAccounts;

class UserAccountController extends Controller{


    /**
     * 用户账户管理获得用户个人信息
     * @param $phone
     * @return 
     * 用户头像
     * 用户昵称
     * 手机号
     * 注册时间
     * 真实姓名
     * 性别
     * 常住地
     * 最高学历
     * 毕业院校
     * 所属行业
     * 工作年限
     */
    public function getUserAccountInfo(Request $request) {
        if($request->isMethod('get')) {
            $user_phone = !empty($request->phone) ? $request->phone : '';
            if($user_phone == '') return responseToJson(1, '参数错误');
            if(!Redis::get(getUserStatusString($user_phone, 0))) return responseToJson(3, '用户登录状态已失效，请重新登录');
            $user_info = UserAccounts::getUserInfo($user_phone);
            if(!empty($user_info)) {
                if($user_info->address != '' || !empty($user_info->address)) $user_info->address = getProCity($user_info->address);
                $user_info->create_time = date("Y-m-d", $user_info->create_time);
                    
            }
            return !empty($user_info) ? responseToJson(0, 'success', $user_info) : responseToJson(1, '查询不到该用户信息');
        }
        else return responseToJson(2, '请求方式错误');
    }


    /**
     * 获得所属行业列表/最高学历
     */
    public function getIndustryList() {
        $arr['industry'] = Dict::dictIndustry()->toArray();
        $arr['education'] = Dict::dictEducation()->toArray();
        $arr['workYears'] = Dict::workYears()->toArray();
        return responseToJson(0, 'success', $arr);
    }


    /**
     * 用户编辑昵称/修改头像
     * phone 用户手机号
     * type 0:修改昵称、1:修改头像
     * newName 用户昵称
     * userHeadImg 用户头像文件
     */
    public function changeName(Request $request) {
        if($request->isMethod('post')) {
            try {
                $user_phone = !empty($request->phone) ? $request->phone : '';
                // dd($request->type == 0);
                if($user_phone == '') throw new \Exception('参数错误');
                if($request->type == 0) {
                    $new_name = !empty(trim($request->newName)) ? trim($request->newName) : '';
                    if($new_name == '') throw new \Exception('用户昵称不能为空');
                } 
                else if($request->type == 1) {
                    $user_head_img = !empty($request->file('userHeadImg')) ? $request->file('userHeadImg') : null;
                    if($user_head_img == null) throw new \Exception('用户头像上传失败'); 
                }

                if($request->type == 0 && !empty(UserAccounts::getAppointUser($user_phone))) {
                    $is_update = UserAccounts::updateUserInfo($user_phone, ['user_name' => $new_name, 'update_time' => time()]);
                    return $is_update ? responseToJson(0, '修改成功') : responseToJson(1, '修改失败');
                }
                else if($request->type == 1 && !empty(UserAccounts::getAppointUser($user_phone))) {
                    DB::beginTransaction();
                    $img_name = getFileName('user', $user_head_img->getClientOriginalExtension());
                    $is_update = UserAccounts::updateUserInfo($user_phone, ['head_portrait' => $img_name, 'update_time' => time()]);
                    $is_put_img = createDirImg($img_name, $user_head_img, 'user');
                    if($is_update && isset($is_put_img) && !is_array($is_put_img)) {
                        DB::commit();
                        return responseToJson(0, '头像修改成功');
                    }
                    else if((is_array($is_put_img) && $is_put_img[0] == 1)) throw new \Exception($is_create_img[1]);
                    else  throw new \Exception('上传失败');
                }
                else throw new \Exception('没有该用户'); 
                
            }catch (\Exception $e) {
                if($request->type == 1) DB::rollback();//事务回滚
                return responseToJson(1, $e->getMessage());
            }
        }
        else return responseToJson(2, '请求方式错误');

    }

    /**
     * 用户修改个人信息
     * @param 
     * userRealName 真实姓名
     * userSex 用户性别
     * userAddress 用户常住地
     * userEducation 用户最高学历
     * userGraduation 用户毕业院校
     * userInIndustry 用户所属行业
     * userWorkYears 用户工作年限
     */
    public function changeUserInfo(Request $request) {

        if($request->isMethod('post')) {
            $user_phone = !empty($request->phone) ? $request->phone : '';
            if($user_phone == '') return responseToJson(1, '参数错误');
            if(trim($request->userRealName) == '') return responseToJson(1, '真实姓名不能为空');
            else if(!is_numeric($request->userSex)) return responseToJson(1, '请选择用户性别');
            else if(empty($request->userAddress)) return responseToJson(1, '请选择用户常住地');
            else if(empty($request->userEducation)) return responseToJson(1, '请选择用户最高学历');
            else if(empty(trim($request->userGraduation))) return responseToJson(1, '请填写用户毕业院校');
            else if(empty($request->userInIndustry)) return responseToJson(1, '请选择用户所属行业');
            else if(empty($request->userWorkYears)) return responseToJson(1, '请选择用户工作年限');

            $is_update = UserAccounts::updateUserInfo($user_phone, [
                'user_information.real_name'        => $request->userRealName,
                'user_information.sex'              => $request->userSex,
                'user_information.address'          => $request->userAddress,
                'user_information.schooling_id'     => $request->userEducation,
                'user_information.graduate_school'  => $request->userGraduation,
                'user_information.industry'         => $request->userInIndustry,
                'user_information.worked_year'      => $request->userWorkYears,
                'user_information.update_time'      => time()
            ]);
            return $is_update ? responseToJson(0, '修改成功') : responseToJson(1, '修改失败');
        }
        else return responseToJson(2, '请求方式错误');

    }



    /**
     * 用户前台获得省事字典
     */
    public function  getFrontProvince() {
       return responseToJson(0, '', getMajorProvincesAndCity());
    }




    






}