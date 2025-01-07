<?php
namespace Home\Controller;
use Think\Controller;

class TransactionController extends CommonController {


    /**
     * 持仓记录
     * @author wang <990529346@qq.com>
     */
	public function record()
	{

		$this->display();
	}


    /**
     * 获取某个产品持仓的订单
     * @author wang <990529346@qq.com>
     */
    public function position()
    {
    	$data 	= array();

    	if(IS_AJAX)
    	{

    		$optionid = trim(I('post.optionid'));

    		if(!$optionid)
    		{
    			$data['status'] = 0;
    			$data['msg']	= '产品不存在';
    			$this->ajaxReturn($data,'JSON');
    		}

    		$order = M('order')->where('data_now_id='.$optionid.' and uid='.$this->user_id.' and ostaus=0 and (unix_timestamp(finirm_time)-unix_timestamp(now())) >= 1')->select();

    		if($order)
    		{

	    		$Price 	 = M('data_now')->where(array('id' => $order[0]['data_now_id']))->getField('last');

	    		foreach ($order as $key => $value) {

	    			$order[$key]['Price'] = $Price;

	    			if($value['ostyle'] == 0)
	    			{
	    				if($Price > $value['buyprice'])
	    				{
	    					$order[$key]['ploss'] = $value['trade_amount'] * $value['odds'];
	    				} else if($Price == $value['buyprice']){
	    					$order[$key]['ploss'] = 0;
	    				} else {
	    					$order[$key]['ploss'] = -$value['trade_amount'];
	    				}
	    			} else {

	    				if($Price < $value['buyprice'])
	    				{
	    					$order[$key]['ploss'] = $value['trade_amount'] * $value['odds'];
	    				} else if($Price == $value['buyprice']){
	    					$order[$key]['ploss'] = 0;
	    				} else {
	    					$order[$key]['ploss'] = -$value['trade_amount'];
	    				}
	    			}

	    			$order[$key]['ostyles'] = $value['ostyle'] == 0 ? '看涨' : '看跌';

	    			$order[$key]['buytime'] = date('Y-m-d H:i:s',$value['buytime']);

					$time = strtotime($value['finirm_time']) - time();
					$order[$key]['selltime'] = $time <= 0 ? 0 : $time;
	    		}

    			$data['status'] = 1;
    			$data['msg']	= $order;
    			$this->ajaxReturn($data,'JSON');

    		} else {

    			$data['status'] = 0;
    			$data['msg']	= '没有持仓的订单';
    			$this->ajaxReturn($data,'JSON');
    		}

    	} else {

    		$data['status'] = 0;
    		$data['msg'] 	= '非法操作';
    		$this->ajaxReturn($data,'JSON');
    	}
    }

    /**
     * 获取全部产品持仓的订单
     * @author wang <990529346@qq.com>
     */
    public function allPosition()
    {
    	$data 	= array();

    	if(IS_AJAX)
    	{

    		$order = M('order')->where('uid='.$this->user_id.' and ostaus=0 and (unix_timestamp(finirm_time)-unix_timestamp(now())) >= 1')->order('oid desc')->select();

    		if($order)
    		{

    			$optionArr = array();
    			foreach ($order as $key => $value) {
    				
    				array_push($optionArr, $value['data_now_id']);
    			}
    			$data_now_id = implode(',',array_unique($optionArr));


	    		$data_now 	 = M('data_now')->field('id,last,code')->where('id in ('.$data_now_id.')')->select();

	    		foreach ($data_now as $key => $value) {
	    			
	    			$dataArr[$value['id']] = $value;
	    		}

	    		foreach ($order as $key => $value) {
	    			
	    			$order[$key]['code']  = $dataArr[$value['data_now_id']]['code'];

	    			$order[$key]['Price'] = $dataArr[$value['data_now_id']]['last'];

	    			if($value['ostyle'] == 0)
	    			{
	    				if($dataArr[$value['data_now_id']]['last'] > $value['buyprice'])
	    				{
	    					$order[$key]['ploss'] = $value['trade_amount'] * $value['odds'];
	    				} else if($dataArr[$value['data_now_id']]['last'] == $value['buyprice']){
	    					$order[$key]['ploss'] = 0;
	    				} else {
	    					$order[$key]['ploss'] = -$value['trade_amount'];
	    				}
	    			} else {

	    				if($dataArr[$value['data_now_id']]['last'] < $value['buyprice'])
	    				{
	    					$order[$key]['ploss'] = $value['trade_amount'] * $value['odds'];
	    				} else if($dataArr[$value['data_now_id']]['last'] == $value['buyprice']){
	    					$order[$key]['ploss'] = 0;
	    				} else {
	    					$order[$key]['ploss'] = -$value['trade_amount'];
	    				}
	    			}

	    			$order[$key]['ostyles'] = $value['ostyle'] == 0 ? '看涨' : '看跌';

	    			$order[$key]['buytime'] = date('Y-m-d H:i:s',$value['buytime']);

					$time = strtotime($value['finirm_time']) - time();
					$order[$key]['selltime'] = $time <= 0 ? 0 : $time;
	    		}

    			$data['status'] = 1;
    			$data['msg']	= $order;
    			$this->ajaxReturn($data,'JSON');

    		} else {

    			$data['status'] = 0;
    			$data['msg']	= '没有持仓的订单';
    			$this->ajaxReturn($data,'JSON');
    		}

    	} else {

    		$data['status'] = 0;
    		$data['msg'] 	= '非法操作';
    		$this->ajaxReturn($data,'JSON');
    	}
    }

