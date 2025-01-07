<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

/*
 *
 *author:Aiuh
 *平仓用的各项操作
 */
class HandleController extends Controller {
	public $options = array();
	/*
		处理订单的过程
	*/
	function lastNum($num) {
		$tmp = explode('.', $num);
		$dec = end($tmp);
		$count = strlen($dec);
		$p = round(pow(0.1, $count) * rand(1, 4), $count);
		return $p;
	}

	public function HandleTrade($trade, $options) {

		$Mtrade = M('order');
		$MUser  = M('accountinfo');

		$tradeid         = $trade['oid']; //订单ID
		$option_id       = intval($trade['data_now_id']);
		$trade_amount    = $trade['trade_amount'];
		$fee			 = $trade['fee'];  		 //手续费
		$trade_direction = $trade['ostyle'];     //0涨 1跌
		$trade_point     = $trade['buyprice'];
		$minute          = $trade['minute'];
		$userid          = $trade['uid'];


		$optionPrice = $options;
		$odds        = $trade['odds'];

        if($trade_direction == 0)
        {
           	if ($optionPrice > $trade_point) {
			    $direction = 1;  // 赢
			} elseif ($optionPrice == $trade_point) {
				$direction = 0; // 跟当前值没变化
			} elseif ($optionPrice < $trade_point) {
				$direction = -1; //输
			}
        } else {

        	if ( $optionPrice < $trade_point) {
			    $direction = 1;  // 赢
			} elseif ($optionPrice == $trade_point) {
				$direction = 0; // 跟当前值没变化
			} elseif ($optionPrice > $trade_point) {
				$direction = -1; //输
			}
        }

		if ($direction == 0) {

			echo '点数一样';
			$money  = $trade_amount;
			$profit = 0;
			$jour['jstate'] = 2;

            //平仓
			$Data = array('is_settle' => 1, 'ostaus' => 1, 'is_win' => 2, 'profit' => $profit, 'selltime' => date('Y-m-d H:i:s'), 'sellprice' => $optionPrice);
			$Mtrade->where(array('oid' => $tradeid))->save($Data);

			$MUser->where(array('uid' => $userid))->setInc('balance', $money);

			$order = M('order')->where(array('oid' => $tradeid))->find();
            money_flow($userid,2,0,$money,'用户对'.$order['ptitle'].'进行平仓增加['.$money.']元',$order['oid']);

            $type = special($userid, $profit,$tradeid); 		 	  //会员单位对赌
            if($type == 'true')
            {
				$this->operate($userid,$tradeid);  					  //运营中心 代理1 代理2 进行返佣
				$this->agent($userid,($trade_amount+$fee),$tradeid);  //全民经纪人返佣
            } else {
            	$th_uid = $type;
            }

		} elseif ($direction == 1) {

			echo "下对方向";
			$profit = $trade_amount * $odds;

            $money = $profit + $trade_amount;
			$MUser->where(array('uid' => $userid))->setInc('balance', $money);

            //平仓
			$jour['jstate'] = 1;
			$Data = array('is_settle' => 1, 'ostaus' => 1, 'is_win' => 1, 'profit' => $profit, 'selltime' => date('Y-m-d H:i:s'), 'sellprice' => $optionPrice);
			$Mtrade->where(array('oid' => $tradeid))->save($Data);

			$order = M('order')->where(array('oid' => $tradeid))->find();
            money_flow($userid,2,0,$money,'用户对'.$order['ptitle'].'进行平仓增加['.$money.']元',$order['oid']);

            $type = special($userid, $profit,$tradeid); //会员单位对赌
            if($type == 'true')
            {
				$this->operate($userid,$tradeid);
				$this->agent($userid,($trade_amount+$fee),$tradeid);
            } else {
            	$th_uid = $type;
            }


		} elseif ($direction == -1) {

			echo '下错方向';
			$money 	= 0;
			$profit = -$trade_amount;
			$jour['jstate'] = 0;

            //平仓
			$Data = array('is_settle' => 1, 'ostaus' => 1, 'is_win' => 0, 'profit' => $profit, 'selltime' => date('Y-m-d H:i:s'), 'sellprice' => $optionPrice);
			$condition = array('oid' => $tradeid);
			$Mtrade->where($condition)->save($Data);

			$order = M('order')->where(array('oid' => $tradeid))->find();
            money_flow($userid,2,0,$money,'用户对'.$order['ptitle'].'进行平仓增加['.$money.']元',$order['oid']);

            $type = special($userid, -$trade_amount,$tradeid);
            if($type == 'true')
            {
				$this->operate($userid,$tradeid);
				$this->agent($userid,($trade_amount+$fee),$tradeid);
            } else {
            	$th_uid = $type;
            }
		}


		$journal = M('journal');

		$productinfo = M("productinfo");
		$username = M('userinfo')->field("username")->where("uid='$userid'")->find();
		$balance = $MUser->field("balance")->where("uid='$userid'")->find();
		$orderno = $this->build_order_no() . rand(1000, 2000);
		$jour['jno']        = $orderno;
		$jour['uid']        = $userid;
		$jour['jtype']      = '平仓';
		$jour['jtime']      = date(time());
		$jour['remarks']    = $trade['ptitle'];
		$jour['balance']    = $balance['balance'];
		$jour['jusername']  = $username['username'];
		$jour['jostyle']    = $trade['ostyle'];
		$jour['jfee']       = $trade['fee'];
		$jour['jincome']    = $money;
		$jour['jbuyprice']  = $trade_point;  //进仓价
		$jour['jsellprice'] = $optionPrice;  //平仓价
		$jour['jaccess']    = $money;        //出入金
		$jour['jploss']     = $profit;       //盈亏
		$jour['oid']        = $tradeid;
		$jour['th_uid']		= $th_uid;

		$journal->add($jour);


	}

