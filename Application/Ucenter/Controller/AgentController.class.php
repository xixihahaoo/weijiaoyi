<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class AgentController extends CommonController{
    //代理1
	public function agent_one()
	{
		$muser_info = M('userinfo');
		if($_GET['StartTime'] && $_GET['EntTime']){	
			$star_date = strtotime($_GET['StartTime']);
		    $end_date = strtotime($_GET['EntTime']);
			$uinfo_where['user2.utime'] = array('between',array($star_date,$end_date));
		}else if($_GET['StartTime']){
			$star_date = strtotime($_GET['StartTime']);
			$uinfo_where['user2.utime'] = array('between',array($star_date,time()));	
		}else if($_GET['EntTime']){
		    $end_date = strtotime($_GET['EntTime']);			
			$uinfo_where['user2.utime'] = array('between',array(0,$end_date));		
		}
		if($_GET['search'])
		{
			$uinfo_where['user2.username']=array("like","%".$_GET['search']."%");
		}
		if($_GET['unit_id'])
		{
			$uinfo_where['user2.unit_id']=array("eq",$_GET['unit_id']);
		}
		$mem_where['otype'] = array('eq',2);
		$mem_where['operate_id'] = array('eq',$_SESSION['cuid']);
		$mem_list = $muser_info->where($mem_where)->select();
		$uinfo_where['user1.operate_id'] = array('eq',$_SESSION['cuid']);
		$uinfo_where['user2.otype'] = array('eq',4);
		$count = $muser_info->where($uinfo_where)->field('user2.*,user1.username as username1')->table('wp_userinfo user1')
		->join("join wp_userinfo user2 on user1.uid = user2.unit_id")
		->count();
		$page	=	new \Think\Page($count,10); 
		$agent_one = $muser_info->where($uinfo_where)->field('user2.*,user1.username as username1')->table('wp_userinfo user1')
		->join("join wp_userinfo user2 on user1.uid = user2.unit_id")
		->limit($page->firstRow.','.$page->listRows)
		->select();
		foreach($agent_one as &$list_agone)
		{
			$list_agone['mem_num'] = $this->two_num($list_agone['uid']);
		}
		$page = $page->show();
		$this->assign("mem_list",$mem_list);
		$this->assign("page",$page);
		$this->assign('agent_one', $agent_one);
        $this->display();
	}
	//代理2
	public function agent_two()
	{
		$muser_info = M('userinfo');
		if($_GET['StartTime'] && $_GET['EntTime']){	
			$star_date = strtotime($_GET['StartTime']);
		    $end_date = strtotime($_GET['EntTime']);
			$uinfo_where['user3.utime'] = array('between',array($star_date,$end_date));
		}else if($_GET['StartTime']){
			$star_date = strtotime($_GET['StartTime']);
			$uinfo_where['user3.utime'] = array('between',array($star_date,time()));	
		}else if($_GET['EntTime']){
		    $end_date = strtotime($_GET['EntTime']);			
			$uinfo_where['user3.utime'] = array('between',array(0,$end_date));		
		}
		if($_GET['search'])
		{
			$uinfo_where['user3.username']=array("like","%".$_GET['search']."%");
		}

		if($_SESSION['userotype'] == 5)
		{
			if($_GET['unit_id'])
			{
				$uinfo_where['user3.unit_id']=array("eq",$_GET['unit_id']);
				$agent_where['otype'] = array('eq',4);
				$agent_where['unit_id'] = array('eq',$_GET['unit_id']);
				$agent_list = $muser_info->where($agent_where)->select();
				$this->assign("agent_list",$agent_list);
			}
			if($_GET['leaguer_id'])
			{
				$uinfo_where['user3.leaguer_id']=array("eq",$_GET['leaguer_id']);
			}
			$mem_where['otype'] = array('eq',2);
			$mem_where['operate_id'] = array('eq',$_SESSION['cuid']);
			$mem_list = $muser_info->where($mem_where)->select();
			$uinfo_where['user1.operate_id'] = array('eq',$_SESSION['cuid']);
			$uinfo_where['user3.otype'] = array('eq',1);
			$count = $muser_info->where($uinfo_where)->field('user3.*,user2.username as username1')->table('wp_userinfo user1')
			->join("join wp_userinfo user2 on user1.uid = user2.unit_id")
			->join("join wp_userinfo user3 on user2.uid = user3.leaguer_id")
			->count();
			$page	=	new \Think\Page($count,10); 
			$agent_one = $muser_info->where($uinfo_where)->field('user3.*,user2.username as username1')->table('wp_userinfo user1')
			->join("join wp_userinfo user2 on user1.uid = user2.unit_id")
			->join("join wp_userinfo user3 on user2.uid = user3.leaguer_id")
			->limit($page->firstRow.','.$page->listRows)
			->select();
			$this->assign("mem_list",$mem_list);
		}
		else if($_SESSION['userotype'] == 2)
		{
			if($_GET['leaguer_id'])
			{
				$uinfo_where['user2.leaguer_id']=array("eq",$_GET['leaguer_id']);
			}
			$agent_where['otype'] = array('eq',4);
			$agent_where['unit_id'] = array('eq',$_SESSION['cuid']);
			$agent_list = $muser_info->where($agent_where)->select();
			$uinfo_where['user1.unit_id'] = array('eq',$_SESSION['cuid']);
			$uinfo_where['user2.otype'] = array('eq',1);
			$count = $muser_info->where($uinfo_where)->field('user2.*,user1.username as username1')->table('wp_userinfo user1')
			->join("join wp_userinfo user2 on user1.uid = user2.leaguer_id")
			->join("join wp_bankinfo bank on bank.uid = user2.uid")
			->count();
			$page	=	new \Think\Page($count,10); 
			$agent_one = $muser_info->where($uinfo_where)->field('user2.*,user1.username as username1')->table('wp_userinfo user1')
			->join("join wp_userinfo user2 on user1.uid = user2.leaguer_id")
			->limit($page->firstRow.','.$page->listRows)
			->select();
			$this->assign("agent_list",$agent_list);
		}
		else
		{
			$this->error('您没有权限');
		}
		foreach($agent_one as &$list_agone)
		{
			$list_agone['mem_num'] = $this->mem_num($list_agone['uid']);
		}
		$page = $page->show();
		$this->assign("page",$page);
		$this->assign('agent_one', $agent_one);
        $this->display();
	}
	//添加代理2
	public function add_agent_two($type=1)
	{
        $myuid = $_SESSION['cuid'];
		$userinfo = D('userinfo');
    	if (IS_POST) {
	    	$uid=I('post.uid');
	    	$managerinfo=M('managerinfo');
            // 自动验证 创建数据集
            if ($userinfo->create()) {
               //验证身份证正确性
               if($uid!=''){
                    //修改
					$leaguer_id = explode(',',I('post.leaguer_id')); 
                    $data['managername']=$leaguer_id[1];
                    /*手续费返点*/
                    $feerebate = trim(I('post.feerebate'));
                    if(isset($feerebate))
                    {
                      if($feerebate < 0 || $feerebate > I('post.input_profit'))
                      {
                         $this->error('手续费返点 设置不正确');
                      }
                    }

                    $data['utel']=I('post.utel');
                    $data['utime']=date(time());
                    $data['upwd']=md5('123456');
                    $data['address']=I('post.address');
					$data['comname']=I('post.comname');
					$data['linkman']=I('post.linkman');
					$data['rebate']=I('post.rebate');
					$data['feerebate']=I('post.feerebate');
                    $data['otype']=1;
                    $data['oid']=$leaguer_id[0];
                    $data['leaguer_id']=$leaguer_id[0];
					if($_SESSION['userotype'] == 5)
					{
						$unit_id = explode(',',I('post.unit_id')); 
						$data['operate_id'] = $myuid;
						$data['unit_id'] = $unit_id[0];
						if(!I('post.leaguer_id'))
						{
							$data['oid'] = $unit_id[0];
							$data['managername']=$unit_id[1];
							$data['leaguer_id'] = NULL;
						    $data['otype'] = 4;
						}
					}
                    if ($userinfo->where("uid=$uid")->save($data)) 
					{
                        $brok['brokerid']=I('post.brokerid');
                        $managerinfo->where("uid=$uid")->save($brok);
						$map['bankname'] = I('bankname');
						$map['province'] = I('province');
						$map['busername'] = I('busername');
						$map['banknumber']   = I('banknumber');
						$map['city'] = I('city');
						M('bankinfo')->where('uid='.$uid)->save($map);
						if(!I('post.leaguer_id'))
						{
							redirect(U('Agent/agent_one'),1, '修改用户成功...');
						}
						else
						{
							redirect(U('Agent/agent_two'),1, '修改用户成功...');
						}
                    }
					else
					{
						$this->error('修改失败...');
					}
                    
                }else{
                    //添加
                    $user=$userinfo->field('username,operate_id,unit_id')->where('uid='.$myuid)->find();
					$leaguer_id = explode(',',I('post.leaguer_id')); 
                    $data['managername']=$leaguer_id[1];
                    $data['username']=I('post.username');
                    $flag = preg_match('/[\x{4e00}-\x{9fa5}]+/u',$data['username']);
                    if($flag){
                        $this->error('姓名不能用汉字，请使用英文和数字');
                    }
                    /*手续费返点*/
                    $feerebate = trim(I('post.feerebate'));
                    if(isset($feerebate))
                    {
                      if($feerebate < 0 || $feerebate > I('post.input_profit'))
                      {
                         $this->error('手续费返点 设置不正确');
                      }
                    }

                    $data['utel']=I('post.utel');
                    $data['utime']=date(time());
                    $data['upwd']=md5('123456');
                    $data['address']=I('post.address');
					$data['comname']=I('post.comname');
					$data['rebate']=I('post.rebate');
					$data['linkman']=I('post.linkman');
					$data['feerebate']=I('post.feerebate');
                    $data['otype']=1;
                    $data['oid']=$leaguer_id[0];
                    $data['operate_id']=$user['operate_id'];
                    $data['unit_id']=$myuid;
                    $data['leaguer_id']=$leaguer_id[0];
					if($_SESSION['userotype'] == 5)
					{
						$unit_id = explode(',',I('post.unit_id')); 
						$data['operate_id'] = $myuid;
						$data['unit_id'] = $unit_id[0];
						if(!I('post.leaguer_id'))
						{
							$data['oid'] = $unit_id[0];
							$data['managername']=$unit_id[1];
							$data['leaguer_id'] = NULL;
						    $data['otype'] = 4;
						}
					}
                    if ($uid = $userinfo->add($data)) 
					{
						$map['bankname'] = I('bankname');
						$map['province'] = I('province');
						$map['busername'] = I('busername');
						$map['banknumber']   = I('banknumber');
						$map['city'] = I('city');
						$map['uid'] = $uid;
						M('bankinfo')->add($map);
                        $brok['uid']=$uid;
                        $brok['brokerid']=I('post.brokerid');
                        $managerinfo->add($brok);
                        $accid['uid']=$uid;
                        M('accountinfo')->add($accid);
						if(!I('post.leaguer_id'))
						{
							redirect(U('Agent/agent_one'),1, '添加用户成功...');
						}
						else
						{
							redirect(U('Agent/agent_two'),1, '添加用户成功...');
						}
                    }
					else
					{
						$this->error('新增用户失败...');
					}
                }
            }else{
                $this->error($userinfo->getError());
            }
    	}
		else
		{
			if($_SESSION['userotype'] == 5)
			{	
				$mem_where['user1.otype'] = array('eq',2);
				$mem_where['user1.operate_id'] = array('eq',$myuid);
				$mem_list = $userinfo->where($mem_where)->table('wp_userinfo user1')
				->join("join wp_bankinfo bank on user1.uid = bank.uid")
				->select();
				$this->assign("mem_list",$mem_list);
			}
			else if($_SESSION['userotype'] == 2)
			{
				$agone_where['user1.otype'] = array('eq',4);
				$agone_where['user1.unit_id'] = array('eq',$myuid);
				$agent_one_list = $userinfo->where($agone_where)->table('wp_userinfo user1')
				->join("join wp_bankinfo bank on user1.uid = bank.uid")
				->select();
				$this->assign("agent_one_list",$agent_one_list);
			}
		}
    	$this->display();
	}
	
	//修改代理2
	public function save_agent_two($uid="",$type=1)
	{
		if(!($uid && $type))
		{
			$this->error('无法获取用户信息...');
		}
		$muserinfo = D('userinfo');
		$myuid = $_SESSION['cuid'];
		$user_info = $muserinfo->where("user1.uid=$uid")->field('user1.*,mana.brokerid,user2.uid as uid2,user2.username as username2,bank.*')->table('wp_userinfo user1')
		->join("left join wp_managerinfo mana on user1.uid = mana.uid")
		->join("left join wp_userinfo user2 on user1.unit_id = user2.uid")
		->join("left join wp_bankinfo bank on user1.uid = bank.uid")
		->find();
		if(!$user_info)
		{
			$this->error('无法获取用户信息1...');
		}
		if($_SESSION['userotype'] == 5)
		{
			$mem_where['otype'] = array('eq',2);
			$mem_where['operate_id'] = array('eq',$myuid);
			$mem_list = $muserinfo->where($mem_where)->select();
			$this->assign("mem_list",$mem_list);
			
			$agone_where['otype'] = array('eq',4);
			$agone_where['unit_id'] = array('eq',$user_info['uid2']);
			$agent_one_list = $muserinfo->where($agone_where)->select();

		}
		else if($_SESSION['userotype'] == 2)
		{
			$agone_where['otype'] = array('eq',4);
			$agone_where['unit_id'] = array('eq',$myuid);
			$agent_one_list = $muserinfo->where($agone_where)->select();
		}
		$this->assign("user_info",$user_info);
		$this->assign("agent_one_list",$agent_one_list);
		$this->display();
	}
	
	//删除代理2
	public function del_agent_two($uid="",$type=1)
	{
		$muserinfo = M('userinfo');
		$managerinfo = M('managerinfo');
		$maccountinfo = M('accountinfo');
		$mbankinfo = M('bankinfo');
		$userinfo = $muserinfo->where("uid=$uid")->delete();
		if($userinfo)
		{
			$managerinfo->where("uid=$uid")->delete();
			$maccountinfo->where("uid=$uid")->delete();
			$mbankinfo->where("uid=$uid")->delete();
			if($type == 1)
			{
				redirect(U('Agent/agent_one'),1, '删除用户成功...');
			}
			else
			{
				redirect(U('Agent/agent_two'),1, '删除用户成功...');
			}
		}
		else
		{
			redirect(U('Agent/agent_two'),1, '删除用户失败...');
		}
	}
	
	public function ajax_agent($val='',$type=1)
	{
		if(!$val)
		{
			return ;
		}
		$userinfo = M('userinfo');
		$leaguer_id = explode(',',$val); 
		$agone_where['otype'] = array('eq',4);
		$agone_where['unit_id'] = array('eq',$leaguer_id[0]);
		$agent_one_list = $userinfo->where($agone_where)->select();
		$this->assign("agent_one_list",$agent_one_list);
		$this->assign("type",$type);
		$this->display();
	}
	
	public function upstatus(){
		$id=$_REQUEST['id'];
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
	}
	
	public function mem_num($uid)
	{
		$mem_where['oid'] = array('eq',$uid);
		$mem_where['otype'] = array('eq',0);
		return M("userinfo")->where($mem_where)->count();
	}
	
	public function two_num($uid)
	{
		$mem_where['oid'] = array('eq',$uid);
		$mem_where['otype'] = array('eq',1);
		return M("userinfo")->where($mem_where)->count();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}