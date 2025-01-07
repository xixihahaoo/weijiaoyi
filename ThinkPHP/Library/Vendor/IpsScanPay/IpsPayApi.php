<?php

require_once "lib/IpsPayRequest.class.php";
require_once "lib/IpsPayVerify.class.php";

/**
 * ************************请求参数*************************
 */
function makeRequest($data) {
//商户号
	include "IpsPay.Config.php";
	$merCode = '192353'; //$data['merCode'];
	//商户账户号
	$merAccount = "1923530016";
//商户名
	$merMerName = '中原联合';
//商户订单号
	$merBillNo = $data['merBillNo'];
//支付方式
	$gatewayType = $data['gatewayType'];
//订单日期
	$orderDate = date('Ymd');
//订单金额
	$amount = $data['amount'];
//订单有效期
	$billEXP = 2;
//商品名称
	$goodsName = '中原联合';
//商户数据包
	$attach = '';
//异步S2S返回
	$serverUrl = $data['serverUrl'];
//加密方式
	$retEncodeType = '17';
//币种
	$currencyType = '156';
//语言
	$lang = 'GB';

	$MsgId = '00001';
/************************************************************/

//构造要请求的参数数组
	$parameter = array(
		"MsgId" => $MsgId,
		"ReqDate" => date("YmdHis"),
		"MerCode" => $merCode,
		"MerName" => $merMerName,
		"Account" => $merAccount,
		"MerBillNo" => $merBillNo,
		"GatewayType" => $gatewayType,
		"Date" => $orderDate,
		"RetEncodeType" => $retEncodeType,
		"CurrencyType" => $currencyType,
		"Amount" => $amount,
		"BillEXP" => $billEXP,
		"GoodsName" => $goodsName,
		"ServerUrl" => $serverUrl,
		"Lang" => $lang,
		"Attach" => $attach,
	);
//建立请求
	//print_r($ipspay_config);
	$ipspayRequest = new IpsPayRequest($ipspay_config);
	//print_r($parameter);
	$html_text = $ipspayRequest->buildRequest($parameter);
	//dump($html_text);die;
	$xmlResult = new SimpleXMLElement($html_text);
	//dump($xmlResult);die;
	$strRspCode = $xmlResult->GateWayRsp->head->RspCode;
	//var_dump($xmlResult);die;
	if ($strRspCode == "000000") {
		//返回报文验签
		$ipspayVerify = new IpsPayVerify($ipspay_config);
		$verify_result = $ipspayVerify->verifyReturn($html_text);
		// 验证成功
		if ($verify_result) {
			$strQrCodeUrl = $xmlResult->GateWayRsp->body->QrCode;
			$message = "交易成功";
		} else {
			$message = "验签失败";
		}
		return $strQrCodeUrl;
	} else {
		$message = $xmlResult->GateWayRsp->head->RspMsg;
		return false;
	}
}

?>
<?php

/*<body>
<?php if ("交易成功" == $message) {?>
<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫码支付</div><br/>
<div style="overflow: hidden">
<img alt="扫码支付" src="qrcode.php?data=<?php echo urlencode($strQrCodeUrl); ?>" class="codeimg2" style="width:150px;height:150px;"/>
</div>
<?php } else {?>
<div class="roll-out-container">
<ul>
<li><span class="set-title">交易结果</span>
<span class="set-label"><?php echo $message ?></span>
</li>
</ul>
</div>
<?php }?>
</body>
</html>
 */