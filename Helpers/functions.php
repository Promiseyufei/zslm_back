<?php
    
    //use Cookie;
    use App\Models\dict as Dict;
    use Illuminate\Support\Facades\Redis;
    use App\Models\dict_region as dictRegion;
    
    /**
     * 公共方法
     */
    
    function test()
    {
        return "公共方法成功了～";
    }
    
    //  function setIdToNumber($id) {
    //     $number = mb_strlen($id,'utf-8') < 7 ? (7 - mb_strlen($id,'utf-8')) : $id;
    //  }
    
    
    /**
     * 页面json 输出
     *
     * @param int $code
     * @param     $msg
     * @param     $paras
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
        return response()->json($res)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
    
    
    /**
     * 上传文件名 生成
     *
     * @param int $code
     * @param     $msg
     * @param     $paras
     */
    function getFileName($ext, $suffix = 'jpg')
    {
        $filename = time() . '-' . uniqid() . '-' . $ext . '.' . $suffix;
        return $filename;
    }
    
    
    /**
     * 判断字符串是否在所需字符串首
     *
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
     *
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
     *
     * @param $password
     * @param $salt
     *
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
     *
     * @param  string $src 源图片路径
     * @param  string $filename 保存名字
     * @param  string $filename 保存路径
     * @param  int    $width 缩略图宽度（只指定高度时进行等比缩放）
     * @param  int    $height 缩略图高度（只指定宽度时进行等比缩放）
     *
     * @return bool
     */
    function thumbnail($src, $filename, $filepath, $width = 150, $height = null)
    {
        $path = $filepath;
        if ($filename != '')
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
        if ($src_type == 3)
            $dest_img = imagecreate($width, $height);
        else $dest_img = imagecreatetruecolor($width, $height);
        imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);
        if (!is_dir($filepath)) {
            mkdir($filepath);
        }
        switch ($src_type) {
            case 1 :
                $img_type = 'gif';
                imagegif($dest_img, $path);
                break;
            case 2 :
                $img_type = 'jpeg';
                imagejpeg($dest_img, $path);
                break;
            case 3 :
                $img_type = 'png';
                imagepng($dest_img, $path);
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
     *
     * @param  string $big 现在时间
     * @param  string $little 记录更新时间
     */
    function timeDiff($big, $little)
    {
        $diff = $big - $little;
        if (0 <= $diff && $diff < 60) {
            return $diff . "秒前";
        } elseif (60 <= $diff && $diff < 3600)
            return (floor($diff / 60)) . "分钟前";
        elseif (3600 <= $diff && $diff < 86400)
            return (floor($diff / 3600)) . "小时前";
        elseif (86400 <= $diff && $diff < 2592000)
            return (floor($diff / 86400)) . "天前";
        elseif (2592000 <= $diff && $diff < 62208000)
            return (floor($diff / 43200 * 2592000)) . "月前";
        elseif (62208000 <= $diff)
            return (floor($diff / 518400 * 60)) . "年前";
    }
    
    
    /*
     * 生成n位随机字符串
     * str 字符串
     * num 位数
     * */
    function strRand($num = 10, $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $key = '';
        for ($i = 0; $i < $num; $i++) {
            $key .= $str[mt_rand(0, strlen($str) - 1)];
        }
        return $key;
    }
    
    
    function generateCode($length = 6)
    {
        return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
    }
    
    /*
     * 把秒转换成天数，小时数，分钟
     * $secs 秒
     * */
    function secsToStr($secs)
    {
        $r = '';
        if ($secs >= 86400) {
            $days = floor($secs / 86400);
            $secs = $secs % 86400;
            $r = $days . ' 天 ';
        }
        if ($secs >= 3600) {
            $hours = floor($secs / 3600);
            $secs = $secs % 3600;
            
            $r .= $hours . ' 小时 ';
        }
        if ($secs >= 60) {
            $minutes = floor($secs / 60);
            $secs = $secs % 60;
            $r .= $minutes . ' 分钟 ';
        }
        return $r;
    }
    
    
    /**
     * 字符串和数组的转换
     * $val  需要转换的数组或者字符串
     * $explStr  规定在哪里分割字符串或合并数组
     */
    function strChangeArr($val, $explStr = '')
    {
        
        $value = null;
        is_string($val) ? $value = explode($explStr, trim($val)) : (is_array($val) ? $value = implode($explStr, $val) : $value = 0);
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
    function getByteToMb($bytes)
    {
        $mb = $bytes / 1048576;
        return round($mb, 0);
    }
    
    /**
     * 将数字字符串数组转换为数字数组
     *
     * @param $val 带转换的字符串数字数组
     */
    function changeStringToInt($val)
    {
        if ($val == '' || $val == null)
            return [];
        if ($val != null)
            for ($i = 0; $i < sizeof($val); $i++) {
                $val[$i] = intval($val[$i]);
            }
        return $val;
    }
    
    /**
     * 删除数组中指定的值
     */
    function deleteArrValue($arr, $val)
    {
        array_splice($arr, array_search($val, $arr), 1);
        
        return $arr;
    }
    
    /**
     * @param       $type
     * @param array $requestParams 请求包换的字段名数组
     *
     * @return bool 返回请求数组的key中是否含有 $requestParams 所包括的值 并且 该key所对应的value不得为null  返回值为yes表示通过，未通过会返回错误字段名
     * @throws Exception type只能为1 or 2 其他情况会抛出异常
     */
    function judgeRequest($type, array $requestParams)
    {
        $requestArray = null;
        if ($type == 1)
            $requestArray = $_GET;
        else if ($type == 2)
            $requestArray = $_POST;
        else
            throw new Exception("Type must be in 1 or 2");
        if ($requestParams != null)
            for ($subscript = 0; $subscript < sizeof($requestParams); $subscript++) {
                
                if (!isset($requestArray[$requestParams[$subscript]]) || $requestArray[$requestParams[$subscript]] == null)
                    return $requestParams[$subscript];
            }
        return 'yes';
    }
    
    
    function mergeRepeatArray(...$arrays)
    {
        if (count($arrays) == 1)
            return array_unique($arrays);
        else {
            $array_b = [];
            foreach ($arrays as $key => $array)
                $array_b += array_flip($array);
            return array_keys($array_b);
            
        }
    }
    
    
    /**
     * 获取省市字典
     */
    function getMajorProvincesAndCity()
    {
        $region = Dict::dictRegion();
        foreach ($region[0] as $key => $item) {
            if (array_key_exists($item->id, $region)) {
                $item->citys = $region[$item->id];
                unset($region[$item->id]);
            }
        }
        return $region;
        
    }
    
    
    //  /**
    //   * 查找某个值是否存在于多维数组中
    //   * @params $value 需要潮汛的值
    //   * @params $array 多维数组
    //   * @return $item 存在指定值的一维数组数组
    //   */
    // function deep_in_array($value, $array) {
    //     foreach($array as $key => $item) {
    //         if(!is_array($item)) {
    //             if ($item == $value) {
    //                 return $item;
    //             } else {
    //                 continue;
    //             }
    //         }
    //         if(is_object($item))
    //             $array[$key] = $item = $item->toArray();
    
    //         if(in_array($value, $item)) {
    //             return $item;
    //         } else if($this->deep_in_array($value, $item)) {
    //             return $item;
    //         }
    //     }
    //     return false;
    // }
    
    
    /**
     * 上传文件
     */
    function createDirImg($imgName = '', $imgHandle, $modularName)
    {
        if ($imgHandle->isValid()) {
            $originalName = $imgHandle->getClientOriginalName(); //源文件名
            $ext = $imgHandle->getClientOriginalExtension();    //文件拓展名
            
            $file_type_arr = ['png', 'jpg', 'jpeg', 'tif', 'image/jpeg'];
            $type = $imgHandle->getClientMimeType(); //文件类型
            $realPath = $imgHandle->getRealPath();   //临时文件的绝对路径
            $size = $imgHandle->getSize();
            
            /**
             *
             * 判断类型
             * 判断是否在文件夹中存在
             * 判断大小
             */
            if (!in_array(strtolower($ext), $file_type_arr)) return [1, '请上传格式为图片的文件'];
            // else if(Storage::disk('operate')->exists($imgName)) return [1, '图片已存在'];
            else if (getByteToMb($size) > 4) return [1, '文件超出最大限制'];
            
            
            $bool = Storage::disk($modularName)->put($imgName, file_get_contents($realPath));
            return $bool ? $bool : [1, '图片上传失败'];
        } else return [1, '图片未上传'];
    }
    
    /**
     * 修改图片名称
     */
    function updateDirImgName($imgUrl = '', $imgNewName = '', $modularName, $url)
    {
        if ($imgUrl !== '' && $imgNewName !== '' && $modularName !== '') {
            $img_arr = explode('/', $imgUrl);
            if (count($img_arr) >= 2)
                return false;
            try {
                // $exists = Storage::disk($modularName)->exists($imgUrl);
                // $exists_new = Storage::disk($modularName)->exists($imgNewName);
                // if($exists == true && $exists == !$exists_new) {
                $dir_url = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $url . DIRECTORY_SEPARATOR;
                // dd($dir_url . $imgNewName);
                return rename($dir_url . $imgUrl, $dir_url . $imgNewName);
                // }
                // throw new \Exception('error');
            } catch (\Exception $e) {
                return false;
            }
        } else
            return false;
    }
    
    
    /**
     * 获得存储在redis中的用户的标示
     *
     * @param $userPhone 用户手机号
     * @param $type 类型 0获得用户会话控制　1获得用户短信验证码　2获得用户图形验证码
     */
    function getUserStatusString($userPhone = '', $type = 0)
    {
        switch ($type) {
            case 0:
                return $userPhone . '-state';
            case 1:
                return $userPhone . '-smsCode';
            case 2:
                return $userPhone . '-code';
            case 3:
                return $userPhone . '-recruitSmsCode';
        }
    }
    
    
    /**
     * 根据省市拼接id字符串获得所在省市
     *
     * @param $proStr 省市拼接字符串
     *
     * @return @pro 返回所在省市所在的数组　$pro['province']:所在省名称　$pro['city']:所在市名称
     */
    function getProCity($proStr = '')
    {
        $pro = [];
        $addressArr = strChangeArr($proStr, EXPLODE_STR);
        $pro['province'] = dictRegion::getOneArea($addressArr[0])[0]->name;
        $pro['city'] = '';
        if ($addressArr != null && sizeof($addressArr) > 1)
            $pro['city'] = dictRegion::getOneArea($addressArr[1])[0]->name;
        return $pro;
    }
    
    /**
     * 根据省市拼接id字符串获得所在省市
     *
     * @param $proStr 省市拼接字符串
     *
     * @return @pro 返回所在省市所在的数组　$pro['province']:所在省名称　$pro['city']:所在市名称
     */
    function getProCity_B($proStr = '')
    {
        $pro = [];
        $addressArr = strChangeArr($proStr, EXPLODE_STR);
        $addr = dictRegion::getOneArea($addressArr[0])[0];
//        $pro['province'] =
        $pro['province'] = '';
        $pro['city'] = '';
        if ($addr != null && sizeof($addr) > 0) {
            $pro['province'] = $addr->name;
            
            if ($addressArr != null && sizeof($addressArr) > 2) {
                $city = dictRegion::getOneArea($addressArr[1])[0];
                if (!empty($city) && sizeof($city)) {
                    $pro['city'] = $city[0]->name;
                }
            }
            return $pro;
        }
    }
    
    
    /**
     * 字符串超出部分以指定字符串代替
     *
     */
    function changeString($str = '', $start = 0, $length, $replace = '...', $codeType = 'utf-8')
    {
        return mb_strlen($str, $codeType) < ($start + $length) ? $str : mb_substr($str, $start, $length, $codeType) . $replace;
    }
    
    
    /**
     * 登录成功存储用户会话状态
     */
    function loginSuccess($request, $userPhone)
    {
        Redis::setex(getUserStatusString($userPhone, 0), 24 * 60 * 60, 1);
        
        if (!Redis::exists(getUserStatusString($userPhone, 0))) {
            $session = $request->session();
            $session->put(getUserStatusString($userPhone, 0), 1);
            Cookie::queue(getUserStatusString($userPhone, 0), 1, time() + 60 * 60 * 60 * 24);
        }
        
        return true;
    }
    
    
    //返回图片路径
    /**
     * $direction admin
     * $range info
     *
     */
    function splicingImgStr($direction, $range, $name)
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . '/storage/' . $direction . '/' . $range . '/' . $name;
    }
    
    
    /**
     * 合并两个一维数组并去重
     */
    function hebingArr($arr1, $arr2)
    {
        return array_keys(array_flip($arr1) + array_flip($arr2));
    }
    
    
    /**
     * @param $url 文件路径，文件的根已经定在了public/storage/，url的值一般都是public/storage/下的某个目录，如 test/test/
     *     也就是public/storage/test/test/目录 url必须前面不能加目录符，后面必须要加目录符
     * @param $name 文件名称
     *
     * @return string
     */
    function splicingImgStrPro($url, $name)
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . '/storage/' . $url . $name;
    }
    
    /**
     * 检查银行卡号是否有效
     *
     * @param $card 卡号
     *
     * @return bool
     */
    function validataBankCard($card)
    {
        $arr_no = str_split($card);
        $last_n = $arr_no[count($arr_no) - 1];
        krsort($arr_no);
        $i = 1;
        $total = 0;
        foreach ($arr_no as $n) {
            if ($i % 2 == 0) {
                $ix = $n * 2;
                if ($ix >= 10) {
                    $nx = 1 + ($ix % 10);
                    $total += $nx;
                } else {
                    $total += $ix;
                }
            } else {
                $total += $n;
            }
            $i++;
        }
        $total -= $last_n;
        $total *= 9;
        return $last_n == ($total % 10);
    }
    
    
    //判断是否是移动端访问
    function isMobile()
    {
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;// 找不到为flase,否则为TRUE
        }
        
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'mobile',
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap'
            );
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
            
            if (isset ($_SERVER['HTTP_ACCEPT'])) { // 协议法，因为有可能不准确，放到最后判断
                // 如果只支持wml并且不支持html那一定是移动设备
                // 如果支持wml和html但是wml在html之前则是移动设备
                if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                    return true;
                }
            }
            return false;
            
        }
    }

