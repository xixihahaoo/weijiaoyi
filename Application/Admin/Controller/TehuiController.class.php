<?php

namespace Admin\Controller;
use Think\Controller;
class TehuiController extends CommonController {
	//会员列表
    public function mlist()
    {

    	
    	$tq=C('DB_PREFIX');
    	$user = D('userinfo');
		$order = D('order');
		$account = D('accountinfo');
		$step = I('get.step');
		
		$field = $tq.'userinfo.username as username,'.$tq.'userinfo.utel as utel,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.uid as uid,'.$tq.'userinfo.otype as otype,'.$tq.'userinfo.ustatus as ustatus,'.$tq.'userinfo.oid as oid,'.$tq.'userinfo.address as address,'.$tq.'userinfo.portrait as portrait,'.$tq.'userinfo.lastlog as lastlog,'.$tq.'userinfo.managername as managername,'.$tq.'userinfo.comname as comname,'.$tq.'userinfo.comqua as comqua,'.$tq.'userinfo.rebate as rebate,'.$tq.'userinfo.feerebate as feerebate,'.$tq.'accountinfo.balance as balance,'.$tq."userinfo.assure,".$tq.'accountinfo.frozen';
		 
		if($step == "search"){
			$keywords = '%'.I('post.keywords').'%';	
			$where['username|utel'] = array('like',$keywords);
			
			$ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->where('ustatus=0 and otype=6')->field($field)->order($tq.'userinfo.uid desc')->select();
			//循环用户id，获取该用户的所有订单数,以及账户余额
			foreach($ulist as $k => $v){
				$ocount = $order->where($tq.'order.uid='.$v['uid'])->count();
				$ulist[$k]['ocount'] = $ocount;
				$ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
				$ulist[$k]['utime'] = date("Y-m-d",$ulist[$k]['utime']);

/*				$ids = get_unit_id($v['uid']);
				$where_temp['uid'] =array('IN',$ids);
				$ulist[$k]['ocount'] = $order->where($where_temp)->count();
				$ulist[$k]['ocount'] = $ocount;
				$ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
				$ulist[$k]['utime'] = date("Y-m-d",$ulist[$k]['utime']);
				$ocount +=$ulist[$k]['ocount'];*/
			}

			if($ulist){
				$this->ajaxReturn($ulist);	
			}else{
				$this->ajaxReturn("null");
			}
		}else if($step == "sxsearch"){
			$key = I('post.sxkey');
			$formula = I('post.formula');
			$sxvalue = I('post.sxvalue');
			if($key=="utime"){
				$sxvalue = strtotime($sxvalue);
			}
			if($key=="uid"){
				$key = $tq."userinfo.uid";
			}
			if($sxvalue=="会员"){
				$sxvalue = 0;
			}else if($sxvalue == "经纪人"){
				$sxvalue = 2;
			}else{
				$sxvalue =$sxvalue;
			}
			switch($formula){
				case "eq":
					$formula = " = '".$sxvalue."'";
					break;
				case "neq":
					$formula = " <> '".$sxvalue."'";
					break;
				case "gt":
					$formula = " > '".$sxvalue."'";
					break;
				case "lt":
					$formula = " < '".$sxvalue."'";
					break;
				case "bh":
					$formula = " like '%".$sxvalue."%'";
					break;
				case "bbh":
					$formula = " no like '%".$sxvalue."%'";
					break;
				default:
					$formula = " = '".$sxvalue."'";
			}
			$where = $key.$formula;

			$ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where.' and otype=6')->field($field)->order($tq.'userinfo.uid desc')->select();
			foreach($ulist as $k => $v){
				$ocount = $order->where($tq.'order.uid='.$v['uid'])->count();
				$ulist[$k]['ocount'] = $ocount;
				$ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
				$ulist[$k]['utime'] = date("Y-m-d",$ulist[$k]['utime']);
				$ulist[$k]['lastlog'] = date("Y-m-d",$ulist[$k]['lastlog']);
				$ulist[$k]['ustatus'] = $ulist[$k]['ustatus'] == 0 ? '正常':'已冻结';
			}
			if($ulist){
				$this->ajaxReturn($ulist);	
			}else{
				$this->ajaxReturn("null");
			}
		}else{
			//分页
			$count = $user->where('ustatus=0 and otype=6')->count();
	        $pagecount = 10;
	        $page = new \Think\Page($count , $pagecount);
	        $page->parameter = $row; //此处的row是数组，为了传递查询条件
	        $page->setConfig('first','首页');
	        $page->setConfig('prev','&#8249;');
	        $page->setConfig('next','&#8250;');
	        $page->setConfig('last','尾页');
	        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
	        $show = $page->show();
			//查询用户和账户信息

			$ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where('otype=6')->field($field)->order($tq.'userinfo.uid desc')->limit($page->firstRow.','.$page->listRows)->select();

			$ocount = 0;
			foreach($ulist as $k => $v){
				$ids_arr = $user->field('uid')->where(array('unit_id'=>$v['uid']))->select();
				$ids='';
				foreach($ids_arr as $item){
					if(!$ids){
						$ids=implode(',',$item);
					}else{
						$ids .=','.implode(',',$item);
					}
				}

				$where_temp['uid'] =array('IN',$ids);
				//$v['uid'];
				$ulist[$k]['ocount'] = $order->where($where_temp)->count();
				$ocount +=$ulist[$k]['ocount'];
				$ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
				
			}
			
			$this->assign('page',$show);
			$this->assign('count',$ocount);
	    	$this->assign('ulist',$ulist);
    	}

