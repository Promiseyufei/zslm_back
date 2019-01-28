<?php


/**
 * 李闪磊
 * 2018-09-12
 * 自定义阿里云短信服务接口封装时需要的配置信息
 */
return array(


    /**
     * 短信API产品名
     * 不要修改
     */
    'product' => 'Dysmsapi',



    /**
     * 短信API产品域名
     * 不要修改
     */
    'domain' => 'dysmsapi.aliyuncs.com',



    /**
     * 暂时不支持多Region专硕联盟网站自定义短信通知
     * 不要修改
     */
    'region' => 'cn-hangzhou',


    /**
     * 服务结点
     * 不要修改
     */
    'endPointName' => 'cn-hangzhou',


    /**
     * AccessKeyId
     */
    'accessKeyId' => 'LTAItBjguvI9h5rV',



    /**
     * AccessKeyScret
     */
    'accessKeySecret' => '0lqnisn6tSLL30kw3JeHVxyc2t64bp',



    /**
     * 短信签名
     */

    'signName' => 'MBA小助手',


    /**
     * 短信模板
     * 短信名称 => 模板code
     */
    'templateCode' => array(

        '测试' => 'SMS_144451921',
        'MBA小助手短信验证' => 'SMS_149325185',
        'MBA小助手用于优惠券标识通知' => 'SMS_152506192',
        '专硕联盟网站自定义短信通知' => 'SMS_149096729'
    )


);


?>