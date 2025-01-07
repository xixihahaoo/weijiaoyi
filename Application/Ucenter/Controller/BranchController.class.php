<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class BranchController extends CommonController{
 
    /**
     * 运营中心列表
     * @author  wang <[990529346@qq.com address]>
     * @return [type] [description]
     */
    public function operate(){
    	$userObj = M('userinfo a');
    	$uid 	 = session('cuid');

    	$starttime = trim(I('post.StartTime'));
    	$endtime   = trim(I('post.EntTime'));
    	$username  = trim(I('post.username'));

    	if($starttime && $endtime)
    	{
    		$start_time = strtotime($starttime);
    		$end_time 	= strtotime($endtime);
    		$map['a.utime']   = array('between',array($start_time,$end_time));
    		$sea['StartTime'] = $starttime;
    		$sea['EntTime']	  = $endtime; 
    	}

    	if($username)
    	{
    		$map['a.username'] = $username;
    		$sea['username']   = $username;
    	}

    	$map['a.branch_id'] 	= $uid;
    	$map['a.otype'] = 5;


        $count = $userObj->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();


    	$field = 'a.*,b.balance';
    	$ulist = $userObj->field($field)->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign('page',$show);
    	$this->assign('sea',$sea);
    	$this->assign('ulist',$ulist);
    	$this->display();
    }


    /**
     * 添加运营中心
     * @author wang <[990529346@qq.com  address]>
     */
    public function operate_add()
    {
    	if(IS_POST)
    	{
    		$userObj 	= M('userinfo');
    		$accountObj = M('accountinfo');
    		$bankObj 	= M('bankinfo');

    		$user['username'] 	= trim(I('post.username'));
    		$user['utel'] 		= trim(I('post.utel'));
    		$user['address'] 	= trim(I('post.address'));
    		$user['linkman'] 	= trim(I('post.linkman'));
    		$user['comname'] 	= trim(I('post.comname'));
    		$user['feerebate'] 	= trim(I('post.feerebate'));
    		$user['pwd'] 		= md5(123456);
    		$user['otype']		= 5;
    		$user['utime']		= time();
    		$user['oid']		= session('cuid');
    		$user['branch_id']	= session('cuid');
    		$user['managername'] = session('newusername');

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
    			$this->error('收款人不能为空');
    		}
    		$result = $userObj->add($user);
    		if($result)
    		{
    			$bank['uid'] 	= $result;
    			$account['uid'] = $result;
    			if($bankObj->add($bank) && $accountObj->add($account))
    			{
    				$this->success('添加成功','operate');
    			} else {
    				$this->error('添加失败');
    			}
    		}

    	} else {
    		$this->display();
    	}
    }

    /**
     * 修改运营中心
     * @author wang <[990529346@qq.com address]>
     */
    public function operate_save()
    {
    	$userObj = M('userinfo a');

    	if(IS_POST)
    	{
    		$uid 				= trim(I('post.uid'));
    		$user['utel'] 		= trim(I('post.utel'));
    		$user['address'] 	= trim(I('post.address'));
    		$user['linkman'] 	= trim(I('post.linkman'));
    		$user['comname'] 	= trim(I('post.comname'));
    		$user['feerebate'] 	= trim(I('post.feerebate'));

    		$bank['bankname'] 	= trim(I('post.bankname'));
    		$bank['province'] 	= trim(I('post.province'));
    		$bank['city'] 		= trim(I('post.city'));
    		$bank['banknumber'] = trim(I('post.banknumber'));
    		$bank['busername'] 	= trim(I('post.busername'));

    		$user_result = M('userinfo')->where(array('uid' => $uid))->save($user);
			$bank_result = M('bankinfo')->where(array('uid' => $uid))->save($bank);
			if($user_result || $bank_result)
			{
				$this->success('修改成功','operate');
			} else{
				$this->error('修改失败');
			}

    	} else{
    		$uid 	= trim(I('get.uid'));
    		$user 	= $userObj->join('inner join wp_bankinfo b on a.uid = b.uid')->where(array('a.uid' => $uid))->find();
    		
    		$this->assign('user',$user);
    		$this->display();
    	}
    }

    /**
     * 会员单位
     * @author  wang <[990529346@qq.com address]>
     */
    public function unit_list()
    {
        $order = M('order');

        $StartTime = trim(I('post.StartTime'));
        $EntTime   = trim(I('post.EntTime'));
        if($StartTime && $EntTime)
        {
            $start_time = strtotime($StartTime);
            $end_time   = strtotime($EntTime);

            $str = " and utime between ".$start_time." and ".$end_time." ";
            $sea['StartTime'] = $StartTime;
            $sea['EntTime']   = $EntTime;
        }

        if($_REQUEST['search'])
        {
            $str = " and username like '%".$_REQUEST['search']."%'";
            $sea['search'] = $_REQUEST['search'];
        }

        $oid  = $_SESSION['cuid'];
        
        $unit = M('userinfo')->distinct(true)->field('uid')->where('branch_id in('.$oid.') and otype = 2')->select();
        $unitArr = array();
        foreach ($unit as $key => $value) {
            array_push($unitArr,$value['uid']);    
        }
        $uid = implode(',',$unitArr);

        //取出会员单位
        $count =M('userinfo')->where('uid in ('.$uid.') and otype=2 and vertus = 1'.$str)->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
        $ulist=M('userinfo')->where('user1.uid in('.$uid.') and user1.otype=2 and user1.vertus = 1'.$str)->field('user1.*')->table('wp_userinfo user1')
        ->limit($page->firstRow.','.$page->listRows)
        ->select();
        
        foreach($ulist as $k => &$v)
        {
            $v['num']           = M('userinfo')->where('oid='.$v['uid'].' and otype=4 and vertus = 1')->count();
            $v['balance']       = M('accountinfo')->where("uid={$v['uid']}")->getField('balance');
            $v['superior_name'] = M('userinfo')->where('operate_id='.$v['operate_id'].'')->getField('username');
        }

        $this->assign('sea',$sea);
        $this->assign('ulist',$ulist);
        $this->assign('page',$show);
        $this->display();
    }


    /**
     * 修改会员单位
     * @author  wang <[990529346@qq.com address]>
     */
    public function unit_save()
    {
        $userObj = M('userinfo a');

        if(IS_POST)
        {
            $uid                = trim(I('post.uid'));
            $user['utel']       = trim(I('post.utel'));
            $user['address']    = trim(I('post.address'));
            $user['linkman']    = trim(I('post.linkman'));
            $user['comname']    = trim(I('post.comname'));
            $user['feerebate']  = trim(I('post.feerebate'));

            $bank['bankname']   = trim(I('post.bankname'));
            $bank['province']   = trim(I('post.province'));
            $bank['city']       = trim(I('post.city'));
            $bank['banknumber'] = trim(I('post.banknumber'));
            $bank['busername']  = trim(I('post.busername'));

            $user_result = M('userinfo')->where(array('uid' => $uid))->save($user);
            $bank_result = M('bankinfo')->where(array('uid' => $uid))->save($bank);
            if($user_result || $bank_result)
            {
                $this->success('修改成功','unit_list');
            } else{
                $this->error('修改失败');
            }

        } else{
            $uid    = trim(I('get.uid'));
            $user   = $userObj->join('inner join wp_bankinfo b on a.uid = b.uid')->where(array('a.uid' => $uid))->find();
            
            $cuid    = session('cuid');
            $operate = $userObj->where('a.otype=5 and a.branch_id in('.$cuid.')')->select();
            $this->assign('operate',$operate);

            $this->assign('user',$user);
            $this->display();
        }
    }

    /**
     * 添加会员单位
     * @author wang <[990529346@qq.com address]>
     */
    public function unit_add()
    {
        if(IS_POST)
        {
            $userObj    = M('userinfo');
            $accountObj = M('accountinfo');
            $bankObj    = M('bankinfo');

            $operate            = trim(I('post.operate')); 
            $user['username']   = trim(I('post.username'));
            $user['utel']       = trim(I('post.utel'));
            $user['address']    = trim(I('post.address'));
            $user['linkman']    = trim(I('post.linkman'));
            $user['comname']    = trim(I('post.comname'));
            $user['feerebate']  = trim(I('post.feerebate'));
            $user['pwd']        = md5(123456);
            $user['otype']      = 2;
            $user['utime']      = time();
            $user['oid']         = $operate;
            $user['operate_id']  = $operate;
            $user['branch_id']   = session('cuid');
            $user['managername'] = $userObj->where(array('uid' => $operate))->getField('username');

            $bank['bankname']   = trim(I('post.bankname'));
            $bank['province']   = trim(I('post.province'));
            $bank['city']       = trim(I('post.city'));
            $bank['banknumber'] = trim(I('post.banknumber'));
            $bank['busername']  = trim(I('post.busername'));

            if(empty($operate))
            {
                $this->error('运营中心不能为空');
            }

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
                $this->error('收款人不能为空');
            }
            $result = $userObj->add($user);
            if($result)
            {
                $bank['uid']    = $result;
                $account['uid'] = $result;
                if($bankObj->add($bank) && $accountObj->add($account))
                {
                    $this->success('添加成功','unit_list');
                } else {
                    $this->error('添加失败');
                }
            }

        } else {
            $cuid    = session('cuid');
            $operate = M('userinfo')->where('otype=5 and branch_id in('.$cuid.')')->select();
            $this->assign('operate',$operate);
            $this->display();
        }
    }

    /**
     * 代理1列表
     * @author wang <[990529346@qq.com address]>
     */
    public function agent_one()
    {
        $userObj = M('userinfo a');

        $map['a.branch_id'] = session('cuid');
        $map['a.otype']     = 4;

        $StartTime  = trim(I('get.StartTime'));
        $EntTime    = trim(I('get.EntTime'));
        $search     = trim(I('get.search'));
        $unit_id    = trim(I('get.unit_id'));


        if($StartTime && $EntTime)
        {
            $starttime = strtotime($StartTime);
            $endtime   = strtotime($EntTime);
            $map['a.utime'] = array('between',array($starttime,$endtime));
            $sea['StartTime'] = $StartTime;
            $sea['EntTime']   = $EntTime;
        }

        if($search)
        {
            $map['a.username'] = array('like','%'.$search.'%');
            $sea['search']     = $search;
        }

        if($unit_id)
        {
            $map['a.unit_id'] = $unit_id;
            $sea['unit_id']   = $unit_id;
        }


        $count = $userObj->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();


        $field = 'a.*,b.balance';
        $ulist = $userObj->field($field)->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        $ulistArr = array();
        foreach ($ulist as $key => $value) {
            array_push($ulistArr,$value['unit_id']);
        }
        
        $ulistId   = implode(',',array_unique($ulistArr));
        $unit_data = M('userinfo')->field('uid,username')->where('uid in('.$ulistId.')')->select();
        $unitArr   = array();
        foreach ($unit_data as $key => $value) {
             $unitArr[$value['uid']] = $value;
         } 

        foreach ($ulist as $key => $value) {
            $ulist[$key]['unit_name'] = $unitArr[$value['unit_id']]['username'];
        }


        $this->assign('page',$show);
        $this->assign('sea',$sea);
        $this->assign('agent_one',$ulist);
        $this->assign('unit',M('userinfo')->field('uid,username')->where(array('branch_id' => session('cuid'),'otype' => 2))->select());
        $this->display();
    }

    /**
     * 添加代理1
     * @author  wang <[990529346@qq.com address]>
     */
    public function add_agent()
    {   
        $userObj    = M('userinfo');
        $accountObj = M('accountinfo');
        $bankObj    = M('bankinfo');

        $uid     = session('cuid');

        if(IS_POST) {

            $data['username'] = trim(I('post.username'));
            $flag = preg_match('/[\x{4e00}-\x{9fa5}]+/u',$data['username']);
            if($flag){
                $this->error('姓名不能用汉字，请使用英文和数字');
            }

            if(empty(trim(I('post.unit_id'))))
            {
                $this->error('上级不能为空');
            }

            if(empty(trim(I('post.username'))))
            {
                $this->error('机构编号不能为空');
            }

            if(empty(trim(I('post.utel'))))
            {
                $this->error('电话号码不能为空');
            }

            if(empty(trim(I('post.bankname'))))
            {
                $this->error('所属银行不能为空');
            }

            if(empty(trim(I('post.banknumber'))))
            {
                $this->error('银行卡号不能为空');
            }

            if(empty(trim(I('post.busername'))))
            {
                $this->error('收款人不能为空');
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

            $unit_id = trim(I('post.unit_id'));
            $user    = $userObj->field('username,uid,branch_id,operate_id,leaguer_id')->where('uid='.$unit_id)->find();


            $data['utel']       = trim(I('post.utel'));
            $data['utime']      = date(time());
            $data['upwd']       = md5('123456');
            $data['address']    = trim(I('post.address'));
            $data['comname']    = trim(I('post.comname'));
            $data['linkman']    = trim(I('post.linkman'));
            $data['feerebate']  = trim(I('post.feerebate'));
            $data['otype']      = trim(I('post.otype'));
            $data['managername']= $user['username'];
            $data['oid']        = $user['uid'];
            $data['branch_id']  = $user['branch_id'];
            $data['operate_id'] = $user['operate_id'];
            $data['unit_id']    = $user['uid'];

            if(trim(I('post.otype')) == 1)
            {
                $data['leaguer_id']    = $user['uid'];
                $url = 'agent_two';
            } else {
                $url = 'agent_one';
            }

            $result = $userObj->add($data);

            if($result)
            {
                $map['bankname']    = trim(I('post.bankname'));
                $map['province']    = trim(I('post.province'));
                $map['busername']   = trim(I('post.busername'));
                $map['banknumber']  = trim(I('post.banknumber'));
                $map['city']        = trim(I('post.city'));
                $map['uid']         = $result;

                $account['uid']     = $result;
                if($bankObj->add($map) && $accountObj->add($account)) {

                    redirect(U($url),1, '添加用户成功...');
                } else {
                    $this->error('新增用户失败...');
                }
            }

        } else {

            $this->assign('unit_data',$userObj->field('uid,username')->where(array('branch_id' => $uid,'otype' => 5))->select());
            $this->display();
        }
        
    }

    /**
     * 修改代理1
     * @author wang <[990529346@qq.com address]>
     */
    public function save_agent()
    {
        $userObj    = M('userinfo');
        $accountObj = M('accountinfo');
        $bankObj    = M('bankinfo');

        if(IS_POST) {


            if(empty(trim(I('post.utel'))))
            {
                $this->error('电话号码不能为空');
            }

            if(empty(trim(I('post.bankname'))))
            {
                $this->error('所属银行不能为空');
            }

            if(empty(trim(I('post.banknumber'))))
            {
                $this->error('银行卡号不能为空');
            }

            if(empty(trim(I('post.busername'))))
            {
                $this->error('收款人不能为空');
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


            $uid = trim(I('post.uid'));

            $data['utel']       = trim(I('post.utel'));
            $data['address']    = trim(I('post.address'));
            $data['comname']    = trim(I('post.comname'));
            $data['linkman']    = trim(I('post.linkman'));
            $data['feerebate']  = trim(I('post.feerebate'));

            $map['bankname']    = trim(I('post.bankname'));
            $map['province']    = trim(I('post.province'));
            $map['busername']   = trim(I('post.busername'));
            $map['banknumber']  = trim(I('post.banknumber'));
            $map['city']        = trim(I('post.city'));
            
            $result = $userObj->where(array('uid' => $uid))->save($data);
            $bank = $bankObj->where(array('uid' => $uid))->save($map);

            if(trim(I('post.otype')) == 1)
            {
                $url = 'agent_two';
            } else {
                $url = 'agent_one';
            }

            if($result || $bank) {

                redirect(U($url),1, '修改用户成功...');
            } else {
                $this->error('修改用户失败...');
            }

        } else {

            $uid    = trim(I('get.uid'));
            $result = M('userinfo a')->join('left join wp_bankinfo as b on a.uid = b.uid')->where(array('a.uid' => $uid))->find();
            $this->assign('user',$result);

            $name  = M('userinfo')->where(array('uid' => $result['oid']))->getField('username');
            $this->assign('name',$name);

            $this->assign('otype',I('get.otype'));
            $this->display();
        }
    }

    /**
     * 代理2列表
     * @author  wang <[990529346@qq.com address]>
     */
    
    public function agent_two()
    {
       $userObj = M('userinfo a');

        $map['a.branch_id'] = session('cuid');
        $map['a.otype']     = 1;

        $StartTime  = trim(I('get.StartTime'));
        $EntTime    = trim(I('get.EntTime'));
        $search     = trim(I('get.search'));
        $unit_id    = trim(I('get.unit_id'));


        if($StartTime && $EntTime)
        {
            $starttime = strtotime($StartTime);
            $endtime   = strtotime($EntTime);
            $map['a.utime'] = array('between',array($starttime,$endtime));
            $sea['StartTime'] = $StartTime;
            $sea['EntTime']   = $EntTime;
        }

        if($search)
        {
            $map['a.username'] = array('like','%'.$search.'%');
            $sea['search']     = $search;
        }

        if($unit_id)
        {
            $map['a.leaguer_id'] = $unit_id;
            $sea['unit_id']      = $unit_id;
        }


        $count = $userObj->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();


        $field = 'a.*,b.balance';
        $ulist = $userObj->field($field)->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        $ulistArr = array();
        foreach ($ulist as $key => $value) {
            array_push($ulistArr,$value['leaguer_id']);
        }

        $ulistId   = implode(',',array_unique($ulistArr));
        $unit_data = M('userinfo')->field('uid,username')->where('uid in('.$ulistId.')')->select();
        $unitArr   = array();
        foreach ($unit_data as $key => $value) {
             $unitArr[$value['uid']] = $value;
         }

        foreach ($ulist as $key => $value) {
            $ulist[$key]['unit_name'] = $unitArr[$value['leaguer_id']]['username'];
        }

        $this->assign('page',$show);
        $this->assign('sea',$sea);
        $this->assign('agent_one',$ulist);
        $this->assign('unit',M('userinfo')->field('uid,username')->where(array('branch_id' => session('cuid'),'otype' => 4))->select());
        $this->display(); 
    }

    /**
     * [recharge 出入金查询]
     * @return [type] [description]
     */
    public function recharge()
    {
        $balanceObj = M('balance a');
        $cuid       = session('cuid');

        $map['b.branch_id']     = $cuid;
        $map['b.otype']         = 0;
        $map['a.status']        = 1;
        $map['a.isverified']    = 1;


        $starttime  = trim(I('get.starttime'));
        $endtime    = trim(I('get.endtime'));
        $id         = trim(I('get.id'));
        $type       = trim(I('get.type'));
        $utel       = trim(I('get.utel'));
        $username   = trim(I('get.username'));

        if($starttime && $endtime)
        {
            $start_time         = strtotime($starttime);
            $end_time           = strtotime($endtime);
            $map['a.bptime']    = array('between',array($start_time,$end_time));
            $sea['starttime']   = $starttime;
            $sea['endtime']     = $endtime;
        }

        if($id)
        {
            $map['a.bpid'] = $id;
            $sea['id']     = $id;
        }

        if($type)
        {
            $map['a.bptype'] = $type;
            $sea['type']     = $type;
        }

        if($utel)
        {
            $map['b.utel'] = $utel;
            $sea['utel']   = $utel;
        }

        if($username)
        {
            $map['b.username'] = array('like','%'.$username.'%');
            $sea['username']   = $username;
        }


        $count = $balanceObj->join('wp_userinfo as b on a.uid = b.uid')->where($map)->count();

        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();

        $field = 'a.*,b.username,b.utel,b.otype';
        $rechargelist = $balanceObj->field($field)->join('wp_userinfo as b on a.uid = b.uid')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        
        $pay_type = array();
        foreach ($rechargelist as $key => $value) {
            array_push($pay_type,$value['pay_type']);
        }

        $payID    = implode(',',array_unique($pay_type));
        $pay_type = M()->table('dict_pay_type')->where('id in('.$payID.')')->select();
        $pay      = array();

        foreach ($pay_type as $key => $value) {
            $pay[$value['id']] = $value;
        }

        foreach ($rechargelist as $key => $value) {
           $rechargelist[$key]['bptime']    = date('Y-m-d H:i:s',$value['bptime']);
           $rechargelist[$key]['pay_type']  = $pay[$value['pay_type']]['pay_name'];
            switch ($value['otype']) {
                case 0:
                    $rechargelist[$key]['user_type'] = '普通用户';
                    break;
                case 1:
                    $rechargelist[$key]['user_type'] = '代理2';
                    break;
                case 4:
                    $rechargelist[$key]['user_type'] = '代理1';
                    break;
                case 2:
                    $rechargelist[$key]['user_type'] = '会员单位';
                    break;
                case 5:
                    $rechargelist[$key]['user_type'] = '运营中心';
                    break;
                default:
                    $rechargelist[$key]['user_type'] = '暂无';
                    break;
            }
        }

        $sea['bpprice'] = $balanceObj->join('wp_userinfo as b on a.uid = b.uid')->where($map)->sum('bpprice');

        $this->assign('sea',$sea);
        $this->assign('page',$show);
        $this->assign('rechargelist',$rechargelist);
        $this->display();
    }

    /**
     * [tradelist 成交明细]
     * @return [type] [description]
     */
    
    public function tradelist()
    {
        $userObj    = M('userinfo');
        $journalObj = M('journal');

        $starttime  = trim(I('get.starttime'));
        $endtime    = trim(I('get.endtime')); 
        $utel       = trim(I('get.utel'));

        if($starttime && $endtime)
        {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $map['jtime']     = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }


        if($utel){
            $where['utel'] = array('like','%'.$utel.'%');
            $sea['utel']   = $utel;
        }

        $where['otype']     = 0;
        $where['branch_id'] = session('cuid');
        $userData = $userObj->distinct(true)->field('uid')->where($where)->select();
        $uidArr   = array();
        foreach ($userData as $key => $value) {
            array_push($uidArr,$value['uid']);
        }
        $uid = implode(',',$uidArr);

        $map['jtype']   = '平仓';
        $map['th_uid']  = array('exp','is null');
        $map['uid']     = array('in',$uid);



        $count =  $journalObj->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();

        $journal = $journalObj->where($map)->limit($page->firstRow,$page->listRows)->select();
        $journalArr  = array();
        $journalArr1 = array();
        foreach ($journal as $key => $value) {
            array_push($journalArr, $value['uid']);
            array_push($journalArr1, $value['oid']);
        }

        /*用户信息*/
        $journalId = implode(',',array_unique($journalArr));
        $user      = $userObj->field('oid,uid,username,utel')->where('uid in('.$journalId.')')->select();
        $userArr2  = array();
        foreach ($user as $key => $value) {
            array_push($userArr2, $value['oid']);
        }

       /*上级用户*/
        $userId2  = implode(',',array_unique($userArr2));
        $user_top = $userObj->field('uid,username')->where('uid in('.$userId2.')')->select();
        $userArr3 = array();
        foreach ($user_top as $key => $value) {
            $userArr3[$value['uid']] = $value;
        }

        foreach ($user as $key => $value) {
            $user[$key]['opera_name'] = $userArr3[$value['oid']]['username'];
        }

        $userArr   = array();
        foreach ($user as $key => $value) {
            $userArr[$value['uid']] = $value;
        }


        /*建仓订单的信息*/
        $journalOid   = implode(',',array_unique($journalArr1));
        $journaljc    = $journalObj->field('oid,jaccess,jtime')->where('oid in('.$journalOid.') and jtype="建仓"')->select();
        $journaljcArr = array();
        foreach ($journaljc as $key => $value) {
            $journaljcArr[$value['oid']] = $value;
        }


        /*订单信息*/
        foreach ($journal as $key => $value) {

            $journal[$key]['jc_jtime']   = $journaljcArr[$value['oid']]['jtime'];
            $journal[$key]['jc_jaccess'] = $journaljcArr[$value['oid']]['jaccess'];
            $journal[$key]['username']   = $userArr[$value['uid']]['username'];
            $journal[$key]['utel']       = $userArr[$value['uid']]['utel'];
            $journal[$key]['opera_name'] = $userArr[$value['uid']]['opera_name'];
            switch ($value['jstate']) {
                case 0:
                    $journal[$key]['jstate'] = '亏损';
                    break;
                case 1:
                    $journal[$key]['jstate'] = '盈利';
                    break;
                case 2:
                    $journal[$key]['jstate'] = '平局';
                    break;
                default:
                    # code...
                    break;
            }
        }

        //统计信息
        $total['jaccess']   = $journalObj->where($map)->sum('jaccess');
        $total['count']     = $count;
        $total['jploss']    = $journalObj->where($map)->sum('jploss');
        $total['jfee']      = $journalObj->where($map)->sum('jfee');


        $this->assign('sea',$sea);
        $this->assign('total',$total);
        $this->assign('page',$show);
        $this->assign('order_list',$journal);
        $this->display();
    }

    /**
     * [special 由特会接管的订单]
     * @return [type] [description]
     */
    
    public function special()
    {
        $userObj    = M('userinfo');
        $journalObj = M('journal');

        $starttime  = trim(I('get.starttime'));
        $endtime    = trim(I('get.endtime')); 
        $utel       = trim(I('get.utel'));

        if($starttime && $endtime)
        {
            $start_time       = strtotime($starttime);
            $end_time         = strtotime($endtime);
            $map['jtime']     = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }


        if($utel){
            $where['utel'] = array('like','%'.$utel.'%');
            $sea['utel']   = $utel;
        }

        $where['otype']     = 0;
        $where['branch_id'] = session('cuid');
        $userData = $userObj->distinct(true)->field('uid')->where($where)->select();
        $uidArr   = array();
        foreach ($userData as $key => $value) {
            array_push($uidArr,$value['uid']);
        }
        $uid = implode(',',$uidArr);

        $map['jtype']   = '平仓';
        $map['th_uid']  = array('exp','is not null');
        $map['uid']     = array('in',$uid);



        $count =  $journalObj->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();

        $journal = $journalObj->where($map)->limit($page->firstRow,$page->listRows)->select();
        $journalArr  = array();
        $journalArr1 = array();
        foreach ($journal as $key => $value) {
            array_push($journalArr, $value['uid']);
            array_push($journalArr1, $value['oid']);
        }

        /*用户信息*/
        $journalId = implode(',',array_unique($journalArr));
        $user      = $userObj->field('oid,uid,username,utel')->where('uid in('.$journalId.')')->select();
        $userArr2  = array();
        foreach ($user as $key => $value) {
            array_push($userArr2, $value['oid']);
        }

       /*上级用户*/
        $userId2  = implode(',',array_unique($userArr2));
        $user_top = $userObj->field('uid,username')->where('uid in('.$userId2.')')->select();
        $userArr3 = array();
        foreach ($user_top as $key => $value) {
            $userArr3[$value['uid']] = $value;
        }

        foreach ($user as $key => $value) {
            $user[$key]['opera_name'] = $userArr3[$value['oid']]['username'];
        }

        $userArr   = array();
        foreach ($user as $key => $value) {
            $userArr[$value['uid']] = $value;
        }


        /*建仓订单的信息*/
        $journalOid   = implode(',',array_unique($journalArr1));
        $journaljc    = $journalObj->field('oid,jaccess,jtime')->where('oid in('.$journalOid.') and jtype="建仓"')->select();
        $journaljcArr = array();
        foreach ($journaljc as $key => $value) {
            $journaljcArr[$value['oid']] = $value;
        }


        /*订单信息*/
        foreach ($journal as $key => $value) {

            $journal[$key]['jc_jtime']   = $journaljcArr[$value['oid']]['jtime'];
            $journal[$key]['jc_jaccess'] = $journaljcArr[$value['oid']]['jaccess'];
            $journal[$key]['username']   = $userArr[$value['uid']]['username'];
            $journal[$key]['utel']       = $userArr[$value['uid']]['utel'];
            $journal[$key]['opera_name'] = $userArr[$value['uid']]['opera_name'];
            switch ($value['jstate']) {
                case 0:
                    $journal[$key]['jstate'] = '亏损';
                    break;
                case 1:
                    $journal[$key]['jstate'] = '盈利';
                    break;
                case 2:
                    $journal[$key]['jstate'] = '平局';
                    break;
                default:
                    # code...
                    break;
            }
        }

        //统计信息
        $total['jaccess']   = $journalObj->where($map)->sum('jaccess');
        $total['count']     = $count;
        $total['jploss']    = $journalObj->where($map)->sum('jploss');
        $total['jfee']      = $journalObj->where($map)->sum('jfee');


        $this->assign('sea',$sea);
        $this->assign('total',$total);
        $this->assign('page',$show);
        $this->assign('order_list',$journal);
        $this->display();
    }

    /**
     * [customerlist 客户列表]
     * @return [type] [description]
     */
    public function customerlist()
    {   
        $map['a.branch_id'] = session('cuid');
        $map['a.otype']     = 0;


        $starttime  = trim(I('get.starttime'));
        $endtime    = trim(I('get.endtime'));
        $phone      = trim(I('get.phone'));
        $username   = trim(I('get.username'));

        if($starttime && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);

            $map['a.utime']   = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

        if($phone)
        {
           $map['a.utel']   = $phone;
           $sea['phone']    = $phone;
        }

        if($username)
        {
            $map['a.username'] = array('like','%'.$username.'%');
            $sea['username']   = $username;
        }



        $count =  M('userinfo a')->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();

        $ulist    = M('userinfo a')->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->limit($page->firstRow,$page->listRows)->select();
        $superior = array();
        foreach ($ulist as $key => $value) {
            array_push($superior,$value['oid']);
        }
        
        $oid = implode(',',$superior);
        $superiorData = M('userinfo')->field('uid,username')->where('uid in('.$oid.')')->select();
        $superiorArr  = array();
        foreach ($superiorData as $key => $value) {
            $superiorArr[$value['uid']] = $value;
        }

        foreach ($ulist as $key => $value) {
            $ulist[$key]['superior'] = $superiorArr[$value['oid']]['username'];
        }

        $total['balance'] = M('userinfo a')->join('inner join wp_accountinfo b on a.uid = b.uid')->where($map)->sum('b.balance');


        $this->assign('total',$total);
        $this->assign('sea',$sea);
        $this->assign('page',$show);
        $this->assign('ulist',$ulist);
        $this->display();
    }




    /**
     * [ajax_get_brokers 获取下级信息]
     * @return [type] [description]
     */
    public function ajax_get_brokers(){
        if(IS_AJAX){
            $userobj         = M('userinfo');
            $field           = trim(I('get.field'));
            $parent_id       = trim(I('get.parent_id'));
            $otype           = trim(I('get.otype'));

            $res = $userobj->where(array($field => $parent_id,'otype' => $otype))->select();

            $data=array('msg'=>'成功','status'=>1,'data'=>$res);
            $this->AjaxReturn($data);
        }
        $this->error('您访问的页面不存在','index/index');
    }

    public function inverse($number)
    {
        if($number > 0)
        {
            return (0 - $number);
        }
        else
        {
            return abs($number);
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

}