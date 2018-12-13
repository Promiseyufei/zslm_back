<?php

namespace App\Http\Controllers\Auto\Share;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AutographController extends Controller {

//获取accesstoken
    function getAccessToken()
    {

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".'wx036711c8ba26c70f'."&secret=".'8b0bc5270f51aa702c975b8da0392bbf';
        // 微信返回的信息
        $returnData = json_decode($this->curlHttp($url));
        if(!empty($returnData->errcode) && $returnData->errcode != 0) return false;
        $resData['accessToken'] = $returnData->access_token;
        $resData['expiresIn'] = $returnData->expires_in;
        $resData['time'] = date("Y-m-d H:i",time());

        $res = $resData;
        return $res;
    }

    function curlHttp($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($curl, CURLOPT_TIMEOUT, 500 );
        curl_setopt($curl, CURLOPT_URL, $url );
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    public function getJsApiTicket($accessToken) {
 
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$accessToken&&type=jsapi";
        // 微信返回的信息
        $returnData = json_decode($this->curlHttp($url));
        if(!empty($returnData->errcode) && $returnData->errcode != 0) return false;
        $resData['ticket'] = $returnData->ticket;
        $resData['expiresIn'] = $returnData ->expires_in;
        $resData['time'] = date("Y-m-d H:i",time());
        $resData['errcode'] = $returnData->errcode;
 
        return $resData;
    }
    // 获取签名
    public function getSignPackage(Request $request) {
        // 获取token
        $token = $this->getAccessToken();
        
        // 获取ticket
        $ticketList = $this->getJsApiTicket($token['accessToken']);
        if($token == false || $ticketList == false) return responseToJson(0, 'error');
        
        $ticket = $ticketList['ticket'];
        
        // 该url为调用jssdk接口的url
        $url = $request->url;
        // 生成时间戳
        $timestamp = time();
        // 生成随机字符串
        $nonceStr = $this->createNoncestr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序 j -> n -> t -> u
        $string = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array (
            "appId" => 'wxda450acec7d47d60',
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string,
            "ticket" => $ticket,
            "token" => $token['accessToken']
        );

        // 返回数据给前端
        return responseToJson(0, 'success', $signPackage);
    }

    // 创建随机字符串
    public function createNoncestr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for($i = 0; $i < $length; $i ++) {
            $str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
        }
        return $str;
    }
}

