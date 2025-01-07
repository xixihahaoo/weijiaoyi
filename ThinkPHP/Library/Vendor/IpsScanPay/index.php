<?php
require_once ("IpsPay.Config.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="source/style-05.css" rel="stylesheet" />
<title>扫码支付</title>
</head>
<body>
	<form name="pay" method="post" action="IpsPayApi.php" id="pay" target="_blank">
		<div class="roll-out-container">
			<ul>
				<li><span class="set-title">商户号</span> <span><input id="merCode"
						name="merCode" type="text" class="set-input" value="<?php echo $ipspay_config['MerCode'];?>" /></span></li>
			</ul>
			<ul>
				<li><span class="set-title">商户账户号</span> <span><input
						id="merAccount" name="merAccount" type="text" class="set-input"
						value="<?php echo $ipspay_config['Account'];?>" /></span></li>
			</ul>
			 <ul>
                <li>
                    <span class="set-title">商户订单号</span>
                    <span>
                        <input id="merBillNo" name="merBillNo" type="text" class="set-input" value="" /></span>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="set-title">支付方式</span>
                    <span>
                        <select id="gatewayType" name="gatewayType">
                            <option value="10">微信</option>
                            <option value="11">支付宝</option>
                        </select>
                    </span>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="set-title">订单日期</span>
                    <span>
                        <input id="orderDate" name="orderDate" type="text" class="set-input" value="" /></span>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="set-title">订单金额</span>
                    <span>
                        <input id="amount" name="amount" type="text" class="set-input" value="0.01" /></span>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="set-title">订单有效期</span>
                    <span>
                        <input id="billEXP" name="billEXP" type="text" class="set-input" value="2" /></span>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="set-title">商品名称</span>
                    <span>
                        <input id="goodsName" name="goodsName" type="text" class="set-input" value="环迅" /></span>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="set-title">商户数据包</span>
                    <span>
                        <input id="attach" name="attach" type="text" class="set-input" value="商户数据包" /></span>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="set-title">异步S2S返回</span>
                    <span>
                        <input id="serverUrl" name="serverUrl" type="text" class="set-input" value="http://<?php echo $_SERVER['HTTP_HOST']?>/ipsscanpay/s2snotify_url.php" /></span>
                </li>
            </ul>
        </div>

        <div id="disableBtn" class="bill-btn-container">
            <button id="submit" type="submit" class="bill-sub-btn">确&nbsp;定</button>
        </div>
	</form>
</body>
<script type="text/javascript">
        var out_MerTrade_no = document.getElementById("merBillNo");
        var inDate = document.getElementById("orderDate");

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

        out_MerTrade_no.value = 'Mer' + new Date().format("yyyyMMddhhmmss");
        inDate.value = new Date().format("yyyyMMdd");

</script>
</html>