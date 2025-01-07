<?php
/**
 * 支付接口调测例子
 * ================================================================
 * index 进入口，方法中转
 * submitOrderInfo 提交订单信息
 * queryOrder 查询订单
 *
 *
 * array(16) {
        ["MsgId"]=>
        string(5) "00001"
        ["ReqDate"]=>
        string(14) "20170206173741"
        ["MerCode"]=>
        string(6) "192545"
        ["MerName"]=>
        string(0) ""
        ["Account"]=>
        string(10) "1925450015"
        ["MerBillNo"]=>
        string(17) "Mer20170206173731"
        ["GatewayType"]=>
        string(2) "10"
        ["Date"]=>
        string(8) "20170206"
        ["RetEncodeType"]=>
        string(2) "17"
        ["CurrencyType"]=>
        string(3) "156"
        ["Amount"]=>
        string(4) "0.01"
        ["BillEXP"]=>
        string(1) "2"
        ["GoodsName"]=>
        string(6) "环迅"
        ["ServerUrl"]=>
        string(41) "http://huanxun.edc6.com/s2snotify_url.php"
        ["Lang"]=>
        string(2) "GB"
        ["Attach"]=>
        string(15) "商户数据包"
    }
 *
 * ================================================================
 */
namespace Org\Util;

require_once('ipspay/IpsPay.Config.php');
require_once("ipspay/lib/IpsPaySubmit.class.php");
require_once("ipspay/lib/IpsPayNotify.class.php");


class Ipspay
{
    //订单有效期
    private $billEXP        = 2;
    //商品名称
    private $goodsName      = '账户充值';
    //商户数据包
    private $attach         = '';
    //加密方式
    private $retEncodeType  = '17';

    private $ipspay_config  = array();


    //支付方式 01#借记卡 02#信用卡 03#IPS账户支付
    private $selPayType     = '01';
    //商戶名
    private $merMerName     = '';
    //支付结果失败返回的商户URL
    private $inFailUrl      = 'http://wei.xcjhjys.com/OrderPay/return_url.php';



    public function __construct()
    {
        $this->ipspay_config['Version']         = 'v1.0.0';
        //商戶號
        $this->ipspay_config['MerCode']         = '192353';
        //交易賬戶號
        $this->ipspay_config['Account']         = '1923530016';
        //商戶證書
        $this->ipspay_config['MerCert']         = 'rlCnr8pLDt89ZRJemb7thAEEXLwLyA2zUwG6EvNDZDNLwy9XtCGG4f3GX3CU9Hg0KDOuORk8AkUtFXQDeampXyRmezKuHFz2mTZHkuq2Zrgn13OmkJa9s570VtfdYTYd';
        //請求地址
        $this->ipspay_config['PostUrl']         = 'https://mobilegw.ips.com.cn/psfp-mgw/paymenth5.do';
        //服务器S2S通知页面路径
        $this->ipspay_config['S2Snotify_url']   = "http://wei.xcjhjys.com/Home/Pay/notify_url.html";
        //页面跳转同步通知页面路径
        $this->ipspay_config['return_url']      = "http://wei.xcjhjys.com/Home/Pay/return_url.html";


        //156#人民币
        $this->ipspay_config['Ccy']             = "156";
        //GB中文
        $this->ipspay_config['Lang']            = "GB";
        //订单支付接口加密方式 5#订单支付采用Md5的摘要认证方式
        $this->ipspay_config['OrderEncodeType'] = "5";
        //返回方式 1#S2S返回
        $this->ipspay_config['RetType']         = "1";

        $this->ipspay_config['MsgId']           = "";
    }


    /**
     * @functionname: get_pay_content
     * @author: FrankHong
     * @date: 2017-04-11 15:07:24
     * @description: 请求接口，网关支付
     * @note:
     * gatewayType  10 微信
     *              11 支付宝
     * @return array
     * @param $dataArr
     *

     *
     *
     *      http://wei.xcjhjys.com/home/pay/ips
     *
     *
     */
    public function get_pay_content($dataArr)
    {
        //商户订单号
        $merBillNo      = $dataArr['merBillNo'];
        //订单日期
        $orderDate      = $dataArr['orderDate'];
        //订单金额
        $amount         = $dataArr['amount'];

        //构造要请求的参数数组
        $parameter = array(
            "Version"           => $this->ipspay_config['Version'],
            "MerCode"           => $this->ipspay_config['MerCode'],
            "Account"           => $this->ipspay_config['Account'],
            "MerCert"           => $this->ipspay_config['MerCert'],
            "PostUrl"           => $this->ipspay_config['PostUrl'],
            "S2Snotify_url"     => $this->ipspay_config['S2Snotify_url'],
            "Return_url"        => $this->ipspay_config['return_url'],
            "CurrencyType"	    => $this->ipspay_config['Ccy'],
            "Lang"	            => $this->ipspay_config['Lang'],
            "OrderEncodeType"   => $this->ipspay_config['OrderEncodeType'],
            "RetType"           => $this->ipspay_config['RetType'],
            "MerBillNo"	        => $merBillNo,
            "MerName"	        => $this->merMerName,
            "MsgId"	            => $this->ipspay_config['MsgId'],
            "PayType"	        => $this->selPayType,
            "FailUrl"           => $this->inFailUrl,
            "Date"	            => $orderDate,
            "ReqDate"	        => date("YmdHis"),
            "Amount"	        => $amount,
            "Attach"	        => $this->attach,
            "RetEncodeType"	    => $this->retEncodeType,
            "BillEXP"	        => $this->billEXP,
            "GoodsName"	        => $this->goodsName
        );


		Log::debugArr($parameter, 'test');

        $ipspaySubmit = new \IpsPaySubmit($this->ipspay_config);
        $html_text = $ipspaySubmit->buildRequestForm($parameter);

		//vD($html_text);

		Log::debugArr($html_text, 'test');
        
		return $html_text;
    }


    /**
     * @functionname: notify_res
     * @author: FrankHong
     * @date: 2017-04-11 17:54:20
     * @description: 处理回调
     * @note:
     */
    public function notify_res()
    {
        $ipspayNotify   = new \IpsPayNotify($this->ipspay_config);
        $verify_result  = $ipspayNotify->verifyReturn();

        if ($verify_result)
        {
            // 验证成功
            $paymentResult  = $_REQUEST['paymentResult'];
            $xmlResult      = new \SimpleXMLElement($paymentResult);
            $status         = $xmlResult->GateWayRsp->body->Status;
            if ($status == "Y")
            {
                $message    = "交易成功";
                return "ipscheckok";
            }
            elseif($status == "N")
            {
                $message    = "交易失败";
                return "ipscheckfail";
            }
            else
            {
                $message    = "交易处理中";
                return "ipscheckfail";
            }
        }
        else
        {
            return "ipscheckfail";
        }

    }



}
