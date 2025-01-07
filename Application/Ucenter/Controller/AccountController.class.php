<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class AccountController extends CommonController{
    //会员列表
	public function agentlist()
    {
		//var_dump($_SESSION);
		//exit;
		if($_REQUEST['search'])
		{
			$str = " and username like '%".$_REQUEST['search']."%'";
		}
    	//获取登录代理商的id
    	$oid=$_SESSION['cuid'];
    	$count =M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=1 and vertus = 1'.$str)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
		$ulist=M('userinfo')->where('user1.oid='.$oid.' and user1.ustatus=0 and user1.otype=1 and user1.vertus = 1'.$str)->field('user1.*')->table('wp_userinfo user1')
		->limit($page->firstRow.','.$page->listRows)
		->select();
		foreach($ulist as $key=>$val)
		{
			$uinfo_where['oid'] = array('eq',$val['uid']);
			$uinfo_where['ustatus'] = array('eq',0);
			$uinfo_where['otype'] = array('eq',0);
			$uinfo_where['vertus'] = array('eq',1);
			$num = M('userinfo')->where($uinfo_where)->count();
			$ainfo_where['user1.agent_id'] = array('eq',$val['uid']);
			$balance_info = M('userinfo')->where($ainfo_where)->field('sum(account.balance) as balance')->table('wp_userinfo user1')
			->join("join wp_accountinfo account on user1.uid = account.uid")
			->group('user1.agent_id')
			->find();
			$ulist[$key]['num'] = $num;
			$ulist[$key]['balance'] = $balance_info['balance']?$balance_info['balance']:'0.00';
		}
        $this->assign('ulist',$ulist);
        $this->assign('page',$show);
		$this->display();
    }

        /**
     * 全民经纪人列表
     */
    public function agent(){

        $username  = trim(I('get.username'));
        $starttime = trim(I('get.starttime'));
        $endtime   = trim(I('get.endtime'));
        $puhui_id  = trim(I('get.puhui_id'));
        $jid       = trim(I('get.jid'));


        $oid = $_SESSION['cuid'];
        $map['unit_id']     = $oid; //当前会员单位下的经纪人
        $map['otype']       = 0;//客户类型
        $map['agenttype']   = 2;//全民经纪人


      if($username)
      {
        $map['username'] = array('like','%'.$username.'%');
        $sea['username'] = $username;
      }

      if($starttime && $endtime)
      { 
        $start_time = strtotime($starttime);
        $end_time   = strtotime($endtime);
        $map['utime']     = array('between',array($start_time,$end_time));
        $sea['starttime'] = $starttime;
        $sea['endtime']   = $endtime;
      }

      if($puhui_id)
      {
        $userid     = get_userid($puhui_id,0);
        $map['uid'] = array('in',$userid);
        $sea['puhui_id'] = $puhui_id;
      }

      if($jid)
      {
        $userid = get_userid($jid,0);
        $map['uid'] = array('in',$userid);
        $sea['jid'] = $jid;

        $jidinfo = M('userinfo')->field('uid,username')->where(array('oid' => $puhui_id,'otype' => 1))->select();
        $this->assign('jidinfo',$jidinfo);
      }


        $count =M('userinfo')->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
        $rs   = M('userinfo')->where($map)->limit($page->firstRow.','.$page->listRows)->select();

        foreach ($rs as $key => $value) {
            $rs[$key]['profit'] = M('agent')->where(array('user_id' => $value['uid']))->sum('profit');
        }


        $this->assign('sea',$sea);
        $this->assign('rows',$rs);
        $this->assign('page',$show);
        $this->assign('daili',M('userinfo')->field('uid,username')->where(array('unit_id' => $oid,'otype' => 4))->select());
        $this->display();
    }
	
    /**
     * 申请经纪人列表
     */
    public function agent_apply(){

        $username  = trim(I('get.username'));
        $starttime = trim(I('get.starttime'));
        $endtime   = trim(I('get.endtime'));
        $puhui_id  = trim(I('get.puhui_id'));
        $jid       = trim(I('get.jid'));

        $oid = $_SESSION['cuid'];
        $map['unit_id']   = $oid; //当前会员下的经纪人
        $map['otype']     = 0;    //客户类型
        $map['agenttype'] = 1;    //申请经纪人中

        $user = M('userinfo');

          if($username)
          {
            $map['username'] = array('like','%'.$username.'%');
            $sea['username'] = $username;
          }

          if($starttime && $endtime)
          { 
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['utime']     = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
          }

          if($puhui_id)
          {
            $userid     = get_userid($puhui_id,0);
            $map['uid'] = array('in',$userid);
            $sea['puhui_id'] = $puhui_id;
          }

          if($jid)
          {
            $userid = get_userid($jid,0);
            $map['uid'] = array('in',$userid);
            $sea['jid'] = $jid;

            $jidinfo = $user->field('uid,username')->where(array('oid' => $puhui_id,'otype' => 1))->select();
            $this->assign('jidinfo',$jidinfo);
          }

        $count = $user->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '&#8249;');
        $page->setConfig('next', '&#8250;');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $rs = $user->where($map)->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign('sea',$sea);
        $this->assign('page',$show);
        $this->assign('rows',$rs);
        $this->assign('daili',$user->field('uid,username')->where(array('unit_id' => $oid,'otype' => 4))->select());
        $this->display();
    }

    public function handle_apply(){
        $oid = $_SESSION['cuid'];
        $uid = I('get.uid',0);
        $userObj = M('userinfo');
        $user = $userObj->where(array('unit_id'=>$oid,'uid'=>$uid))->find();
        if(!$user){
            $this->ajaxReturn(array('msg'=>'不存在该会员或会员关系不相符','status'=>0));
        }
        $idea = I('get.idea');
        if($idea == 1){
            $idea=2;//agenttype 为2，经纪人
            $info = '同意id=【'.$uid.'代理申请】';
            user_log($info,2);
        }else{
            $info = '拒绝id=【'.$uid.'代理申请】';
            user_log($info,2);
        }

        $rs = $userObj->where(array('uid'=>$uid))->data(array('agenttype'=>$idea))->save();
        if($rs){
            M('managerinfo')->where('uid='.$uid)->delete();
            $this->ajaxReturn(array('msg'=>'处理成功','status'=>1));
        }
        $this->ajaxReturn(array('msg'=>'处理失败','status'=>0));
    }
	public function agentlist1()
    {
		if($_REQUEST['search'])
		{
			$str = " and username like '%".$_REQUEST['search']."%'";
		}
    	//获取登录代理商的id
    	$oid=$_REQUEST['uid'];
		$sea['uid'] = $oid;
    	$count =M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=0 and vertus = 1'.$str)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();
		$ulist=M('userinfo')->where('oid='.$oid.' and ustatus=0 and otype=0 and vertus = 1'.$str)->limit($page->firstRow.','.$page->listRows)->select();
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
                    //修改
                    //
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
                    
                    $data['uid']=$uid;
                    $data['utel']=I('post.utel');
                    $data['address']=I('post.address');
                    $data['rebate']=I('post.rebate');
					$data['linkman']=I('post.linkman');
                    $data['feerebate']=I('post.feerebate');
                    $userinfo->save($data);
                    $mana['mid']=$mid;
                    $mana['brokerid']=I('post.brokerid');
					$mana['comname']=I('post.comname');

                    $managerinfo->save($mana); 
                    $map['bankname'] = I('bankname');
                    $map['province'] = I('province');
                    $map['busername'] = I('busername');
					$map['banknumber'] = I('banknumber');
                    $map['city'] = I('city');
                    $bankinfo = M('bankinfo')->where('uid='.$uid)->find();
                    if($bankinfo['uid'] != ''){
                         M('bankinfo')->where('uid='.$uid)->save($map);
                    }else{
                        $map['uid'] = $uid;
                        M('bankinfo')->add($map);
                    }
                    redirect(U('Account/agentlist'),1, '修改成功...');
                }else{
                    //添加
                    $user=$userinfo->field('username,operate_id,unit_id')->where('uid='.$myuid)->find();
                    $data['managername']=$user['username'];
                    $data['username']=I('post.username1').I('post.username2');
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
					$data['linkman']=I('post.linkman');
					$data['comname']=I('post.comname');
					$data['rebate']=I('post.rebate');
					$data['feerebate']=I('post.feerebate');
                    $data['otype']=1;
                    $data['oid']=$myuid;
                    $data['operate_id']=$user['operate_id'];
                    $data['unit_id']=$user['unit_id'];
                    $data['leaguer_id']=$myuid;
                    if ($uid = $userinfo->add($data)) {
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
                    }
                    redirect(U('Account/agentlist'),1, '新增用户成功...');
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
            $bankinfo = M('bankinfo')->where('uid='.$uid)->find();
            $this->assign('bankinfo',$bankinfo);
    		$this->assign('user',$user);
    	      }	
    	
    	$this->display();
    }
    //删除会员
    public function agentdel($uid=''){
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
			redirect(U('Account/agentlist'),1, '删除用户成功...');
		}
		else
		{
			redirect(U('Account/agentlist'),1, '删除用户失败...');
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

    /**
     * 设置全民经纪人比例
     * @author wang <[990529346@qq.com address]>
     */
    public function agent_rate()
    {
        $uid       = session('cuid');
        $rebateObj = M('rebate');

        $rebate    = $rebateObj->where(array('unit_id' => $uid))->select();
        $count     =  count($rebate);
        
        for ($i=0; $i <3-$count ; $i++) { 
            $rebate[]['type'] = $i+1;
        }

        foreach ($rebate as $key => $value) {
            $rebate[$key]['type']     = $value['type'];
            $rebate[$key]['dateline'] = isset($value['dateline']) ? date('Y-m-d H:i:s',$value['dateline']) :'';
        }

        $this->assign('uid',$uid);
        $this->assign('rebate',$rebate);
        $this->display();
    }


    /**
     *修改全民经纪人比例
     */
    public function save_rate()
    {
        $uid    = I('post.uid');
        $type   = I('post.type');
        $rate   = I('post.rate');
        $id     = I('post.id');

        $rebateObj = M('rebate');
        $return    = array();

        if(!$uid)
        {
            $return['msg']  = '会员单位不存在';
            $return['code'] = 400;
            $this->ajaxReturn($return,'JSON');
        }

        foreach ($type as $key => $value) {
            $arr[$key]['type'] = $value;
            $arr[$key]['rate'] = $rate[$key];
            $arr[$key]['id']   = $id[$key];
        }

        if(empty($arr[0]['id']))
        {
            foreach ($arr as $key => $value) {
                $data['unit_id']  = $uid;
                $data['rate']     = $value['rate'];
                $data['type']     = $value['type'];
                $data['dateline'] = time();
                $result[] = $rebateObj->add($data);
            }

        } else {

            foreach ($arr as $key => $value) {
                $data['rate']     = $value['rate'];
                $data['type']     = $value['type'];
                $result[] = $rebateObj->where(array('id' => $value['id'],'unit_id' => $uid))->save($data);
            }
        }

        if($result)
        {
            $return['msg']  = '修改成功';
            $return['code'] = 200;
            $this->ajaxReturn($return,'JSON');
        } else {
            $return['msg']  = '修改失败';
            $return['code'] = 400;
            $this->ajaxReturn($return,'JSON');
        }
    }

    /**
     * 联动菜单
     */
    public function ajax_get_brokers(){
      if(IS_AJAX){
          $id = trim(I('get.id'));
          $userinfo = M('userinfo');
          if($id) {
              $info = $userinfo->field('uid,username,feerebate')->where(array('oid' => $id))->select();
              $this->ajaxReturn($info,'JSON');
          }
      }
    }

    /**
     * 佣金流水
     */
    public function flow()
    {

      $username   = trim(I('get.username'));
      $starttime  = trim(I('get.starttime'));
      $endtime    = trim(I('get.endtime'));
      $puhui_id   = trim(I('get.puhui_id'));
      $jid        = trim(I('get.jid'));


      $userinfo = M('userinfo');
      $agent    = M('agent a');


      $oid = $_SESSION['cuid'];
      $map['b.unit_id']   = $oid; //当前会员下的经纪人
      $map['b.otype']     = 0;    //客户类型



      if($username)
      {
        $map['b.username']  = array('like','%'.$username.'%');
        $sea['username']    = $username;
      }

      if($tel)
      {
        $map['b.utel']  = $tel;
        $sea['tel']     = $tel;
      }

      if($starttime && $endtime)
      {
        $start_time = strtotime($starttime);
        $end_time   = strtotime($endtime);
        $map['a.create_time'] = array('between',array($start_time,$end_time));
        $sea['starttime']     = $starttime;
        $sea['endtime']       = $endtime;
      }

      if($puhui_id)
      {
          $map['a.user_id'] = array('in',get_userid($puhui_id));
          $sea['puhui_id'] = $puhui_id;
      }

      if($jid)
      {
          $map['a.user_id'] = array('in',get_userid($jid));

          $jidinfo = $userinfo->where(array('oid' => $puhui_id,'otype' =>1))->select();
          $sea['jid'] = $jid;
          $this->assign('jidinfo',$jidinfo);
      }


      $count = $agent->
                    where($map)->
                    join('inner join wp_userinfo as b on a.user_id = b.uid')->
                    join('inner join wp_order as c on a.order_id = c.oid')->
                    join('inner join wp_userinfo as d on a.purchaser_id = d.uid')->
                    count();

      $pagecount = 15;
      $page = new \Think\Page($count, $pagecount);
      $page->parameter = $row;
      $page->setConfig('first', '首页');
      $page->setConfig('prev', '&#8249;');
      $page->setConfig('next', '&#8250;');
      $page->setConfig('last', '尾页');
      $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
      $show = $page->show();

      $info  = $agent->
                    where($map)->
                    field('a.*,b.username,b.unit_id,b.utel,c.ptitle,d.username as purchaser_username')->
                    join('inner join wp_userinfo as b on a.user_id = b.uid')->
                    join('inner join wp_order as c on a.order_id = c.oid')->
                    join('inner join wp_userinfo as d on a.purchaser_id = d.uid')->
                    limit($page->firstRow . ',' . $page->listRows)->
                    select();

      $data = array();
      foreach ($info as $key => $value) {
          array_push($data, $value['unit_id']);
      }

      $unit_id   = implode(',', array_unique($data));
      $unit_data = $userinfo->field('uid,username')->where('uid in('.$unit_id.') and otype = 2')->select();
      $unit_arr  = array();
      foreach ($unit_data as $key => $value) {
        $unit_arr[$value['uid']] = $value;
      }

      foreach ($info as $key => $value) {
          $info[$key]['unit_name'] = $unit_arr[$value['unit_id']]['username'];
      }

      $profit = $agent->where($map)->
                    join('inner join wp_userinfo as b on a.user_id = b.uid')->
                    join('inner join wp_order as c on a.order_id = c.oid')->
                    join('inner join wp_userinfo as d on a.purchaser_id = d.uid')->sum('a.profit');
      $this->assign('profit',$profit);


      $this->assign('sea',$sea);
      $this->assign('rows',$info);
      $this->assign('show',$show);
      $this->assign('daili',$userinfo->field('uid,username')->where(array('unit_id' => $oid,'otype' => 4))->select());
      $this->display();
    }
}