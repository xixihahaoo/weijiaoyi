<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class TradeController extends CommonController{

    /**
     * @functionname: tradelist
     * @author: FrankHong
     * @date: 2017-05-16 11:14:37
     * @description: updated by frank
     * @note:
     */
    public function tradelist()
    {
		$userinfo   = M('userinfo');
    	$order      = M('order');
		$journal    = D('journal');
		$otype      = ['5'=>'operate_id', '2'=>'unit_id', '4'=>'leaguer_id', '1'=>'agent_id'];
		$subordinate_dis    = ['5' => array(1, 1, 1),'2' => array(1, 1),'4' => array(1)];
		$subordinate_all    = array();
		$sumploss   = 0;
		
		//获取下级单位
		$subordinate_list   = $this->get_subordinate($_SESSION);
		$customer_where[$otype[$_SESSION['userotype']]] = array('eq',$_SESSION['cuid']);


		//前台的查询条件
		if($_GET['starttime'] && $_GET['endtime'])
        {
			$star_date  = strtotime($_GET['starttime']);
		    $end_date   = strtotime($_GET['endtime']);
			$journal_where['journal.jtime'] = array('between', array($star_date, $end_date));
		}
        else if($_GET['starttime'])
        {
			$star_date  = strtotime($_GET['starttime']);
			$journal_where['journal.jtime'] = array('between', array($star_date,time()));
		}
        else if($_GET['endtime'])
        {
		    $end_date   = strtotime($_GET['endtime']);
			$journal_where['journal.jtime'] = array('between', array(0,$end_date));
		}
        else
        {
			$_GET["starttime"]  = date('Y-m-d').' 00:00:00';
			$_GET["endtime"]    = date('Y-m-d').' 23:59:59';
			$star_date          = strtotime($_GET["starttime"]);
			$end_date           = strtotime($_GET["endtime"]);
			$journal_where['journal.jtime'] = array('between', array($star_date,$end_date));
		}


		if($_GET['utel'])
        {
			$journal_where['user1.utel']    = array('like', '%'.$_GET["utel"].'%');
		}

		if($_GET['uid'])
        {
			$journal_where['user1.uid']     = array('eq', $_GET["uid"]);
			if(count($_GET) == 1)
			{
				$user_list  = $userinfo->where("uid={$_GET['uid']}")->field('uid as cuid,otype as userotype,username,unit_id,leaguer_id,agent_id')->find();
				header("location: ".$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."&unit_id={$user_list['unit_id']}&leaguer_id={$user_list['leaguer_id']}&agent_id={$user_list['agent_id']}");
			}
		}


		if($_GET['ostaus'])
        {
			$journal_where['journal.jtype'] = array('eq', $_GET["ostaus"]);
		}

		if($_GET['unit_id'])
		{
			$customer_where     = array();
			$user_list          = $userinfo->where("uid={$_GET['unit_id']}")->field('uid as cuid,otype as userotype,username')->find();
			$customer_where[$otype[$user_list['userotype']]]    = array('eq', $user_list['cuid']);
			$subordinates       = $this->get_subordinate($user_list);
			$subordinate_all['leaguer_id']                      = $subordinates;
		}

		if($_GET['leaguer_id'])
		{
            $customer_where     = array();
			$user_list          = $userinfo->where("uid={$_GET['leaguer_id']}")->field('uid as cuid,otype as userotype,username')->find();
			$customer_where[$otype[$user_list['userotype']]]    = array('eq',$user_list['cuid']);
			$subordinates = $this->get_subordinate($user_list);
			$subordinate_all['agent_id']                        = $subordinates;
		}

		if($_GET['agent_id'])
		{
			$customer_where     = array();
			$user_list          = $userinfo->where("uid={$_GET['agent_id']}")->field('uid as cuid,otype as userotype,username')->find();
			$customer_where[$otype[$user_list['userotype']]]    = array('eq',$user_list['cuid']);
		}

		if(count($subordinate_all) && $_SESSION['userotype'] == 1)
		{
			$subordinate_list   = array();
		}


		//获取下级所有用户信息
		$customer_where['otype']    = array('eq',0);
		$customer   = $userinfo->distinct(true)->field('uid')->where($customer_where)->select();
		foreach($customer as $row_customer)
		{
			$customer_uid[] = $row_customer['uid'];
		}
		$journal_where['journal.uid']       = array('in',$customer_uid);
		$journal_where['journal.jtype']     = array('eq','平仓');
        $journal_where['journal.th_uid']    = array('exp','is null');



		$sumbuymoney    = $order->where("is_settle=1")->sum('trade_amount');
		$count = $journal->where($journal_where)->field('count(*) as count,sum(orders.trade_amount) as jaccess,sum(jploss) as jploss, sum(orders.fee) as total_fee')->table('wp_journal journal')
		->join("join wp_userinfo user1 on user1.uid = journal.uid")
		->join("join wp_order orders on journal.oid = orders.oid")
		->find();

//        Vd($count);
//        die();
		$page =	new \Think\Page($count['count'],15); 
		$order_list = $journal->where($journal_where)->field("journal.*,user1.username,user1.utel,user1.oid as pid,orders.fee,orders.trade_amount,orders.buytime,orders.selltime,(case orders.is_win when 0 then '亏损' when 1 then '盈利' else '平局' end) as is_win")->table('wp_journal journal')
		->join("join wp_userinfo user1 on user1.uid = journal.uid")
		->join("join wp_order orders on journal.oid = orders.oid")
		->join("join wp_userinfo user2 on user1.leaguer_id = user2.uid")
		->order('journal.jtime desc')
		->limit($page->firstRow.','.$page->listRows)
		->select();
//print_r($order_list);exit;
//        $order_list = $journal->where($journal_where)->field("journal.*,user1.username,user1.utel,user2.username as managername,orders.fee,orders.trade_amount,orders.buytime,orders.selltime,(case orders.is_win when 0 then '亏损' when 1 then '盈利' else '平局' end) as is_win")->table('wp_journal journal')
//            ->join("join wp_userinfo user1 on user1.uid = journal.uid")
//            ->join("join wp_order orders on journal.oid = orders.oid")
//            ->join("join wp_userinfo user2 on user1.agent_id = user2.uid")
//            ->order('journal.jtime desc')
//            ->select();
	
		foreach($order_list as $key => $order_info)
		{
			if($order_info['jtype'] == '平仓')
			{
				$order_list[$key]['managername'] = $userinfo->where("uid=" . $order_info['pid'])->getField('username');//上级用户名
				$order_amount = $order_info['trade_amount']+$order_info['fee'];
				$trade_amount += $order_amount;
				$sumfee += $order_info['fee'];
			}
		}
		
		$journal_where = array();
		$journal_where['uid'] = array('in',$customer_uid);
		$rebate = M("agent")->where($journal_where)->sum("add_money");
		
		$journal_where['is_settle'] = array('eq',0);
		$unliquidated_order = $order->field('sum(trade_amount) as sumbuymoney,sum(fee) as sumfee,count(*) as count')->where($journal_where)->find();
		$journal_where['is_settle'] = array('eq',1);
		$settlement_order = $order->field('sum(trade_amount) as sumbuymoney,sum(fee) as sumfee,count(*) as count')->where($journal_where)->find();
		//$trade_amount = $count['jaccess'];
		//$sumfee = $unliquidated_order['sumfee'] + $settlement_order['sumfee'];
		$total_jc = count($order_list);
		$page = $page->show();
		//dump($subordinate_list);
		//exit;


        //vD($order_list);
        foreach($order_list as $k => $v)
        {
            //echo date('Y-m-d H:i:s', $v['jtime']);
        }
//print_r($order_list);exit;
		$this->assign("subordinate_all",$subordinate_all);
		$this->assign("subordinate_list",$subordinate_list);
		$this->assign("subordinate_dis",$subordinate_dis[$_SESSION['userotype']]);
		$this->assign("order_list",$order_list);
		$this->assign("trade_amount",$count['jaccess']);
		$this->assign("sumploss",$this->inverse($count['jploss']));
		$this->assign("rebate",$rebate);
		$this->assign("unliquidated_order",$unliquidated_order);
		$this->assign("settlement_order",$settlement_order);
		$this->assign("sumbuymoney",$sumbuymoney+$sumfee);
		//$this->assign("sumfee",$sumfee);
        $this->assign("sumfee",$count['total_fee']);
		//$this->assign("total_jc",$total_jc);
        $this->assign("total_jc",$count['count']);
		$this->assign("page",$page);
		$this->display();
	}


    /**
     * 由特会接管的订单
     * @author  wang <[email address]>
     */
    public function special()
    {
        $userinfo = M('userinfo');
        $order = M('order');
        $journal = D('journal');
        $otype = ['5'=>'operate_id','2'=>'unit_id','4'=>'leaguer_id','1'=>'agent_id'];
        $subordinate_dis = ['5'=>array(1,1,1),'2'=>array(1,1),'4'=>array(1)];
        $subordinate_all = array();
        $sumploss = 0;

        //获取下级单位
        $subordinate_list = $this->get_subordinate($_SESSION);
        $customer_where[$otype[$_SESSION['userotype']]] = array('eq',$_SESSION['cuid']);

        //查询条件
        if($_GET['starttime'] && $_GET['endtime']){
            $star_date = strtotime($_GET['starttime']);
            $end_date = strtotime($_GET['endtime']);
            $journal_where['journal.jtime'] = array('between',array($star_date,$end_date));
        }else if($_GET['starttime']){
            $star_date = strtotime($_GET['starttime']);
            $journal_where['journal.jtime'] = array('between',array($star_date,time()));
        }else if($_GET['endtime']){
            $end_date = strtotime($_GET['endtime']);
            $journal_where['journal.jtime'] = array('between',array(0,$end_date));
        }
        if($_GET['jusername']){
            $journal_where['journal.jusername'] = array('like','%'.$_GET["jusername"].'%');
        }
        if($_GET['ostaus']){
            $journal_where['journal.jtype'] = array('eq',$_GET["ostaus"]);
        }
        if($_GET['unit_id'])
        {
            $customer_where = array();
            $user_list = $userinfo->where("uid={$_GET['unit_id']}")->field('uid as cuid,otype as userotype,username')->find();
            $customer_where[$otype[$user_list['userotype']]] = array('eq',$user_list['cuid']);
            $subordinates = $this->get_subordinate($user_list);
            $subordinate_all['leaguer_id'] = $subordinates;
        }
        if($_GET['leaguer_id'])
        {
            $customer_where = array();
            $user_list = $userinfo->where("uid={$_GET['leaguer_id']}")->field('uid as cuid,otype as userotype,username')->find();
            $customer_where[$otype[$user_list['userotype']]] = array('eq',$user_list['cuid']);
            $subordinates = $this->get_subordinate($user_list);
            $subordinate_all['agent_id'] = $subordinates;
        }
        if($_GET['agent_id'])
        {
            $customer_where = array();
            $user_list = $userinfo->where("uid={$_GET['agent_id']}")->field('uid as cuid,otype as userotype,username,unit_id,leaguer_id')->find();
            $customer_where[$otype[$user_list['userotype']]] = array('eq',$user_list['cuid']);
            if(count($_GET) == 1)
            {
                header("location: ".$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."&unit_id={$user_list['unit_id']}&leaguer_id={$user_list['leaguer_id']}");
            }
        }
        //获取下级所有用户信息
        $customer_where['otype'] = array('eq',0);

        $customer = $userinfo->distinct(true)->field('uid')->where($customer_where)->select();
        foreach($customer as $row_customer)
        {
            $customer_uid[] = $row_customer['uid'];
        }
        $journal_where['journal.uid']    = array('in',$customer_uid);
        $journal_where['journal.jtype']  = array('eq','平仓');
        $journal_where['journal.th_uid'] = array('exp','is not null');

        $sumbuymoney = $order->where("is_settle=1")->sum('trade_amount');
        $count = $journal->where($journal_where)->field('count(*) as count,sum(orders.trade_amount) as jaccess, sum(orders.fee) as fee,sum(jploss) as jploss')->table('wp_journal journal')
        ->join("join wp_userinfo user1 on user1.uid = journal.uid")
        ->join("join wp_order orders on journal.oid = orders.oid")
        ->find();

        $page = new \Think\Page($count['count'],15);
        $order_list = $journal->where($journal_where)->field('journal.*,user1.username,user1.utel,user2.username as managername,orders.fee,orders.trade_amount,orders.trade_time,orders.settle_time,user3.username as special_name')->table('wp_journal journal')
        ->join("join wp_userinfo user1 on user1.uid = journal.uid")
        ->join("join wp_order orders on journal.oid = orders.oid")
        ->join("join wp_userinfo user2 on user1.leaguer_id = user2.uid")
        ->join("left join wp_userinfo user3 on journal.th_uid = user3.uid")
        ->order('journal.jtime desc')
        ->limit($page->firstRow.','.$page->listRows)
        ->select();



        foreach($order_list as $key => $order_info)
        {
            if($order_info['jtype'] == '平仓')
            {
                $order_amount = $order_info['trade_amount']+$order_info['fee'];
                $trade_amount += $order_amount;


                if($order_info['jstate'] == 1)
                {
                	$order_list[$key]['is_win'] = '盈利';

                } else if($order_info['jstate'] == 2)
                {
                	$order_list[$key]['is_win'] = '平局';
                } else {

                	$order_list[$key]['is_win'] = '亏损';
                }


            }
        }
        $journal_where = array();
        $journal_where['uid'] = array('in',$customer_uid);
        $rebate = M("agent")->where($journal_where)->sum("add_money");

        $journal_where['is_settle'] = array('eq',0);
        $unliquidated_order = $order->field('sum(trade_amount) as sumbuymoney,sum(fee) as sumfee,count(*) as count')->where($journal_where)->find();
        $journal_where['is_settle'] = array('eq',1);
        $settlement_order = $order->field('sum(trade_amount) as sumbuymoney,sum(fee) as sumfee,count(*) as count')->where($journal_where)->find();
        $trade_amount = $count['jaccess']+ $count['fee'];
        $sumfee = $unliquidated_order['sumfee'] + $settlement_order['sumfee'];
        $total_jc = $unliquidated_order['count'] + $settlement_order['count'];
        $page = $page->show();

        //------- Frank

        $this->assign("subordinate_all",$subordinate_all);
        $this->assign("subordinate_list",$subordinate_list);
        $this->assign("subordinate_dis",$subordinate_dis[$_SESSION['userotype']]);
        $this->assign("order_list",$order_list);
        $this->assign("trade_amount",$trade_amount);
        $this->assign("sumploss",$count['jploss']);
        $this->assign("rebate",$rebate);
        $this->assign("unliquidated_order",$unliquidated_order);
        $this->assign("settlement_order",$settlement_order);
        $this->assign("sumbuymoney",$sumbuymoney+$sumfee);
        //$this->assign("sumfee",$sumfee);
        //$this->assign("total_jc",$total_jc);
        $this->assign("total_jc",$count['count']);
        $this->assign("sumfee",$count['fee']);
        $this->assign("page",$page);
        $this->display();
    }




	
	public function inverse($number)
	{
		if($number > 0)
		{
			return array('amount' => (0 - $number), 'style' => 'color:#81bd82;');
		}
		else
		{
			return array('amount' => abs($number), 'style' => 'color:red;');
		}
	}
	
	public function get_subordinate($data,$type=1)
	{
		$userinfo = M('userinfo');
		$otype = [5,2,4,1];
		$key = array_search($data['userotype'], $otype);
		$user_where['oid'] = array('eq',$data['cuid']);
		$user_where['otype'] = array('eq',$otype[$key+1]);
		$user_list = $userinfo->where($user_where)->select();
		if($type)
		{
			return $user_list;
		}
		else
		{
			echo json_encode($user_list);
		}
	}
	/*public function tradelist()
    {
    	$tq=C('DB_PREFIX');
    	$userinfo=M('userinfo');
    	$order = M('order');
		$journal = D('journal');
    	//默认查询全部
		// $otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->getField("otype");
		$otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->find();


//        vD($otype);
//        die();
		// var_dump($otype['otype']);die;
		if($otype['otype'] == 2)
		{
			$t = 4;
		}else if($otype['otype'] == 4)
		{
			$t = 1;
		}else if($otype['otype'] == 1)
		{
			$t = 0;
		}
		//过滤搜索
		// $huilist = $userinfo->where("otype = ".$t)->select();
		$huilist = $userinfo->where("otype = ".$t." and oid=".$otype['uid'])->select();
		$this->assign("huilist",$huilist);
		$where = "";
		//获取用户名，生产模糊条件
		$username = $_GET['jusername'];
		//获取订单时间
		$starttime = I('get.starttime','');
		$endtime = I('get.endtime','');
		if($starttime || $endtime){
			if(!$endtime){
				$endtime = date('Y-m-d',time()+86400);
			}
			$where['jtime'] = array('between', array(strtotime($starttime), strtotime($endtime)));
			$sea['starttime'] = $starttime;//$_GET["starttime"];
			$sea['endtime'] = $endtime;//$_GET["endtime"];
		}

		//获取订单状态
		$ostaus = $_GET['ostaus'];
		$oid = $_GET['oid'];
		if($oid)
		{
			// $oids = getDownuids($oid);
		 //    $oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
			// foreach ($oids as $key => $value) {
			// 	 $oids2[]=$value['uid'];
			// }
			// $where['uid'] = array("in",implode(',',$oids2));
				$otype2=M("userinfo")->field("otype")->where("uid=".$oid )->find();

			// $oids = getDownuids($oid);
			// $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
			if($otype2['otype'] == 2){
				$oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
			}
			if($otype2['otype'] == 4){

				$oids=M("userinfo")->field("uid")->where("leaguer_id=".$oid)->select();
			}	
			if($otype2['otype'] == 1){

				$oids=M("userinfo")->field("uid")->where("agent_id=".$oid)->select();
			}	
           if($otype2['otype'] == 5){
			  $oids=M("userinfo")->field("uid")->where("operate_id=".$_SESSION['cuid'])->select();
		   }				
	    	foreach ($oids as $key => $value) {
				 $oids2[]=$value['uid'];
			}
			$where['uid']  = array("in",implode(',',$oids2));

  
			// $where['uid'] = array("in",implode(',',$oids));
			
			$sea['oid'] = $oid;
		}else{
			// $oids = getDownuids($_SESSION['cuid']);
			// $info=M("userinfo")->field("uid")->where("unit_id=".$_SESSION['cuid'])->select();
			// foreach ($info as $key => $value) {
			// 	$oids2[]=$value['uid'];
			// }
			// $oids3=array_merge($oids,$oids2);
			//  $oids4=array_unique($oids3);
		if($otype['otype'] == 2){
			$oids=M("userinfo")->field("uid")->where("unit_id=".$_SESSION['cuid'])->select();
		}
		if($otype['otype'] == 4){
			$oids=M("userinfo")->field("uid")->where("leaguer_id=".$_SESSION['cuid'])->select();
		}	
		if($otype['otype'] == 1){
			$oids=M("userinfo")->field("uid")->where("agent_id=".$_SESSION['cuid'])->select();
		}
       if($otype['otype'] == 5){
			$oids=M("userinfo")->field("uid")->where("operate_id=".$_SESSION['cuid'])->select();
		}			
	
			foreach ($oids as $key => $value) {
				 $oids2[]=$value['uid'];
			}
			$where['uid'] = array("in",implode(',',$oids2));

			// $where['uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}
		if($username){
			$where['jusername'] = array('like','%'.$_GET["jusername"].'%');
			$sea['jusername'] = $_GET["jusername"];
		}

		if($ostaus!=""){
			if($ostaus == '4')
			{
				$where['jtype'] = '建仓';
				$sea['ostaus'] = 4;
			}
			if($ostaus == '1')
			{
				$where['jtype'] = '平仓';
				$sea['ostaus'] = 1;				
			}
			// if($ostaus == '2')
			// {
			// 	$where['jtype'] = '爆仓';
			// 	$sea['ostaus'] = 2;
			// }
			// if($ostaus == '3')
			// {
			// 	$where['jtype'] = '隔夜利息扣除';
			// 	$sea['ostaus'] = 3;
			// }
			// if($ostaus == '5')
			// {
			// 	$where['jtype'] = '止盈';
			// 	$sea['ostaus'] = 5;
			// }
			// if($ostaus == '6')
			// {
			// 	$where['jtype'] = '止损';
			// 	$sea['ostaus'] = 6;
			// }
		}
		$this->assign("sea",$sea);
		$count = $journal->order('jtime desc')->where($where)->count();				
		$pagecount = 20;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$start = $page->firstRow;
		$end = $page->listRows;
		
		$tlist = $journal->order('jtime desc')->limit($start,$end)->where($where)->select();
		//echo M("")->getlastsql();exit;
		foreach($tlist as $key=>$val)
		{
			$ooid = M("userinfo")->where("uid=".$val['uid'])->getField('oid');
			$tlist[$key]['oid']=M("userinfo")->where("uid=".$ooid)->getField('username');	
			$tlist[$key]['count'] = $journal->where('oid='.$val['oid'])->count();	
		}
		// $hlist = $journal->order('jtime desc')->where($where)->select();
		// var_dump($hlist);die;
	    $hlist = M("order")->order('buytime desc')->where($where)->select();
  $rebate=M("agent")->where($where)->sum("add_money");
  
 $total_cc=0;
 $total_pc=0;
		foreach($hlist as $key=>$val)
		{
			// $sums = $val['juprice']*$val['number'];
			// $sums = $val['trade_amount']+2;
			// $sumbuymoney+=$sums;
			// $sumploss += $val['profit'];
			// $sumfee += $val['jfee'];
		    $sums = $val['trade_amount']*1.02;             //xxxxxxxxxxxxxxx
			$sumbuymoney+=$sums;
			$sumploss += $val['profit'];
			$sumfee += $val['fee'];
				if($hlist[$key]['is_settle']==0){
				$total_cc+=1;
			}
			if($hlist[$key]['is_settle']==1){
				$total_pc+=1;
			}
			$total_jc=$key+1;
		}
		
		// var_dump($tlist);die;
		$show = $page->show();	
	$this->assign('sumbuymoney',$sumbuymoney);
		$this->assign('sumploss',$sumploss*(-1));
		$this->assign('sumfee',$sumfee);
		$this->assign('tlistcount',$tlistcount);
		$this->assign('ordlist',$tlist);
		$this->assign('show',$show);
		$this->assign('total_cc',$total_cc);
		$this->assign('total_pc',$total_pc);
		$this->assign('total_jc',$total_jc);
		$this->assign('rebate',$rebate);
		$this->assign('t',$t);
		  $myuid=$_SESSION['cuid'];
          $otype = M("userinfo")->where("uid = " . $myuid)->getField("otype");
       	if($otype==1){
 			$is_agent=1;
 			$this->assign("is_agent",$is_agent);	
 		}
 
		$this->display();
    }*/
	public function daochu()
    {
    	$tq=C('DB_PREFIX');
    	$userinfo=M('userinfo');
    	$order = M('order');
		$journal = D('journal');
    	//默认查询全部
		$otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->find();
		if($otype['otype'] == 2)
		{
			$t = 4;
		}else if($otype['otype'] == 4)
		{
			$t = 1;
		}else if($otype['otype'] == 1)
		{
			$t = 0;
		}
		//过滤搜索
		$huilist = $userinfo->where("otype = ".$t." and oid=".$otype['uid'])->select();
		$this->assign("huilist",$huilist);
		$where = "";
		//获取用户名，生产模糊条件
		$username = $_GET['jusername'];
		//获取订单时间
		$starttime = date('Y-m-d',strtotime($_GET["starttime"]));
		$endtime = date('Y-m-d',strtotime($_GET["endtime"]));
		//获取订单状态
		$ostaus = $_GET['ostaus'];
		$oid = $_GET['oid'];
	if($oid)
		{
			// $oids = getDownuids($oid);
		 //    $oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
			// foreach ($oids as $key => $value) {
			// 	 $oids2[]=$value['uid'];
			// }
			// $where['uid'] = array("in",implode(',',$oids2));
				$otype2=M("userinfo")->field("otype")->where("uid=".$oid )->find();

			// $oids = getDownuids($oid);
			// $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
			if($otype2['otype'] == 2){
				$oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
			}
			if($otype2['otype'] == 4){

				$oids=M("userinfo")->field("uid")->where("leaguer_id=".$oid)->select();
			}	
			if($otype2['otype'] == 1){

				$oids=M("userinfo")->field("uid")->where("agent_id=".$oid)->select();
			}		
	    	foreach ($oids as $key => $value) {
				 $oids2[]=$value['uid'];
			}
			$where['uid']  = array("in",implode(',',$oids2));

  
			// $where['uid'] = array("in",implode(',',$oids));
			
			$sea['oid'] = $oid;
		}else{
			// $oids = getDownuids($_SESSION['cuid']);
			// $info=M("userinfo")->field("uid")->where("unit_id=".$_SESSION['cuid'])->select();
			// foreach ($info as $key => $value) {
			// 	$oids2[]=$value['uid'];
			// }
			// $oids3=array_merge($oids,$oids2);
			//  $oids4=array_unique($oids3);
		if($otype['otype'] == 2){
			$oids=M("userinfo")->field("uid")->where("unit_id=".$_SESSION['cuid'])->select();
		}
		if($otype['otype'] == 4){
			$oids=M("userinfo")->field("uid")->where("leaguer_id=".$_SESSION['cuid'])->select();
		}	
		if($otype['otype'] == 1){
			$oids=M("userinfo")->field("uid")->where("agent_id=".$_SESSION['cuid'])->select();
		}		 

			foreach ($oids as $key => $value) {
				 $oids2[]=$value['uid'];
			}
			$where['uid'] = array("in",implode(',',$oids2));

			// $where['uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}
		if($username){
			$where['jusername'] = array('like','%'.$_GET["jusername"].'%');
			$sea['jusername'] = $_GET["jusername"];
		}
		if($_GET["starttime"] && $_GET["endtime"]){
			$starttime = strtotime($starttime." 00:00:00");
			$endtime = strtotime($endtime." 23:59:59");
			$where['jtime'] = array('between',array($starttime,$endtime));
			$sea['starttime'] = $_GET["starttime"];
			$sea['endtime'] = $_GET["endtime"];
		}
		if($ostaus!=""){
			if($ostaus == '4')
			{
				$where['jtype'] = '建仓';
				$sea['ostaus'] = 4;
			}
			if($ostaus == '1')
			{
				$where['jtype'] = '平仓';
				$sea['ostaus'] = 1;				
			}
			if($ostaus == '2')
			{
				$where['jtype'] = '爆仓';
				$sea['ostaus'] = 2;
			}
			if($ostaus == '3')
			{
				$where['jtype'] = '隔夜利息扣除';
				$sea['ostaus'] = 3;
			}
		}
		$tlist = $journal->order('jtime desc')->where($where)->select();

			$data[0] = array(
			'编号','用户','操作时间','产品','交易类型','状态','金额','手续费','入仓价','平仓价',"盈亏"
		);
		foreach($tlist as $key=>$val)
		{
			$data[$key+1][] = $val['jno'];
			$data[$key+1][] = $val['jusername'];
		 	$data[$key+1][] = date("Y-m-d H:i:s",$val['jtime']);
		 	$data[$key+1][] = $val['remarks'];
			// $ooid = M("userinfo")->where("uid=".$val['uid'])->getField('oid');
			// $data[$key+1][]=M("userinfo")->where("uid=".$ooid)->getField('username');
			$data[$key+1][] = $val['jtype'];
				if($val['jostyle'] == 1)
			{
				$data[$key+1][] = "买跌";
			}else{
				$data[$key+1][] = "买涨";
			}
		 
			$data[$key+1][] = $val['jaccess'];
	 
	
			$data[$key+1][] = $val['jfee'];
			$data[$key+1][] = $val['jbuyprice'];
			$data[$key+1][] = $val['jsellprice'];
	 
			$data[$key+1][] = $val['jploss'];
		 
		}
		$name='Excelfile';  //生成的Excel文件文件名
		$res=$this->push($data,$name);
	}
	public function push($data,$name){
		import("Excel.class.php");
		$excel = new Excel();
		$excel->download($data,$name);
	}
	public function recharge(){
		//读出提现和充值列表
		$balance = D('balance');
		$tq=C('DB_PREFIX');
		$user = M("userinfo");
		$otype1 = ['5'=>'operate_id','2'=>'unit_id','4'=>'leaguer_id','1'=>'agent_id'];
		$otype2 = [5,2,4,1];
		$key = array_search($_SESSION['userotype'], $otype2);
		//查询多条记录
       	$field = $tq.'userinfo.username as username,'.$tq.'userinfo.unit_id as unit_id,'.$tq.'userinfo.leaguer_id as leaguer_id,'.$tq.'userinfo.agent_id as agent_id,'.$tq.'balance.uid as uid,'.$tq.'balance.bpid as bpid,'.$tq.'balance.bptype as bptype,'.$tq.'balance.bptime as bptime,'.$tq.'balance.bpprice as bpprice,'.$tq.'balance.remarks as remarks,'.$tq.'balance.isverified as isverified,'.$tq.'accountinfo.balance as balance,'.$tq.'balance.cltime as cltime,'.$tq.'userinfo.utel,dict_pay_type.pay_name';
		$otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->find();
		//var_dump($otype['otype']);die;
		if($otype['otype'] == 2)
		{
			$t = 4;
		}else if($otype['otype'] == 4)
		{
			$t = 1;
		}else if($otype['otype'] == 1)
		{
			$t = 0;
		}else{
			$t = $otype['otype'];
		}
		//过滤搜索
		$huilist_where[$otype1[$_SESSION['userotype']]] = array('eq',$_SESSION['cuid']);
		$huilist_where['otype'] = array('eq',$otype2[$key+1]);
		$huilist = M("userinfo")->where($huilist_where)->select();

		$this->assign("huilist",$huilist);
		$where = "";
		//获取用户名，生产模糊条件
		$username = $_GET['username'];
		//获取订单时间
		$starttime = I('get.starttime',0);//date('Y-m-d',strtotime($_GET["starttime"]));
		$endtime = I('get.endtime',0); //date('Y-m-d',strtotime($_GET["endtime"]));
		//获取订单类型
		$type = $_GET['type'];
		//获取订单盈亏
		$ploss = $_GET['ploss'];
		//获取订单状态
		$ostaus = $_GET['ostaus'];
		$oid = $_GET['oid'];
		if($oid)
		{
			$oids = $this->getuid($oid,0);
			$where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}else{
			$oids =$this->getuid($_SESSION['cuid'],0);
			
			$where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}
		if($username){
			$where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
			$sea['username'] = $_GET["username"];
		}
		
		if($_GET['starttime'] && $_GET['endtime']){	
			$star_date = strtotime($_GET['starttime']);
		    $end_date = strtotime($_GET['endtime']);
			$where[$tq.'balance.bptime'] = array('between',array($star_date,$end_date));
		}else if($_GET['starttime']){
			$star_date = strtotime($_GET['starttime']);
			$where[$tq.'balance.bptime'] = array('between',array($star_date,time()));	
		}else if($_GET['endtime']){
		    $end_date = strtotime($_GET['endtime']);			
			$where[$tq.'balance.bptime'] = array('between',array(0,$end_date));		
		}
		else
		{
			$_GET["starttime"] = date('Y-m-d').' 00:00:00';
			$_GET["endtime"] = date('Y-m-d').' 23:59:59';
			$star_date = strtotime($_GET["starttime"]);
			$end_date = strtotime($_GET["endtime"]);
			$where[$tq.'balance.bptime'] = array('between',array($star_date,$end_date));
		}
		$sea['starttime'] = $_GET["starttime"];
		$sea['endtime'] = $_GET["endtime"];

		if($type!=""){
			$where[$tq.'balance.bptype'] = array("eq",$type);
			$sea['type'] = $type;
		}
		$shangji=M("userinfo")->getField('uid,username');
		$where[$tq.'balance.isverified'] = array("eq",1);
		$count = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where($where)->order($tq.'balance.bptime desc')->count();
		$pagecount = 10;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$start = $page->firstRow;
		$end = $page->listRows;
		$this->assign("sea",$sea);
		$rechargelist = $balance->join('dict_pay_type on '.$tq.'balance.pay_type = dict_pay_type.id','left')->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where($where)->limit($start,$end)->order($tq.'balance.bptime desc')->select();
		//dump($where);
		//echo M()->getlastsql();exit;
		foreach($rechargelist as $k => $v){
			$rechargelist[$k]['agent_id']=$shangji[$v["agent_id"]];
			$rechargelist[$k]['leaguer_id']=$shangji[$v["leaguer_id"]];
			$rechargelist[$k]['unit_id']=$shangji[$v["unit_id"]];
			$rechargelist[$k]['bptime'] = date("Y-m-d H:m",$rechargelist[$k]['bptime']);
			if($rechargelist[$k]['cltime']==""){
				$rechargelist[$k]['cltime']="";
			}else{
				$rechargelist[$k]['cltime'] = date("Y-m-d H:m",$rechargelist[$k]['cltime']);	
			}
			$oid = M("userinfo")->where("uid=".$rechargelist[$k]['uid'])->getField('oid');
			$rechargelist[$k]['oid'] = M("userinfo")->where("uid=".$oid)->getField('username');
			$sumsheng += $rechargelist[$k]['balance'];
			$summoeny += $rechargelist[$k]['bpprice'];
		}
		$show = $page->show();	
		$this->assign("rechargelist",$rechargelist);
		$this->assign("summoeny",$summoeny);
		$this->assign("sumsheng",$sumsheng);
		$this->assign("page",$show);
	     $myuid=$_SESSION['cuid'];
         $otype = M("userinfo")->where("uid = " . $myuid)->getField("otype");
        	if($otype==1){
 			$is_agent=1;
 			$this->assign("is_agent",$is_agent);	
 		}
		$this->display();     	
	}
    public function delord(){
    	header("Content-type: text/html; charset=utf-8");
    	$orderno=I('get.orderno');
    	if ($orderno) {
    		$order=M('order');
	    	$data['display']=1;
	    	if ($order->where('orderno='.$orderno)->save($data)) {
	    		redirect(U('Trade/tradelist'),1, '删除用户成功...');
	    	}else{
	    		redirect(U('Trade/tradelist'),1, '删除用户失败...');
	    	}
    	}
    	redirect(U('Trade/tradelist'),1, '用户订单不存在...');
    }
   private function getuid($id,$type){
	   if(is_array($id)){
		  $id=implode(',',$id);
	   }
	   $result=M("userinfo")->where('oid in ( '. $id.' )')->getField('uid',true);
	  
	   $otype = M("userinfo")->where('oid in ( '. $id.' )')->getField("otype");
	   
	   if($otype!=$type){
		   return $this->getuid($result,$type);
	   }else{
		  
		    return $result;
	   }
   }
    public function nowlist(){
        $orderObj = M('order');
		$user_info = M('userinfo');
		
		//有type则查询全部
		if(!$_GET['type'])
		{
			$order_where['orders.is_settle'] = array('eq',0);
		}
		
		//有$_GET['cuid']则为跨级查询$_GET['cuid']为代理2的uid
		if($_GET['cuid'])
		{
			$order_where['user1.oid'] = array('eq',$_GET['cuid']);
		}
		else
		{
			if($_SESSION['userotype'] == 1)
			{
				$order_where['user1.oid'] = array('eq',$_SESSION['cuid']);
				$_GET['cuid'] = $_SESSION['cuid'];
			}
			else
			{
				// $agent_two = $user_info->where("oid={$_SESSION['cuid']}")->select();
				// foreach($agent_two as $row_agtwo)
				// {
				// 	$agtwo_id[] = $row_agtwo['uid'];
				// }
				// $this->assign("agent_two",$agent_two);
				// $order_where['user1.oid'] = array('in',$agtwo_id);

				$order_where['user1.oid'] = $_SESSION['cuid'];
			}
		}
		
		//查询条件判断
		if($_GET['StartTime'] && $_GET['EntTime']){	
			$star_date = date('Y-m-d H:i:s',strtotime($_GET['StartTime']));
		    $end_date = date('Y-m-d H:i:s',strtotime($_GET['EntTime']));
			$order_where['orders.trade_time'] = array('between',array($star_date,$end_date));
		}else if($_GET['StartTime']){
			$star_date = date('Y-m-d H:i:s',strtotime($_GET['StartTime']));
			$order_where['orders.trade_time'] = array('between',array($star_date,date('Y-m-d H:i:s',time())));	
		}else if($_GET['EntTime']){
		    $end_date = date('Y-m-d H:i:s',strtotime($_GET['EntTime']));			
			$order_where['orders.trade_time'] = array('between',array(0,$end_date));		
		}
		if($_GET['orderno'])
		{
			$order_where['orders.orderno']=array("like","%".$_GET['orderno']."%");
		}
		if($_GET['uid'])
		{
			$order_where['user1.uid']=array("eq",$_GET['uid']);
		}
		if($_GET['ostyle'] !== '' && $_GET['ostyle'] !== NULL)
		{
			$order_where['orders.ostyle']=array("eq",$_GET['ostyle']);
		}
		if($_GET['pid'])
		{
			$order_where['orders.ptitle']=array("eq",$_GET['pid']);
		}
		if($_GET['agent_uid'])
		{
			$order_where['user1.oid'] = array('eq',$_GET['agent_uid']);
			$user_where['otype'] = array('eq',0);
			$user_where['agent_id'] = array('eq',$_GET['agent_uid']);
			$user_list = $user_info->where($user_where)->select();
			$this->assign("user_list",$user_list);
		}
		//查询列表代理2的用户列表
		if(!$_GET['agent_uid'])
		{
			$user_where['otype'] = array('eq',0);
			$user_where['agent_id'] = array('eq',$_GET['cuid']);
			$user_list = $user_info->where($user_where)->select();
			$this->assign("user_list",$user_list);
		}
		
		//查询列表商品列表
		$product_list = $orderObj->group('ptitle')->select();
		
		//数据分页
		$count = $orderObj->where($order_where)->field('count(user1.uid) as count,sum(orders.fee) as fee,sum(trade_amount) as trade_amount')->table('wp_order orders')
		->join("join wp_userinfo user1 on user1.uid = orders.uid")
		->find();
		$page	=	new \Think\Page($count['count'],10); 
		$order_info = $orderObj->where($order_where)->field('orders.*,user1.username,user1.utel,data.last,user2.username as managername')->table('wp_order orders')
		->join("join wp_userinfo user1 on user1.uid = orders.uid")
		->join("join wp_data_now data on data.id = orders.data_now_id")
		->join("join wp_userinfo user2 on user1.leaguer_id = user2.uid")
		->limit($page->firstRow.','.$page->listRows)
		->order('orders.buytime DESC,orders.oid DESC')
		->select();

	//	echo M()->getLastSql();die;
		
		//完善数据获取剩余时间和盈亏
		foreach($order_info as &$row_order)
		{
			$row_order['un_surplus'] = strtotime($row_order['finirm_time']) - time();
			$row_order['un_surplus'] = $row_order['un_surplus']>0?$row_order['un_surplus']:0;
			$row_order['surplus'] = $this->time_algorithm($row_order['un_surplus']);
			$row_order['profit'] = $this->profit_algorithm($row_order['buyprice'],$row_order['last'],$row_order['trade_amount'],$row_order['odds']);
		}
		$page = $page->show();
		$this->assign("page",$page);
		$this->assign("type",$_GET['type']);
		$this->assign("total",$count['count']);
		$this->assign("product_list",$product_list);
		$this->assign('order_info', $order_info);
		$this->assign('total_fee',$count['fee']);
        $this->assign('total_trade_amount',$count['trade_amount']);
        $this->display();
    }
	
	/**
	*jajx刷新剩余时间,当前点位,盈亏
	* @order_type 商品类型的数组
	* @remaining_time 时间和秒的数组
	* @all_order_info 订单信息
	*/
	public function ajax_agent($order_type,$remaining_time,$all_order_info)
	{
		$data_now = M('data_now');
		foreach($order_type as $row_type)
		{
			$data_list = $data_now->field('last')->where("id=$row_type")->find();
			$data_lists[$row_type] = $data_list['last'];
		}

		foreach($all_order_info as $k=>$order_info)
		{
			$profit[$k] = $this->profit_algorithm($order_info['action'],$data_lists[$order_info['data_now']],$order_info['initial'],$order_info['interest'],$order_info['ostyle']);
		}
		foreach($remaining_time as &$row_type)
		{
			if($row_type[0]>0)
			{
				$row_type[0] = $row_type[1] - time();
				$row_type[0] = $row_type[0]>0?$row_type[0]:0;
			}
			$date_time[] = $this->time_algorithm($row_type[0]);
		}
		$all_time['remaining_time'] = $remaining_time;
		$all_time['date_time'] = $date_time;
		$data['profit'] = $profit;
		$data['list'] = $data_lists;
		$data['time'] = $all_time;
		echo json_encode($data);
	}
	
	/**
	*剩余时间
	* @time 时间秒数
	*/
	public function time_algorithm($time)
	{
		if($time >= 60){
			$data = date('i:s',$time);
		}else{
			$data = date('i:s',$time);
		}
		return $data;
	}
	
	/**
	*盈亏算法
	* @action 初始点位
	* @end 当前点位
	* @initial 投资金额
	* @interest 收益利率
	*/
	public function profit_algorithm($action,$end,$initial,$interest,$ostyle)
	{
		# 0涨 1跌
		if($ostyle == 0)
		{
			if($end > $action)
			{
				$data = ($initial*$interest);

			} else if($end == $action)
			{
				$data = 0;

			} else {

				$data = -$initial;
			}
		} else {

			if($end < $action)
			{
				$data = ($initial*$interest);

			} else if($end == $action)
			{
				$data = 0;

			} else {

				$data = -$initial;
			}
		}

		return $data;
	}
	
	/**
	*根据代理2获取客户
	* @val 代理2的uid
	*/
	public function ajax_mem($val)
	{
		$user_info = M('userinfo');
		$user_where['otype'] = array('eq',0);
		$user_where['agent_id'] = array('eq',$val);
		$user_list = $user_info->where($user_where)->select();
		echo json_encode($user_list);
	}
}