    /**
     * 历史记录
     * @author wang <990529346@qq.com>
     */
    public function allRecord()
    {
    	if(IS_AJAX)
    	{

			$p = trim(I('post.p'));
			$p = empty($p) ? 1 : $p;

			$pagecount	= 10;

			$count      = M('order')->where('uid='.$this->user_id.' and ostaus=1')->count();

    		$order = M('order')->where('uid='.$this->user_id.' and ostaus=1')->order('oid desc')->page($p,$pagecount)->select();

    		if($order)
    		{

	    		foreach ($order as $key => $value) {

	    			$order[$key]['ostyles'] = $value['ostyle'] == 0 ? '看涨' : '看跌';

	    			$order[$key]['buytime'] = date('Y-m-d H:i:s',$value['buytime']);
	    		}
	    		

    			$data['status'] = 1;
    			$data['msg']	= $order;
    			$data['count'] 	= ceil($count / $pagecount);
    			$this->ajaxReturn($data,'JSON');

    		} else {

    			$data['status'] = 0;
    			$data['msg']	= '没有历史记录';
    			$this->ajaxReturn($data,'JSON');
    		}

    	} else {
    		$data['status'] = 0;
    		$data['msg'] 	= '非法操作';
    		$this->ajaxReturn($data,'JSON');
    	}
    }



