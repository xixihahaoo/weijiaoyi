<?php
namespace Admin\Controller;
use Think\Controller;

class BranchController extends Controller {

	public function index()
	{
        $user= A('Admin/User');
        $user->checklogin();

		$userObj = M('userinfo a');
		
		$map['a.otype'] = 7;

		$phone 		= trim(I('get.phone'));
		$username 	= trim(I('get.username'));
		$starttime 	= trim(I('get.starttime'));
		$endtime 	= trim(I('get.endtime'));

		if($phone)
		{
			$map['a.utel']  = $phone;
			$sea['phone'] = $phone;
		}

		if($username)
		{
			$map['a.username'] = array('like','%'.$username.'%');
			$sea['username'] = $username;
		}

		if($starttime && $endtime)
		{
			$start_time 	  = strtotime($starttime);
			$end_time		  = strtotime($endtime)+24*60*60-1;
			$map['a.utime'] 	  = array('between',''.$start_time.','.$end_time.'');
			$sea['starttime'] = $starttime;
			$sea['endtime']	  = $endtime;
		}

        $count = $userObj->where($map)->count();   //总数量
        $pagecount = 10;
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
        $field = 'a.*,b.balance';
		$ulist = $userObj->field($field)->where($map)->join('inner join wp_accountinfo b on a.uid = b.uid')->limit($page->firstRow, $page->listRows)->select();

		$this->assign('page',$show);
		$this->assign('sea',$sea);
		$this->assign('ulist',$ulist);
		$this->display();
	}

	/**
	 * 修改信息
	 * @author  wang <[990529346@qq.com address]>
	 */
    public function mupdate(){
        $user = A('Admin/User');
        $user->checklogin();

        $userObj 	= M('userinfo');
        $bankObj 	= M('bankinfo');
        $accountObj = M('accountinfo');

        if(IS_POST)
        {
        	$uid 				= trim(I('post.uid'));
        	$usesr['utel'] 		= trim(I('post.utel'));
        	$users['address'] 	= trim(I('post.address'));
        	$users['comname'] 	= trim(I('post.comname'));
        	// $users['linkman'] 	= trim(I('post.linkman'));
        	$users['feerebate'] = trim(I('post.feerebate'));

        	$bank['bankname'] 	= trim(I('post.bankname'));
        	$bank['province'] 	= trim(I('post.province'));
        	$bank['city'] 		= trim(I('post.city'));
        	$bank['banknumber'] = trim(I('post.banknumber'));
        	$bank['busername'] 	= trim(I('post.busername'));

        	$balance 	= trim(I('post.balance'));
        	$upwd 		= trim(I('post.upwd'));
        	$rpwd 		= trim(I('post.rpwd'));

        	if($userObj->where(array('uid' => $uid))->find())
        	{
        		$save_user = $userObj->where('uid = '.$uid.'')->save($users);
        	}

        	if($bankObj->where(array('uid' => $uid))->find())
        	{
        		$save_bank = $bankObj->where('uid = '.$uid.'')->save($bank);
        	} else {
        		$bank['uid'] = $uid;
        		$save_bank = $bankObj->add($bank);
        	}

        	if($upwd)
        	{
	        	if($upwd != $rpwd)
	        	{
	        		$this->error('两次密码不一致，请重新修改');
	        	}

	        	$save_pwd = $userObj->where('uid = '.$uid.'')->setField('upwd',md5($upwd));
        	}


        	if($balance)
        	{	
        		$save_balance = $accountObj->where('uid = '.$uid.'')->setInc('balance',$balance);
        		if($save_balance)
        		{
        			$data = $userObj->where(array('uid' => $uid))->find();
        			if($balance > 0)
        			{
        				$remarks = '账户加款';

        			} else {
        				$remarks = '账户扣款';
        			}
                    $datas['bptype']  	 = '充值';
                    $datas['bptime']  	 = time();
                    $datas['bpprice'] 	 = $balance;
                    $datas['remarks'] 	 = $remarks;
                    $datas['uid'] 	  	 = $uid;
                    $datas['isverified'] = 1;
                    $datas['cltime'] 	 = time();
                    $datas['shibpprice'] = $data['balance'];
                    $datas['pay_type'] 	 = 0;//支付类型，0手动
                    $datas['b_type'] 	 = 1;
                    $datas['balanceno']	 = "SD".time();
                    M("balance")->add($datas);

                    $money_log['uid'] 			= $uid;
                    $money_log['type'] 			= 4;//充值
                    $money_log['oid'] 			= 0;
                    $money_log['note'] 			= '管理员对['.$data['username'].']'.$remarks.''.$balance.'元';
                    $money_log['op_id'] 		= $_SESSION['userid']?$_SESSION['userid']:0;
                    $money_log['user_type'] 	= 7; //分部
                    $money_log['change_money'] 	= $balance;
                    $money_log['balance'] 		= $data['balance'];
                    $money_log['dateline'] 		= time();
                    $money_log['tempdate'] 		= date('Y-m-d H:i:s');
                    M('money_flow')->add($money_log);
                    user_log($remarks,2);
        		}
        	}

        	if($save_user || $save_bank || $save_pwd || $save_balance)
        	{
        		$this->success('修改成功');
        	} else {
        		$this->error('修改失败');
        	}


        } else {
	        $uid 	 = trim(I('get.uid'));
	        $map['uid'] = $uid;

	        $ult 	    = $userObj->where($map)->find();
	        $bankinfo   = $bankObj->where($map)->find();
	        $account 	= $accountObj->field('balance')->where($map)->find();

	        $this->assign('us',$ult);
	        $this->assign('bankinfo',$bankinfo);
	        $this->assign('accountinfo',$account);
	        $this->display();
        }
    }