	public function Manage($trade, $options) {

		$MUser = M('userinfo');
		$userid = $trade['uid'];

		$tradeid = $trade['id'];

		$userinfo = $MUser->where(array('uid' => $userid))->find();
		$manage = $userinfo['manage'];

		$option_id = intval($trade['data_now_id']);
		$trade_amount = $trade['trade_amount'];
		$trade_direction = $trade['ostyle'];
		$trade_point = $trade['buyprice'];
		$minute = $trade['minute'];
		$optionPrice = $options[$option_id]['last'];
		$order_type = $trade['order_type'];
		$diffPrice = $this->lastNum($trade_point);
		$point = $trade_point - $optionPrice;
		if ($order_type == 2) {
			if ($manage == 1) {
				//必输
				if ($trade_direction == 0) {
					//买涨
					$optionPrice = $trade_point - $diffPrice;
				} else {

					$optionPrice = $trade_point + $diffPrice;
				}
			} elseif ($manage == 2) {

				if ($trade_direction == 0) {
					//买涨
					$optionPrice = $trade_point + $diffPrice;
				} else {
					$optionPrice = $trade_point - $diffPrice;
				}
			} elseif ($manage == 3 && abs($point) <= $userinfo['point']) {
				//必输
				if ($trade_direction == 0) {
					//买涨
					$optionPrice = $trade_point - $diffPrice;
				} else {
					$optionPrice = $trade_point + $diffPrice;
				}
			} elseif ($manage == 4 && abs($point) <= $userinfo['point']) {
				//必赢
				if ($trade_direction == 0) {
					//买涨
					$optionPrice = $trade_point + $diffPrice;
				} else {
					$optionPrice = $trade_point - $diffPrice;
				}
			}
		}


		$this->HandleTrade($trade, $optionPrice);
	}


/**
 * 运营中心 代理1 代理2 返佣
 * @param  [type] $userid  [description]
 * @param  [type] $tradeid [description]
 * @return [type]          [description]
 */
	public function operate($userid,$tradeid){

		$userinfo   = M('userinfo')->where(array('uid' => $userid))->find();

		//$branch_id	= $userinfo['branch_id']; 	//交易所分部id
		$operate_id = $userinfo['operate_id'];	//运营中心
		$unit_id    = $userinfo['unit_id'];		//会员单位
		$leaguer_id = $userinfo['leaguer_id'];	//代理1
		//$agent_id   = $userinfo['agent_id'];	//代理2

		//$branch  = M('userinfo')->field('feerebate,oid,username')->where(array('uid' => $branch_id))->find();
		$operate = M('userinfo')->field('feerebate,oid,username')->where(array('uid' => $operate_id))->find();
		$unit    = M('userinfo')->field('feerebate,oid,username')->where(array('uid' => $unit_id))->find();
		$leaguer = M('userinfo')->field('feerebate,oid,username')->where(array('uid' => $leaguer_id))->find();
		//$agent   = M('userinfo')->field('feerebate,oid,username')->where(array('uid' => $agent_id))->find();



		$order = M('order')->field('fee,trade_amount')->where(array('oid' => $tradeid))->find();
		$fee   = ($order['trade_amount'] + $order['fee']);


		// if(!empty($branch['feerebate']))
		// {
  //           //手续费 %
  //           $branch_fee  = $branch['feerebate']/100; 	//交易所分部
		// 	$branch_addmoney = $order['fee'] * $branch_fee;
		// 	M('accountinfo')->where(array('uid' => $branch_id))->setInc('balance',$branch_addmoney);
		// 	money_flow($branch_id,5,7,$branch_addmoney,'交易所分部['.$branch['username'].']获取佣金增加['.$branch_addmoney.']元',$tradeid);
		// }

		if(!empty($operate['feerebate']))
		{
            $operate_fee = $operate['feerebate']/100;   //运营中心
			$operate_addmoney = $order['fee'] * $operate_fee;
			M('accountinfo')->where(array('uid' => $operate_id))->setInc('balance',$operate_addmoney);
			money_flow($operate_id,5,5,$operate_addmoney,'运营中心['.$operate['username'].']获取佣金增加['.$operate_addmoney.']元',$tradeid);
		}

		if(!empty($leaguer['feerebate']))
		{
            $leaguer_fee = $leaguer['feerebate']/100;   //代理1
			$one_addmoney = $fee * $leaguer_fee;

			M('accountinfo')->where(array('uid' => $unit_id))->setDec('balance',$one_addmoney);     //会员单位
			M('accountinfo')->where(array('uid' => $leaguer_id))->setInc('balance',$one_addmoney);  //代理1

            money_flow($unit_id,5,2,$one_addmoney,'代理1['.$leaguer['username'].']获取佣金['.$unit['username'].']扣除['.$one_addmoney.']元',$tradeid);
            money_flow($leaguer_id,5,4,$one_addmoney,'代理1['.$leaguer['username'].']获取佣金增加['.$one_addmoney.']元',$tradeid);
		}

		// if(!empty($agent['feerebate']))
		// {
  //           $agent_fee   = $agent['feerebate']/100;     //代理2

		// 	$two_addmoney = $fee * $agent_fee;

	 //        M('accountinfo')->where(array('uid' => $leaguer_id))->setDec('balance',$two_addmoney);  //代理1
		// 	M('accountinfo')->where(array('uid' => $agent_id))->setInc('balance',$two_addmoney);    //代理2

		//     money_flow($leaguer_id,5,4,$two_addmoney,'代理2['.$agent['username'].']获取佣金['.$leaguer['username'].']扣除['.$two_addmoney.']元',$tradeid);
		//     money_flow($agent_id,5,1,$two_addmoney,'代理2['.$agent['username'].']获取佣金增加['.$two_addmoney.']元',$tradeid);
		// }

	}