    /**
     * 交易下单
     * @author wang <990529346@qq.com>
     */
    public function intoorder()
    {
    	if(IS_AJAX)
    	{
    		$data = array();

			$trademoney   	= trim(I('post.trademoney'));  		//下单金额
			$tradedirection = trim(I('post.tradedirection')); 	//0涨1跌
			$optionid      	= trim(I('post.optionid'));  		//产品id
			$tradingfinish 	= trim(I('post.tradingfinish')); 	//订单时长

			if(empty($trademoney))
			{
				$data['status'] = 0;
				$data['msg'] 	= '下单金额不能为空';
				$this->ajaxReturn($data,'JSON');
			}

			if(empty($tradedirection))
			{
				$data['status'] = 0;
				$data['msg'] 	= '买涨或跌参数不能为空！';
				$this->ajaxReturn($data,'JSON');
			}

			if(empty($optionid))
			{
				$data['status'] = 0;
				$data['msg'] 	= '产品编号不能为空';
				$this->ajaxReturn($data,'JSON');
			}

			if(empty($tradingfinish))
			{
				$data['status'] = 0;
				$data['msg'] 	= '订单时长不能为空';
				$this->ajaxReturn($data,'JSON');
			}

			$order_type 	= 2;

			$tradedirection = $tradedirection == '买涨' ? 0 : 1;
			$tradingfinish 	= $tradingfinish / 60; 

			$order         	= M("order");
			$userinfo      	= M('userinfo');
			$accountinfo   	= M('accountinfo');
			$option        	= M('option');
			$productinfo   	= M("productinfo");


			//判断该产品是否休市中
			$optioninfo 	= M("data_now")->where(array('id' => $optionid))->find();
			if($optioninfo['flag'] == 0)
			{
				$data['status'] = 0;
				$data['msg'] 	= '该产品当前休市中';
				$this->ajaxReturn($data,'JSON');
			}


			$condition  = array('cid' => $optionid, "minute='$tradingfinish'");
			$oddinfo 	= $productinfo->where($condition)->find();
			if (!$oddinfo) {

				$data['status'] = 0;
				$data['msg'] 	= '找不到该产品和交易时间';
				$this->ajaxReturn($data,'JSON');
			}

			/*判断该规格是否休市中*/
            if(shijian($oddinfo['pid']) == 0)
            {
				$data['status'] = 0;
				$data['msg'] 	= '该产品规格当前休市中';
				$this->ajaxReturn($data,'JSON');
            }

			/*判断该规格产品是否即将休市*/
			$selltime = shijian($oddinfo['pid']);

            if(($selltime-time()) < ($tradingfinish * 60))
            {
				$data['status'] = 0;
				$data['msg'] 	= '你购买的'.($tradingfinish * 60).'s即将休市';
				$this->ajaxReturn($data,'JSON');
            }


		   //判断用户冻结状态
		  	$user = $userinfo->where(array('uid' => $this->user_id))->find();
		  	if ($user['status'] == 1)
		  	{
				$data['status'] = 0;
				$data['msg'] 	= '账号交易功能被冻结';
				$this->ajaxReturn($data,'JSON');
	      	}


			//下单金额限制
			$config = M('webconfig')->where(array('id' => 1))->find();
			$arr 	= $config['limit'];
			$arr 	= explode('|', $arr);

			if ($trademoney < $arr[0]) {

				$data['status'] = 0;
				$data['msg'] 	= '下单金额不能小于'.$arr[0].'';
				$this->ajaxReturn($data,'JSON');
			}
			if ($trademoney > $arr[1]) {

				$data['status'] = 0;
				$data['msg'] 	= '下单金额不能大于'.$arr[1].'';
				$this->ajaxReturn($data,'JSON');
			}

			//交易手续费
			$feeprice = $trademoney * ($oddinfo['feeprice'] / 100);


			//判断当前的持仓数
			$condition2 = array('data_now_id' => $optionid, 'uid' => $this->user_id, 'is_settle' => 0, "minute='$tradingfinish'");
			$trades 	= $order->where($condition2)->count();

			if ($trades >= $oddinfo['maxhands']) {

				$data['status'] = 0;
				$data['msg'] 	= '最大持仓'.$oddinfo['maxhands'].'单';
				$this->ajaxReturn($data,'JSON');
			}


            /*会员单位阈值*/
            $balance  = $accountinfo->where(array('uid' => $user['unit_id']))->getField('balance');

            if(!$balance)
            {
   				$data['status'] = 0;
				$data['msg'] 	= '会员单位不存在';
				$this->ajaxReturn($data,'JSON');
            }

    //         if($balance <= C('UNIT_BALANCE'))
    //         {
   	// 			$data['status'] = 0;
				// $data['msg'] 	= '会员单位资金不足';
				// $this->ajaxReturn($data,'JSON');
    //         }

			$usermoney 	= $accountinfo->where(array('uid' => $this->user_id))->getField('balance');

			$pay 		= ($trademoney + $feeprice);

			if ($pay > $usermoney) {
			
   				$data['status'] = 0;
				$data['msg'] 	= '资金不够';
				$this->ajaxReturn($data,'JSON');
			}

			$changmoney 	= $accountinfo->where(array('uid' => $this->user_id))->setDec('balance', $pay);

			$remarks 		= $oddinfo['protle'] . "-" . $tradingfinish . "M";

			$data['buyprice'] 		= $optioninfo['last']; //下单点位
			$data['trade_amount'] 	= $trademoney; 			//交易金额
			$data['uid'] 			= $this->user_id;
			$data['fee'] 			= $feeprice;
			$data['ostyle'] 		= $tradedirection;
			$data['order_type'] 	= $order_type;
			$data['data_now_id'] 	= $optionid;
			$data['buytime'] 		= time();
			$data['ostaus'] 		= 0;
			$data['selltime'] 		= "";
			$data['orderno'] 		= time() . $this->user_id;
			$data['trade_time'] 	= date('Y-m-d H:i:s'); //  下单时间
			$data['finirm_time'] 	= date('Y-m-d H:i:s', time() + ($tradingfinish * 60)); //下单到期时间
			$data['odds'] 			= $oddinfo['odds'];
			$data['ptitle'] 		= $remarks;
			$data['minute'] 		= $tradingfinish;
			$data['is_settle'] 		= 0;

			if ($changmoney) 
			{
				$orderid = $order->add($data);

				if ($orderid) {
					$journal['jno'] 		= $this->build_order_no(); 	//订单号
					$journal['uid'] 		= $this->user_id; 					//用户id
					$journal['jtype'] 		= '建仓'; 					//类型
					$journal['jtime'] 		= date(time()); 			//操作时间
					$journal['jincome'] 	= $pay; 					//收支金额【要予以删除】
					$journal['remarks'] 	= $remarks; 				//产品名称
					$journal['balance'] 	= ($usermoney-$pay); 		//账户余额
					$journal['jstate'] 		= 0; 						//盈利还是亏损
					$journal['jusername'] 	= $user['username']; 		//用户名
					$journal['jostyle'] 	= $data['ostyle']; 			//涨、跌
					$journal['jfee'] 		= 0; 						//手续费
					$journal['jbuyprice'] 	= $data['buyprice']; 		//入仓价
					$journal['jaccess'] 	= $pay * (-1); 				//支持金额，求负数
					$journal['oid'] 		= $orderid; 				//改订单流水的订单id

					M('journal')->add($journal);

					$order->where('oid=' . $orderid)->setField('commission', $journal['balance']);

					/*用户资金流水*/
                    money_flow($this->user_id,1,0,$pay,'用户购买'.$remarks.'扣除['.$pay.']元',$orderid);
                    /*用户资金流水*/
				}

   				$data['status'] = 1;
				$data['msg'] 	= '下单成功';
				$this->ajaxReturn($data,'JSON');

			} else { 
			
   				$data['status'] = 0;
				$data['msg'] 	= '下单失败';
				$this->ajaxReturn($data,'JSON');
			}
    	}
    }

    /**
     * 生成订单号
     * @author wang <990529346@qq.com>
     */
	public function build_order_no() {

		return date(time()) . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 3);
	}
}
