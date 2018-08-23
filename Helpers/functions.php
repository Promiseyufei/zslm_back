<?php

/**
 * 公共方法
 */

 function test() {
     return "公共方法成功了～";
 }

//  function setIdToNumber($id) {
//     $number = mb_strlen($id,'utf-8') < 7 ? (7 - mb_strlen($id,'utf-8')) : $id;
//  }


 /**
 * 页面json 输出
 *
 * @param int $code
 * @param $msg
 * @param $paras
 * $code = 0 请求正常
 * $code = 1 请求失败
 * $code = 2 其他情况
 */
function responseToJson($code = 0, $msg = '', $paras = null)
{
    $res["code"] = $code;
    $res["msg"] = $msg;
    // if (!empty($paras)) {
    $res["result"] = $paras;
    // }
    return response()->json($res);
}


/**
 * 上传文件名 生成
 *
 * @param int $code
 * @param $msg
 * @param $paras
 */
function getFileName($ext)
{
    $filename = time() . '-' . uniqid() . '.' . $ext;
    return $filename;
}


/**
 * 判断字符串是否在所需字符串首
 * @param string $str
 * @param string $needle
 */
function startWith($str, $needle)
{
    return strpos($str, $needle) === 0;
}


/**
 * 判断字符串是否在所需字符串尾
 */
function endWith($hayStack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($hayStack, -$length) === $needle);
}


/**
 * 生成一串随机字符串。如果不加前缀长度为36位
 * @param string $prefix
 */
function createUuid($prefix = "")
{    //可以指定前缀
    $str = md5(uniqid(mt_rand(), true));
    $uuid = substr($str, 0, 8) . '-';
    $uuid .= substr($str, 8, 4) . '-';
    $uuid .= substr($str, 12, 4) . '-';
    $uuid .= substr($str, 16, 4) . '-';
    $uuid .= substr($str, 20, 12);
    return $prefix . $uuid;
}

/**
 * 获取用户密码加密字符串
 * @param $password
 *               @param $salt
 * @return string
 */
function encryptPassword($passWord)
{
    return md5(md5($passWord));
}


/**
 * 返回一串float数字
 */
function millisecond()
{
     return floor(microtime(true) * 1000);
}



/**
 * 生成缩略图函数（支持图片格式：gif、jpeg、png）
 * @author ruxing.li
 * @param  string $src      源图片路径
 * @param  string $filename 保存名字
 * @param  string $filename 保存路径
 * @param  int    $width    缩略图宽度（只指定高度时进行等比缩放）
 * @param  int    $height    缩略图高度（只指定宽度时进行等比缩放）
 * @return bool
 */
function thumbnail($src, $filename, $filepath, $width = 150, $height = null) {
    $path = $filepath;
    if($filename!='')
        $path = $path . '/' . $filename;
    // $path = str_replace('\\','/',$path);
    // dd($path);
    $size = getimagesize($src);
    if (!$size)
        return false;
    list($src_w, $src_h, $src_type) = $size;
    if (!isset($width))
        $width = $src_w * ($height / $src_h);
    if (!isset($height))
        $height = $src_h * ($width / $src_w);

    $src_img = imagecreatefromstring(file_get_contents($src));
    if($src_type==3)
        $dest_img = imagecreate($width, $height);
    else $dest_img = imagecreatetruecolor($width, $height);
    imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);
    if(!is_dir($filepath)){
        mkdir($filepath);
    }
    switch($src_type) {
        case 1 :
            $img_type = 'gif';
            imagegif($dest_img,$path);
            break;
        case 2 :
            $img_type = 'jpeg';
            imagejpeg($dest_img,$path);
            break;
        case 3 :
            $img_type = 'png';
            imagepng($dest_img,$path);
            break;
        default :
            return false;
    }
    imagedestroy($src_img);
    imagedestroy($dest_img);
    return true;
}


/**
 * 得到记录的时间距离当前时间的长度
 * @param  string $big      现在时间
 * @param  string $little   记录更新时间
 */
function timeDiff($big,$little){
    $diff = $big-$little;
    if(0<=$diff&&$diff<60){
        return $diff."秒前";
    }elseif(60<=$diff&&$diff<3600)
        return (floor($diff/60))."分钟前";
    elseif(3600<=$diff&&$diff<86400)
        return (floor($diff/3600))."小时前";
    elseif(86400<=$diff&&$diff<2592000)
        return (floor($diff/86400))."天前";
    elseif(2592000<=$diff&&$diff<62208000)
        return (floor($diff/43200*2592000))."月前";
    elseif(62208000<=$diff)
        return (floor($diff/518400*60))."年前";
}


/*
 * 生成n位随机字符串
 * str 字符串
 * num 位数
 * */
function strRand($num,$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){
    $key = '';
    for ( $i = 0; $i < $num; $i++ )
    {
        $key .= $str[ mt_rand(0, strlen($str) - 1) ];
    }
    return $key;
}


/*
 * 把秒转换成天数，小时数，分钟
 * $secs 秒
 * */
function secsToStr($secs) {
    $r = '';
    if($secs>=86400){
        $days=floor($secs/86400);
        $secs=$secs%86400;
        $r=$days.' 天 ';
    }
    if($secs>=3600){
        $hours=floor($secs/3600);
        $secs=$secs%3600;

        $r.=$hours.' 小时 ';
    }
    if($secs>=60){
        $minutes=floor($secs/60);
        $secs=$secs%60;
        $r.=$minutes.' 分钟 ';
    }
    return $r;
}


/**
 * 字符串和数组的转换
 * $val  需要转换的数组或者字符串
 * $explStr  规定在哪里分割字符串或合并数组
 */
function strChangeArr($val,$explStr = '') {

    $value = null;
    is_string($val) ? $value = explode($explStr,trim($val)) : (is_array($val) ? $value = implode($explStr,$val) : $value = 0);
    return $value;
}


 /** 获得session中用户的id
 * @return int|string
 */
function get_session_user_id()
{
    $user = session("user");

    return $user ? $user->id : 0;
}



/**
 * 字节转ＭＢ
 */
function getByteToMb($bytes) {
    $mb = $bytes / 1048576;
    return round($mb, 0);
}


/**
 * 删除数组中指定的值
 */
 function deleteArrValue($arr, $val) {
    array_splice($arr, array_search($val, $arr), 1);

    return $arr;
 }


