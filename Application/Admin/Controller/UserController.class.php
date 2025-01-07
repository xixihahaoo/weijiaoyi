<?php

namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {

    public function _initialize(){

        
        //获取管理者的身份
        $uid=$_SESSION['userid'];
        $user = M('userinfo')->where(['uid'=>$uid])->find();
        //获取栏目允许哪类管理者用户
        $cate = M('admin_category');
        $cateArr = $cate->where(['state'=>1])->select();
        $rule = M('role')->where(['id'=>$user['q']])->select();
        $role = explode(',',$rule[0]['rules']);
        foreach ($cateArr as $k => $v){
            if (in_array($v['cid'],$role)) {
                $showArr[$v['cname']]['cid'] = $v['cid'];
                $showArr[$v['cname']]['pid'] = $v['pid'];
                $showArr[$v['cname']]['class'] = $v['class'];
                $showArr[$v['cname']]['url'] = $v['url'];
            }
        }

        $this->assign('category',$showArr);

        $this->assign('controller',strtolower(CONTROLLER_NAME));
    }
    //管理员登陆
    public function signin()
    {
        if(IS_POST){
            header("Content-type: text/html; charset=utf-8");

            $user = D("userinfo");

            //查询条件
            $where = array();
            $where['username'] = I('post.username');
            $where['ustatus'] = 0;
            //$where['ustatus'] = "1";
            $result = $user->where($where)->field("uid,upwd,username,utel,utime,otype,ustatus,vertus,feerebate")->find();

            //验证用户
            if(empty($result)){
                $this->error('登录失败,用户名不存在!');
            }else{
                $map['lastlog'] = time();
                M('userinfo')->where('username ="'.I('post.username').'"')->save($map);
                if($result['upwd'] == md5(I('post.password'))){
                    if($result['vertus'] != 1)
                    {
                        $this->error('对不起,你还没通过平台审核，不能登录!');
                    }
                    //session
                    if($result['otype']==2 && $result['ustatus']==0)//类型2
                    {
                        session('cuid',$result['uid']);
                        session('userotype',$result['otype']);
                        session('newusername',$result['username']);
                        user_log("会员单位【".$result['username']."】登录成功",1);//加入操作日志
                        $this->success('登录成功,正跳转至系统会员单位首页...', U('Ucenter/Ordinary/agentlist'));
                    }

                    elseif ($result['otype']==5&&$result['ustatus']==0)

                    {
                        session('cuid',$result['uid']);
                        session('userotype',$result['otype']);
                        session('newusername',$result['username']);
                        user_log("运营中心【".$result['username']."】登录成功",1);//加入操作日志
                        $this->success('登录成功,正跳转至运营中心首页...', U('Ucenter/Unit/agentlist'));
                    }

                    // elseif ($result['otype']==6&&$result['ustatus']==0)

                    // {
                    //     session('cuid',$result['uid']);
                    //     session('userotype',$result['otype']);
                    //     session('newusername',$result['username']);
                    //     user_log("特会【".$result['username']."】登录成功",1);//加入操作日志
                    //     $this->success('登录成功,正跳转至特会首页...', U('Ucenter/Tehui/tradelist'));
                    // }


                    elseif ($result['otype']==3&&$result['ustatus']==0)

                    {

                        $nowIp  = get_client_ip();
//                        if(!in_array($nowIp, array('101.68.92.106', '119.163.107.106')))
//                            $this->error('用户名非法');

                        session('userid',$result['uid']);
                        session('userotype',$result['otype']);
                        session('username',$result['username']);
                        user_log("系统管理员【".$result['username']."】登录成功",1);//加入操作日志
                        $this->success('登录成功,正跳转至系统管理员首页...', U('Admin/Index/index'));
                    }elseif ($result['otype']==4&&$result['ustatus']==0)

                    {
                        session('cuid',$result['uid']);
                        session('newusername',$result['username']);
                        session('userotype',$result['otype']);
                        session('feerebate',$result['feerebate']);
                         user_log("代理1【".$result['username']."】登录成功",1);//加入操作日志
                        $this->success('登录成功,正跳转至系统代理1首页...', U('Ucenter/Account/agentlist'));
                    }
                    // elseif ($result['otype']==1&&$result['ustatus']==0)
                    // {
                    //     session('cuid',$result['uid']);
                    //     session('newusername',$result['username']);
                    //     session('userotype',$result['otype']);
                    //     session('feerebate',$result['feerebate']);
                    //     user_log("代理2【".$result['username']."】登录成功",1);//加入操作日志
                    //     $this->success('登录成功,正跳转至系统代理2首页...', U('Ucenter/Trade/tradelist'));
                    // }

                    // elseif ($result['otype']==7&&$result['ustatus']==0)
                    // {
                    //     session('cuid',$result['uid']);
                    //     session('newusername',$result['username']);
                    //     session('userotype',$result['otype']);
                    //     session('feerebate',$result['feerebate']);
                    //     user_log("代理2【".$result['username']."】登录成功",1);//加入操作日志
                    //     $this->success('登录成功,正跳转至交易所分部首页...', U('Ucenter/Unit/agentlist'));
                    // }
                    else{
                        $this->error('登录失败,用户名不存在!');
                    }
                }else{
                    $this->error('用户名或密码错误');
                }
            }
        }else{
            $this->display();
        }
    }

    //删除客户
    public function delete_mem($uid="",$url="")
    {
        $muserinfo = M('userinfo');
        $managerinfo = M('managerinfo');
        $maccountinfo = M('accountinfo');
        $mbankinfo = M('bankinfo');
        $mbalance = M('balance');
        $mjournal = M('journal');
        $morder = M('order');
        $userinfo = $muserinfo->where("uid=$uid")->delete();
        if($userinfo)
        {
            $anagerinfo = $managerinfo->where("uid=$uid")->delete();
            $accountinfo = $maccountinfo->where("uid=$uid")->delete();
            $bankinfo = $mbankinfo->where("uid=$uid")->delete();
            $balance = $mbalance->where("uid=$uid")->delete();
            $journal = $mjournal->where("uid=$uid")->delete();
            $order = $morder->where("uid=$uid")->delete();
            redirect(U($url),1, '删除用户成功...');
        }
        else
        {
            redirect(U($url),1, '删除用户失败...');
        }
    }

    //管理员信息
    public function personalinfo(){
        $this->checklogin();

        $uid = $_SESSION['uid'];
        $user = D('userinfo');
        $person = $user->where('uid='.$uid)->find();

        $this->assign('person',$person);
        $this->display();
    }

    /**
    * 用户注销
    */
    public function signinout()
    {
        // 清楚所有session
        header("Content-type: text/html; charset=utf-8");
        session(null);
        redirect(U('User/signin'), 2, '正在退出登录...');
    }

    //全民返佣详细记录
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


    public function mult_unique($array)
    {
        foreach($array as &$list_array)
        {
            $new_arrays = array();
            $new_arrays[] = $list_array[0];
            foreach($new_arrays as &$new_array)
            {
                $i = 1;
                foreach($list_array as $row_array)
                {
                    if(($new_array['uid'] != $row_array['uid']) && ($i >= count($new_arrays)) && ($row_array['uid']))
                    {
                        $new_arrays[] = $row_array;
                    }
                    $i++;
                }
            }
            $list_array = $new_arrays;
        }
        return $array;
    }


   public function ulist()
   {
        $this->checklogin();

      $userObj    = M('userinfo');
      $accountObj = M('accountinfo');
      $orderObj   = M('order');

     /*筛选*/
      $phone = trim(I('get.phone'));
      $username = trim(I('get.username'));
      $starttime = trim(I('get.starttime'));
      $endtime = trim(I('get.endtime'));
      $operate = trim(I('get.operate'));
      $oid = trim(I('get.oid'));
      $puhui_id = trim(I('get.puhui_id'));
      $jid = trim(I('get.jid'));
      $ustatus = trim(I('get.ustatus'));


      $map['otype']    = 0;
      $map['utel']     = array('exp','is not null');
      $map['username'] = array('exp','is not null');


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
      if ($ustatus) {
            $map['ustatus'] = array('eq',$ustatus);
            $sea['ustatus'] = $ustatus;
      } else {
            $map['ustatus'] = array('neq','7');
            $sea['ustatus'] = $ustatus;
      }

      if($operate)
      {
        $userid = get_userid($operate,0);
        $map['uid'] = array('in',$userid);
        $sea['operate'] = $operate;
      }

      if($oid)
      {
        $userid = get_userid($oid,0);
        $map['uid'] = array('in',$userid);
        $sea['oid'] = $oid;

        $oidinfo = M('userinfo')->where(array('uid' => $oid))->find();
        $this->assign('oidinfo',$oidinfo);
      }

      if($puhui_id)
      {
        $userid = get_userid($puhui_id,0);
        $map['uid'] = array('in',$userid);
        $sea['puhui_id'] = $puhui_id;

        $puhuiinfo = M('userinfo')->where(array('uid' => $puhui_id))->find();
        $this->assign('puhuiinfo',$puhuiinfo);
      }

      if($jid)
      {
        $userid = get_userid($jid,0);
        $map['uid'] = array('in',$userid);
        $sea['jid'] = $jid;

        $jidinfo = M('userinfo')->where(array('uid' => $jid))->find();
        $this->assign('jidinfo',$jidinfo);
      }

      if($operate)
      {
          $uinfo_where['user1.otype'] = array('eq',2);
          $uinfo_where['user1.oid'] = array('eq',$operate);
          $oid = $oid?$oid:-1;
          $puhui_id = $puhui_id?$puhui_id:-1;
          $all_agents = $userObj->where($uinfo_where)->field('user1.uid as uid1,user1.username as username1,user1.otype as otype1,
                                                              user2.uid as uid2,user2.username as username2,user2.otype as otype2,
                                                              user3.uid as uid3,user3.username as username3,user3.otype as otype3')->table('wp_userinfo user1')
          ->join("left join wp_userinfo user2 on user1.uid = user2.unit_id and user2.otype = 4 and user2.oid = $oid")
          ->join("left join wp_userinfo user3 on user2.uid = user3.leaguer_id and user3.otype = 1 and user3.oid = $puhui_id")
          ->select();
          foreach($all_agents as $agents_list)
          {
              $all_agent['mem'][] = array(
                  'uid'=>$agents_list['uid1'],
                  'username'=>$agents_list['username1'],
                  'otype'=>$agents_list['otype1'],
              );
              $all_agent['one'][] = array(
                  'uid'=>$agents_list['uid2'],
                  'username'=>$agents_list['username2'],
                  'otype'=>$agents_list['otype2'],
              );
              $all_agent['two'][] = array(
                  'uid'=>$agents_list['uid3'],
                  'username'=>$agents_list['username3'],
                  'otype'=>$agents_list['otype3'],
              );
          }

          $all_agent = $this->mult_unique($all_agent);
          $this->assign('all_agent',$all_agent);
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
   //    echo M()->getLastSql();
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
      $this->display();
   }

  /**
   * 客户列表导出
   */









    //会员列表
    public function ulist_back()
    {
        $step = I('get.step');
        $this->checklogin();
        $tq=C('DB_PREFIX');
        $user = D('userinfo');
        $order = D('order');
        $account = D('accountinfo');

        $operate = $user->where('otype=5')->select();
        $this->assign('operate',$operate);

        $huilist = $user->where("otype = 2")->select();
        $this->assign("huilist",$huilist);

        $puhuilist = $user->where("otype = 4")->select();
        $this->assign("puhuilist",$puhuilist);

        $jlist = $user->where("otype = 1")->select();
        $this->assign("jlist",$jlist);

        $field = $tq.'userinfo.username as username,'.$tq.'userinfo.uid as uid,'.$tq.'userinfo.utel as utel,'.$tq.'userinfo.address as address,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.oid as oid,'.$tq.'userinfo.managername as managername,'.$tq.'userinfo.lastlog as lastlog,'.$tq.'accountinfo.balance as balance,'.$tq.'userinfo.otype as otype,'.$tq.'userinfo.ustatus as ustatus,'.$tq.'userinfo.uip as uip';
        $phone = $_GET['phone'];
        $username = $_GET['username'];
        $starttime =I('get.starttime','');// $_GET['starttime'];
        $endtime = I('get.endtime','');// $_GET['endtime'];
        $oid = $_GET['oid'];
        if($phone)
        {
            $where[$tq.'userinfo.utel'] = array('like','%'.$_GET["phone"].'%');
            $sea['phone'] = $_GET["phone"];
        }
        $username = $_GET['username'];
        if($username)
        {
            $where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
            $sea['username'] = $_GET["username"];
        }else{
            $where[$tq.'userinfo.username'] =array('neq','');
        }

            if($starttime || $endtime){
                if(!$endtime){
                    $endtime = date('Y-m-d',time());
                }
                $where[$tq.'userinfo.utime'] = array('between',array(strtotime($starttime),strtotime($endtime)+86400));
                $sea['starttime'] = $starttime;
                $sea['endtime'] = $endtime;
            }


        if($oid)
        {
            $oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
            foreach ($oids as $key => $value) {
                 $oids2[]=$value['uid'];
            }
             $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids2));
            $sea['oid'] = $oid;

        }

          $puhui_id = $_GET['puhui_id'];

        if($puhui_id)
        {
            // $puhui_ids = getDownuids($puhui_id);

            // $where[$tq.'userinfo.uid'] = array("in",implode(',',$puhui_ids));
            $puhui_ids=M("userinfo")->field("uid")->where("leaguer_id=".$puhui_id)->select();
            foreach ($puhui_ids as $key => $value) {
                 $puhui_ids2[]=$value['uid'];
            }

             $where[$tq.'userinfo.uid']  = array("in",implode(',',$puhui_ids2));
            $sea['puhui_id'] = $puhui_id;
        }


        $jid = $_GET['jid'];
        if($jid)
        {
            // $jids = $user->field("uid")->where("oid=".$jid)->select();
            // foreach($jids as $val){
            //  $jids[] = $val['uid'];
            // }
            // $where['wp_userinfo.uid'] = array("in",implode(',',$jids));
            $jids=M("userinfo")->field("uid")->where("agent_id=".$jid)->select();
            foreach ($jids as $key => $value) {
                 $jids2[]=$value['uid'];
            }
             $where[$tq.'userinfo.uid'] = array("in",implode(',',$jids2));
            $sea['jid'] = $jid;
        }

        $where[$tq.'userinfo.otype'] =array('NEQ',3);
        $this->assign("sea",$sea);
        //分页
        $count = $user->where($where)->count();
        $pagecount = 10;
        $page = new \Think\Page($count , $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
        //查询用户和账户信息
        $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->field($field)->order($tq.'userinfo.uid desc')->limit($page->firstRow.','.$page->listRows)->select();
        //dump($user);die;
        $ulist_more = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->field($field)->order($tq.'userinfo.uid desc')->select();
        $summoney = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->field($field)->order($tq.'userinfo.uid desc')->sum("balance");

        //循环用户id，获取该用户的所有订单数
        $broker_id='';//返佣人员的id号串初始化;
        foreach($ulist as $k => $v){
            //$v['uid'];
            $ocount = $order->where($tq.'order.uid='.$v['uid'])->count();
            $ulist[$k]['ocount'] = $ocount;
            $ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
            $ulist[$k]['managername']=M('userinfo')->where('uid='.$v['oid'])->getField('username');
            $agent=M('agent')->where('oid='.$v['uid'])->sum('add_money');
            if($agent!=""){
                $ulist[$k]['agent']=$agent;
            }else{
                $ulist[$k]['agent']=0;
            }
        }

        $this->assign('page',$show);
        $this->assign('ulist',$ulist);


        //统计
        //用户数量
        $userCount = $user->where('ustatus=0')->count();
        //交易手数
        $orders = $order->where('ostaus=1')->field('onumber')->select();
        //所有用户账户余额统计
        $acc = $account->field('balance')->select();
        $onumber = 0;
        $anumber = 0;
        foreach($orders as $k => $v){
            $onumber += $orders[$k]['onumber'];
        }
        foreach($acc as $k => $v){
            $anumber += $acc[$k]['balance'];
        }
        $anumber = number_format($anumber,2);
        //返佣总金额
        $brokerage=0.00;
        foreach($ulist_more as $v){
            $agent_total=M('agent')->where('oid='.$v['uid'])->sum('add_money');
            if($agent_total!=""){
                $brokerage += $agent_total;
            }
        }

        $this->assign('brokerage',$brokerage);
        $this->assign('summoney',$summoney);
        $this->assign('onumber',$onumber);
        $this->assign('anumber',$anumber);
        $this->assign('ucount',$userCount);
        $this->display();
    }
    //会员列表
    public function daochu()
    {
        $this->checklogin();
        $tq=C('DB_PREFIX');
        $user = D('userinfo');
        $order = D('order');
        $account = D('accountinfo');
        $huilist = $user->where("otype = 2")->select();
        $this->assign("huilist",$huilist);

        $field = $tq.'userinfo.username as username,'.$tq.'userinfo.uid as uid,'.$tq.'userinfo.utel as utel,'.$tq.'userinfo.address as address,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.oid as oid,'.$tq.'userinfo.managername as managername,'.$tq.'userinfo.lastlog as lastlog,'.$tq.'accountinfo.balance as balance,'.$tq.'userinfo.otype as otype';
        $phone = $_GET['phone'];
        $username = $_GET['username'];
        $starttime = $_GET['starttime'];
        $endtime = $_GET['endtime'];
        $oid = $_GET['oid'];
        if($phone)
        {
            $where[$tq.'userinfo.utel'] = array('like','%'.$_GET["phone"].'%');
            $sea['phone'] = $_GET["phone"];
        }
        $username = $_GET['username'];
        if($username)
        {
            $where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
            $sea['username'] = $_GET["username"];
        }
        if($_GET["starttime"] && $_GET["endtime"]){
            $starttime = strtotime($starttime." 00:00:00");
            $endtime = strtotime($endtime." 23:59:59");
            $where[$tq.'userinfo.utime'] = array('between',array($starttime,$endtime));
            $sea['starttime'] = $_GET["starttime"];
            $sea['endtime'] = $_GET["endtime"];
        }
        if($oid)
        {
            // $oids = getDownuids($oid);

            // $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
            $oids=M("userinfo")->field("uid")->where("unit_id=".$oid)->select();
            foreach ($oids as $key => $value) {
                 $oids2[]=$value['uid'];
            }
             $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids2));
            $sea['oid'] = $oid;
        }

          $puhui_id = $_GET['puhui_id'];

        if($puhui_id)
        {
            // $puhui_ids = getDownuids($puhui_id);

            // $where[$tq.'userinfo.uid'] = array("in",implode(',',$puhui_ids));
            $puhui_ids=M("userinfo")->field("uid")->where("leaguer_id=".$puhui_id)->select();
            foreach ($puhui_ids as $key => $value) {
                 $puhui_ids2[]=$value['uid'];
            }

             $where[$tq.'userinfo.uid']  = array("in",implode(',',$puhui_ids2));
            $sea['puhui_id'] = $puhui_id;
        }


        $jid = $_GET['jid'];
        if($jid)
        {
            // $jids = $user->field("uid")->where("oid=".$jid)->select();
            // foreach($jids as $val){
            //  $jids[] = $val['uid'];
            // }
            // $where['wp_userinfo.uid'] = array("in",implode(',',$jids));
            $jids=M("userinfo")->field("uid")->where("agent_id=".$jid)->select();
            foreach ($jids as $key => $value) {
                 $jids2[]=$value['uid'];
            }
             $where[$tq.'userinfo.uid'] = array("in",implode(',',$jids2));
            $sea['jid'] = $jid;
        }
        //查询用户和账户信息
        $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->field($field)->order($tq.'userinfo.uid desc')->select();
        $data[0] = array('编号','用户','手机号','创建时间','上级','订单数量','帐户余额','会员类别');
        foreach($ulist as $k => $v){
            $data[$k+1][] = $v['uid'];
            $data[$k+1][] = $v['username'];
            $data[$k+1][] = $v['utel'];
            $data[$k+1][] = date("Y-m-d H:i:s",$v['utime']);
            $data[$k+1][]=M("userinfo")->where("uid=".$v['oid'])->getField('username');
            $ocount = $order->where($tq.'order.uid='.$v['uid'])->count();
            $data[$k+1][] = $ocount;
            $data[$k+1][] = number_format($v['balance'],2);
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
        //dump($data);die;
        $name='Excelfile';  //生成的Excel文件文件名
        $res=$this->push($data,$name);
        $info = '导出信息';
        user_log($info,2);
    }
    public function push($data,$name){
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data,$name);
    }
    public function recommend(){
        $recommend=M("webconfig")->field("recommend,recommend2")->where("id=1")->find();

        $this->assign("recommend",$recommend['recommend']);
        $this->assign("recommend2",$recommend['recommend2']);
        $this->display();
    }
    public function act_recommend(){

        $recommend=$_POST['recommend'];
        $recommend2=$_POST['recommend2'];
        $data['recommend']=$recommend;
        $data['recommend2']=$recommend2;
        M("webconfig")->where("id=1")->save($data);
        $this->success("修改成功",U("index/index"));
    }

    //经纪人申请列表
    public function agentlist(){
      $tq   = C('DB_PREFIX');
      $user = M('userinfo');

      $username  = trim(I('get.username'));
      $tel       = trim(I('get.tel'));
      $starttime = trim(I('get.starttime'));
      $endtime   = trim(I('get.endtime'));
      $operate   = trim(I('get.operate'));
      $oid       = trim(I('get.oid'));
      $puhui_id  = trim(I('get.puhui_id'));
      $jid       = trim(I('get.jid'));

      if($username)
      {
        $map['username'] = array('like','%'.$username.'%');
        $sea['username'] = $username;
      }

      if($tel)
      {
        $map['utel'] = array('like','%'.$tel.'%');
        $sea['tel'] = $tel;
      }

      if($starttime && $endtime)
      { 
        $start_time = strtotime($starttime);
        $end_time   = strtotime($endtime);
        $map['utime']     = array('between',array($start_time,$end_time));
        $sea['starttime'] = $starttime;
        $sea['endtime']   = $endtime;
      }
      
      if($operate)
      {
        $userid = get_userid($operate,0);
        $map['uid'] = array('in',$userid);
        $sea['operate'] = $operate;
      }

      if($oid)
      {
        $userid = get_userid($oid,0);
        $map['uid'] = array('in',$userid);
        $sea['oid'] = $oid;

        $oidinfo = M('userinfo')->field('uid,username')->where(array('oid' => $operate,'otype' => 2))->select();
        $this->assign('oidinfo',$oidinfo);
      }

      if($puhui_id)
      {
        $userid = get_userid($puhui_id,0);
        $map['uid'] = array('in',$userid);
        $sea['puhui_id'] = $puhui_id;

        $puhuiinfo = M('userinfo')->field('uid,username')->where(array('oid' => $oid,'otype' => 4))->select();
        $this->assign('puhuiinfo',$puhuiinfo);
      }

      if($jid)
      {
        $userid = get_userid($jid,0);
        $map['uid'] = array('in',$userid);
        $sea['jid'] = $jid;

        $jidinfo = M('userinfo')->field('uid,username')->where(array('oid' => $puhui_id,'otype' => 1))->select();
        $this->assign('jidinfo',$jidinfo);
      }


      $map['agenttype'] = 1;

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

      $list = $user->
              where($map)->order('uid desc')->
              limit($page->firstRow . ',' . $page->listRows)->
              select();



      $this->assign('sea',$sea);
      $this->assign('page',$show);
      $this->assign('list',$list);
      $this->assign('operate',$user->field('uid,username')->where(array('otype' =>5))->select());
      $this->assign('count',$count);
      $this->display();
    }


    //处理代理申请是否通过
    public function edituser(){
        $user = D('userinfo');
        $uid=I('get.uid');
        $otype=I('get.otype');
        $up = $user->where("uid=".$uid)->find();
        if ($otype==0) {
            //拒绝
            $date['agenttype']=0;
            $info = '拒绝id=【'.$uid.'代理申请】';
            user_log($info,2);
            if($user->where("uid=".$uid)->save($date)){
                M('managerinfo')->where('uid='.$uid)->delete();
            }
        }else{
            if($up['oid']){
                //通过
                $upp = $user->where("uid=".$up['oid'])->find();
                if($upp['otype'] == 1){
                    $data['oid'] = $upp['oid'];
                }elseif($upp['otype'] > 1){
                    $data['oid'] = $up['oid'];
                }
            }else{
                $data['oid'] = '285';
            }

            $date['agenttype']=2;
            $date['otype']=0;
            $user->where("uid=".$uid)->save($date);
            $info = '通过id=【'.$uid.'代理申请】';
            user_log($info,2);
        }
       $this->redirect('User/agentlist');
    }



    //手动充值验证用户信息
    public function validate(){
        $phone = I('post.phone');

        $data = M("userinfo")->join("wp_accountinfo ON wp_accountinfo.uid = wp_userinfo.uid")->where(array('wp_userinfo.utel'=>$phone,'wp_userinfo.otype'=>0))->find();

        if ($data['otype'] == 2) {
            $arr['money'] = $data['assure'];
        }else{
            $arr['money'] = $data['balance'];
        }
        $arr['id'] = $data['uid'];

        $arr['username'] = $data['username'];
        echo json_encode($arr);die;
    }
    public function addmoney(){

        $this->checklogin();
        $this->display();
    }
    public function downpay()
    {
        if($_POST){

            $phone = I("post.phone");
            $money = I("post.money");
            $password=I("post.passwd");
            $user = M("userinfo");
            $upwd=$user->where('uid='.$_SESSION['userid'])->getField('upwd');

            if(!$money){
                $this->error('金额不能为空');
            }

            $user = M("userinfo");
            $accinfo = M("accountinfo");
            $uid = $user->where(array('utel'=>$phone,'otype'=>0))->getField('uid');
            if(!$uid){
                $this->error('不存在该用户');
            }

            $otype = $user->where('utel='.$phone)->getField('otype');

            if($otype == 2){
                $nowmoeny =  $user->where('uid='.$uid)->getField('assure');
                $data['assure']=$nowmoeny+$money;
                $a = $user->where('uid='.$uid)->save($data);
            }else{
                $nowmoeny =  $accinfo->where('uid='.$uid)->getField('balance');
                $data['balance']=$nowmoeny+$money;
                // var_dump($uid);die;
                $a = $accinfo->where('uid='.$uid)->save($data);
            }


            if($a){
                $nowmoenys =  $accinfo->where('uid='.$uid)->getField('balance');
                $datas['bptype']='充值';
                $datas['bptime']=time();
                $datas['bpprice']=$money;
                $datas['remarks'] = '手动充值';
                $datas['uid'] = $uid;
                $datas['isverified'] = 1;
                $datas['cltime'] = time();
                $datas['shibpprice'] = $nowmoenys;//用户余额
                $datas['pay_type'] = 0;//支付类型，0手动
                $datas['b_type'] =1;
                $datas['balanceno'] = "SD".time();
                // var_dump($datas);die;
                M("balance")->add($datas);
                $this->success('更新成功1','recharge');
                $info = '手动充值【'.$uid.'用户】'.$money.'元';
                user_log($info,2);
            }else{
                $this->error('更新失败');
            }
        }else{
            $this->display();
        }
    }
    public function jingjishen()
    {
        $uid = $_REQUEST['uid'];
        $row = M('userinfo')->where('uid='.$uid)->find();
        if($row['agenttype'] == 1)
        {
            echo 3;exit;
        }
        $map['agenttype'] = 1;
        $t = M('userinfo')->where('uid='.$uid)->save($map);
        if($t)
        {
            echo 1;exit;
        }else{
            echo 2;exit;
        }
    }
    //修改会员
    public function updateuser()
    {

        //检测用户是否登陆
        $this->checklogin();

        //实例化数据表
        $tq=C('DB_PREFIX');
        $user = D('userinfo');
        $manager = D('managerinfo');
        $bank = D('bankinfo');
        $acinfo = D('accountinfo');
        $order = D('order');
        //判断如果是post，执行修改用户方法，否则显示视图
        if(IS_POST){
            $uid = I('post.uid');               //用户id
            $username = I('post.username');     //用户名
            $mname = I('post.mname');           //真实姓名
            $upwd = I('post.upwd');             //密码
            $otype = I('post.otype');           //用户类型
            if($otype=='客户'){
                $otype=0;
            }else if($otype=='会员'){
                $otype=2;
            }else if($otype=='代理商'){
                $otype=1;
            }
            $utel = I('post.utel');             //手机号码
            $brokerid = I('post.brokerid');     //身份证号码
            $banknumber = I('post.banknumber'); //银行卡号
            $branch = I('post.branch');         //开户行地址
            $bankname = I('post.bankname');     //所属银行
            $province = I('post.province');     //省份
            $city = I('post.city');             //城市
            $busername = I('post.busername');   //持卡人
            $balance = I('post.balance');       //账户余额

            //取值，如果没有做修改，保存原有值
            $users = $user->where('uid='.$uid)->find();
            $mginfo = $manager->where('uid='.$uid)->find();
            $banks = $bank->where('uid='.$uid)->find();
            $accinfo = $acinfo->where('uid='.$uid)->find();

            if($username)
            {
                $users['username'] = $username;
            }
            //判断密码是否为空
            if(!empty($upwd)){
                $users['upwd'] = md5($upwd);
            }
            //判断电话是否为空
            if(!empty($utel)){
                $users['utel'] = $utel;
            }
            //判断真实姓名是否为空
            if(!empty($mname)){
                $mginfo['mname'] = $mname;
            }
            //判断身份证号码是否为空
            if(!empty($brokerid)){
                $mginfo['brokerid'] = $brokerid;
            }
            //判断银行卡号是否为空
            if(!empty($banknumber)){
                $banks['banknumber'] = $banknumber;
            }
            //判断开户行地址是否为空
            if(!empty($branch)){
                $banks['branch'] = $branch;
            }
            //判断所属银行是否为空
            if(!empty($bankname)){
                $banks['bankname'] = $bankname;
            }
            //判断省份是否为空
            if(!empty($province)){
                $banks['province'] = $province;
            }
            //判断城市是否为空
            if(!empty($city)){
                $banks['city'] = $city;
            }
            //判断持卡人是否为空
            if(!empty($busername)){
                $banks['busername'] = $busername;
            }
            //判断账户余额
            if(!empty($balance)){
                $accinfo['balance'] = $balance;
            }
            //判断是否为普通用户修改会员单位
            if(isset($_POST['huiyuandanwei']) && !empty($_POST['huiyuandanwei'])){
                $users['unit_id']=$_POST['huiyuandanwei'];
            }
            //判断是否为普通用户修改普通会员
            if(isset($_POST['putonghuiyuan']) && !empty($_POST['putonghuiyuan'])){
                $users['leaguer_id']=$_POST['putonghuiyuan'];
            }
            //判断是否为普通用户修改经纪人
            if(isset($_POST['jingjiren']) && !empty($_POST['jingjiren'])){
                $users['agent_id']=$_POST['jingjiren'];
                $users['oid']=$_POST['jingjiren'];
            }
            //dump($users);exit;
            //修改用户基本信息

            $userlist = $user->where('uid='.$uid)->find();
            if (empty($userlist)) {
                $this->error('用户不存在');
                exit();
            }
            //判断客户名是否重复
            $uname = $user->where('username=\''.$username.'\'')->find();
            if ($uname) {
                if ($uname['uid'] != $uid) {
                    $this->error('客户名重复请更换');
                    exit();
                }
            }

            $resultUser = $user->where('uid='.$uid)->save($users);
            //修改用户真实信息
            $resultManager = $manager->where('uid='.$uid)->save($mginfo);
            //修改账户余额
            if($balance)
            {
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
                    $money_log['note'] ='管理员对['.$username.']账户加款'.$balance.'元';
                    $money_log['op_id'] =$_SESSION['userid']?$_SESSION['userid']:0;
                    $money_log['user_type'] = 0;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
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
                    $money_log['note'] ='管理员对['.$username.']账户减款'.$balance.'元';
                    $money_log['op_id'] =$_SESSION['userid']?$_SESSION['userid']:0;
                    $money_log['user_type'] = 0;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                    $money_log['change_money'] = $balance;
                    $money_log['balance'] = $now_money + $balance;
                    $money_log['dateline'] = time();
                    $money_log['tempdate'] = date('Y-m-d H:i:s');
                    $money_log_id = M('money_flow')->add($money_log);
                    user_log('账户减款',2);
                }

            }
            //判断用户是否存在银行卡信息
            if($banks['uid']==$uid){
                //修改银行卡信息
                $resultBank = $bank->where('uid='.$uid)->save($banks);
            }else{
                $banks['uid'] = $uid;
                //添加银行卡信息
                $resultBank = $bank->add($banks);
            }

            if($resultUser || $resultManager || $resultBank || $resultAcinfo){
               user_log("修改【".$username."】用户资料",2);

               $this->success('修改成功');
            }else if($resultUser==0 || $resultManager==0 || $resultBank==0 || $resultAcinfo==0){
                $this->error('未做任何修改');
            }else{
                $this->error('修改失败');
            }

        }else{
            //根据获取的用户id查询该用户的信息，展示视图
            $uid=I('get.uid');
            //需要查询的字段
            $field = $tq.'userinfo.uid as uid,'.$tq.'userinfo.username as username,'.$tq.'userinfo.oid as oid,'.$tq.'userinfo.managername as managername,'.$tq.'userinfo.otype as otype,'.$tq.'userinfo.utel as utel,'.$tq.'managerinfo.mname as mname,'.$tq.'managerinfo.brokerid as brokerid,'.$tq.'bankinfo.bankname as bankname,'.$tq.'bankinfo.province as province,'.$tq.'bankinfo.city as city,'.$tq.'bankinfo.branch as branch,'.$tq.'bankinfo.banknumber as banknumber,'.$tq.'bankinfo.bankname as bankname,'.$tq.'bankinfo.busername as busername,'.$tq.'accountinfo.balance as balance,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.ustatus as ustatus,'.$tq.'userinfo.operate_id as operate_id,'.$tq.'userinfo.agent_id as agent_id';
            //修改用户显示的数据
            $userme = $user->join($tq.'managerinfo on '.$tq.'userinfo.uid='.$tq.'managerinfo.uid','left')->join($tq.'bankinfo on '.$tq.'userinfo.uid='.$tq.'bankinfo.uid','left')->join($tq.'accountinfo on '.$tq.'accountinfo.uid='.$tq.'userinfo.uid','left')->field($field)->where($tq.'userinfo.uid='.$uid)->find();
            $userlist = M("userinfo")->where("otype=2")->getField('uid,username');
            $sys = $user->field('otype')->where('uid='.$userme['oid'])->find();
            //账户余额
            $account = $acinfo->field('balance,frozen')->where('uid='.$uid)->find();
            $account['balance'] = number_format($account['balance'],2);
            //个人账户佣金
             $list= M("userinfo")->field("otype,unit_id,leaguer_id,agent_id")->where("uid=".$uid)->find();
             $userlist2=M("userinfo")->getField('uid,username');

            if($userlist[$list['unit_id']]){
                $data["info"] = "<option value='".$list['unit_id']."'>".$userlist2[$list['unit_id']]."</option>";
                 $leaguer_userlist = M("userinfo")->where("otype=4 and unit_id=".$list['unit_id'])->getField('uid,username');

                if($userlist2[$list['leaguer_id']]){
                     $leaguer_id ="<option value='" .$list['leaguer_id']. "'>" .$userlist2[$list['leaguer_id']]. "</option>";
                }else{
                     $leaguer_id ="<option value=''>无</option>";
                }
                if($leaguer_userlist[$list['leaguer_id']]){
                     unset($leaguer_userlist[$list['leaguer_id']]);
                }

                 if(is_array($leaguer_userlist)){
                    // $leaguer_id="<option value=''>请选择</option>";
                     foreach($leaguer_userlist as $key=>$vo) {
                    $leaguer_id.="<option value='" .$key . "'>" . $vo. "</option>";
                   }
                 }

                 $agent_userlist = M("userinfo")->where("otype=1 and unit_id=".$list['unit_id'])->getField('uid,username');

                if(isset($userlist2[$list['agent_id']])){
                     $agent_id ="<option value='" .$list['leaguer_id']. "'>" .$userlist2[$list['agent_id']]. "</option>";
                }else{
                    $agent_id ="<option value=''>无</option>";
                }

                 if(isset($agent_userlist[$list['agent_id']])){
                      unset($agent_userlist[$list['agent_id']]);
                 }

                 if(is_array($agent_userlist)){
                    //$agent_id.="<option value=''>请选择</option>";
                    foreach($agent_userlist as $key=>$vo) {
                    $agent_id.="<option value='" .$key . "'>" . $vo . "</option>";
                   }
                 }


            }else{
                $data["info"] = "<option value=''>无</option>";
            }
                unset($userlist[$list['unit_id']]);
                foreach ($userlist as $key=>$vo) {
                    $data["info"].="<option value='" .$key . "'>" . $vo. "</option>";
                }
             //运营中心
                $operate = M('userinfo')->where(array('otype'=>5))->select();
            //echo $user->getLastSql();
            $agent = M('userinfo')->field('username,uid')->where(array('uid'=>$userme['agent_id']))->find();
            $this->assign('agent',$agent);
            $this->assign('sys',$sys);
            $this->assign('type',$list["otype"]);
            $this->assign('userlist', $data["info"]);
            $this->assign('leaguer_id', $leaguer_id);
            $this->assign('agent_id', $agent_id);
            $this->assign('userme',$userme);
            $this->assign('account',$account);
            $this->assign('operate',$operate);
            $this->display();
        }

    }
    public function deldata(){
        $where['bpid'] = I("post.bpid");
        M("balance")->where($where)->delete();
    }
    public function index()
    {
        $this->display('ulist');
    }
    /**
     * 添加会员
     * */
    public function addmenber(){

        $this->display();
    }
    /**
     * 添加客户
     * */
    public function adduser(){

        $this->display();
    }
    public function userdel(){

        $user = D('userinfo');
        //单个删除
        $uid = I('get.uid');
        $result = $user->where('uid='.$uid)->delete();
        if($result!==FALSE){
            $this->success("成功删除！",U("User/ulist"));
        }else{
            $this->error('删除失败！');
        }
    }
    public function daochu1(){
        $this->checklogin();
        //读出提现和充值列表
        $balance = D('balance');
        $tq=C('DB_PREFIX');
        $step = I('get.step');
        $user = M("userinfo");
        //查询多条记录
        $field = $tq.'userinfo.username as username,'.$tq.'balance.uid as uid,'.$tq.'balance.bpid as bpid,'.$tq.'balance.bptype as bptype,'.$tq.'balance.bptime as bptime,'.$tq.'balance.bpprice as bpprice,'.$tq.'balance.remarks as remarks,'.$tq.'balance.isverified as isverified,'.$tq.'accountinfo.balance as balance,'.$tq.'balance.cltime as cltime,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.utel as utel,'.$tq.'userinfo.oid as oid';
        //过滤搜索
        $huilist = $user->where("otype = 2")->select();
        $this->assign("huilist",$huilist);
        $where = "";
        //获取用户名，生产模糊条件
        $username = $_GET['username'];
        //获取订单时间
        $starttime = date('Y-m-d',strtotime($_GET["starttime"]));
        $endtime = date('Y-m-d',strtotime($_GET["endtime"]));
        //获取订单类型
        $type = $_GET['type'];
        //获取订单盈亏
        $ploss = $_GET['ploss'];
        //获取订单状态
        $ostaus = $_GET['ostaus'];
        $oid = $_GET['oid'];
        if($oid)
        {
            $oids = getDownuids($oid);
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
        $where[$tq.'balance.isverified'] = array("eq",1);
        if($where){
            $rechargelist = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->where($where)->order($tq.'balance.bptime desc')->select();
        }else{
            $rechargelist = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->order($tq.'balance.bptime desc')->select();
        }
        $data[0] = array('编号','用户','上级','手机号','金额','完成时间','帐户余额','类型','是否通过');
        foreach($rechargelist as $k => $v){
            $data[$k+1][] = $v['uid'];
            $data[$k+1][] = $v['username'];
            $data[$k+1][]=M("userinfo")->where("uid=".$v['oid'])->getField('username');
            $data[$k+1][] = $v['utel'];
            $data[$k+1][] = $v['bpprice'];
            $data[$k+1][] = date("Y-m-d H:i:s",$v['cltime']);
            $data[$k+1][] = number_format($v['balance'],2);
            $data[$k+1][] = $v['bptype'];
            if($v['isverified'] == 1 )
            {
                $data[$k+1][] = "已通过";
            }else{
                $data[$k+1][] = "未通过";
            }
        }
        $name='Excelfile';  //生成的Excel文件文件名
        $res=$this->push($data,$name);
    }
    public function recharge(){

        $this->checklogin();
        //读出提现和充值列表
        $balance = D('balance');
        $tq=C('DB_PREFIX');
        $step = I('get.step');
        $user = M("userinfo");
        //查询多条记录
        $field = $tq.'userinfo.username as username,'.$tq.'balance.uid as uid,'.$tq.'balance.bpid as bpid,'.$tq.'balance.bptype as bptype,'.$tq.'balance.bptime as bptime,'.$tq.'balance.bpprice as bpprice,'.$tq.'balance.shibpprice as shibpprice,'.$tq.'balance.remarks as remarks,'.$tq.'balance.isverified as isverified,'.$tq.'accountinfo.balance as balance,'.$tq.'balance.cltime as cltime';
        //过滤搜索
        $huilist = $user->where("otype = 2")->select();
        $this->assign("huilist",$huilist);
        $where = "";
        //获取用户名，生产模糊条件
        $username = $_GET['username'];
        //获取订单时间
        $starttime = I('get.starttime',0);//date('Y-m-d',strtotime($_GET["starttime"]));
        $endtime = I('get.endtime',0); //date('Y-m-d',strtotime($_GET["endtime"]));
        //获取订单类型
        $type = $_GET['type']?$_GET['type']:'充值';
        $template = 'recharge_c';
        if($type=='提现'){
            $template = 'recharge_t';
        }
        //获取订单盈亏
        $ploss = $_GET['ploss'];
        //获取订单状态
        $ostaus = $_GET['ostaus'];
        $oid = $_GET['oid'];
        if($oid)
        {
            $oids = getDownuids($oid);
            $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
            $sea['oid'] = $oid;
        }
        if($username){
            $where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
            $sea['username'] = $_GET["username"];
        }

        if($starttime || $endtime){
            if(!$endtime){
                $endtime = date('Y-m-d',time());
            }
            $where[$tq.'balance.bptime'] = array('between',array(strtotime($starttime),strtotime($endtime)+86400));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
        }

        if($type!=""){
            $where[$tq.'balance.bptype'] = array("eq",$type);
            $sea['type'] = $type;
        }
        if($where){
            $count = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->where($where)->count();
        }else{
            $count = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->count();
        }
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
        if($where){
            $rechargelist = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->where($where)->limit($start,$end)->order($tq.'balance.bptime desc')->select();
            $rechargelist_all = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->where($where)->select();
        }else{
            $rechargelist = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->limit($start,$end)->order($tq.'balance.bptime desc')->select();

            $rechargelist_all = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->select();
        }
//print_r($rechargelist[0]);
        foreach($rechargelist as $k => $v){
            if($type!='提现'){
                $rechargelist[$k]['balance'] = $balance->where("uid=".$rechargelist[$k]['uid']." and cltime<={$v['cltime']}")->sum('bpprice');
            }
            $rechargelist[$k]['bptime'] = date("Y-m-d H:i:m",$rechargelist[$k]['bptime']);
            if($rechargelist[$k]['cltime']==""){
                $rechargelist[$k]['cltime']="";
            }else{
                $rechargelist[$k]['cltime'] = date("Y-m-d H:i:m",$rechargelist[$k]['cltime']);
            }
            $oid = M("userinfo")->where("uid=".$rechargelist[$k]['uid'])->getField('oid');
            $rechargelist[$k]['oid'] = M("userinfo")->where("uid=".$oid)->getField('username');
            $rechargelist[$k]['assure'] = M("userinfo")->where("uid=".$rechargelist[$k]['uid'])->getField('assure');
            $rechargelist[$k]['otype'] = M("userinfo")->where("uid=".$rechargelist[$k]['uid'])->getField('otype');
        }
        //print_r($rechargelist[0]);
        $sumsheng=$summoeny=$sumshibpprice=0;
        foreach($rechargelist_all as $k=>$vo){
            $sumsheng += $vo['balance'];
            $summoeny += $vo['bpprice'];
            $sumshibpprice += $vo['shibpprice'];
        }
        //dump($rechargelist);die;
        $show = $page->show();
        $this->assign("rechargelist",$rechargelist);
        $this->assign("summoeny",$summoeny);
        $this->assign("sumsheng",$sumsheng);
        $this->assign('sumshibpprice',$sumshibpprice);
        $this->assign("page",$show);
        $this->display($template);
    }
    public function chujin(){
        $this->checklogin();
        //读出提现和充值列表
        $balance = D('balance');
        $tq=C('DB_PREFIX');
        $step = I('get.step');
        $user = M("userinfo");
        //查询多条记录
        $field = $tq.'userinfo.username as username,'.$tq.'balance.uid as uid,'.$tq.'balance.bpid as bpid,'.$tq.'balance.bptype as bptype,'.$tq.'balance.bptime as bptime,'.$tq.'balance.bpprice as bpprice,'.$tq.'balance.shibpprice as shibpprice,'.$tq.'balance.remarks as remarks,'.$tq.'balance.isverified as isverified,'.$tq.'accountinfo.balance as balance,'.$tq.'balance.cltime as cltime';

        //过滤搜索
        $huilist = $user->where("otype = 2")->select();
        $this->assign("huilist",$huilist);
        $where = "";
        //获取用户名，生产模糊条件
        $username = $_GET['username'];
        //获取订单时间
        $starttime = I('get.starttime',0);//date('Y-m-d',strtotime($_GET["starttime"]));
        $endtime = I('get.endtime',0); //date('Y-m-d',strtotime($_GET["endtime"]));
        //获取订单类型
        $type = $_GET['type']?$_GET['type']:'充值';
        $template = 'chujin';
        if($type=='提现'){
            $template = 'recharge_t';
        }
        //获取订单盈亏
        $ploss = $_GET['ploss'];
        //获取订单状态
        $ostaus = $_GET['ostaus'];
        $oid = $_GET['oid'];
        if($oid)
        {
            $oids = getDownuids($oid);
            $where[$tq.'userinfo.uid'] = array("in",implode(',',$oids));
            $sea['oid'] = $oid;
        }
        if($username){
            $where[$tq.'userinfo.username'] = array('like','%'.$_GET["username"].'%');
            $sea['username'] = $_GET["username"];
        }

        if($starttime || $endtime){
            if(!$endtime){
                $endtime = date('Y-m-d',time());
            }
            $where[$tq.'balance.bptime'] = array('between',array(strtotime($starttime),strtotime($endtime)+86400));
            $sea['starttime'] = $starttime;
            $sea['endtime'] = $endtime;
        }

        if($type!=""){
            $where[$tq.'balance.bptype'] = array("eq",$type);
            $sea['type'] = $type;
        }
        if($where){
            $count = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->where($where)->count();
        }else{
            $count = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->count();
        }
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
        if($where){
            $rechargelist = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->where($where)->limit($start,$end)->order($tq.'balance.bptime desc')->select();

            $rechargelist_all = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->where($where)->select();
        }else{
            $rechargelist = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->limit($start,$end)->order($tq.'balance.bptime desc')->select();

            $rechargelist_all = $balance->join($tq.'userinfo on '.$tq.'balance.uid='.$tq.'userinfo.uid','left')->join($tq.'accountinfo on '.$tq.'balance.uid='.$tq.'accountinfo.uid','left')->field($field)->where("(wp_balance.bptype = '充值' and wp_balance.isverified = 1) or (wp_balance.bptype = '提现')")->select();
        }

        foreach($rechargelist as $k => $v){
            $rechargelist[$k]['bptime'] = date("Y-m-d H:i:m",$rechargelist[$k]['bptime']);
            if($rechargelist[$k]['cltime']==""){
                $rechargelist[$k]['cltime']="";
            }else{
                $rechargelist[$k]['cltime'] = date("Y-m-d H:i:m",$rechargelist[$k]['cltime']);
            }
            $oid = M("userinfo")->where("uid=".$rechargelist[$k]['uid'])->getField('oid');
            $rechargelist[$k]['oid'] = M("userinfo")->where("uid=".$oid)->getField('username');
        }
        $sumsheng=$summoeny=$sumshibpprice=0;
        foreach($rechargelist_all as $k=>$vo){
            $sumsheng += $vo['balance'];
            $summoeny += $vo['bpprice'];
            $sumshibpprice += $vo['shibpprice'];
        }
        $show = $page->show();
        $this->assign("rechargelist",$rechargelist);
        $this->assign("summoeny",$summoeny);
        $this->assign("sumsheng",$sumsheng);
        $this->assign('sumshibpprice',$sumshibpprice);
        $this->assign("page",$show);
        $this->display($template);
    }
    //更新充值提现状态
    public function upbalance(){
        $this->checklogin();
        //获取参数
        $bpid=I('post.bpid');
        $isverified = I('post.isverified');
        $remarks = I('post.remarks');
        $rebpprce=I('post.rebpprce');
        $userid=I('post.userid');
        $balance = D('balance');
        $accountinfo=M('accountinfo');
        $cltime = time();
        $type = M("balance")->where("bpid = ".$bpid)->getField("bptype");
        if($isverified=="1"){
            $isver=$balance->where('bpid='.$bpid)->setField(array('isverified'=>'1','cltime'=>$cltime));//1是同意
            if($type == "充值")
            {
                $date=$accountinfo->where('uid='.$userid)->find();
                $date['balance']=$date['balance']+$rebpprce;
                $accountinfo->where('uid='.$userid)->save($date);
            }
        }else if($isverified=="0"){
            $isver=$balance->where('bpid='.$bpid)->setField(array('isverified'=>'2','cltime'=>$cltime,));//2是拒绝

            if($type == "提现"){
                $userinfo = M('userinfo as u')->field('u.assure,u.username,u.otype,a.balance,a.frozen,a.uid')->join('wp_accountinfo as a ON a.uid = u.uid')->where(array('u.uid'=>$userid))->find();
//
//              vD($userinfo);
//              vD($rebpprce);
//              die();
                if($userinfo['otype'] == 2){
                    $userinfo1 = M('accountinfo')->where(array('uid'=>$userid))->setInc('balance',$rebpprce);
                    //$userinfo = M('userinfo')->where(array('uid'=>$userid))->setInc('assure',$rebpprce);
                }else{

                    $userinfo1 = M('accountinfo')->where(array('uid'=>$userid))->setInc('balance',$rebpprce);
                }
                user_log('管理员拒绝了['.$userinfo['username'].']的提现申请', '2');

                $accountNow = M('accountinfo')->field('balance')->where(array('uid'=>$userid))->find();
                $moneyData  = array(
                    'uid'           => $userid,
                    'user_type'     => $userinfo['otype'],
                    'oid'           => $bpid,
                    'type'          => 3,
                    'op_id'         => $_SESSION['userid'],
                    'change_money'  => $rebpprce,
                    'balance'       => $accountNow['balance'],
                    'dateline'      => time(),
                    'note'          => '拒绝提现，账户增加['.$rebpprce.']元'
                );
                M('money_flow')->add($moneyData);

            }
        }else{
            $isver=$balance->where('bpid='.$bpid)->setField(array('isverified'=>'0','cltime'=>$cltime));//0是初始值
        }

        if($isver){
            $this->ajaxReturn("success");
        }else{
            $this->ajaxReturn("null");
        }

    }




    public function checklogin()
    {
        $uid=islogin();
        if(!$uid)
        {
            $this->error('请登录','/Admin/User/signin');
        }
    }
    public function dongtis(){
        $this->checklogin();
        $uid=$_REQUEST['uid'];
        $types=$_REQUEST['types'];
        /*var_dump($uid."---".$types);
        exit;*/
        if($types==1){
            $a['ustatus']=1;
            $dongtis=M("userinfo")->where("uid = '".$uid."'")->save($a);
        }else if($types==2){
            $a['ustatus']=0;
            $dongtis=M("userinfo")->where("uid = '".$uid."'")->save($a);
        }
        if($dongtis){
            $this->success("操作成功!");
        }else{
            $this->error('操作失败,请重试!');
        }
    }
    public function find_agent() {
        $id = $_REQUEST['id'];
        $otype = $_REQUEST['type'];

        switch ($otype) {
            case 5:
                $where = " operate_id=" . $id;
                $userlist = M("userinfo")->field("uid,username")->where("otype=2 and utel !='' and operate_id=" . $id)->select();
                break;
            case 4:
                $where = " leaguer_id=" . $id;
                $userlist = M("userinfo")->field("uid,username")->where("otype=1 and utel !='' and leaguer_id=" . $id)->select();
                break;
            case 2:
                $where = " unit_id=" . $id;
                $userlist = M("userinfo")->field("uid,username")->where("otype=4 and utel !='' and  unit_id=" . $id)->select();
                break;
            case 1:
                $where = " agent_id=" . $id;
                //$userlist = M("userinfo")->field("uid,username")->where("otype=$otype and agent_id=" . $id)->select();
                break;
            default:
                $where = "";
                $userlist = M("userinfo")->field("uid,username")->where("otype=$otype and utel !=''")->select();
        }
        if ($userlist) {
            // $data["info"]="<option value=''>请选择</option>";
            foreach ($userlist as $vo) {
                $data["info"].="<option value='" . $vo["uid"] . "'>" . $vo["username"] . "</option>";
            }
        } else {
            $data["info"] = "<option value=''></option>";
        }
         $this->ajaxReturn($data);
    }
    public function user_info(){
        $type=$_POST['type'];
        switch($type){
            case 0:
                 $userlist=M("userinfo")->field("uid,username")->where("otype=1 and utel !='' and leaguer_id=" . $id)->select();
                break;
            case 2:
                break;
            case 1:
                break;
        }
    }
    public function userlog(){

        $this->checklogin();
        $tp=C('DB_PREFIX');
        if(IS_GET){
            $type = I('get.type');
            $username = I('get.username');
            $starttime = I('get.starttime');
            $endtime = I('get.endtime');
            $otype = I('get.level');
            if ($type !='') {
                $where['type'] =$type;
            }
            if ($otype !='') {
                $where['u.otype'] =$otype;
            }
            if ($username != '') {
                $map['username'] = $username;
                $user = M('userinfo')->where($map)->find();
                $where['l.uid'] = $user['uid'];
                $sea['username'] = $username;
            }
            if($starttime && $endtime) {
                $where['l.time'] = array('between',array(strtotime($starttime),strtotime($endtime)+86400));
                $sea['starttime'] = $starttime;
                $sea['endtime'] = $endtime;
            } else {
              $starttime = date('Y-m-d', time());
              $endtime = date('Y-m-d', time());
              $where['l.time'] = array('between',array($starttime,$endtime+86400));
                $sea['starttime'] =  $starttime;
                $sea['endtime'] = $endtime;
            }
        }
        if (!empty($where)) {
            $userlog = M("userlog as l");
            $count = $userlog
            ->field('l.id,l.info,l.type,l.ip,l.time,u.username,u.otype')
            ->join('wp_userinfo as u ON u.uid =l.uid ')
            ->where($where)
            ->count();
            $Page = new \Think\Page($count,10);//
            $show = $Page->show();// 分页显示输出
            $list = $userlog
            ->field('l.id,l.info,l.type,l.ip,l.time,u.username,u.otype')
            ->join('wp_userinfo as u ON u.uid =l.uid ')
            ->where($where)->order('id desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
            //echo M("userlog as l")->getLastSql();die;
            //dump($list);die;
            $this->assign('sea', $sea);
            $this->assign("rechargelist",$list);
            $this->assign('page',$show);// 赋值分页输出
        }
        $this->display();
    }



    public function deluserlog(){
        $id = $_REQUEST['id'];
        $res = M('userlog')->where(array('id' => $id))->delete();
    }
    public function financial_setting(){
        $this->checklogin();
        if(IS_POST){
             if($_POST["type"]=="入金"){
                 $where["type"]=1;
             }else if($_POST["type"]=="出金"){
                $where["type"]=2;
             }
               //$data["poundage"]=$_POST["poundage"];
               $data["max_monery"]=$_POST["max_monery"];
               $data["min_monery"]=$_POST["min_monery"];
               /*$data["starttime"]=$_POST["starttime"];
               $data["endtime"]=$_POST["endtime"];*/
               $financial = M("financial_setting")->where($where)->save($data);
               if($financial){
                   $this->success("操作成功!");
               }else{
                   $this->error('操作失败,请重试!');
               }

        }else{
            if($_GET["type"] == '入金'){
                $type = 1;
            }else{
                $type =2;
            }
            $data['type'] = $type;
            $res = M("financial_setting")->where($data)->find();

            $this->assign("type",$_GET["type"]);
            $this->assign('list',$res);
            $this->display("financial_setting");
        }
    }

    public function log_del(){
        $menu=$_POST['menu'];
        //dump($menu);die;
        $data['id'] = array('in',$menu);
        $res = M('userlog')->where($data)->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
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


}