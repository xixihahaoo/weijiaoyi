<?php
//ini_set('date.timezone','Asia/Shanghai');
require_once("IpsPay_MD5.function.php");
require_once("IpsPayCode.funtion.php");
//require_once 'log.php';

//初始化日志
//$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);

class IpsPayNotify
{
    var $ipspay_config;
    
    function __construct($ipspay_config){
        $this->ipspay_config = $ipspay_config;
    }
    function IpsPayNotify($ipspay_config) {
        $this->__construct($ipspay_config);
    }
    
    function verifyReturn(){
        try {
            if(empty($_REQUEST)) {
                return false;
            }
            else {
                $paymentResult = $_REQUEST['paymentResult'];
                //Log::DEBUG("支付返回报文:" . $paymentResult);
                
                $xmlResult = new SimpleXMLElement($paymentResult);
                $strSignature = $xmlResult->GateWayRsp->head->Signature;
                
                $retEncodeType =$xmlResult->GateWayRsp->body->RetEncodeType;
                $strBody = subStrXml("<body>","</body>",$paymentResult);
                
               
                if(md5Verify($strBody,$strSignature,$this->ipspay_config["MerCode"],$this->ipspay_config["MerCert"])){
                    return true;
                }else{
                    //Log::DEBUG("支付返回报文验签失败:" . $paymentResult);
                    return false;
                }
            }
        } catch (Exception $e) {
            //Log::ERROR("异常:" . $e);
        }
        return false;
    }
}

?>