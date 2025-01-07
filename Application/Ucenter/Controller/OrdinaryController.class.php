<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class OrdinaryController extends CommonController{
    //会员列表
	public function agentlist()
    {
		if($_REQUEST['search'])
		{
			$str = " and username like '%".$_REQUEST['search']."%'";
		}
    	//获取登录代理商的id
    	$oid=$_SESSION['cuid'];
    	$count =M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=4 and vertus = 1'.$str)->count();
		// var_dump($count);die;
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
		$ulist=M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=4 and vertus = 1'.$str)->field('user1.*')->table('wp_userinfo user1')
		->limit($page->firstRow.','.$page->listRows)
		->select();
		foreach($ulist as $key=>$val)
		{
			$num = M('userinfo')->where('oid='.$val['uid'].' and ustatus=0 and otype=1 and vertus = 1')->count();
			$ulist[$key]['num'] = $num;
		}
		
        $this->assign('ulist',$ulist);
        $this->assign('page',$show);
		$this->display();
    }
    //会员增加或者修改
	public function agentadd()
    {
    	header("Content-type: text/html; charset=utf-8");
        //获取登录代理商的id
        $myuid=$_SESSION['cuid'];
    	if (IS_POST) {
	    	$uid=I('post.uid');
	    	$mid=I('post.mid');
	    	$userinfo=D('userinfo');
	    	$managerinfo=M('managerinfo');
            // 自动验证 创建数据集
            if ($userinfo->create()) {
               //验证身份证正确性
               // $this->checkIdCard(I('post.brokerid'));
               if($uid!=''&&$mid!=''){
                    
                    /*手续费返点*/
                    $feerebate = trim(I('post.feerebate'));
                    if(isset($feerebate))
                    {
                      if($feerebate < 0  || $feerebate > 5)
                      {
                         $this->error('手续费返点 设置不正确');
                      }
                    }
                    /*手续费返点*/

                    //修改
                    $data['uid']=$uid;
                    $data['utel']=I('post.utel');
                    $data['address']=I('post.address');
                    $data['rebate']=I('post.rebate');
                    $data['feerebate']=I('post.feerebate');
					$data['comname']=I('post.comname');
					$data['linkman']=I('post.linkman');
                    $userinfo->save($data);
                    $mana['mid']=$mid;
                    $mana['brokerid']=I('post.brokerid');
					$mana['comname']=I('post.comname');
                    $map['bankname'] = I('post.bankname');
                    $map['province'] = I('post.province');
                    $map['busername'] = I('post.busername');
					$map['banknumber'] = I('post.banknumber');
                    $map['city'] = I('city');
                    $bankinfo = M('bankinfo')->where('uid='.$uid)->find();
                    if($bankinfo['uid'] != ''){
                         M('bankinfo')->where('uid='.$uid)->save($map);
                    }else{
                        $map['uid'] = $uid;
                        M('bankinfo')->add($map);
                    }
                    $info = '修改【'.I('post.utel').'】代理信息';
                    user_log($info,2);
                    $managerinfo->save($mana); 
                    redirect(U('Ordinary/agentlist'),1, '修改成功...');
                }else{
                    //添加 
                    $user=$userinfo->field('username,operate_id')->where('uid='.$myuid)->find();
                    $data['managername']=$user['username'];
                    $data['username']=I('post.username');
                    $flag = preg_match('/[\x{4e00}-\x{9fa5}]+/u',$data['username']);
                    if($flag){
                        $this->error('姓名不能用汉字，请使用英文和数字');
                    }
                    
                    /*手续费返点*/
                    $feerebate = trim(I('post.feerebate'));
                    if(isset($feerebate))
                    {
                      if($feerebate < 0 || $feerebate > 5)
                      {
                         $this->error('手续费返点 设置不正确');
                      }
                    }
                    /*手续费返点*/

                    $data['utel']=I('post.utel');
                    $data['utime']=date(time());
                    $data['upwd']=md5('123456');
                    $data['address']=I('post.address');
					$data['comname']=I('post.comname');
					$data['rebate']=I('post.rebate');
					$data['feerebate']=I('post.feerebate');
					$data['linkman']=I('post.linkman');
                    $data['otype']=4;
                    $data['oid']=$myuid;
                    $data['operate_id']=$user['operate_id'];
                    $data['unit_id']=$myuid;
                    if ($uid = $userinfo->add($data)) {
                          $brok['uid']=$uid;
                          $brok['brokerid']=I('post.brokerid');
						  $map['bankname'] = I('bankname');
						  $map['province'] = I('province');
						  $map['busername'] = I('busername');
					      $map['banknumber']   = I('banknumber');
						  $map['city'] = I('city');
						  $map['uid'] = $uid;
						  M('bankinfo')->add($map);
                          $managerinfo->add($brok);
                          $accid['uid']=$uid;
                          M('accountinfo')->add($accid);
                          $info = '添加【'.I('post.utel').'】代理信息';
                          user_log($info,2);
                    }
                    redirect(U('Ordinary/agentlist'),1, '新增用户成功...');
                }
            }else{
                $this->error($userinfo->getError());
            }
    	}
    	//判断跳转到修改页面或者新增页面
            $uid = trim(I('get.uid'));
    		$user=M('userinfo')->where('uid='.$uid)->find();
    		$usermsg=M('managerinfo')->where('uid='.$uid)->find();
    		$user['brokerid']=$usermsg['brokerid'];
    		$user['mid']=$usermsg['mid'];
            $bankinfo = M('bankinfo')->where('uid='.$uid)->find();
            $this->assign('bankinfo',$bankinfo);
    		$this->assign('user',$user);
    	    $this->display();
    }
    
    //删除会员
    public function agentdel($uid='',$url='Ordinary/agentlist'){
    	$muserinfo = D('userinfo');
		$managerinfo = D('managerinfo');
		$maccountinfo = D('accountinfo');
		$mbankinfo = D('bankinfo');
		$userinfo = $muserinfo->where("uid=$uid")->delete();
		if($userinfo)
		{
			$anagerinfo = $managerinfo->where("uid=$uid")->delete();
			$accountinfo = $maccountinfo->where("uid=$uid")->delete();
			$bankinfo = $mbankinfo->where("uid=$uid")->delete();
			redirect(U($url),1, '删除用户成功...');
		}
		else
		{
			redirect(U($url),1, '删除用户失败...');
		}
    }

	public function memberlist()
    {
		$this->display();
    }
	public function memberadd()
    {
		$this->display();
    }
    //身份证号验证
    function checkIdCard($idcard){  
    // 只能是18位  
    if(strlen($idcard)!=18){ 
        $this->error("身份证号不正确，请重新输入"); 
        return false;  
    }  
    // 取出本体码  
    $idcard_base = substr($idcard, 0, 17);  
    // 取出校验码  
    $verify_code = substr($idcard, 17, 1);  
    // 加权因子  
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);  
    // 校验码对应值  
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');  
    // 根据前17位计算校验码  
    $total = 0;  
    for($i=0; $i<17; $i++){  
        $total += substr($idcard_base, $i, 1)*$factor[$i];  
    }  
    // 取模  
    $mod = $total % 11;  
  
    // 比较校验码  
    if($verify_code == $verify_code_list[$mod]){  
        return true;  
    }else{  
        $this->error("身份证号不正确，请重新输入");
        return false;  
     }  
    } 
	public function agentdown()
	{
		$oid = $_REQUEST['uid'];
		$count =M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=1 and vertus = 1')->count();
		// var_dump($count);die;
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
		$ulist=M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=1 and vertus = 1')->limit($page->firstRow.','.$page->listRows)->select();
		foreach($ulist as $key=>$val)
		{
			$num = M('userinfo')->where('oid='.$val['uid'].' and ustatus=0 and otype=0 and vertus = 1')->count();
			$ulist[$key]['num'] = $num;
		}
        $this->assign('ulist',$ulist);
        $this->assign('page',$show);
		$this->display();
	}
	public function agentdown1()
	{
		$oid = $_REQUEST['uid'];
		$count =M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=0 and vertus = 1')->count();
		// var_dump($count);die;
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
		$ulist=M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=0 and vertus = 1')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('ulist',$ulist);
        $this->assign('page',$show);
		$this->display();
	}
	public function showpre()
	{
		$starttime=strtotime(date('Y-m-d', strtotime(I('post.StartTime'))));
        $endtime=strtotime(date('Y-m-d 24:00:00', strtotime(I('post.EntTime'))));
		if($_REQUEST['StartTime'])
		{
			$str .= " and jtime > '".$starttime."'";
			$str1 .= " and bptime > '".$endtime."'";
		}
		if($_REQUEST['search'])
		{
			$str .= " and jtime < '".$starttime."'";
			$str1 .= " and bptime < '".$endtime."'";
		}
		$uid = $_REQUEST['uid'];
		$map['sumyk']=M("journal")->where("uid =".$uid.' $str')->sum('jploss');
		$map['sumsxf']=M("journal")->where("uid =".$uid.' $str')->sum('jfee');
		$map['sumbla']=M("balance")->where("uid =".$uid." and bptype='充值'".$str1)->sum('bpprice');
		echo  json_encode($map,true);
	}
}