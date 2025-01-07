<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class RebateController extends CommonController {
   
	public function index(){



		$id=$_REQUEST['uid'];

		$info_one=level_info($id,1);
foreach ($info_one as $key => $value) {
  $info[$key]=M("order")->where("oid=".$value['order_id'])->find();
   $info[$key]['add_money']=$value['add_money'];
   $info[$key]['ratio']=$value['ratio'];
   $info[$key]['username']=$value['username'];
}
       $info_two=level_info($id,2);
foreach ($info_two as $key => $value) {
  $info2[$key]=M("order")->where("oid=".$value['order_id'])->find();
   $info2[$key]['add_money']=$value['add_money'];
   $info2[$key]['ratio']=$value['ratio'];
   $info2[$key]['username']=$value['username'];
}
 
		$this->assign("info",$info);
		$this->assign("info2",$info2);
		$this->display();die;












 
		     
    	$tq=C('DB_PREFIX');
    	$user = D('userinfo');
		$order = D('order');
		$account = D('accountinfo');
		$huilist = $user->where("otype = 2")->select();
		$this->assign("huilist",$huilist);
	    $puhuilist = $user->where("otype = 4")->select();
		$this->assign("puhuilist",$puhuilist);
		$jlist = $user->where("otype = 1")->select();
		$this->assign("jlist",$jlist);
		
		$field = $tq.'userinfo.username as username,'.$tq.'userinfo.uid as uid,'.$tq.'userinfo.utel as utel,'.$tq.'userinfo.address as address,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.oid as oid,'.$tq.'userinfo.managername as managername,'.$tq.'userinfo.lastlog as lastlog,'.$tq.'accountinfo.balance as balance,'.$tq.'userinfo.otype as otype';
		$phone = $_GET['phone'];
		$username = $_GET['username'];
		$starttime = $_GET['starttime'];
		$endtime = $_GET['endtime'];
		$oid = $_GET['oid'];
		if($phone)
		{
			$where[$tq.'userinfo.utel'] = array('like','%'.$_GET["phone"].'%');
			$sea['phone'] = $_GET["phone"];
		}
		$username = $_GET['username'];
		if($username)
		{
			$where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
			$sea['username'] = $_GET["username"];
		}
		if($_GET["starttime"] && $_GET["endtime"]){
			$starttime = strtotime($starttime." 00:00:00");
			$endtime = strtotime($endtime." 23:59:59");
			$where[$tq.'userinfo.utime'] = array('between',array($starttime,$endtime));
			$sea['starttime'] = $_GET["starttime"];
			$sea['endtime'] = $_GET["endtime"];
		}
		if($oid)
		{
			// $oids = getDownuids($oid);

			// $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
        	$oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
			foreach ($oids as $key => $value) {
				 $oids2[]=$value['uid'];
			}
			 $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids2));
			$sea['oid'] = $oid;

		}

		  $puhui_id = $_GET['puhui_id'];

		if($puhui_id)
		{
			// $puhui_ids = getDownuids($puhui_id);

			// $where[$tq.'userinfo.uid'] = array("in",implode(',',$puhui_ids));
			$puhui_ids=M("userinfo")->field("uid")->where("leaguer_id=".$puhui_id)->select();
		 	foreach ($puhui_ids as $key => $value) {
				 $puhui_ids2[]=$value['uid'];
			}
	 
 			 $where[$tq.'userinfo.uid']  = array("in",implode(',',$puhui_ids2));
			$sea['puhui_id'] = $puhui_id;
		}
 
  
		$jid = $_GET['jid'];
		if($jid)
		{
			// $jids = $user->field("uid")->where("oid=".$jid)->select();
			// foreach($jids as $val){
			// 	$jids[] = $val['uid'];
			// }
			// $where['wp_userinfo.uid'] = array("in",implode(',',$jids));
	    	$jids=M("userinfo")->field("uid")->where("agent_id=".$jid)->select();
		 	foreach ($jids as $key => $value) {
				 $jids2[]=$value['uid'];
			}	
			 $where[$tq.'userinfo.uid'] = array("in",implode(',',$jids2));
			$sea['jid'] = $jid;
		}
		
		$this->assign("sea",$sea);
		//分页
		$count = $user->where($where)->count();
		$pagecount = 10;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','&#8249;');
		$page->setConfig('next','&#8250;');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		$show = $page->show();
		//查询用户和账户信息
		$ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->field($field)->order($tq.'userinfo.uid desc')->limit($page->firstRow.','.$page->listRows)->select();
 
		$summoney = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->field($field)->order($tq.'userinfo.uid desc')->sum("balance");
		//循环用户id，获取该用户的所有订单数
		foreach($ulist as $k => $v){
			//$v['uid'];
			$ocount = $order->where($tq.'order.uid='.$v['uid'])->count();
			$ulist[$k]['ocount'] = $ocount;
			$ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
			$ulist[$k]['managername']=M('userinfo')->where('uid='.$v['oid'])->getField('username');
		}
		$this->assign('page',$show);
		$this->assign('ulist',$ulist);
    	

		//统计
		//用户数量
    	$userCount = $user->where('ustatus=0')->count();
		//交易手数
		$orders = $order->where('ostaus=1')->field('onumber')->select();
		//所有用户账户余额统计
		$acc = $account->field('balance')->select();
		$onumber = 0;
		$anumber = 0;
		foreach($orders as $k => $v){
			$onumber += $orders[$k]['onumber'];
		}
		foreach($acc as $k => $v){
			$anumber += $acc[$k]['balance'];
		}
		$anumber = number_format($anumber,2);
		$this->assign('summoney',$summoney);
		$this->assign('onumber',$onumber);
		$this->assign('anumber',$anumber);
		$this->assign('ucount',$userCount);
		$this->display();
	}
















}