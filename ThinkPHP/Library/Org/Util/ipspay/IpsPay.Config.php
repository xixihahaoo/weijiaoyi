<?php
$ipspay_config['Version']	 = 'v1.0.0';
//商戶號
$ipspay_config['MerCode']	 = '192353';
//交易賬戶號
$ipspay_config['Account']	 = '1923530016';
//商戶證書
$ipspay_config['MerCert']	 = 'rlCnr8pLDt89ZRJemb7thAEEXLwLyA2zUwG6EvNDZDNLwy9XtCGG4f3GX3CU9Hg0KDOuORk8AkUtFXQDeampXyRmezKuHFz2mTZHkuq2Zrgn13OmkJa9s570VtfdYTYd';
//請求地址
$ipspay_config['PostUrl']	 = 'https://mobilegw.ips.com.cn/psfp-mgw/paymenth5.do';
//服务器S2S通知页面路径
$ipspay_config['S2Snotify_url'] = "http://localhost:8081/orderpay/s2snotify_url.php";
//页面跳转同步通知页面路径 
$ipspay_config['return_url'] = "http://wei.xcjhjys.com/Home/Pay/return_url.html";
//156#人民币
$ipspay_config['Ccy'] = "156";
//GB中文
$ipspay_config['Lang'] = "GB";
//订单支付接口加密方式 5#订单支付采用Md5的摘要认证方式
$ipspay_config['OrderEncodeType'] = "5";
//返回方式 1#S2S返回
$ipspay_config['RetType'] = "1";

$ipspay_config['MsgId'] = "";
