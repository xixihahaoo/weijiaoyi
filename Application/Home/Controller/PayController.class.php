<?php
namespace Home\Controller;
header("content-type:text/html;charset=UTF-8");

use Think\Controller;
use Org\Util\Yongyi;
use Org\Util\Log;


class PayController extends CommonController
{
    
     /**
      * [number 生成订单号]
      * @author wang 990529346@qq.com
      */
    private function number()
    {
         return time().mt_rand();
    }

    /**
     * [pay 开始支付]
     * @author wang 990529346@qq.com
     */
     public function pay()
     {
        if(IS_POST)
        {
            $balance    = trim(I('post.balance'));
            $paytype    = trim(I('post.paytype'));

            if(empty($balance))
            {
                $this->error('金额不存在');
                return false;
            }

            if(empty($paytype))
            {
                $this->error('支付方式不存在');
                return false;
            }

            $data['bptime']     = time();
            $data['bptype']     = '充值';
            $data['uid']        = $this->user_id;
            $data['balanceno']  = $this->user_id.'YY'.time().rand(1,100);
            $data['remarks']    = "开始充值";
            $data['bpprice']    = $balance;
            $data['isverified'] = 0;
            $data['status']     = 0;

            $res = M('balance')->add($data);
            if($res)
            {
                 switch ($paytype) {
                     case 'yy_yinlian':
                         $this->yy_yinlian($data['balanceno'],$data['bpprice'],$data['remarks']);
                         break;
                     
                     default:
                         $this->error('系统没有此支付方式');
                         break;
                 }
            }

        }
    }

    public function yy_yinlian($orderId,$orderAmt,$remarks)
    {
        //mb_convert_encoding($str, 'utf-8', 'gbk');  utf-8转gbk

        $remarks    = mb_convert_encoding($remarks,'gbk','utf-8');

        $req        = new Yongyi();

        $bank       = $req->get_bank();   //获取银行卡列表

        $bankId     = $bank[3]['bankID'];
        

        $transactionData = "<orderNo>".$orderId."</orderNo><orderAmt>".$orderAmt."</orderAmt><bankId>".$bankId."</bankId><remark>".$remarks."</remark><cardType>01</cardType>";

        $returnData             = $req->repay($transactionData);

        $data                   = array();

        $data['interfaceName']  = $returnData['interfaceName'];
        $data['tranData']       = $returnData['tranDataBase64'];
        $data['version']        = $returnData['version'];
        $data['merSignMsg']     = $returnData['hmac'];
        $data['merchantId']     = $returnData['merId'];

        $this->create($data,$returnData['nodeAuthorizationURL']);
    }




    public function yy_pay_notify()
    {
        $balance    = M('balance');
        $account    = M('accountinfo');

        $req        = new Yongyi();
        $data       = $req->get_result($_POST);

        Log::debugArr($data, 'yongyi_notify_url111');

        if(empty($data))
        {
            Log::debugArr('支付异常', 'yongyi_notify');
            return false;
        }

        $order_no  = $data->orderNo;
        $orderAmts = $data->orderAmt;
        $tranStat  = $data->tranStat;

        if(substr($orderAmts,0,1) == '.')
        {
            $orderAmts = '0'.$orderAmts;
        }
        
        $data1 = $balance->where(array('balanceno' => "$order_no",'bpprice' => "$orderAmts"))->find();

        if($tranStat == 1)
        {
            if(!$data1)
            {
                $log = array('data' => $data, 'msg' => '系统没有查到该条订单信息');
                Log::debugArr($log,'yongyi_notify');
                return false; 
            }

            if($data1['isverified'] == 1 || $data1['status'] == 1)
            {
                $log = array('data' => $data, 'msg' => '已经充值成功了');
                Log::debugArr($log,'yongyi_notify');
                return false;
            }

            //执行系统入金规则
            $poundage = M('financial_setting')->where(array('type'=>1))->getField('poundage');
            $poundage = $poundage/100;

            $fee        = $orderAmts * $poundage;

            $orderAmts  = ($orderAmts-$fee);

            $datas['bpprice']    = $orderAmts;
            $datas['shibpprice'] = ($account->where(array('uid' => $data1['uid']))->getField('balance') + $orderAmts);
            $datas['isverified'] = 1;
            $datas['status']     = 1;
            $datas['cltime']     = time();
            $datas['remarks']    = '涌易银联['.$orderAmts.']';
            $datas['pay_type']   = 5;

            $case = $balance->where(array('balanceno' => "$order_no",'isverified' => 0,'status' => 0))->save($datas);

            if($case)
            {
                $money       = $account->where(array('uid' => $data1['uid']))->setInc('balance', $orderAmts);

                if($money)
                {
                    $map['uid']          = $data1['uid'];
                    $map['type']         = 4;
                    $map['oid']          = $data1['bpid'];
                    $map['note']         = '用户使用甬易支付充值['.$orderAmts.']元';
                    $map['op_id']        = $data1['uid'];
                    $map['user_type']    = 0;
                    $map['change_money'] = $orderAmts;
                    $map['balance']      = $account->where(array('uid' => $data1['uid']))->getField('balance');
                    $map['dateline']     = time();
                    if(M("money_flow")->add($map))
                    {
                        echo 'success';
                        $log = array('data' => $data, 'msg' => '充值成功');
                        Log::debugArr($log,'yongyi_notify');
                        return false;
                    }
                }
            }

        } else {

            $datas['isverified'] = 1;
            $datas['status']     = 0;
            $datas['remarks']    = '等待付款';
            $datas['cltime']     = time();

            $result = $balance->where(array('balanceno' => "$order_no",'isverified' => 0,'status' => 0))->save($datas);
            if($result)
            {
                echo 'error';
                $log = array('data' => $data, 'msg' => '充值失败');
                Log::debugArr($log,'yongyi_notify');
                return false;
            }
        }
    }


    /**
     * from表单提交
     * @author wang 990529346@qq.com
     */
    
    private function create($data, $submitUrl) {
        $inputstr = "";
        foreach ($data as $key => $v) {
            $inputstr .= '<input type="hidden"  id="' . $key . '" name="' . $key . '" value="' . $v . '"/>';
        }

        $form = '<form action="' . $submitUrl . '" name="pay" id="pay" method="POST">';
        $form .= $inputstr;
        $form .= '</form>';
        $html = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>请不要关闭页面,支付跳转中.....</title>
        </head><body>
        ';
        $html .= $form;
        $html .= '
        <script type="text/javascript">
           document.getElementById("pay").submit();
        </script>';
        $html .= '</body></html>';
        $this->Mheader('utf-8');
        echo $html;
        exit;
    }

    private function Mheader($type) {

        header("Content-Type:text/html;charset={$type}");
    }
  

    //随机生成订单编号
    public function build_order_no() {
        return date(time()) . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 3);
    }

}
