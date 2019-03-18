<?php
/**
 * Created by PhpStorm.
 * User: jinzhao
 * Date: 2019/3/18
 * Time: 9:49 AM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class img extends Controller
{
    public function imgUpdate(Request $request){
        $img_handle = $request->file('image');

        $img_name = getFileName('operate', $img_handle->getClientOriginalExtension());
        $is_create_img = createDirImg($img_name, $img_handle, 'operate');
        if($is_create_img){
            return responseToJson(0, '上传成功', splicingImgStr('admin', 'operate', $img_name));
        }else{
            return responseToJson(1, '上传失败');
        }
    }
}