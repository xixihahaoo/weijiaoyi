<?php

namespace Admin\Controller;
use Think\Controller;
class LeaguerController extends CommonController {
    //会员列表
    public function mlist()
    {


        $userObj    = M('userinfo');
        $accountObj = M('accountinfo');
        $orderObj   = M('order');

        /*筛选*/
        $phone     = trim(I('get.phone'));
        $username  = trim(I('get.username'));
        $starttime = trim(I('get.starttime'));
        $endtime   = trim(I('get.endtime'));
        $operate   = trim(I('get.operate'));
        $oid       = trim(I('get.oid'));
        $puhui_id  = trim(I('get.puhui_id'));


        $map['otype'] = 4;

        if($phone)
        {
           $map['utel']  = $phone;
           $sea['phone'] = $phone;
        }

        if($username)
        {
            $map['username'] = array('like','%'.$username.'%');
            $sea['username'] = $username;
        }

        if($starttime && $endtime)
        {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime);
            $map['utime'] = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

        if($operate)
        {
            $userid = get_userid($operate,4);
            $map['operate_id'] = array('eq',$operate);
            $sea['operate'] = $operate;
        }

        if($oid)
        {
            $userid = get_userid($oid,4);
            $map['unit_id'] = array('eq',$oid);
            $sea['oid'] = $oid;

            $oidinfo = M('userinfo')->where(array('uid' => $oid))->find();
            $this->assign('oidinfo',$oidinfo);
        }

        $count = $userObj->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();


        $ulist = $userObj->where($map)->limit($page->firstRow.','.$page->listRows)->select();

        $ulistArr = array();
        foreach ($ulist as $key => $value) {
            array_push($ulistArr,$value['uid']);
        }

        $ulistId = implode(',',array_unique($ulistArr));


        //用户资金
        $accountinfo = $accountObj->where('uid in('.$ulistId.')')->select();
        $accountArr = array();
        foreach ($accountinfo as $key => $value) {
           $accountArr[$value['uid']] = $value;
        }

        //用户订单
        $order = $orderObj->where('uid in('.$ulistId.')')->select();
        $orderArr = array();
        foreach ($order as $key => $value) {
            $orderArr[$value['uid']] = count($order);
        }


        //用户信息
        foreach ($ulist as $key => $value) {
            $ulist[$key]['balance'] = $accountArr[$value['uid']]['balance'];
            $ulist[$key]['ocount']  = $orderArr[$value['uid']];
            $ulist[$key]['managername'] = $userObj->where(array('uid' => $value['oid']))->getField('username');
            $ulist[$key]['num'] = $this->get_subordinate_num($value);
        }


        //总统计
        $totalUser = $userObj->distinct(true)->field('uid')->where($map)->select();
        $totalArr  = array();
        foreach ($totalUser as $key => $value) {
            array_push($totalArr,$value['uid']);
        }
        $totalId = implode(',',$totalArr);
        $balance = $accountObj->where('uid in ('.$totalId.')')->sum('balance');
        $total['balance'] = $balance;
        $this->assign('total',$total);

        $operate = $userObj->where('otype=5')->select();
        $this->assign('operate',$operate);


        $this->assign('sea',$sea);
        $this->assign('ulist',$ulist);
        $this->assign('page',$show);
        $this->display();
    }

    //获取下级数量
    public function get_subordinate_num($data)
    {
        $userinfo = M('userinfo');
        $otype = [5,2,4,1,0];
        $key = array_search($data['otype'], $otype);
        $user_where['oid'] = array('eq',$data['uid']);
        $user_where['otype'] = array('eq',$otype[$key+1]);
        $user_list = $userinfo->where($user_where)->count();
        return $user_list;
    }

    public function get_subordinate($data,$type = -1,$json = false)
    {
        $userinfo = M('userinfo');
        if($type == -1)
        {
            $otype = [3,5,2,4,1];
            $key = array_search($data['otype'], $otype);
            $user_where['oid'] = array('eq',$data['uid']);
            $user_where['otype'] = array('eq',$otype[$key+1]);
        }
        else
        {
            //$user_where['oid'] = array('eq',$data);
            $user_where['uid'] = array('eq',$data);
            $user_where['otype'] = array('eq',$type);
        }
        $user_list = $userinfo->where($user_where)->select();
        if($json)
        {
            echo json_encode($user_list);
        }
        else
        {
            return $user_list;
        }
    }