	/**
	 * 全民经纪人返佣
	 * @author   <[990529346@qq.com wang]>
	 * $uid 	 用户id
	 * $profit 	 订单金额
	 * $order_id 订单id
	 */

	public function agent($uid='',$profit='',$order_id='')
	{


		if(empty($uid) || empty($profit) || empty($order_id)) return false;

		$userinfo	 = M('userinfo');
		$accountinfo = M('accountinfo');
		$rebate 	 = M('rebate');
		$agent 		 = M('agent');
		$flow 		 = M('MoneyFlow');

		$user 		 = $userinfo->where(array('uid' => $uid))->find();
		$unit 		 = $userinfo->field('username,uid')->where(array('uid' => $user['unit_id']))->find();

		$rebateData = $rebate->where(array('unit_id' => $user['unit_id']))->select();
		foreach ($rebateData as $key => $value) {
			if($value['type'] == 1)
			{
				$one_rate 	= ($value['rate'] / 100);
			} else if($value['type'] == 2)
			{
				$two_rate 	= ($value['rate'] / 100);
			} else if($value['type'] == 3){
				$three_rate = ($value['rate'] / 100);
			}
		}

		if($user['rel_id'])
		{
			$one_info = $userinfo->field("username,uid,rel_id")->where(array('uid' => $user['rel_id'],'otype' => 0))->find(); 	//一级用户

            if($one_info)
			{
				/*一级*/
				$one_profit = ($profit * $one_rate);

				if(!$agent->where(array('user_id' => $one_info['uid'],'order_id' => $order_id))->find())
				{

					if($accountinfo->where(array('uid' => $one_info['uid']))->setInc('balance',$one_profit))
					{
						$one_agent['order_id'] 	   = $order_id;
						$one_agent['user_id'] 	   = $one_info['uid'];
						$one_agent['profit'] 	   = $one_profit;
						$one_agent['fee'] 		   = $profit;
						$one_agent['rate'] 		   = $one_rate;
						$one_agent['class'] 	   = 1;
						$one_agent['status'] 	   = 1;
						$one_agent['purchaser_id'] = $user['uid'];
						$one_agent['create_time']  = time();
						$agent->add($one_agent);

						$one_flow['uid'] 			= $one_info['uid'];
						$one_flow['type'] 			= 5;
						$one_flow['oid'] 			= $order_id;
						$one_flow['note'] 			= '全民经纪人返佣['.$one_info['username'].']账户金额增加['.$one_profit.']元';
						$one_flow['op_id'] 			= $one_info['uid'];
						$one_flow['user_type'] 		= 0;
						$one_flow['change_money'] 	= $one_profit;
						$one_flow['balance'] 		= $accountinfo->where(array('uid' => $one_info['uid']))->sum('balance');
						$one_flow['dateline'] 		= time();

                        //Log::debugArr($one_flow, '3333333');
						$flow->add($one_flow);

						if($accountinfo->where(array('uid' => $unit['uid']))->setDec('balance',$one_profit))
						{
							$one_unit_flow['uid'] 			= $unit['uid'];
							$one_unit_flow['type'] 			= 5;
							$one_unit_flow['oid'] 			= $order_id;
							$one_unit_flow['note'] 			= '全民经纪人返佣['.$unit['username'].']账户金额扣除['.$one_profit.']元';
							$one_unit_flow['op_id'] 		= $one_info['uid'];
							$one_unit_flow['user_type'] 	= 2;
							$one_unit_flow['change_money'] 	= $one_profit;
							$one_unit_flow['balance'] 		= $accountinfo->where(array('uid' => $unit['uid']))->sum('balance');
							$one_unit_flow['dateline'] 		= time();
							$flow->add($one_unit_flow);
						}
					}

				}

				/*二级*/
				$two_info = $userinfo->field('username,uid,rel_id')->where(array('uid' => $one_info['rel_id'],'otype' => 0))->find();

				if($two_info)
				{
					$two_profit = ($profit * $two_rate);
					if(!$agent->where(array('user_id' => $two_info['uid'],'order_id' => $order_id))->find())
					{
						if($accountinfo->where(array('uid' => $two_info['uid']))->setInc('balance',$two_profit))
						{
							$two_agent['order_id'] 	   = $order_id;
							$two_agent['user_id'] 	   = $two_info['uid'];
							$two_agent['profit'] 	   = $two_profit;
							$two_agent['fee'] 		   = $profit;
							$two_agent['rate'] 		   = $two_rate;
							$two_agent['class'] 	   = 2;
							$two_agent['status'] 	   = 1;
							$two_agent['purchaser_id'] = $user['uid'];
							$two_agent['create_time']  = time();
							$agent->add($two_agent);


							$two_flow['uid'] 			= $two_info['uid'];
							$two_flow['type'] 			= 5;
							$two_flow['oid'] 			= $order_id;
							$two_flow['note'] 			= '全民经纪人返佣['.$two_info['username'].']账户金额增加['.$two_profit.']元';
							$two_flow['op_id'] 			= $two_info['uid'];
							$two_flow['user_type'] 		= 0;
							$two_flow['change_money'] 	= $two_profit;
							$two_flow['balance'] 		= $accountinfo->where(array('uid' => $two_info['uid']))->sum('balance');
							$two_flow['dateline'] 		= time();
							$flow->add($two_flow);

							if($accountinfo->where(array('uid' => $unit['uid']))->setDec('balance',$two_profit))
							{
								$two_unit_flow['uid'] 			= $unit['uid'];
								$two_unit_flow['type'] 			= 5;
								$two_unit_flow['oid'] 			= $order_id;
								$two_unit_flow['note'] 			= '全民经纪人返佣['.$unit['username'].']账户金额扣除['.$two_profit.']元';
								$two_unit_flow['op_id'] 		= $two_info['uid'];
								$two_unit_flow['user_type'] 	= 2;
								$two_unit_flow['change_money'] 	= $two_profit;
								$two_unit_flow['balance'] 		= $accountinfo->where(array('uid' => $unit['uid']))->sum('balance');
								$two_unit_flow['dateline'] 		= time();
								$flow->add($two_unit_flow);
							}
						}
					}

					/*三级*/
					$three_info = $userinfo->field("username,uid,rel_id")->where(array('uid' => $two_info['rel_id'],'otype' => 0))->find();
					if($three_info)
					{
						$three_profit = ($profit * $three_rate);
						if(!$agent->where(array('user_id' => $three_info['uid'],'order_id' => $order_id))->find())
						{
							if($accountinfo->where(array('uid' => $three_info['uid']))->setInc('balance',$three_profit))
							{
								$three_agent['order_id'] 	 = $order_id;
								$three_agent['user_id'] 	 = $three_info['uid'];
								$three_agent['profit'] 	   	 = $three_profit;
								$three_agent['fee'] 		 = $profit;
								$three_agent['rate'] 		 = $three_rate;
								$three_agent['class'] 		 = 3;
								$three_agent['status'] 	   	 = 1;
								$three_agent['purchaser_id'] = $user['uid'];
								$three_agent['create_time']  = time();
								$agent->add($three_agent);

								$three_flow['uid'] 			= $three_info['uid'];
								$three_flow['type'] 		= 5;
								$three_flow['oid'] 			= $order_id;
								$three_flow['note'] 		= '全民经纪人返佣['.$three_info['username'].']账户金额增加['.$three_profit.']元';
								$three_flow['op_id'] 		= $three_info['uid'];
								$three_flow['user_type'] 	= 0;
								$three_flow['change_money'] = $three_profit;
								$three_flow['balance'] 		= $accountinfo->where(array('uid' => $three_info['uid']))->sum('balance');
								$three_flow['dateline'] 	= time();
								$flow->add($three_flow);

								if($accountinfo->where(array('uid' => $unit['uid']))->setDec('balance',$three_profit))
								{
									$two_unit_flow['uid'] 			= $unit['uid'];
									$two_unit_flow['type'] 			= 5;
									$two_unit_flow['oid'] 			= $order_id;
									$two_unit_flow['note'] 			= '全民经纪人返佣['.$unit['username'].']账户金额扣除['.$three_profit.']元';
									$two_unit_flow['op_id'] 		= $three_info['uid'];
									$two_unit_flow['user_type'] 	= 2;
									$two_unit_flow['change_money'] 	= $three_profit;
									$two_unit_flow['balance'] 		= $accountinfo->where(array('uid' => $unit['uid']))->sum('balance');
									$two_unit_flow['dateline'] 		= time();
									$flow->add($two_unit_flow);
								}
							}
						}
					}
				}
			}
		}
	}


