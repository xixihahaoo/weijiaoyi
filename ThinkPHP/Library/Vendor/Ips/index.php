<?php
require_once ("IpsPay.Config.php");
 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>订单支付</title>
<link href="source/demostyle.css" rel="stylesheet" />
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
	<form action="ipspayapi.php" method="post" target="_blank">
		<div class="warp main1"></div>
		<div class="pay-demo">
			<span style="font-size: 22px; font-weight: bold;">订单支付</span>
			<div class="demo">
				<div class="demo-text">
					<table>
						<tr>
							<td style="text-align: right;"><span>商户号:</span></td>
							<td style="text-align: left;"><input type="text" name="InMerCode"
								id="InMerCode" value="<?php echo $ipspay_config['MerCode'];?>">
								<span style="color: red">*</span></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>交易账户号:</span></td>
							<td style="text-align: left;"><input type="text" name="InAccount"
								id="InAccount" value="<?php echo $ipspay_config['Account'];?>">
								<span style="color: red">*</span></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>商户名:</span></td>
							<td style="text-align: left;"><input type="text" name="InMerName"
								id="InMerName"></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>版本号:</span></td>
							<td style="text-align: left;"><input type="text" name="InVersion"
								id="InVersion" value="<?php echo $ipspay_config['Version'];?>"></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>商户订单号:</span></td>
							<td style="text-align: left;"><input type="text"
								name="InMerBillNo" id="InMerBillNo"> <span style="color: red">*</span>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>支付方式:</span></td>
							<td style="text-align: left;"><select id="selPayType"
								name="selPayType">
									<option value="01">借记卡</option>
									<option value="02">信用卡</option>
									<option value="03">IPS账户支付</option>
							</select></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>订单日期:</span></td>
							<td style="text-align: left;"><input type="text" name="InDate"
								id="InDate"> <span style="color: red">*</span></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>订单金额:</span></td>
							<td style="text-align: left;"><input type="text" name="InAmount"
								id="InAmount" value ="0.01"> <span style="color: red">*</span></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>支付结果成功返回的商户URL:</span></td>
							<td style="text-align: left;"><input type="text"
								name="InReturnUrl" id="InReturnUrl"
								value="<?php echo $ipspay_config['return_url'];?>" style="width:260px"> <span
								style="color: red">*</span></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>支付结果失败返回的商户URL</span></td>
							<td style="text-align: left;"><input type="text" name="InFailUrl"
								id="InFailUrl" style="width:260px"></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>商户数据包</span></td>
							<td style="text-align: left;"><input type="text" name="InAttach"
								id="InAttach" style="width:260px"></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>交易返回接口加密方式:</span></td>
							<td style="text-align: left;"><select id="selRetEncodeType"
								name="selRetEncodeType">
									<option value="17">Md5</option>
									 
							</select></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>异步S2S返回:</span></td>
							<td style="text-align: left;"><input type="text" 
								name="InServerUrl" id="InServerUrl"
								value="<?php echo $ipspay_config['S2Snotify_url'];?>" style="width:260px"> <span
								style="color: red">*</span></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>订单有效期:</span></td>
							<td style="text-align: left;"><input type="text" name="InBillEXP"
								id="InBillEXP"></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>商品名称:</span></td>
							<td style="text-align: left;"><input type="text"
								name="InGoodsName" id="InGoodsName" value="商品"> <span style="color: red">*</span>
							</td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>是否直连:</span></td>
							<td style="text-align: left;"><select id="selIsCredit"
								name="selIsCredit">
									<option value="">非直连</option>
									<option value="1">直连</option>
							</select></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>银行号:</span></td>
							<td style="text-align: left;"><input type="text"
								name="InBankCode" id="InBankCode"></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>产品类型:</span></td>
							<td style="text-align: left;"><select id="selProductType"
								name="selProductType">
									<option value="1">个人网银</option>
									<option value="2">企业网银</option>
							</select></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>姓名:</span></td>
							<td style="text-align: left;"><input type="text"
								name="InUserRealName" id="InUserRealName"></td>
						</tr>
						<tr>
							<td style="text-align: right;"><span>平台用户名:</span></td>
							<td style="text-align: left;"><input type="text"
								name="InUserId" id="InUserId"></td>
						</tr>
					</table>
				</div>
				<p>
					<input type="submit" class="botton" value="支付">
				</p>
			</div>
		</div>
	</form>
</body>
<script type="text/javascript">
var out_MerTrade_no = document.getElementById("InMerBillNo");
var inDate = document.getElementById("InDate");

//设定时间格式化函数
Date.prototype.format = function (format) {
    var args = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(),
        "h+": this.getHours(),
        "m+": this.getMinutes(),
        "s+": this.getSeconds(),
    };
    if (/(y+)/.test(format))
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var i in args) {
        var n = args[i];
        if (new RegExp("(" + i + ")").test(format))
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? n : ("00" + n).substr(("" + n).length));
    }
    return format;
};

out_MerTrade_no.value = 'Mer'+ new Date().format("yyyyMMddhhmmss");
inDate.value = new Date().format("yyyyMMdd");

</script>
</html>