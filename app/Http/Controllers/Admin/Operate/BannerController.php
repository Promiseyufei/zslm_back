<?php

/**
 * Banner管理
 * 频道横幅管理
 */

namespace App\Http\Controllers\Admin\Operate;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\banner_ad as BannerAd;
use App\Models\urls_bt as UrlsBt;
use DB;
use Log;

class BannerController extends Controller 
{

    

    /**
     * @api {post} admin/operate/getIndexListName 获得所有一级页面的名称
     * @apiGroup operate
     * 
     * @apiDescription 在频道横幅页面调用，获得顶部各列表页的名称，不需要传递参数
     * 
     *
     * @apiSuccess {Object[]} obj  一级页面名称
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "name":"xxxxxxxxxxxx",
     *              "url":"front/test/test"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     *
     */
    public function getIndexListName(Request $request) {
        // var_dump('test');die;
        if($request->isMethod('post')) {
            $indexs_name = UrlsBt::getIndexUrlName();
            $indexs_name  = count($indexs_name) ? $indexs_name : [];
            if($indexs_name !== []) 
                return responseToJson(0, '', $indexs_name);
            else 
                return responseToJson(1,'请求失败', $indexs_name);
        }
        else 
            return responseToJson(2,'请求方式错误');
    }



    /**
     * @api {post} admin/operate/getIndexBanner 获得一级页面的Banner
     * @apiGroup operate
     *
     * @apiParam {Number} indexId 一级页面id
     * @apiParam {Number} btType banner的类型　０是banner类型，1是广告类型
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "",
     * "data": {
     *
     *          {
     *              "id":"xxx",
     *              "img":"xxxxxxxxxxxx",
     *              "img_alt":"front/test/test",
     *              "re_rul":"xxxxxxxxxxxx",
     *              "re_alt":"xxxxxxxxxxxx",
     *              "show_weight":"xxxxxxxxxxxx",
     *              "create_time":"xxxxxxxxxxxx"
     *          }
     *   }
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '请求失败'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function getIndexBanner(Request $request) {
        if($request->isMethod('post')) {
            $url_id = is_numeric($request->indexId)? $request->indexId : 0;
            $bt_type = is_numeric($request->btType) ? $request->btType : -1;
            if($url_id !== 0 && $bt_type >= 0) {
                $url_bt = BannerAd::getIndexBt($url_id, $bt_type);
                if(is_array($url_bt)) {
                    if(count($url_bt) > 0)
                        foreach($url_bt as $key => &$value) {
                            $value->create_time = date('Y-m-d H:i:s', $value->create_time);
                        }
                    return responseToJson(0,'',$url_bt);
                }
                else 
                    return responseToJson(1,'请求失败',$url_bt);
            }
            else return responseToJson(1,'参数错误');
        }
        else 
            return responseToJson(2, '请求方式错误');
    }



    /**
     * @api {post} admin/operate/setBtWeight 设置一级页面上banner的权重
     * @apiGroup operate
     *
     * @apiParam {Number} bannerAdId 指定banner的id
     * @apiParam {Number} weight 要修改的权重，默认为0
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "更新成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": '更新失败/参数错误'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setBtWeight(Request $request) {
        if($request->isMethod('post')) {
            $banner_ad_id = is_numeric($request->bannerAdId) ? $request->bannerAdId : 0;
            $weight = is_numeric($request->weight) ? $request->weight : -1;
            if($banner_ad_id !== 0 && $weight >= 0) {
                $if_update = BannerAd::setBannerAdWeight($banner_ad_id, $weight);
                return $if_update ? responseToJson(0, '更新成功') : responseToJson(1, '更新失败');
            }
            else 
                return responseToJson(1, '参数错误');
        }
        else 
            return responseToJson(2,'请求方式错误');
    }



    /**
     * @api {post} admin/operate/setBtMessage 修改一级页面上指定banner的信息
     * @apiGroup operate
     *
     * @apiParam {String} btName 图片名称
     * @apiParam {String} btImgAlt 图片alt
     * @apiParam {String} reUrl 点击跳转的路由
     * @apiParam {String} btId Banner的id(必需)
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "更新成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function setBtMessage(Request $request) {
        if($request->isMethod('post')) {
            if((trim($request->btName) == '') || mb_strlen($request->btName, 'utf-8') > 30)
                return responseToJson(1, '图片名称长度错误');
            else $bt_arr['bt_name'] = $request->btName;
            
            if(mb_strlen($request->btImgAlt, 'utf-8') > 255)
                return responseToJson(1,'图片alt属性长度错误');
            else if(strpos($request->btImgAlt,'/') || strpos($request->btImgAlt,'.')) 
                return responseToJson(1, '图片名称含有非法字符');
            else
                $bt_arr['bt_img_alt'] = $request->btImgAlt;
            
            
            $pattern="/(\\w+(-\\w+)*)(\\.(\\w+(-\\w+)*))*(\\?\\S*)?/";
            if(!preg_match($pattern, $request->reUrl)) 
                return responseToJson('图片跳转url格式错误');
            else 
                (trim($request->reUrl) == '') ? $bt_arr['re_url'] = '' : $bt_arr['re_url'] = $request->reUrl;
            
            if(!isset($request->btId)) return responseToJson(1, '无法获得当前banner的id');
            
            try {
                DB::beginTransaction();
                $img_name = BannerAd::getBannerAdImgName($request->btId);
                $is_uppdate = BannerAd::setBannerAdMessage($request->btId, $bt_arr);

                $if_rename = $this->updateDirImgName($img_name, $bt_arr['bt_name']);
                if($is_uppdate && $if_rename) {
                    DB::commit();
                    return responseToJson(0,'更新成功');
                }
                else 
                    throw new \Exception('更新失败');
            } catch(\Exception $e) {
                DB::rollback();//事务回滚
                return responseToJson(1, $e->getMessage());
            }
        }
        else 
            return responseToJson(2,'请求方式错误');
    }



    /**
     * @api {post} admin/operate/deleteBannerAd 删除一级页面上的Banner
     * @apiGroup operate
     *
     * @apiParam {String} btId 要删除的Banner的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "删除成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */
    public function deleteBannerAd(Request $request) {
        if($request->isMethod('post')) {
            $bt_id = isset($request->btId) ? $request->btId : 0;
            if(!$bt_id) return responseToJson(1, '参数错误');
    
            $is_delete = BannerAd::delBannerBt($bt_id);
            return $is_delete ? responseToJson(0,'删除成功') : responseToJson(1, '删除失败');
        }
        else 
            return responseToJson(2,'请求错误');
    }




