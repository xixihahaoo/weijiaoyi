<?php

namespace Admin\Controller;
use Think\Controller;
class AgentlistController extends CommonController {
    //会员列表
    public function alist()
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


      $map['otype']    = 1;
      // $map['utel']     = array('exp','is not null');
      // $map['username'] = array('exp','is not null');


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
        $map['operate_id'] = array('eq',$operate);
        $sea['operate'] = $operate;
      }

      if($oid)
      {
        $map['unit_id'] = array('eq',$oid);
        $sea['oid'] = $oid;

        $oidinfo = M('userinfo')->where(array('uid' => $oid))->find();
        $this->assign('oidinfo',$oidinfo);
      }

      if($puhui_id)
      {
        $map['leaguer_id'] = array('eq',$puhui_id);
        $sea['puhui_id'] = $puhui_id;

        $puhuiinfo = M('userinfo')->where(array('uid' => $puhui_id))->find();
        $this->assign('puhuiinfo',$puhuiinfo);
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
         // echo M()->getLastSql();

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
        $otype = [3,5,2,4,1,0];
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
            $user_where['oid'] = array('eq',$data);
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
    //读取关注微信的用户信息。
    public function wxlist(){


        $userinfo = M('userinfo');
        //分页
        $count = $userinfo->where('usertype=1')->count();
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
        $ulist = $userinfo->where('usertype=1')->order('uid desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign('page',$show);
        $this->assign('ulist',$ulist);


        $this->display();
    }
    /*
    *获取最新的所有关注用户的信息，添加到用户列表，注意usertype，wxtype，2个参数。
    */
    public function instruser(){

        $wxinfo=M('wechat')->find();
        $appid = $wxinfo['appid'];
        $appsecret = $wxinfo['appsecret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output =curl_exec($ch);
        curl_close($ch);
        $jsoninfo = json_decode($output, true);
        $access_token = $jsoninfo["access_token"];
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token";
        $result =$this->https_request($url);
        $jsoninfo = json_decode($result);  // 默认false，为Object，若是True，为Array

        $data = $jsoninfo -> data;
        header("Content-type: text/html; charset=utf-8");
        $userlist=array();
        foreach($data -> openid as $x=>$x_value) {
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$x_value;
            $result = $this->https_request($url);
            $php_json =(Array)json_decode($result);   //再把json格式的数据转换成php数组
            $php_json['username']= substr($php_json['openid'], -5).time();//登录名
            $php_json['address']=$php_json['country'].$php_json['province'].$php_json['city'];//地址
            $php_json['portrait']=$php_json['headimgurl'];//头像
            $php_json['utime']=$php_json['subscribe_time'];//时间
            $php_json['openid']= $php_json['openid'];
            $php_json['nickname']=$php_json['nickname'];
            $php_json['usertype']='1';
            $php_json['wxtype']='1';
            $userlist[]=$php_json;
        }
        //重组数组
        $mydata=array();
        $userinfo = M('userinfo');
        foreach ($userlist as $key => $value) {
            $mydata[$key]['username']=$value['username'];
            $mydata[$key]['address']=$value['address'];
            $mydata[$key]['portrait']=$value['portrait'];
            $mydata[$key]['openid']=$value['openid'];
            $mydata[$key]['utime']=$value['utime'];
            $mydata[$key]['nickname']=$value['nickname'];
            $mydata[$key]['usertype']=1;
            $mydata[$key]['wxtype']=1;
            $usersum=$userinfo->where("openid='".$value['openid']."'")->count();
            if ($usersum<1) {
                $userinfo->add($mydata[$key]);
            }

        }
        $this->redirect('Menber/wxlist');
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
            $data['operate_id'] = I('operate');
            $data['unit_id'] = I('oid');
            $data['leaguer_id'] = I('puhui_id');
            $data['oid'] = I('puhui_id');
            $data['linkman'] = I('linkman');
            //$map['balance'] = I('post.balance');
            $upwd = I('upwd');
            $map['bankname'] = I('bankname');
            $map['busername'] = I('busername');
            $map['province'] = I('province');
            $map['banknumber'] = I('banknumber');
            $map['city'] = I('city');
            $balance = I('post.balance');//账户余额
            if(!($feerebate >= 0 && $feerebate < 5))
            {
                $this->error('返佣比例必须大于0并且小于5');
            }
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
                    $money_log['user_type'] = 1;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
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
                    $money_log['user_type'] = 1;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                    $money_log['change_money'] = $balance;
                    $money_log['balance'] = $now_money + $balance;
                    $money_log['dateline'] = time();
                    $money_log['tempdate'] = date('Y-m-d H:i:s');
                    $money_log_id = M('money_flow')->add($money_log);
                    user_log('账户减款',2);
                }

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

            /*身份信息*/

            M('accountinfo')->where('uid='.$uid)->save($map);
            $editlt = $user->where('uid='.$uid)->save($data);
            if($editlt!==FALSE){
                $info = '修改【'.I('post.utel').'】运营中心信息';
                $type = 2;
                user_log($info,$type);
                $this->success("修改成功",U("Agentlist/alist"));
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
            $data['uid'] = $_SESSION['userid'];
            $data['otype'] = $_SESSION['userotype'];
            $subordinate['operate'] = $this->get_subordinate($data);
            $uid = I('get.uid');
            $us = $user->where('user.uid='.$uid)->field('user.*,user1.feerebate as feerebate1')->table('wp_userinfo user')
            ->join("join wp_userinfo user1 on user1.uid = user.leaguer_id")
            ->find();
            $subordinate['unit'] = $this->get_subordinate($us['operate_id'],2);
            $subordinate['leaguer'] = $this->get_subordinate($us['unit_id'],4);
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

    public function upstatus(){

        $id   = trim(I('post.id'));
        $type = trim(I('post.type'));

        $res["ustatus"] = $type;
        $resut = M("userinfo")->where("uid=" . $id)->save($res);

        if($resut){
            if($type == 1){
                $info = "冻结【id=".$id."经纪人】";
            }else{
                $info = "解冻【id=".$id."经纪人】";
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
        $userObj     = M('userinfo');
        $accountObj  = M('accountinfo');
        $orderObj    = M('order');

          $uid       = trim(I('get.uid'));
        $phone     = trim(I('get.phone'));
        $username  = trim(I('get.username'));
        $starttime = trim(I('get.starttime'));
        $endtime   = trim(I('get.endtime'));
        $operate   = trim(I('get.operate'));
          $oid       = trim(I('get.oid'));
        $puhui_id  = trim(I('get.puhui_id'));
        $jid       = trim(I('get.jid'));

      $map['utel']     = array('exp','is not null');
      $map['username'] = array('exp','is not null');

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
          $ulist[$key]['balance'] = $accountArr[$value['uid']]['balance'] ? $accountArr[$value['uid']]['balance'] : '0.00';
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




    /**
     * 添加代理2
     * @author  wang <[email address]>
     */
    public function madd(){
       

        $user    = M('userinfo');
        $account = M('accountinfo');
        $manager = M('managerinfo');
        if(IS_AJAX)
        {
            $username = trim(I('post.username'));
            $utel     = trim(I('post.utel'));
            $address  = trim(I('post.address'));
            $brokerid = trim(I('post.brokerid'));
            $comname  = trim(I('post.comname'));
            $comqua   = trim(I('post.comqua'));
            $operate  = trim(I('post.operate'));
            $oid      = trim(I('post.oid'));
            $puhui_id = trim(I('post.puhui_id'));
            $upwd     = trim(md5(I('post.upwd')));
            $rpwd     = trim(md5(I('post.rpwd')));
            $feerebate = trim(I('post.feerebate'));
            $linkman = trim(I('post.linkman'));

            $data     = array();
            // echo $username;die;
            if(!($feerebate > 1.5 && $feerebate<I('post.input_profit')))
            {
                $data['status'] = 0;
                $data['msg']  = '返佣比例必须大于1.5并且小于'.I('post.input_profit');
                $this->ajaxReturn($data,'JSON');
            }
            if(strlen($username) < 7 )
            {
                $data['status'] = 0;
                $data['msg']  = '机构编号不得少于7位纯数字';
                $this->ajaxReturn($data,'JSON');
            }

            if($user->where(array('username' => $username))->find()){

                $data['status'] = 0;
                $data['msg']    = '机构编号已经存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(!preg_match('/^1\d{10}$/',$utel)){

                $data['status'] = 0;
                $data['msg']    = '手机号填写错误';
                $this->ajaxReturn($data,'JSON');
            }

            if($user->where('otype != 0 and utel = '.$utel.'')->find())
            {
                $data['status'] = 0;
                $data['msg']    = '手机号已经存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($address) || is_numeric($address))
            {
                $data['status'] = 0;
                $data['msg']    = '办公地址填写不正确';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($comname) || is_numeric($comname))
            {
                $data['status'] = 0;
                $data['msg']    = '公司名称填写错误';
                $this->ajaxReturn($data,'JSON');
            }

            if(!$user->where(array('otype' => 5,'uid' => $operate))->find())
            {
                $data['status'] = 0;
                $data['msg']    = '运营中心不存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(!$user->where(array('otype' => 2,'uid' => $oid))->find())
            {
                $data['status'] = 0;
                $data['msg']    = '会员单位不存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(!$user->where(array('otype' => 4,'uid' => $puhui_id))->find())
            {
                $data['status'] = 0;
                $data['msg']    = '代理1不存在';
                $this->ajaxReturn($data,'JSON');
            }

            if(!$upwd)
            {
                $data['status'] = 0;
                $data['msg']    = '密码填写不正确';
                $this->ajaxReturn($data,'JSON');
            }

            if($upwd != $rpwd)
            {
                $data['status'] = 0;
                $data['msg']    = '密码填写不一致';
                $this->ajaxReturn($data,'JSON');
            }

            $map['username']   = $username;
            $map['upwd']       = $upwd;
            $map['utel']       = $utel;
            $map['otype']      = 1;
            $map['utime']      = time();
            $map['address']    = $address;  //地址
            $map['comname']    = $comname;  //公司
            $map['comqua']     = $comqua;   //资质
            $map['operate_id'] = $operate;
            $map['unit_id']    = $oid;
            $map['leaguer_id'] = $puhui_id;
            $map['oid']        = $puhui_id;
            $map['linkman']    = $linkman;

            $info = $user->add($map);

            if($info)
            {
                $bank_data['bankname'] = I('bankname');
                $bank_data['province'] = I('province');
                $bank_data['busername'] = I('busername');
                $bank_data['banknumber']   = I('banknumber');
                $bank_data['city'] = I('city');
                $bank_data['uid'] = $info;
                $bankinfo = M('bankinfo')->add($bank_data);
                if($bankinfo)
                {
                    $data['status'] = 1;
                    $data['msg']    = '添加成功';
                    $this->ajaxReturn($data,'JSON');
                } else {
                    $data['status'] = 0;
                    $data['msg']    = '添加失败';
                    $this->ajaxReturn($data,'JSON');
                }
                $manager['uid']      = $info;
                $manager['brokerid'] = $brokerid;
                $managerinfo = M('managerinfo')->add($manager);
                if($managerinfo)
                {
                    $data['status'] = 1;
                    $data['msg']    = '添加成功';
                    $this->ajaxReturn($data,'JSON');
                } else {
                    $data['status'] = 0;
                    $data['msg']    = '添加失败';
                    $this->ajaxReturn($data,'JSON');
                }
                $accid['uid'] = I('post.3471');
                M('accountinfo')->add($accid);
            }

        } else
        {
            $ulist = $user->where(array('otype' => 5))->select();
            $this->assign('ulist',$ulist);
            $this->display();
        }
    }

    public function ajax_name($name="")
    {
        $user = M('userinfo');
        if($user->where(array('username' => $name))->find())
        {
            $data['status'] = 0;
            $data['msg']    = '机构编号已经存在,或没有修改';
            $this->ajaxReturn($data,'JSON');
            exit;
        }
        $data['status'] = 1;
    }

    public function save_name($uid='',$url='')
    {
        $muserinfo = M('userinfo');
        if($_GET['sub'])
        {
            if($muserinfo->where("uid=$uid")->save(array('username'=>$_GET['username'])) !== false)
            {
                redirect(U($url),1, '修改成功...');
            }
            else
            {
                redirect(U($url),1, '修改失败...');
            }
        }
        else
        {
            $user_info = $muserinfo->where("uid=$uid")->find();
            $list_info['operate'] = $muserinfo->field('uid,username,otype')->where("otype=5 and uid={$user_info['operate_id']}")->find();
            if($user_info['unit_id'])
            {
                $list_info['unit'] = $muserinfo->field('uid,username,otype')->where("otype=2 and uid={$user_info['unit_id']}")->find();
            }
            if($user_info['leaguer_id'])
            {
                $list_info['leaguer'] = $muserinfo->field('uid,username,otype')->where("otype=4 and uid={$user_info['leaguer_id']}")->find();
            }
            $otype_info = array(
                '5'=>array(
                    'name'=>'修改运营中心',
                    'list'=>array(0,0,0),
                    'list_info'=>array(),
                    'where'=>"eq",
                    'where1'=>"等于",
                    'len'=>"3"
                ),
                '2'=>array(
                    'name'=>'修改会员单位',
                    'list'=>array(1,0,0),
                    'list_info'=>$list_info,
                    'where'=>"eq",
                    'where1'=>"等于",
                    'len'=>"6"
                ),
                '4'=>array(
                    'name'=>'修改代理1',
                    'list'=>array(1,1,0),
                    'list_info'=>$list_info,
                    'where'=>"gt",
                    'where1'=>"大于",
                    'len'=>"6"
                ),
                '1'=>array(
                    'name'=>'修改代理2',
                    'list'=>array(1,1,1),
                    'list_info'=>$list_info,
                    'where'=>">gt",
                    'where1'=>"大于",
                    'len'=>"7"
                ),
            );
            $this->assign("url",$url);
            $this->assign("user_info",$user_info);
            $this->assign("otype_info",$otype_info[$user_info['otype']]);
        }
        $this->display();
    }

    public function text1()
    {
        dump($_SERVER);
        exit;
    }
}