    public function position()
    {
    	$pres = 0;   //上一秒

        do{
        	$s  = time();  //当前秒
        	if($pres != $s)
        	{
        		$this->HandleOption();
        		$pres = $s;
        	} else {
                usleep(10000);
        	}


        }while(true);
    }


	/*
     * 平仓订单
	 */

public function HandleOption() {

		$Mtrade  = M('order');
		$Moption = M('data_now');

		//获取当前所有的交易品种的价格信息
	    foreach ($Moption->SELECT() as $key => $option) {
			$options[$option['id']] = $option;
		}

		//时间下单
		$time      	= date('Y-m-d H:i:s');
		$condition 	= array('is_settle' => 0, " '$time' >= finirm_time and order_type=2");
		$trades    	= $Mtrade->where($condition)->select();


		$oids		= get_log_temp();
		$tradeIdArr = array();
		foreach ($trades as $trade)
		{
			if(!in_array($trade['oid'], $oids))
			{
				array_push($tradeIdArr, $trade['oid']);
			}
		}


		if(!empty($tradeIdArr))
		{
			write_log('HandleOption', serialize($tradeIdArr));
			$logId	= write_log_temp('HandleOption11', serialize($tradeIdArr));
		}



		foreach ($trades as $trade)
		{
			if(!in_array($trade['oid'], $oids))
			{
				$journal = M('journal')->where(array('oid' => $trade['oid'],'jtype' => '平仓'))->find();
				if(!$journal)
				{
					$this->Manage($trade, $options);
				}
			}
		}

		M()->table('log_cli_temp')->where(array('id' => $logId))->delete();

		unset($tradeIdArr);
}



	public function build_order_no() {
		return date(time()) . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 3);
	}

}