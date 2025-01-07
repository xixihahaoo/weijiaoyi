<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class CustomerController extends CommonController{
     //会员列表
	public function customerlist()
    {
		$userinfo = M("userinfo");
		$tq=C('DB_PREFIX');
		// $otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->getField("otype");
		$otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->find();
	//	 var_dump($otype);die;
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
		$huilist = $userinfo->where("otype = ".$t." and oid = ".$_SESSION['cuid'])->select();
		// echo $userinfo->getLastsql();exit;
		$this->assign("huilist",$huilist);
		$where = "";
		//获取用户名，生产模糊条件
		$username = $_GET['username'];
		//获取订单时间

		$starttime = date('Y-m-d',strtotime($_GET["starttime"]));
		if(!isset($_GET['endtime']) || !$_GET['endtime']){
			$endtime=date('Y-m-d',time()+86400);
		}else{
			$endtime = $_GET["endtime"];
		}
		//获取订单类型
		$type = $_GET['type'];
		//获取订单盈亏
		$ploss = $_GET['ploss'];
		//获取订单状态
		$ostaus = $_GET['ostaus'];
		$oid = $_GET['oid'];
		$phone = $_GET['phone'];
		if($oid)
		{
			$otype2=M("userinfo")->field("otype,username")->where("uid=".$oid )->find();

			// $oids = getDownuids($oid);
			// $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
			if($otype2['otype'] == 2){
				$oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
			}
			if($otype2['otype'] == 4){
				$oids=M("userinfo")->field("uid")->where("leaguer_id=".$oid)->select();
			}
			if($otype2['otype'] == 5){
				$oids=M("userinfo")->field("uid")->where("operate_id=".$oid)->select();
			}	
			if($otype2['otype'] == 1){
				$oids=M("userinfo")->field("uid")->where("agent_id=".$oid)->select();
			}		
	    	foreach ($oids as $key => $value) {
				 $oids2[]=$value['uid'];
			}
			$where[$tq.'userinfo.uid'] = array("in",implode(',',$oids2));
			
	 
			$sea['oid'] = $oid;

		}else{
	    	if($otype['otype'] == 2){
				$oids=M("userinfo")->field("uid")->where("unit_id=".$_SESSION['cuid'])->select();
			}
			if($otype['otype'] == 4){
				$oids=M("userinfo")->field("uid")->where("leaguer_id=".$_SESSION['cuid'])->select();
			}
			if($otype['otype'] == 5){
				$oids=M("userinfo")->field("uid")->where("operate_id=".$_SESSION['cuid'])->select();
			}
			if($otype['otype'] == 1){
				$oids=M("userinfo")->field("uid")->where("agent_id=".$_SESSION['cuid'])->select();
			}		
	    	foreach ($oids as $key => $value) {
				 $oids2[]=$value['uid'];
			}
			$where[$tq.'userinfo.uid'] = array("in",implode(',',$oids2));
 
			// $oids = getDownuids($_SESSION['cuid']);
			// $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
			
			$sea['oid'] = $oid;
		}
		// var_dump($sea);
		//exit;
		if($username){
			$where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
			$sea['username'] = $_GET["username"];
		}
		if($phone){
			$where[$tq.'userinfo.utel'] = array('like','%'.$_GET["phone"].'%');
			$sea['phone'] = $_GET["phone"];
		}
		if($_GET['starttime']){
//			$starttime = strtotime($starttime." 00:00:00");
//			$endtime = strtotime($endtime." 23:59:59");
			$where[$tq.'userinfo.utime'] = array('between',array(strtotime($starttime),strtotime($endtime)+86400));
			$sea['starttime'] = $starttime;
			$sea['endtime'] = $endtime;
		}
		$where[$tq.'userinfo.otype'] = 0;
			$this->assign("sea",$sea);
            $count =$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')
	    	->where($where)->count();
	    	$pagecount = 10;
	        $page = new \Think\Page($count , $pagecount);
	        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
	        $page->setConfig('first','首页');
	        $page->setConfig('prev','上一页');
	        $page->setConfig('next','下一页');
	        $page->setConfig('last','尾页');
	        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
	        $show = $page->show();
	    	$list=$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')
	    	->where($where)->limit($page->firstRow.','.$page->listRows)->select();
			$list_more=$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')
			->where($where)->select();
		 
			$nummoney=$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid')->where($where)->sum($tq.'accountinfo.balance');
			// var_dump($list);die;
	    	foreach ($list as $k => $v) {
	    		$sum[]=M('order')->where('uid='.$v['uid'])->sum('onumber');
	    		$accoun[]=M('accountinfo')->field('balance')->where('uid='.$v['uid'])->find();
				$list[$k]['upusername'] = M("userinfo")->where("uid=".$v['oid'])->getField("username");
			    $agent=M('agent')->where('oid='.$v['uid'])->sum('add_money');
 if($agent!=""){$list[$k]['agent']=$agent;}else{$list[$k]['agent']=0;}
	    	}

	    	foreach ($list as $key => $value) {

	    		if(!$value['username']){
	    			$list[$key]['username']="已绑定，未注册";
	    		}
	    		foreach ($sum as $k => $v) {
	    			if($key==$k){
	    				$list[$key]['sum'] = $sum[$k];	
	    			}
	    		}
	    		foreach ($accoun as $ky => $va) {
	    			if($key==$ky){
	    				$list[$key]['balance'] = $accoun[$ky]['balance'];
	    			}
	    		}
	    	}

	    $assure=M("userinfo")->field("assure","otype")->where("uid=".$_SESSION['cuid'])->find();	
        //$assure=$assure['assure'];
         $myuid=$_SESSION['cuid'];
         $otype = M("userinfo")->where("uid = " . $myuid)->getField("otype");
        	if($otype==1){
 			$is_agent=1;
 			$this->assign("is_agent",$is_agent);	
 		}
 	 	if($otype==2){
 			$is_unit=1;
 			$this->assign("is_unit",$is_unit);	
 		}
		//返佣总金额
		$brokerage=0.00;
		foreach($list_more as $v){
			$agent_total=M('agent')->where('oid='.$v['uid'])->sum('add_money');
			if($agent_total!=""){
				$brokerage += $agent_total;
			}
		}

		//数据导出
		if( $_GET['pp'] == 2){
			$otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->find();
			if($otype['otype'] != 2){
				$this->error('无权限');
			}
			//dump($list);die;
		//查询用户和账户信息
		$data[0] = array('用户id','用户名','注册时间','上级','最近登录时间','账号余额','全民返佣','客户类别');
		foreach($list as $k => $v){
			$data[$k+1][] = $v['uid'];
			$data[$k+1][] = $v['utel'];
			$data[$k+1][] = date('Y-m-d',$v['utime']);
			$data[$k+1][] = $v['upusername'];
			$data[$k+1][] = date('Y-m-d',$v['lastlog']);
			$data[$k+1][] = $v['balance'];
			$data[$k+1][] = $v['agent'];
			if($v['otype'] == 2 )
			{
				$data[$k+1][] = "会员单位";
			}else if($v['otype'] == 1){
				$data[$k+1][] = "经纪人";
			}else if($v['otype'] == 3){
				$data[$k+1][] = "管理员";
			}else{
				$data[$k+1][] = "客户";
			}
		}
		$name='Excelfile';  //生成的Excel文件文件名
		$res=$this->push($data,$name);
		}else{
			$this->assign('brokerage',$brokerage);
			//echo $userinfo->getLastSql();
	        //dump($list);die;
			$this->assign('nummoney',$nummoney);
			$this->assign('assure',$assure['assure']);
		    $this->assign('ulist',$list);
		    // echo "<pre>";
		    // var_dump($list);die;
		    $this->assign('sea',$sea);
		    $this->assign('t',$t);
	        $this->assign('page',$show);
	        $this->assign('otype',$assure['otype']);
			$this->display();	
		}


    }


    /**
     * @functionname: customerlist_direct
     * @author: FrankHong
     * @date: 直属客户列表
     * @description:
     * @note:
     */
    public function customerlist_direct()
    {
        $userinfo   = M("userinfo");
        $tq         = C('DB_PREFIX');

        $otype      = $userinfo->where("uid=".$_SESSION['cuid'])->find();

        if($otype['otype'] == 2)
        {
            $t = 4;
        }
        else if($otype['otype'] == 4)
        {
            $t = 1;
        }
        else if($otype['otype'] == 1)
        {
            $t = 0;
        }
        //过滤搜索
        $huilist    = $userinfo->where("otype = ".$t." and oid = ".$_SESSION['cuid'])->select();


        // echo $userinfo->getLastsql();exit;
        $this->assign("huilist",$huilist);
        $where      = "";
        //获取用户名，生产模糊条件
        $username   = $_GET['username'];
        //获取订单时间
        $starttime  = date('Y-m-d', strtotime($_GET["starttime"]));
        if(!isset($_GET['endtime']) || !$_GET['endtime'])
        {
            $endtime    = date('Y-m-d',time()+86400);
        }
        else
        {
            $endtime    = $_GET["endtime"];
        }
        //获取订单类型
        $type   = $_GET['type'];
        //获取订单盈亏
        $ploss  = $_GET['ploss'];
        //获取订单状态
        $ostaus = $_GET['ostaus'];
        $oid    = $_GET['oid'];
        $phone  = $_GET['phone'];
        if($oid)
        {
            $otype2 = M("userinfo")->field("otype, username")->where("uid=".$oid )->find();

            // $oids = getDownuids($oid);
            // $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
            if($otype2['otype'] == 2){
                $oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
            }
            if($otype2['otype'] == 4){
                $oids=M("userinfo")->field("uid")->where("leaguer_id=".$oid)->select();
            }
            if($otype2['otype'] == 5){
                $oids=M("userinfo")->field("uid")->where("operate_id=".$oid)->select();
            }
            if($otype2['otype'] == 1){
                $oids=M("userinfo")->field("uid")->where("agent_id=".$oid)->select();
            }
            foreach ($oids as $key => $value) {
                $oids2[]=$value['uid'];
            }
            $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids2));


            $sea['oid'] = $oid;

        }
        else
        {
            if($otype['otype'] == 2){
                $oids=M("userinfo")->field("uid")->where("unit_id=".$_SESSION['cuid'])->select();
            }
            if($otype['otype'] == 4){
                $oids=M("userinfo")->field("uid")->where("leaguer_id=".$_SESSION['cuid'])->select();
            }
            if($otype['otype'] == 5){
                $oids=M("userinfo")->field("uid")->where("operate_id=".$_SESSION['cuid'])->select();
            }
            if($otype['otype'] == 1){
                $oids=M("userinfo")->field("uid")->where("agent_id=".$_SESSION['cuid'])->select();
            }



            foreach ($oids as $key => $value)
            {
                $oids2[]=$value['uid'];
            }
            $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids2));

            // $oids = getDownuids($_SESSION['cuid']);
            // $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));

            $sea['oid'] = $oid;
        }
        // var_dump($sea);
        //exit;
        if($username){
            $where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
            $sea['username'] = $_GET["username"];
        }
        if($phone){
            $where[$tq.'userinfo.utel'] = array('like','%'.$_GET["phone"].'%');
            $sea['phone'] = $_GET["phone"];
        }
        if($_GET['starttime']){
//			$starttime = strtotime($starttime." 00:00:00");
//			$endtime = strtotime($endtime." 23:59:59");
            $where[$tq.'userinfo.utime'] = array('between',array(strtotime($starttime),strtotime($endtime)+86400));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
        }
        $where[$tq.'userinfo.otype'] = 0;
        $this->assign("sea",$sea);

        $where[$tq.'userinfo.oid'] = $_SESSION['cuid'];

        $count =$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')
            ->where($where)->count();


        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
        $list=$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')
            ->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        $list_more=$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')
            ->where($where)->select();

        $nummoney=$userinfo->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid')->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid')->where($where)->sum($tq.'accountinfo.balance');
        // var_dump($list);die;
        foreach ($list as $k => $v) {
            $sum[]=M('order')->where('uid='.$v['uid'])->sum('onumber');
            $accoun[]=M('accountinfo')->field('balance')->where('uid='.$v['uid'])->find();
            $list[$k]['upusername'] = M("userinfo")->where("uid=".$v['oid'])->getField("username");
            $agent=M('agent')->where('oid='.$v['uid'])->sum('add_money');
            if($agent!=""){$list[$k]['agent']=$agent;}else{$list[$k]['agent']=0;}
        }

        foreach ($list as $key => $value) {

            if(!$value['username']){
                $list[$key]['username']="已绑定，未注册";
            }
            foreach ($sum as $k => $v) {
                if($key==$k){
                    $list[$key]['sum'] = $sum[$k];
                }
            }
            foreach ($accoun as $ky => $va) {
                if($key==$ky){
                    $list[$key]['balance'] = $accoun[$ky]['balance'];
                }
            }
        }

        $assure=M("userinfo")->field("assure","otype")->where("uid=".$_SESSION['cuid'])->find();
        //$assure=$assure['assure'];
        $myuid=$_SESSION['cuid'];
        $otype = M("userinfo")->where("uid = " . $myuid)->getField("otype");
        if($otype==1){
            $is_agent=1;
            $this->assign("is_agent",$is_agent);
        }
        if($otype==2){
            $is_unit=1;
            $this->assign("is_unit",$is_unit);
        }
        //返佣总金额
        $brokerage=0.00;
        foreach($list_more as $v){
            $agent_total=M('agent')->where('oid='.$v['uid'])->sum('add_money');
            if($agent_total!=""){
                $brokerage += $agent_total;
            }
        }

        //数据导出
        if( $_GET['pp'] == 2){
            $otype = M("userinfo")->where("uid=".$_SESSION['cuid'])->find();
            if($otype['otype'] != 2){
                $this->error('无权限');
            }
            //dump($list);die;
            //查询用户和账户信息
            $data[0] = array('用户id','用户名','注册时间','上级','最近登录时间','账号余额','全民返佣','客户类别');
            foreach($list as $k => $v){
                $data[$k+1][] = $v['uid'];
                $data[$k+1][] = $v['utel'];
                $data[$k+1][] = date('Y-m-d',$v['utime']);
                $data[$k+1][] = $v['upusername'];
                $data[$k+1][] = date('Y-m-d',$v['lastlog']);
                $data[$k+1][] = $v['balance'];
                $data[$k+1][] = $v['agent'];
                if($v['otype'] == 2 )
                {
                    $data[$k+1][] = "会员单位";
                }else if($v['otype'] == 1){
                    $data[$k+1][] = "经纪人";
                }else if($v['otype'] == 3){
                    $data[$k+1][] = "管理员";
                }else{
                    $data[$k+1][] = "客户";
                }
            }
            $name='Excelfile';  //生成的Excel文件文件名
            $res=$this->push($data,$name);
        }else{
            $this->assign('brokerage',$brokerage);
            //echo $userinfo->getLastSql();
            //dump($list);die;
            $this->assign('nummoney',$nummoney);
            $this->assign('assure',$assure['assure']);
            $this->assign('ulist',$list);
            // echo "<pre>";
            // var_dump($list);die;
            $this->assign('sea',$sea);
            $this->assign('t',$t);
            $this->assign('page',$show);
            $this->assign('otype',$assure['otype']);
            $this->display();
        }


    }

	public function rebate()
	{
		$id = $_REQUEST['uid'];
		$info_one = level_info($id, 1);

		foreach ($info_one as $key => $value) {
			$info[$key] = M("order")->where("oid=" . $value['order_id'])->find();
			$info[$key]['add_money'] = $value['add_money'];
			$info[$key]['ratio'] = $value['ratio'];
			$info[$key]['username'] = $value['username'];
			$info[$key]['is_win'] = is_win($value['is_win']);
		}
		$info_two = level_info($id, 2);

		foreach ($info_two as $key => $value) {
			$info2[$key] = M("order")->where("oid=" . $value['order_id'])->find();
			$info2[$key]['add_money'] = $value['add_money'];
			$info2[$key]['ratio'] = $value['ratio'];
			$info2[$key]['username'] = M("agent")->field("username")->where("order_id=" . $value['order_id'] . " and level=1")->getfield("username");//取得下两级的用户名
			$info2[$key]['is_win'] = is_win($value['is_win']);
		}
		$info_three = level_info($id, 3);
		foreach ($info_three as $key => $value) {
			$info3[$key] = M("order")->where("oid=" . $value['order_id'])->find();
			$info3[$key]['add_money'] = $value['add_money'];
			$info3[$key]['ratio'] = $value['ratio'];
			$info3[$key]['username'] = M("agent")->field("username")->where("order_id=" . $value['order_id'] . " and level=2")->getfield("username");//取得下两级的用户名
			$info3[$key]['is_win'] = is_win($value['is_win']);
		}

		$this->assign("info", $info);
		$this->assign("info2", $info2);
		$this->assign('info3', $info3);
		$this->display();


	}
	public function customeradd()
    {
    	header("Content-type: text/html; charset=utf-8");
        //获取登录代理商的id
        $myuid=$_SESSION['cuid'];
         $otype = M("userinfo")->where("uid = " . $myuid)->getField("otype");
        	if($otype==1){
 			$is_agent=1;
 			$this->assign("is_agent",$is_agent);	
 		}
    	if (IS_POST) {
	    	$uid=I('post.uid');
	    	$mid=I('post.mid');
	    	$userinfo=D('userinfo');
	    	$managerinfo=M('managerinfo');
            // 自动验证 创建数据集
            if ($userinfo->create()) {
               //验证身份证正确性
               $broker= A('Ucenter/Account');
               $broker->checkIdCard(I('post.brokerid'));
               if($uid!=''&&$mid!=''){
                    //修改
                    $data['uid']=$uid;
                    $data['utel']=I('post.utel');
                    $data['address']=I('post.address');
                    if(I('post.upwd') !=''){
                    	$data['upwd']=md5(I('post.upwd'));
                    }
                    $userinfo->save($data);
                    $mana['mid']=$mid;
                    $mana['brokerid']=I('post.brokerid');
                    $managerinfo->save($mana); 
                    $info = '修改【'.I('post.utel').'用户】信息';
                    user_log($info,2);
                    redirect(U('Customer/customerlist'),1, '修改成功...');
                }else{
                    //添加
                    $user=$userinfo->field('username')->where('uid='.$myuid)->find();
                    $data['managername']=$user['username'];
                    $data['username']=I('post.username');
                    $data['utel']=I('post.utel');
                    $data['utime']=date(time());
                    $data['upwd']=md5('123456');
                    $data['address']=I('post.address');
                    $data['otype']=0;
                    $data['oid']=$myuid;
                    if ($uid = $userinfo->add($data)) {
                          $brok['uid']=$uid;
                          $brok['brokerid']=I('post.brokerid');
                          $managerinfo->add($brok);
                          $accid['uid']=$uid;
                          M('accountinfo')->add($accid);
                    }
                    redirect(U('Customer/customerlist'),1, '新增用户成功...');
                }
            }else{
                $this->error($userinfo->getError());
            }
    	}
    	//判断跳转到修改页面或者新增页面
		$uid=I('get.uid');
    	if($uid){
    		$user=M('userinfo')->where('uid='.$uid)->find();
    		$usermsg=M('managerinfo')->where('uid='.$uid)->find();
    		$user['brokerid']=$usermsg['brokerid'];
    		$user['mid']=$usermsg['mid'];
    		$this->assign('user',$user);

    	}	
 
    	$this->display();
    }

    /**
     * @functionname: qrcode
     * @author: FrankHong
     * @date: 2017-04-25 16:09:12
     * @description: 机构的推广二维码
     * @note:
     */
    public function qrcode()
    {
        $myuid      = $_SESSION['cuid'];
        $otype      = M("userinfo")->where("uid = " . $myuid)->getField("otype");
        $hostlink   = $_SERVER['HTTP_HOST'];

        $limitArray = array(1, 4, 2);

        if(in_array(intval($otype), $limitArray))
        {
            //$url        = "http://" . $hostlink . '/Home/User/wxlr' . "?uid=" . $myuid;

            $url = WX_QRCODE_URL.'?uid='.$myuid;
            $this->assign('url', $url);
            $is_agent   = $otype;
        }
        else
        {
            $is_agent   = 0;
        }

        $this->assign("is_agent", $is_agent);
        $this->display();
	}




	public function customerdetail()
    {
    	$uid=I('get.uid');
    	//普通会员信息
    	$user=M('userinfo')->where('uid='.$uid)->find();
    	$usermsg=M('managerinfo')->where('uid='.$uid)->find();
    	$account=M('accountinfo')->where('uid='.$uid)->find();
    	//普通会员上线信息
    	$ouid=M('userinfo')->where('uid='.$user['oid'])->find();

    	$user['brokerid']=$usermsg['brokerid'];
    	$user['mname']=$usermsg['mname'];
    	$user['balance']=$account['balance'];
    	$user['oname']=$ouid['username'];

    	$this->assign('user',$user);
		$this->display();
    }
	public function verifylist()
	{
		$uid = $_SESSION['cuid'];
		$user = M('userinfo')->where('oid='.$uid)->order("vertus desc")->select();
		$this->assign("ulist",$user);
		$this->display();
	}
	public function verifyeditok()
	{
		$uid = $_POST['uid'];
		$map['vertus']=1;
		$map['agenttype']=2;
		$map['otype']=1;
		$res = M('userinfo')->where('uid='.$uid)->save($map);
		if($res)
		{
			echo 1;die;
		}else{
			echo 0;die;
		}
	}
	public function verifyeditno()
	{
		$uid = $_REQUEST['uid'];
		$map['vertus']=1;
		$map['agenttype']=0;
		$map['otype']=0;
		$res = M('userinfo')->where('uid='.$uid)->save($map);
		if($res)
		{
			echo 1;die;
		}else{
			echo 0;die;
		}
	}
	public function cancel(){
		$uid = I('post.uid');
		$otype = M("userinfo")->where("uid = " . $uid)->find();
		if($otype['otype'] !=0){
			$data['info'] = '此用户不能注销！';
			$data['status'] = 0;
			$this->ajaxReturn($data);
		}
		if($otype['upwd'] =='' && $otype['utel']=='' ){
			$data['info'] = '此用户已注销！';
			$data['status'] = 0;
			$this->ajaxReturn($data);
		}
		$data['upwd'] = '';
		$data['utel'] = '';
		$res = M('userinfo')->where('uid='.$uid)->save($data);
		if($res){
			$data['info'] = '注销成功';
			$data['status'] = 1;
			$this->ajaxReturn($data);
		}
	}
	public function push($data,$name){
		import("Excel.class.php");
		$excel = new Excel();
		$excel->download($data,$name);
	}

	function upstatus(){
		$myuid=$_SESSION['cuid'];
		$userinfo = M('userinfo')->where('uid='.$myuid)->find();
		if($userinfo['otype'] == 5){
			$id = $_REQUEST['id'];
			$res["ustatus"]=$_REQUEST['type'];
			$resut = M("userinfo")->where("uid=" . $id)->save($res);
			if($resut){
				$data['state']=1;
				$data["info"]="操作成功！";
				if($_REQUEST['type'] == 1){
					$info = 'id【'.$id.'交易冻结】';
				}else if($_REQUEST['type'] == 2){
					$info = 'id【'.$id.'出金冻结】';
				}else{
					$info = 'id【'.$id.'解冻】';
				}
				user_log($info,2);
			}else{
				$data['state']=2;
				$data["info"]="操作失败！";
			}
			$this->ajaxReturn($data);
		}else{
			$data['state']=0;
			$data["info"]="没有权限!";
		}

	}

}