    /**
     * 添加交易所分部
     * @author wang <[990529346@qq.com address]>
     */
    public function add()
    {
    	if(IS_POST)
    	{
    		$userObj 	= M('userinfo');
    		$bankObj 	= M('bankinfo');
    		$accountObj = M('accountinfo');

    		$user['username'] 	= trim(I('post.username'));
    		    		
    		$user['utel'] 		= trim(I('post.utel'));

    		$user['address'] 	= trim(I('post.address'));

    		$user['comname'] 	= trim(I('post.comname'));

    		$user['feerebate'] 	= trim(I('post.feerebate'));

    		$user['upwd'] 		= trim(I('post.upwd'));

    		$user['otype']		= 7;

    		$user['utime']		= time();

    		$user['oid']		= session('userid');

    		$rpwd				= trim(I('post.rpwd'));

    		$bank['bankname'] 	= trim(I('post.bankname'));

    		$bank['province'] 	= trim(I('post.province'));

    		$bank['city'] 		= trim(I('post.city'));

    		$bank['banknumber'] = trim(I('post.banknumber'));

    		$bank['busername'] 	= trim(I('post.busername'));


    		if(empty($user['username']))
    		{
    			$this->error('机构编号不能为空');
    		}

    		if(empty($user['utel']))
    		{
    			$this->error('电话号码不能为空');
    		}

    		if(empty($bank['bankname']))
    		{
    			$this->error('所属银行不能为空');
    		}

			if(empty($bank['banknumber']))
    		{
    			$this->error('银行卡号不能为空');
    		}

			if(empty($bank['busername']))
    		{
    			$this->error('持卡人不能为空');
    		}

			if(empty($user['upwd']))
    		{
    			$this->error('密码不能为空');
    		}

    		if($user['upwd'] != $rpwd)
    		{
    			$this->error('两次密码不一致，请重新修改');
    		}
            $user['upwd'] = md5($user['upwd']);
    		$result = $userObj->add($user);
    		if($result)
    		{
    			$bank['uid'] 	= $result;
    			$account['uid'] = $result;
    			if($bankObj->add($bank) && $accountObj->add($account))
    			{
    				$this->success('添加成功');
    			}
    		}

    	} else {

    		$this->display();
    	}
    }

    /**
     * 查看运营中心
     * @author wang <[990529346@qq.com address]>
     */
    public function show_operate()
    {
        $uid     = trim(I('get.uid'));
        $userObj = M('userinfo a');

        $count = $userObj->where(array('a.branch_id' => $uid,'a.otype' => 5))->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $userinfo = $userObj->field('a.uid,a.username,a.utel,a.lastlog,a.utime,b.balance')->join('inner join wp_accountinfo as b on a.uid=b.uid')->where(array('a.branch_id' => $uid,'a.otype' => 5))->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign('page',$show);
        $this->assign('info',$userinfo);
        $this->display();
    }
}