    public function index()
    {
        $this->display('mlist');
    }
    /**
     * 添加代理
     * */
    public function madd(){

        $user = D('userinfo');
        $account = D('accountinfo');
        $manager = D('managerinfo');
        if(IS_POST){
            if($data=$user->create()){
                $data['utime']=date(time());
                $data['upwd']=md5(I('post.upwd'));
                $data['oid']= I('post.oid');
                $data['managername']=session('username');
                $data['utime']=date(time());
                $data['rebate']=I('post.rebate');
                $data['feerebate']=I('post.feerebate');
                $data['gefeebate']=I('post.gefeebate');
                $data['username'] = I('post.username');
                $data['operate_id'] = I('post.operate');
                $data['unit_id'] = I('post.oid');
                $data['oid'] = I('post.oid');
                $flag = preg_match('/[\x{4e00}-\x{9fa5}]+/u',$data['username']);
                if($flag){
                    $this->error('登录名不能用汉字，请使用英文和数字');
                }
                $data['assure']=I('post.assure');
                if(I('post.oid') == ''){
                    $this->error('会员单位不能为空');
                }
                $result = $user->add($data);
                if($result){
                    $bank_data['bankname'] = I('bankname');
                    $bank_data['province'] = I('province');
                    $bank_data['busername'] = I('busername');
                    $bank_data['banknumber'] = I('banknumber');
                    $bank_data['city'] = I('city');
                    $bank_data['uid'] = $result;
                    $bankinfo = M('bankinfo')->add($bank_data);
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
                    $accid['uid'] = I('post.3471');
                    M('accountinfo')->add($accid);
                    $this->success('添加成功',U('Leaguer/mlist'));
                }else{
                    $this->error("添加失败");
                }
            }else{
                $this->error($user->getError());
            }
        }else{
            $ulist = M('userinfo')->where(array('otype' => 5))->select();
            $this->assign('ulist',$ulist);
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
            if(!($feerebate >= 0 && $feerebate<=5))
            {
                $this->error('返佣比例必须大于0并且小于5');
            }
            $data['username'] = I('username');
            $data['utel'] = I('utel');
            $data['address'] = I('address');
            $data['brokerid'] = I('brokerid');
            $data['comname'] = I('comname');
            $data['comqua'] = I('comqua');
            $data['assure']=I('post.assure');
            $data['rebate'] = $rebate;
            $data['feerebate'] = $feerebate;
            $data['operate_id'] = I('operate');
            $data['unit_id'] = I('oid');
            $data['oid'] = I('oid');
            $data['linkman'] = I('linkman');
            //$map['balance'] = I('post.balance');
            $upwd = I('upwd');
            $map['bankname'] = I('bankname');
            $map['busername'] = I('busername');
            $map['province'] = I('province');
            $map['banknumber'] = I('banknumber');
            $map['city'] = I('city');
            $balance = I('post.balance');//账户余额
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

           /*身份信息*/
            if($data['brokerid'])
            {
               if($manager->where('uid='.$uid)->find())
               {
                    $manager->where('uid='.$uid)->setField('brokerid',$data['brokerid']);
               } else {
                    $mana['uid'] = $uid;
                    $mana['brokerid'] = $data['brokerid'];
                    $manager->add($mana);
               }
            }

            //修改账户余额
            if($balance)
            {
                $acinfo = D('accountinfo');
                $now_money = M('accountinfo')->where(array('uid'=>$uid))->getField('balance');
                if($balance>0)
                {
                    $resultAcinfo = $acinfo->where('uid='.$uid)->setInc('balance',$balance);
                    //获取最新账户余额
                    $newmoney = $acinfo->where('uid='.$uid)->getField('balance');
                    //账户加款
                    $datas['bptype'] = '充值';
                    $datas['bptime'] = time();
                    $datas['bpprice'] = $balance;
                    $datas['remarks'] = '账户加款';
                    $datas['uid'] = $uid;
                    $datas['isverified'] = 1;
                    $datas['cltime'] = time();
                    $datas['shibpprice'] = $newmoney;//用户余额
                    $datas['pay_type'] = 0;//支付类型，0手动
                    $datas['b_type'] = 1;
                    $datas['balanceno'] = "SD".time();
                    //var_dump($datas);exit();
                    M("balance")->add($datas);
                    //资金流水记录表
                    $money_log['uid'] = $uid;
                    $money_log['type'] = 4;//充值
                    $money_log['oid'] = 0;//
                    $money_log['note'] ='管理员对['.$data['username'].']账户加款'.$balance.'元';
                    $money_log['op_id'] =$_SESSION['userid']?$_SESSION['userid']:0;
                    $money_log['user_type'] = 4;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                    $money_log['change_money'] = $balance;
                    $money_log['balance'] = $now_money + $balance;
                    $money_log['dateline'] = time();
                    $money_log['tempdate'] = date('Y-m-d H:i:s');
                    $money_log_id = M('money_flow')->add($money_log);
                    user_log('账户加款',2);
                }
                else
                {
                    $balance = abs($balance);
                    $user_balance = $acinfo->where('uid='.$uid)->getField('balance');
                    $user_balance>0?$user_balance:0;
                    if($balance>$user_balance)
                    {
                        $balance = $user_balance;
                    }
                    $resultAcinfo = $acinfo->where('uid='.$uid)->setDec('balance',$balance);
                    $balance = '-'.$balance;

                    //获取最新账户余额
                    $newmoney = $acinfo->where('uid='.$uid)->getField('balance');
                    //账户加款
                    $datas['bptype'] = '充值';
                    $datas['bptime'] = time();
                    $datas['bpprice'] = $balance;
                    $datas['remarks'] = '账户减款';
                    $datas['uid'] = $uid;
                    $datas['isverified'] = 1;
                    $datas['cltime'] = time();
                    $datas['shibpprice'] = $newmoney;//用户余额
                    $datas['pay_type'] = 0;//支付类型，0手动
                    $datas['b_type'] = 1;
                    $datas['balanceno'] = "SD".time();
                    // var_dump($datas);die;
                    M("balance")->add($datas);
                    //资金流水记录表
                    $money_log['uid'] = $uid;
                    $money_log['type'] = 4;//充值
                    $money_log['oid'] = 0;//
                    $money_log['note'] ='管理员对['.$data['username'].']账户减款'.$balance.'元';
                    $money_log['op_id'] =$_SESSION['userid']?$_SESSION['userid']:0;
                    $money_log['user_type'] = 4;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                    $money_log['change_money'] = $balance;
                    $money_log['balance'] = $now_money + $balance;
                    $money_log['dateline'] = time();
                    $money_log['tempdate'] = date('Y-m-d H:i:s');
                    $money_log_id = M('money_flow')->add($money_log);
                    user_log('账户减款',2);
                }

            }


            /*身份信息*/


            M('accountinfo')->where('uid='.$uid)->save($map);
            $editlt = $user->where('uid='.$uid)->save($data);
            if($editlt!==FALSE){
                $info = '修改【'.I('post.utel').'】运营中心信息';
                $type = 2;
                user_log($info,$type);
                $this->success("修改成功",U("Leaguer/mlist"));
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
            $data['uid'] = $_SESSION['userid'];
            $data['otype'] = $_SESSION['userotype'];
            //运营中心
            $subordinate['operate'] = $this->get_subordinate($data);
            $us = $user->where('uid='.$uid)->find();
            //会员中心
            //旧$subordinate['unit'] = $this->get_subordinate($us['operate_id'],2);
            $subordinate['unit'] = $this->get_subordinate($us['unit_id'],2);
            $mg = $manager->where('uid='.$uid)->find();
            $accountinfo = M('accountinfo')->where('uid='.$uid)->find();
            $bankinfo = M('bankinfo')->where('uid='.$uid)->find();
            $this->assign('subordinate',$subordinate);
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


    public function alist_user()
    {
        $userObj    = M('userinfo');
        $accountObj = M('accountinfo');
        $orderObj   = M('order');

        $uid       = trim(I('get.uid'));
        $phone     = trim(I('get.phone'));
        $username  = trim(I('get.username'));
        $starttime = trim(I('get.starttime'));
        $endtime   = trim(I('get.endtime'));
        $operate   = trim(I('get.operate'));
        $oid       = trim(I('get.oid'));
        $puhui_id  = trim(I('get.puhui_id'));
        $jid       = trim(I('get.jid'));

        if($uid)
        {
            $sea['uid'] = $uid;
        }


      if($phone)
      {
           $map['utel']  = $phone;
           $sea['phone'] = $phone;
      }

      if($username)
      {
        $map['username'] = array('like','%'.$username.'%');
        $sea['username'] = $username;
      }

      if($starttime && $endtime)
      {
         $start_time = strtotime($starttime);
         $end_time   = strtotime($endtime);
         $map['utime'] = array('between',array($start_time,$end_time));
         $sea['starttime'] = $starttime;
         $sea['endtime']   = $endtime;
      }

      // if($operate)
      // {
      //    $userid = get_userid($operate);
      //   $map['uid'] = array('in',$userid);
      //   $sea['operate'] = $operate;
      // }

      // if($oid)
      // {
      //    $userid = get_userid($oid);
      //   $map['uid'] = array('in',$userid);
      //   $sea['oid'] = $oid;

      //   $oidinfo = M('userinfo')->where(array('uid' => $oid))->find();
      //   $this->assign('oidinfo',$oidinfo);
      // }

      // if($puhui_id)
      // {
      //    $userid = get_userid($puhui_id);
      //   $map['uid'] = array('in',$userid);
      //   $sea['puhui_id'] = $puhui_id;

      //   $puhuiinfo = M('userinfo')->where(array('uid' => $puhui_id))->find();
      //   $this->assign('puhuiinfo',$puhuiinfo);
      // }

      // if($jid)
      // {
      //    $userid = get_userid($jid);
      //   $map['uid'] = array('in',$userid);
      //   $sea['jid'] = $jid;

      //   $jidinfo = M('userinfo')->where(array('uid' => $jid))->find();
      //   $this->assign('jidinfo',$jidinfo);
      // }



        $map['oid'] = $uid;
        $count = $userObj->where($map)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();

        $ulist = $userObj->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        $ulistArr = array();
        foreach ($ulist as $key => $value) {
             array_push($ulistArr,$value['uid']);
        }
        $ulistId = implode(',',array_unique($ulistArr));


      //用户资金
      $accountinfo = $accountObj->where('uid in('.$ulistId.')')->select();
      $accountArr = array();
      foreach ($accountinfo as $key => $value) {
           $accountArr[$value['uid']] = $value;
      }

      //用户订单
      $order = $orderObj->where('uid in('.$ulistId.')')->select();
      $orderArr = array();
      foreach ($order as $key => $value) {
         $orderArr[$value['uid']] = count($order);
      }


      //用户信息
      foreach ($ulist as $key => $value) {
          $ulist[$key]['balance'] = $accountArr[$value['uid']]['balance'];
          $ulist[$key]['ocount']  = $orderArr[$value['uid']];
          $ulist[$key]['managername'] = $userObj->where(array('uid' => $value['oid']))->getField('username');
      }

      //总统计
      $totalUser = $userObj->distinct(true)->field('uid')->where($map)->select();
      $totalArr  = array();
      foreach ($totalUser as $key => $value) {
         array_push($totalArr,$value['uid']);
      }
      $totalId = implode(',',$totalArr);
      $balance = $accountObj->where('uid in ('.$totalId.')')->sum('balance');
      $total['balance'] = $balance;
      $this->assign('total',$total);

      $operate = $userObj->where('otype=5')->select();
      $this->assign('operate',$operate);


      $this->assign('sea',$sea);
      $this->assign('ulist',$ulist);
      $this->assign('page',$show);
      $this->assign('user',$userObj->where(array('uid' => $uid))->find());
      $this->display();
    }

}