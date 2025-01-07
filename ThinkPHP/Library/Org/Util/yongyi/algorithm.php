<?php
/* *
 * 功能：甬易支付即时到账（直连银行）接口MD5签名方法页面
 * 版本：1.0
 * 日期：2014-03-04
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户应根据自己网站的需要，按照技术文档编写。
 */
 
function HmacMd5($data,$key)    
{    
    // RFC 2104 HMAC implementation for php.    
    // Creates an md5 HMAC.    
    // Eliminates the need to install mhash to compute a HMAC    
    // written by shihh
   
    //需要配置环境支持iconv，否则中文参数不能正常处理    
    $key = iconv("GB2312","UTF-8",$key);    
    $data = iconv("GB2312","UTF-8",$data);    
   
    $b = 64; // byte length for md5    
    if (strlen($key) > $b) {    
        $key = pack("H*",md5($key));    
    }    
    $key = str_pad($key, $b, chr(0x00));    
    $ipad = str_pad('', $b, chr(0x36));    
    $opad = str_pad('', $b, chr(0x5c));    
    $k_ipad = $key ^ $ipad ;    
    $k_opad = $key ^ $opad;    
   
    return md5($k_opad . pack("H*",md5($k_ipad . $data)));    
}   

//函数 parse_ini_file。
function getini($key,$inifile){
  $array = parse_ini_file($inifile);
  return $array[$key];
}

function getMd5($data){
   return  strtoupper(md5($data));
}   

function getHmacMd5($data,$key,$merchantId)
{
   $enkey= getMd5($key).$merchantId;
   $enkey= getMd5($enkey);
   return HmacMd5($data,$enkey);
}    
