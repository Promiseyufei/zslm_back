<?php

/**
 * 短信操作
 */

namespace App\Http\Controllers\Auto\Sms;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//aliyun sms
use Aliyun\Core\Config;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendBatchSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;



/**
 * 加载区域结点配置
 */
Config::load();


class SmsController extends Controller 
{



    static $acsClient = null;


    /**
     * 构造器
     * @param 
     */
    private static function getAcsClient() {
        if(static::$acsClient == null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile(config('sms.region'), config('sms.accessKeyId'),config('sms.accessKeySecret'));

            // 增加服务结点
            DefaultProfile::addEndpoint(config('sms.endPointName'), config('sms.region'), config('sms.product'), config('sms.domain'));

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);

        }

        return static::$acsClient;
    }



    /**
     * 发送短信
     * @param $phoneNumbers String 发送的手机号码
     * @param $signMseeage Array 短信模板参数　可以不用加键名，但是注意数组中顺序要和config中数组参数名顺序一致
     * @param $templateName String 短信模板名称
     * @param $outId String 短信流水单号
     */
    public static function sendSms(string $phoneNumbers = '', array $signMseeage = [], $templateName = '', $outId = null) {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest;

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($phoneNumbers);

        // 必填，设置签名名称，应严格按"签名名称"填写
        $request->setSignName(config('sms.signName'));

        // 必填，设置模板CODE，应严格按"模板CODE"填写
        $request->setTemplateCode(config("sms.templateCode.$templateName"));

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode($signMseeage, JSON_UNESCAPED_UNICODE));

        // 可选，设置流水号
        if($outId != null && is_string($outId)) $request->setOutId($outId);

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;

    }




    /**
     * 批量发送短信
     * @param $phoneBatchNUms Array 群发电话号码数组 批量发送上限为100
     * @param $templateName String 短信模板名称
     * @param $signMseeage Array 批量发送短信的模板参数
     */
    public static function sendBatchSms(array $phoneBatchNUms = [], $templateName = '', array $signMseeage = []) {

        $request = new SendBatchSmsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填:待发送手机号。支持JSON格式的批量调用，批量上限为100个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
        $request->setPhoneNumberJson(json_encode($phoneBatchNUms, JSON_UNESCAPED_UNICODE));

        for($i = 0; $i < count($phoneBatchNUms); $i++) 
            $signName[$i] = config('sms.signName');

        $request->setSignNameJson(json_encode($signName), JSON_UNESCAPED_UNICODE);

        $request->setTemplateCode(config("sms.templateCode.$templateName"));

        $request->setTemplateParamJson(json_encode($signMseeage), JSON_UNESCAPED_UNICODE);

        // 可选-上行短信扩展码(扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段)
        // $request->setSmsUpExtendCodeJson("[\"90997\",\"90998\"]");

        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;

    }



    /**
     * 短信发送记录查询
     * @param $queryPhoneNumber String 需要查询的手机号码
     * @param $date String 日期　格式Ymd,支持近三十天
     * @param $bizId String 流水单号
     */
    public static function querySendDetails($queryPhoneNumber = '', $date = '', $bizId = '') {

        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();

        //可选-启用https协议
        //$request->setProtocol("https");

        // 必填，短信接收号码
        $request->setPhoneNumber($queryPhoneNumber);

        // 必填，短信发送日期，格式Ymd，支持近30天记录查询
        $request->setSendDate($date);


        // 必填，分页大小
        $request->setPageSize(10);


        // 必填，当前页码
        $request->setCurrentPage(1);

        // 选填，短信发送流水号
        // $request->setBizId("yourBizId");

        // 发起访问请求
        $acsResponse = static::getAcsClient()->getAcsResponse($request);

        return $acsResponse;
    }


    
}