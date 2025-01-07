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
        $merBillNo = $xmlResult->GateWayRsp->body->MerBillNo;
        $ipsBillNo = $xmlResult->GateWayRsp->body->IpsBillNo;
        $ipsTradeNo = $xmlResult->GateWayRsp->body->IpsTradeNo;
        $bankBillNo = $xmlResult->GateWayRsp->body->BankBillNo;
        $message = "交易成功";
    }elseif($status == "N")
    {
        $message = "交易失败";
    }else {
        $message = "交易处理中";
    }
} else {
    $message = "验证失败";
}

?>
 
<title>IPS订单支付接口返回</title>
</head>
<body>
	<div class="header">
		<div class="functionbar_box">
			<div class="functionbar">
				<div class="top_link font12_white">
					<div class="top_contact">
						<em>7×24小时客服热线：4009688588; +86-021-31081300 </em>
					</div>
				</div>
			</div>
		</div>
		<div class="nav_bg"></div>
		<div class="nav_box">
			<div class="nav_main">
				<div class="logo">
					<a href="http://www.ips.com/"> <img src="source/logo2.jpg"
						style="margin-top: -3px;" height="62" width="238">
					</a>
				</div>
			</div>
		</div>
	</div>
	<form id="form1">
		<div class="warp main1"></div>

		<div class="pay-demo">
			<span style="font-size: 22px; font-weight: bold;"><label
				id="lblResult"><?php echo $message?></label></span>
			<div class="demo">
				<div class="demo-text">
					<table>
						<tr>
							<td style="text-align: right;"><span>商户订单号:</span></td>
							<td style="text-align: left;"><label id="lblMerBillNo"><?php echo $merBillNo?></label>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>IPS订单号:</span></td>
							<td style="text-align: left;"><label id="lblIpsBillNo"><?php echo $ipsBillNo?></label>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>交易流水号:</span></td>
							<td style="text-align: left;"><label id="lblIpsTradeNo"><?php echo $ipsTradeNo?></label>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>银行订单号:</span></td>
							<td style="text-align: left;"><label id="lblBankBillno"><?php echo $bankBillNo?></label>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</form>
</body>
</html>