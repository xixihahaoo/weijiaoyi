<?php
/**
 * @author: FrankHong
 * @datetime: 2017-05-16 16:25:07
 * @filename: Yongyi.class.php
 * @description:  甬易支付
 * @note: 
 * 
 */

namespace Org\Util;

header("content-type:text/html;charset=UTF-8");

require('yongyi/algorithm.php');


class Yongyi
{
    private $resHandler = null;
    private $reqHandler = null;
    private $pay = null;
    private $cfg = null;

    public function __construct(){

    }


    public function repay($transactionData)
    {

        $transactionData1   = $transactionData; 	 //订单信息（订单号，金额，备注）

        //创建支付请求
        ////////////////////////////////////////////////////////////
        ///////支付请求表单域以接口文档为准//////////////
        ////////////////////////////////////////////////////////////
        $configFile             ="merchantInfo.ini";

        $keyValue               = getini("keyValue", "merchantInfo.ini");	  //商家密钥
        $nodeAuthorizationURL   = getini("payReqURL", "merchantInfo.ini");   //交易请求地址
        $interfaceName          = 'anonymousPayOrder';
        $merId                  = getini("merId", "merchantInfo.ini");		//商户编号
        $curType                = 'CNY';
        $merURL                 = getini("merURL", "merchantInfo.ini");	//商户接收支付成功页面跳转的地址
        $serverNotifyURL        = getini("serverNotifyURL", "merchantInfo.ini");;   //商户接收支付成功后台通知
        $version                = 'B2C1.0';

        $tranData       = "<?xml version=\"1.0\" encoding=\"GBK\"?><B2CReq><merchantId>".$merId."</merchantId><curType>".$curType."</curType><returnURL>".$merURL."</returnURL><notifyURL>".$serverNotifyURL."</notifyURL>".$transactionData1."</B2CReq>";//支付通道编码

        Log::debugArr($tranData,'yy_xml');

        // 获得MD5-HMAC签名
        $hmac           = HmacMd5($tranData, $keyValue);
        $tranDataBase64 = base64_encode($tranData);

        $dataReturn     = array(
            'interfaceName'         => $interfaceName,
            'version'               => $version,
            'tranData'              => $tranData,
            'tranDataBase64'        => $tranDataBase64,
            'hmac'                  => $hmac,
            'nodeAuthorizationURL'  => $nodeAuthorizationURL,
            'merId'                 => $merId
        );

        return $dataReturn;
    }


    /**
     * @functionname: get_result
     * @author: FrankHong
     * @date: 2017-05-23 17:54:09
     * @description: 甬易支付即时到账（直连银行）接口甬易后台通知处理页面
     * @note:
     * @return \SimpleXMLElement|string
     * @param $postArr
     */
    public function get_result($postArr)
    {
        $interfaceName  = $postArr['interfaceName'];
        $version        = $postArr['version'];
        $tranData       = $postArr['tranData'];								// 通知结果数据
        $signMsg        = $postArr['signData'];								// 甬易对通知结果的签名数据
        $configFile     = "merchantInfo.ini";									// 配置文件
        $keyValue       = getini("keyValue", "merchantInfo.ini");				// 商家密钥

        //对返回的tranData做base64的解码
        $tranDataDecode = base64_decode($tranData);
        // 获得MD5-HMAC签名
        $hmac           = HmacMd5($tranDataDecode, $keyValue);

        // 对返回的数据也进行验签
        if ($hmac == $signMsg)
        {
        //对返回的XML数据进行解析
            $retXml     = simplexml_load_string($tranDataDecode);
            return $retXml;
        }
        else
        {
            return 'error';
        }
    }


