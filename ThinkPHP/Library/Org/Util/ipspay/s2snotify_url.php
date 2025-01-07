<?php
require_once ("IpsPay.Config.php");
require_once ("lib/IpsPayNotify.class.php");
?>
<!DOCTYPE HTML>
<html>
<head>
<link href="source/demostyle.css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
$ipspayNotify = new IpsPayNotify($ipspay_config);
$verify_result = $ipspayNotify->verifyReturn();

if ($verify_result) { // 验证成功
   $paymentResult = $_REQUEST['paymentResult'];
    $xmlResult = new SimpleXMLElement($paymentResult);
    $status = $xmlResult->GateWayRsp->body->Status;
    if ($status == "Y") {
        $message = "交易成功";
        echo "ipscheckok";
    }elseif($status == "N")
    {
        $message = "交易失败";
        echo "ipscheckfail";
    }else {
        $message = "交易处理中";
        echo "ipscheckfail";
    }
} else {
    echo "ipscheckfail";
}

?>
 
<title>接口返回</title>
</head>
<body>
</body>
</html>