		//用户数量
    	$userCount = $user->where('otype=0 and utel is not null')->count();
		//交易手数
		$onumber = $order->where('ostaus=1')->count();
		//所有用户账户余额统计
		$anumber = $account->where('uid in(select distinct uid from wp_userinfo where otype=0 and utel is not null)')->sum('balance');

		$this->assign('onumber',$onumber);
		$this->assign('anumber',number_format($anumber,2));
		$this->assign('ucount',$userCount);
		$this->display();
	}
	public function index()
	{
		$this->display('mlist');		
	}
	/**
	 * 添加特会
	 * */
	public function madd(){

		
		$user = D('userinfo');
		$account = D('accountinfo');
		$manager = D('managerinfo');
		if(IS_POST){
			if($data=$user->create()){
				$data['utime']=date(time());
				$data['upwd']=md5(I('post.upwd'));
				$data['oid']=session('userid');
				$data['managername']=session('username');
				$data['utime']=date(time());
				$data['rebate']=I('post.rebate');
				$data['feerebate']=I('post.feerebate');
				$data['username'] = I('post.username');
				$flag = preg_match('/[\x{4e00}-\x{9fa5}]+/u',$data['username']);
				if($flag){
					$this->error('登录名不能用汉字，请使用英文和数字');
				}
				$data['gefeebate']=I('post.gefeebate');
				$data['assure']=I('post.assure');
				$result = $user->add($data);
				if($result){
					$mg['brokerid'] = I('post.brokerid');
					$mg['uid'] = $result;
					$ac['uid'] = $result;
					//创建账户表
					$account->add($ac);
					//创建身份证信息表
					$manager->add($mg);
					$info = '添加特会【'.I('post.utel').'】';
					$type = 5;
					user_log($info,$type);
					$this->success('添加成功',U('Tehui/mlist'));
				}else{
					$this->error("添加失败");
				}
			}else{
				$this->error($user->getError());
			}
		}else{
			$this->display();	
		}
	}
	
	public function mupdate(){
		
		
		$user = D('userinfo');
		$manager = D('managerinfo');
		if(IS_POST){
			$ajax = I('get.ajax');
			$uid = I('post.uid');
			$rebate = I('post.rebate');
			$feerebate = I('post.feerebate');
			$data['username'] = I('username');
			$data['utel'] = I('utel');
			$data['address'] = I('address');
			$data['brokerid'] = I('brokerid');
			$data['comname'] = I('comname');
			$data['comqua'] = I('comqua');
			$data['assure']=I('post.assure');
			$data['rebate'] = $rebate;
			$data['feerebate'] = $feerebate;
			$map['balance'] = I('post.balance');
			$upwd = I('upwd');
			$map['bankname'] = I('bankname');
			$map['province'] = I('province');
			$map['city'] = I('city');
			if($upwd){
				$data['upwd'] = md5($upwd);	
			}
			$bankinfo = M('bankinfo')->where('uid='.$uid)->find();
			if($bankinfo['uid'] != ''){
				 M('bankinfo')->where('uid='.$uid)->save($map);
			}else{
				$map['uid'] = $uid;
				M('bankinfo')->add($map);
			}
			M('accountinfo')->where('uid='.$uid)->save($map);
			$editlt = $user->where('uid='.$uid)->save($data);
			if($editlt!==FALSE){
				$info = '修改【'.I('post.utel').'】运营中心信息';
				$type = 2;
				user_log($info,$type);
				$this->success("修改成功",U("Tehui/mlist"));
			}else{
				$this->error('修改失败');
			}
			
			if($ajax=="rebate"){
				$result = $user->where('uid='.$uid)->setField('rebate',$rebate);
				if($result){
					$info = '修改【'.I('post.utel').'】运营中心信息';
					$type = 2;
					user_log($info,$type);
					$this->ajaxReturn('修改成功');
				}else{
					$this->ajaxReturn('修改失败');
				}
			}else if($ajax=="feerebate"){
				$result = $user->where('uid='.$uid)->setField('feerebate',$feerebate);
				if($result){
					$info = '修改【'.I('post.utel').'】运营中心信息';
					$type = 2;
					user_log($info,$type);
					$this->ajaxReturn('修改成功');
				}else{
					$this->ajaxReturn('修改失败');
				}
			}
			
		}else{
			$uid = I('get.uid');			
			$us = $user->where('uid='.$uid)->find();
			$mg = $manager->where('uid='.$uid)->find();
			$accountinfo = M('accountinfo')->where('uid='.$uid)->find();
			$bankinfo = M('bankinfo')->where('uid='.$uid)->find();
			$this->assign('bankinfo',$bankinfo);
			$this->assign('us',$us);
			$this->assign('mg',$mg);
			$this->assign('accountinfo',$accountinfo);
			$this->display();
		}
	} 
	function upstatus(){
		$id=$_REQUEST['id'];
		$res["ustatus"]=$_REQUEST['type'];
		$resut = M("userinfo")->where("uid=" . $id)->save($res);
		if($resut){
			if($_REQUEST['type'] == 1){
				$info = "冻结【id=".$id."运营中心】";
			}else{
				$info = "解冻【id=".$id."运营中心】";
			}
			
			$type = 2;
			user_log($info,$type);
			$data['state']=1;
			$data["info"]="操作成功！";
		}else{
			$data['state']=2;
			$data["info"]="操作失败！";
		}
		$this->ajaxReturn($data);
	}

	/**
	 * 特别会员下的会员单位
	 * @author wang 
	 */
	public function show_unit()
	{
		$uid 	 = trim(I('get.uid'));
		$userObj = M('userinfo a');

		$count = $userObj->where(array('a.th_uid' => $uid,'a.otype' => 2))->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

		$userinfo = $userObj->field('a.uid,a.username,a.utel,a.lastlog,a.utime,b.balance')->join('inner join wp_accountinfo as b on a.uid=b.uid')->where(array('a.th_uid' => $uid,'a.otype' => 2))->limit($page->firstRow.','.$page->listRows)->select();

		$this->assign('page',$show);
		$this->assign('info',$userinfo);
		$this->display();
	}

}