    /**
     * @functionname: get_bank
     * @author: wang
     * @date: 2017-05-23 17:54:09
     * @description: 甬易支付即时到账（直连银行）接口获取支付银行页面
     * @note:
     * @return \SimpleXMLElement|string
     *object(SimpleXMLElement)#10 (2) {
      ["bankCount"]=>
      string(2) "18"
      ["bankList"]=>
      object(SimpleXMLElement)#11 (1) {
    ["bankRow"]=>
    array(18) {
      [0]=>
      object(SimpleXMLElement)#12 (4) {
        ["bankName"]=>
        string(12) "工商银行"
        ["bankID"]=>
        string(4) "102C"
        ["otherBankID"]=>
        string(4) "ICBC"
        ["cardType"]=>
        string(2) "01"
      }
      [1]=>
      object(SimpleXMLElement)#13 (4) {
        ["bankName"]=>
        string(12) "农业银行"
        ["bankID"]=>
        string(4) "103C"
        ["otherBankID"]=>
        string(3) "ABC"
        ["cardType"]=>
        string(2) "01"
      }
      [2]=>
      object(SimpleXMLElement)#14 (4) {
        ["bankName"]=>
        string(12) "中国银行"
        ["bankID"]=>
        string(4) "104C"
        ["otherBankID"]=>
        string(3) "BOC"
        ["cardType"]=>
        string(2) "01"
      }
      [3]=>
      object(SimpleXMLElement)#15 (4) {
        ["bankName"]=>
        string(12) "建设银行"
        ["bankID"]=>
        string(4) "105C"
        ["otherBankID"]=>
        string(3) "CCB"
        ["cardType"]=>
        string(2) "01"
      }
      [4]=>
      object(SimpleXMLElement)#16 (4) {
        ["bankName"]=>
        string(12) "交通银行"
        ["bankID"]=>
        string(4) "301C"
        ["otherBankID"]=>
        string(4) "COMM"
        ["cardType"]=>
        string(2) "01"
      }
      [5]=>
      object(SimpleXMLElement)#17 (4) {
        ["bankName"]=>
        string(12) "中信银行"
        ["bankID"]=>
        string(4) "302C"
        ["otherBankID"]=>
        string(5) "CITIC"
        ["cardType"]=>
        string(2) "01"
      }
      [6]=>
      object(SimpleXMLElement)#18 (4) {
        ["bankName"]=>
        string(12) "光大银行"
        ["bankID"]=>
        string(4) "303C"
        ["otherBankID"]=>
        string(3) "CEB"
        ["cardType"]=>
        string(2) "01"
      }
      [7]=>
      object(SimpleXMLElement)#19 (4) {
        ["bankName"]=>
        string(12) "民生银行"
        ["bankID"]=>
        string(4) "305C"
        ["otherBankID"]=>
        string(4) "CMBC"
        ["cardType"]=>
        string(2) "01"
      }
      [8]=>
      object(SimpleXMLElement)#20 (4) {
        ["bankName"]=>
        string(12) "广发银行"
        ["bankID"]=>
        string(4) "306C"
        ["otherBankID"]=>
        string(3) "GDB"
        ["cardType"]=>
        string(2) "01"
      }
      [9]=>
      object(SimpleXMLElement)#21 (4) {
        ["bankName"]=>
        string(12) "平安银行"
        ["bankID"]=>
        string(4) "307C"
        ["otherBankID"]=>
        string(3) "PAB"
        ["cardType"]=>
        string(2) "01"
      }
      [10]=>
      object(SimpleXMLElement)#22 (4) {
        ["bankName"]=>
        string(12) "北京银行"
        ["bankID"]=>
        string(4) "309C"
        ["otherBankID"]=>
        string(3) "BOB"
        ["cardType"]=>
        string(2) "01"
      }
      [11]=>
      object(SimpleXMLElement)#23 (4) {
        ["bankName"]=>
        string(12) "浦发银行"
        ["bankID"]=>
        string(4) "310C"
        ["otherBankID"]=>
        string(4) "SPDB"
        ["cardType"]=>
        string(2) "01"
      }
      [12]=>
      object(SimpleXMLElement)#24 (4) {
        ["bankName"]=>
        string(12) "南京银行"
        ["bankID"]=>
        string(4) "325C"
        ["otherBankID"]=>
        string(4) "NJCB"
        ["cardType"]=>
        string(2) "01"
      }
      [13]=>
      object(SimpleXMLElement)#25 (4) {
        ["bankName"]=>
        string(24) "上海农村商业银行"
        ["bankID"]=>
        string(4) "339C"
        ["otherBankID"]=>
        string(4) "SRCB"
        ["cardType"]=>
        string(2) "01"
      }
      [14]=>
      object(SimpleXMLElement)#26 (4) {
        ["bankName"]=>
        string(24) "中国邮政储蓄银行"
        ["bankID"]=>
        string(4) "403C"
        ["otherBankID"]=>
        string(6) "POSTGC"
        ["cardType"]=>
        string(2) "01"
      }
      [15]=>
      object(SimpleXMLElement)#27 (4) {
        ["bankName"]=>
        string(12) "东亚银行"
        ["bankID"]=>
        string(4) "502C"
        ["otherBankID"]=>
        string(3) "BEA"
        ["cardType"]=>
        string(2) "01"
      }
      [16]=>
      object(SimpleXMLElement)#28 (4) {
        ["bankName"]=>
        string(18) "深圳发展银行"
        ["bankID"]=>
        string(4) "807C"
        ["otherBankID"]=>
        string(3) "SDB"
        ["cardType"]=>
        string(2) "01"
      }
      [17]=>
      object(SimpleXMLElement)#29 (4) {
        ["bankName"]=>
        string(12) "兴业银行"
        ["bankID"]=>
        string(4) "809C"
        ["otherBankID"]=>
        string(3) "CIB"
        ["cardType"]=>
        string(2) "01"
      }
    }
  }
}
     */

    public function get_bank()
    {      
        $configFile     = "merchantInfo.ini";
        $keyValue       = getini("keyValue","merchantInfo.ini");      //商家密钥
        $getBankURL     = getini("getBankURL","merchantInfo.ini");   //获取付款银行请求地址
        $interfaceName  = 'getBanksForPay';  
        $merId          = getini("merId","merchantInfo.ini");        //商户编号
        $version        = 'B2C1.0';

        $tranData       = "<?xml version=\"1.0\" encoding=\"GBK\"?><B2CReq><remark>mark</remark></B2CReq>";
        $hmac           = HmacMd5($tranData,$keyValue);
        $tranDataBase64 = base64_encode($tranData);

        $para = 'interfaceName='.$interfaceName.'&version='.urlencode($version).'&tranData='.urlencode($tranDataBase64).'&merSignMsg='.urlencode($hmac).'&merchantId='.$merId;

        $curl = curl_init($getBankURL);      // curl初始化
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);// SSL证书认证
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);// 非严格认证
         //curl_setopt($curl,CURLOPT_PORT, 8080 ); // 设置端口，视测试环境配置。上生产环境时注释掉
         curl_setopt($curl,CURLOPT_HEADER, 0 ); // 过滤HTTP头
         curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
         curl_setopt($curl,CURLOPT_POST,true); // post传输数据
         curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
         $responseText = curl_exec($curl);
        // var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
         curl_close($curl);

        $responseText = base64_decode($responseText);
 
        //$retXml = simplexml_load_string($responseText);

        libxml_disable_entity_loader(true);
        $bank = json_decode(json_encode(simplexml_load_string($responseText, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        return $bank['bankList']['bankRow'];
    }

    
}