    /**
     * @api {post} admin/operate/createBannerAd 新增一级页面上的banner
     * @apiGroup operate
     *
     * @apiParam {String} imgName 图片名称
     * @apiParam {String} imgAlt 图片alt
     * @apiParam {String} reUrl 点击跳转的路由
     * @apiParam {Object} img 图片
     * @apiParam {Number} urlId 一级页面的id
     *
     * @apiSuccessExample　{json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "上传成功"
     * }
     *
     * @apiError　{Object[]} error　 这里是失败时返回实例
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 40x
     *     {
     *       "code": "1",
     *        "msg": 'xxxxxx'
     *     }
     *
     *      HTTP/1.1 5xx
     *     {
     *       "code": "2",
     *        "msg": '请求方式错误'
     *     }
     */  
    public function createBannerAd(Request $request) {
        if($request->isMethod('post')) {
            $img_name = trim($request->imgName);
            $img_alt  = trim($request->imgAlt);
            $re_url   = trim($request->reUrl);
            $img_handle      = $request->file('img');
            $url_id   = $request->urlId || 0;
            
            if(mb_strlen($img_name,'utf-8') >= 100) return responseToJson(1, '名称长度超出范围');
            else if(mb_strlen($img_alt) >= 255) return responseToJson(1,'图片描述长度超出范围');
            else if(mb_strlen($re_url) >= 255) return responseToJson(1,'跳转路由长度超出范围');
            else if(isset($img)) return responseToJson(1,'请选择要上传的图片');
            else if($url_id == 0) return responseToJson(1, '请指定Banner页面');
    
            if(!isset($img_name)) $img_name = getFileName('operate', $img_handle->getClientOriginalExtension());
            else $img_name = $img_name . '.' . $img_handle->getClientOriginalExtension();
            $img_msg = [
                'img' => $img_name,
                'img_alt' => $img_alt,
                're_url' => $re_url,
                'type'=> 0,
                'url_id' => $url_id
            ];
    
            try {
                DB::beginTransaction();
                $is_created = BannerAd::createBanAd($img_msg);
                $is_create_img = $this->createDirImg($img_name, $img_handle);
                
    
                if($is_created && ($is_create_img === true)) {
                    DB::commit();
                    return responseToJson(0, '上传成功'); 
                }
                else if(is_array($is_create_img) && $is_create_img[0] == 1) {
                    throw new \Exception($is_create_img[1]);
                }
                else throw new \Exception('上传失败');
    
            } catch(\Exception $e) {
                DB::rollback();//事务回滚
                return responseToJson(1, $e->getMessage());
            }
        }
        else 
            return responseToJson(2, '请求方式错误');
    }


    /**
     * 上传文件
     */
    private function createDirImg($imgName = '', &$imgHandle) {
        if($imgHandle->isValid()) {
            $originalName = $imgHandle->getClientOriginalName(); //源文件名
            $ext = $imgHandle->getClientOriginalExtension();    //文件拓展名

            $file_type_arr = ['png','jpg','jpeg','tif','image/jpeg'];
            $type = $imgHandle->getClientMimeType(); //文件类型
            $realPath = $imgHandle->getRealPath();   //临时文件的绝对路径
            $size = $imgHandle->getSize();

            /**
             * 
             * 判断类型
             * 判断是否在文件夹中存在
             *  判断大小
             */
            if(!in_array(strtolower($ext), $file_type_arr)) return [1,'请上传格式为图片的文件'];
            else if(Storage::disk('operate')->exists($imgName)) return [1, '图片已存在'];
            else if(getByteToMb($size) > 3) return [1, '文件超出最大限制'];
                

            $bool = Storage::disk('operate')->put($imgName, file_get_contents($realPath));
            return $bool ? $bool : [1, '图片上传失败'];
        }
        else return [1, '图片未上传'];
    }

    /**
     * 修改图片名称
     */
    private function updateDirImgName($imgUrl = '',$imgNewName = '') {
        if($imgUrl !== '' && $imgNewName !== '') {
            $img_arr = explode('/', $imgUrl); 
            if(count($img_arr) >= 2)
                return false;

            try {
                $exists = Storage::disk('operate')->exists($imgUrl);
                $exists_new = Storage::disk('operate')->exists($imgNewName);
                if($exists == true && $exists == !$exists_new) {
                    $dir_url = dirname(Storage::url($imgUrl));
                    return rename(Storage::url($imgUrl), $dir_url . $imgNewName);
                }
                throw new \Exception('error');
            } catch(\Exception $e) {
                return false;
            }
        }
        else 
            return false;
    }



}