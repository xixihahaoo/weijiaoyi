<?php
require_once ("IpsPay.Config.php");
require_once ("lib/IpsPayNotify.class.php");

$ipspayNotify = new IpsPayNotify($ipspay_config);
$verify_result = $ipspayNotify->verifyReturn();

if ($verify_result) { // 验证成功
    /**
     * TODO 商户还需要实现的逻辑
     * 判断订单号和金额,请使用报文数据与本地数据比较
     * 
     */
     
    echo "ipscheckok";
} else {
    echo "ipscheckfail";
}

?>
