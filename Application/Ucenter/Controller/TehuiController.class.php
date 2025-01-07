<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class TehuiController extends CommonController{
	public function tradelist()
    
{    	$tq=C('DB_PREFIX');
    	$userinfo=M('userinfo');
    	$order = M('order');
		$journal = D('journal');
    	//默认查询全部
		// $otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->getField("otype");
		$otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->find();
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
		}else{
			
			$where['th_uid'] = $_SESSION['cuid'];
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
		$count = $order->order('buytime desc')->where($where)->count();				
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
		
		$tlist = $order->order('buytime desc')->limit($start,$end)->where($where)->select();
		//dump($tlist);die;
		//echo M("")->getlastsql();exit;
		foreach($tlist as $key=>$val)
		{
			$ooid = M("userinfo")->where("uid=".$val['uid'])->getField('oid');
			$tlist[$key]['oid']=M("userinfo")->where("uid=".$ooid)->getField('username');	
			$tlist[$key]['count'] = $order->where('oid='.$val['oid'])->count();	
			$tlist[$key]['username'] = M("userinfo")->where("uid=".$val['uid'])->getField('username');
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
		
		//dump($tlist);die;
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
    }
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
		//查询多条记录
       	$field = $tq.'userinfo.username as username,'.$tq.'userinfo.unit_id as unit_id,'.$tq.'userinfo.leaguer_id as leaguer_id,'.$tq.'userinfo.agent_id as agent_id,'.$tq.'balance.uid as uid,'.$tq.'balance.bpid as bpid,'.$tq.'balance.bptype as bptype,'.$tq.'balance.bptime as bptime,'.$tq.'balance.bpprice as bpprice,'.$tq.'balance.remarks as remarks,'.$tq.'balance.isverified as isverified,'.$tq.'accountinfo.balance as balance,'.$tq.'balance.cltime as cltime';
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
		 $huiyundanwen =  $this->getuid($_SESSION['cuid'],2);
		$huilist = M("userinfo")->where('uid in ( '. implode(',',$huiyundanwen).' )')->getField('uid,username');
		//echo M()->getlastsql();exit;
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
		if($_GET["starttime"] && $_GET["endtime"]){
			$starttime = strtotime($starttime." 00:00:00");
			$endtime = strtotime($endtime." 23:59:59");
			$where[$tq.'balance.bptime'] = array('between',array($starttime,$endtime));
			$sea['starttime'] = $_GET["starttime"];
			$sea['endtime'] = $_GET["endtime"];
		}
		
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
		$rechargelist = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where($where)->limit($start,$end)->order($tq.'balance.bptime desc')->select();
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
}