<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wx44c1f3df19dd2d03';
	//受理商ID，身份标识
	const MCHID = '1395206102';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = 'fawfq049lIKOAOj04023930e2kwmflsm';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = 'fedfa5b0ffd86cac6724d7c948b195f5';
	
	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	const JS_API_CALL_URL = '';
	
	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径
	const SSLCERT_PATH = 'ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_cert.pem';
	const SSLKEY_PATH = 'ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_key.pem';
	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = '';

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
}
	
?>