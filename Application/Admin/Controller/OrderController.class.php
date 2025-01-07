<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Phpexcel;
class OrderController extends CommonController {
    public function ocontent()
    {

        $order = D('order');
        $users = D('userinfo');
        $binfo = D('bankinfo');
        $pinfo = D('productinfo');
        $manager = D('managerinfo');
        $account = D('accountinfo');
        //获取订单id
        $oid = I('get.oid');
        $jtype=I('get.jtype','建仓');
        //查询订单数据基本信息
        $oinfo = $order->where('oid=' . $oid)->find();
        //客户信息
        $uinfo = $users->where('uid=' . $oinfo['uid'])->find();
        //商品信息
        $goods = $pinfo->where('cid=' . $oinfo['data_now_id'] . ' and odds=' . $oinfo['odds'])->find();

        //银行卡信息
        $bank = $binfo->where('uid=' . $oinfo['uid'])->field('bnkmber')->find();
        //身份证信息
        $mger = $manager->where('uid=' . $oinfo['uid'])->field('mname,brokerid')->find();
        //用户账户信息
        $acount = $account->where('uid=' . $oinfo['uid'])->field('balance')->find();
        //dump($oinfo);die;
        $this->assign('jtype', $jtype);
        $this->assign('oinfo', $oinfo);
        $this->assign('uinfo', $uinfo);
        $this->assign('goods', $goods);

        $this->assign('bank', $bank);
        $this->assign('mger', $mger);
        $this->assign('acount', $acount);
        $this->display();
    }

    public function deldingdan()
    {

        $order = D('order');
        $journal = D("journal");
        //获取订单id
        $oid = I('get.oid');
        $order->where('oid=' . $oid)->delete();
        $journal->where('oid=' . $oid)->delete();
        $this->success('OK');
    }

    public function olist()
    {


        $tq = C('DB_PREFIX');
        $order = D('order');
        $pinfo = D('productinfo');
        $step = I('get.step');
        //重命名数据库字段名，以免多表查询字段重复
        $liestr = $tq . 'order.uid as uid,' . $tq . 'order.selltime as selltime,' . $tq . 'userinfo.username as username,' . $tq . 'order.buytime as buytime,' . $tq . 'order.ptitle as ptitle,' . $tq . 'order.commission as commission,' . $tq . 'order.oid as oid,' . $tq . 'order.ploss as ploss,' . $tq . 'order.onumber as onumber,' . $tq . 'order.ostyle as ostyle,' . $tq . 'order.ostaus as ostaus,' . $tq . 'order.fee as fee,' . $tq . 'order.pid as pid,' . $tq . 'order.buyprice as buyprice,' . $tq . 'order.sellprice as sellprice,' . $tq . 'order.orderno as orderno,' . $tq . 'accountinfo.balance as balance,' . $tq . 'productinfo.cid as cid,' . $tq . 'productinfo.wave as wave';
        //die;
        if ($step == "search") {
            //获取订单号，生产模糊条件
            $orderno = I('post.orderno');
            //获取用户名，生产模糊条件
            $username = I('post.username');
            //获取订单时间
            $buytime = I('post.buytime');
            //获取订单类型
            $ostyle = I('post.ostyle');
            //获取订单盈亏
            $ploss = I('post.ploss');
            //获取订单状态
            $ostaus = I('post.ostaus');
            if ($orderno) {
                $where['orderno'] = array('like', '%' . I('post.orderno') . '%');
            }
            if ($username) {
                $where['username'] = array('like', '%' . I('post.username') . '%');
            }
            if ($buytime) {
                $today = date("Y-m-d", strtotime($buytime));
                $today = explode('-', $today);
                $begintime = mktime(0, 0, 0, $today[1], $today[2], $today[0]);
                $endtime = mktime(23, 59, 59, $today[1], $today[2], $today[0]);
                $where['buytime'] = array('between', array($begintime, $endtime));
            }
            if ($ostyle != "") {
                $where['ostyle'] = $ostyle;
            }
            if ($ploss == '0') {
                $where['ploss'] = array('egt', '0');
            } else if ($ploss == '1') {
                $where['ploss'] = array('lt', '0');
            }
            if ($ostaus != "") {
                $where['ostaus'] = $ostaus;
            }
//          $this->ajaxReturn($ploss);

            $orders = $order->join($tq . 'userinfo on ' . $tq . 'order.uid=' . $tq . 'userinfo.uid', 'left')->join($tq . 'accountinfo on ' . $tq . 'accountinfo.uid=' . $tq . 'userinfo.uid', 'left')->join($tq . 'productinfo on ' . $tq . 'order.pid=' . $tq . 'productinfo.pid', 'left')->field($liestr)->order($tq . 'order.oid desc')->where($where)->select();
            //$this->ajaxReturn($order->getLastSql());
            foreach ($orders as $k => $v) {
                $orders[$k]['buytime'] = date("Y-m-d H:m", $orders[$k]['buytime']);
            }
            if ($orders) {
                $this->ajaxReturn($orders);
            } else {
                $this->ajaxReturn("null");
            }

        } else {
            //分页
            $count = $order->count();
            $pagecount = 15;
            $page = new \Think\Page($count, $pagecount);
            $page->parameter = $row; //此处的row是数组，为了传递查询条件
            $page->setConfig('first', '首页');
            $page->setConfig('prev', '&#8249;');
            $page->setConfig('next', '&#8250;');
            $page->setConfig('last', '尾页');
            $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
            $show = $page->show();
            //订单列表
            $orders = $order->join($tq . 'userinfo on ' . $tq . 'order.uid=' . $tq . 'userinfo.uid', 'left')->join($tq . 'accountinfo on ' . $tq . 'accountinfo.uid=' . $tq . 'userinfo.uid', 'left')->join($tq . 'productinfo on ' . $tq . 'order.pid=' . $tq . 'productinfo.pid', 'left')->field($liestr)->order($tq . 'order.oid desc')->limit($page->firstRow . ',' . $page->listRows)->select();
            //今日统计
            $today = date("Y-m-d", time());
            $today = explode('-', $today);
            $begintime = mktime(0, 0, 0, $today[1], $today[2], $today[0]);
            $endtime = mktime(23, 59, 59, $today[1], $today[2], $today[0]);
            $where['buytime'] = array('between', array($begintime, $endtime));
            $statis = $order->join($tq . 'productinfo on ' . $tq . 'order.pid=' . $tq . 'productinfo.pid')->field('onumber,uprice,ploss')->where($where)->select();
            foreach ($statis as $k => $v) {
                $total = $v['onumber'] * $v['uprice'];
                $totals += $total;
                $number = $v['onumber'];
                $num += $number;
                $ploss = $v['ploss'];
                $tploss += $ploss;
            }
            //echo $v['onumber']*$v[''];
            $this->assign('totals', $totals);
            $this->assign('tploss', $tploss);
            $this->assign('num', $num);
            $this->assign('page', $show);
            $this->assign('orders', $orders);
        }
        //统计
        //$today=strtotime(date('Y-m-d 00:00:00'));
        //create_time
        $this->display();
    }

    public function tlist_new(){


        $journalObj=M('journal');
        $userObj = M('userinfo');
        $member['huilist'] = $userObj->where(array('otype'=>2))->select();//会员单位列表
        $member['puhuilist'] = $userObj->where(array('otype'=>4))->select();//普通会员列表
        $member['jlist'] = $userObj->where(array('otype'=>1))->select();
        $this->assign($member);

        $jno = I('get.jno');//订单编号
        if($jno){
            $where['j.jno'] = $sea['jno'] = $jno;
        }
        $username = I('get.username');//用户名称
        if ($username) {
            $where['j.jusername'] = array('like', '%' . $username. '%');
            $sea['username'] = $username;
        }
        $starttime = I('get.starttime');
        $endtime = I('get.endtime');
        if($starttime || $endtime){
            if(!$endtime){
                $endtime = date('Y-m-d',time());
            }
            $where['j.jtime'] = array('between', array(strtotime($starttime), strtotime($endtime)+86400));
            $sea['starttime'] = $starttime;//$_GET["starttime"];
            $sea['endtime'] = $endtime;//$_GET["endtime"];
        }

        $ostyle = I('get.ostyle');
        if ($ostyle != "") {
            $where['j.jostyle'] = $ostyle;
            $sea['ostyle'] = $ostyle;
        }
        $ploss = I('get.ploss',-1);
        if ($ploss > 0 ) {
            $where['j.jstate'] = $sea['ploss'] =$ploss;

        }

        $oid = I('get.oid');//上级会员
        if ($oid) {//会员单位下所有订单
            $oids = $userObj->field("uid")->where("unit_id=" . $oid)->select();
            foreach ($oids as $key => $value) {
                $oids2[] = $value['uid'];
            }
            $where['j.uid'] = array("in", implode(',', $oids2));
            $sea['oid'] = $oid;
        }

        $puhui_id = I('get.puhui_id');
        if ($puhui_id) {//普通会员id
            $puhui_ids = M("userinfo")->field("uid")->where("leaguer_id=" . $puhui_id)->select();
            foreach ($puhui_ids as $key => $value) {
                $puhui_ids2[] = $value['uid'];
            }
            $where['j.uid'] = array("in", implode(',', $puhui_ids2));
            $sea['puhui_id'] = $puhui_id;
        }

        $jid = I('get.jid');
        if ($jid) {
            $jids = M("userinfo")->field("uid")->where("agent_id=" . $jid)->select();
            foreach ($jids as $key => $value) {
                $jids2[] = $value['uid'];
            }
            $where['j.uid'] = array("in", implode(',', $jids2));
            $sea['jid'] = $jid;
        }


        $this->display('tlist');

    }
    public function tlist_back(){


        $tq = C('DB_PREFIX');//表前缀
        $journal = D('journal');
        $user = D('userinfo');
        $huilist = $user->where("otype = 2")->select();
        $this->assign("huilist", $huilist);
        $puhuilist = $user->where("otype = 4")->select();
        $this->assign("puhuilist", $puhuilist);
        $jlist = $user->where("otype = 1")->select();
        $this->assign("jlist", $jlist);
        $thlist = $user->where("otype = 6")->select();
        $this->assign('thlist',$thlist);
        $yylist = $user->where("otype=5")->select();
        $this->assign('yylist',$yylist);
        $where = "";
//        $orderno = $_GET['orderno'];
        $orderno = I('get.orderno','');
        //获取用户名，生产模糊条件
//        $username = $_GET['username'];
        $username = I('get.username');
        $starttime = I('get.starttime','');
        $endtime = I('get.endtime','');
        //获取订单类型
        $ostyle = $_GET['ostyle'];
        //获取订单盈亏
        $ploss = $_GET['ploss'];
        //获取订单状态
        $ostaus = $_GET['ostaus'];
        $oid = $_GET['oid'];
        if ($oid) {
            // $oids = getDownuids($oid);

            $oids = M("userinfo")->field("uid")->where("unit_id=" . $oid)->select();
            foreach ($oids as $key => $value) {
                $oids2[] = $value['uid'];
            }
            $where['uid'] = array("in", implode(',', $oids2));

            $sea['oid'] = $oid;

        }

        $puhui_id = $_GET['puhui_id'];
        if ($puhui_id) {
            // $puhui_ids = getDownuids($puhui_id);  //所有经纪人的ID
            $puhui_ids = M("userinfo")->field("uid")->where("leaguer_id=" . $puhui_id)->select();
            foreach ($puhui_ids as $key => $value) {
                $puhui_ids2[] = $value['uid'];
            }

            $where['uid'] = array("in", implode(',', $puhui_ids2));
            $sea['puhui_id'] = $puhui_id;

        }

        $jid = $_GET['jid'];
        if ($jid) {
            // $jids = M("userinfo")->field("uid")->where("oid=".$jid)->select();
            // foreach($jids as $val){
            //  $jids[] = $val['uid'];
            // }
            $jids = M("userinfo")->field("uid")->where("agent_id=" . $jid)->select();
            foreach ($jids as $key => $value) {
                $jids2[] = $value['uid'];
            }
            $where['uid'] = array("in", implode(',', $jids2));
            $sea['jid'] = $jid;
        }

        $tel = I('get.tel');
        if($tel){
            $uid = M('userinfo')->where(array('utel'=>$tel))->getField('uid');
            $where['uid'] = $uid;
            $sea['tel'] = $tel;
        }

        $th = I('get.tehui');//特会订单
        if($th){
            $th_ids = M('order')->where(array('th_uid'=>$th))->getField('oid',true);

            $where['oid']=array('IN',$th_ids);
            $sea['tehui'] = $th;
        }

        $yid = I('get.yid');
        if($yid){
            $y_ids = M('userinfo')->where(array('operate_id'=>$yid))->getField('uid',true);
            $where['uid'] = array('IN',$y_ids);
            $sea['yid'] = $yid;
        }
        if ($orderno) {
            $where['jno'] = array('like', '%' . $orderno . '%');
            $sea['jno'] = $orderno;
        }
        if ($username) {
            $where['jusername'] = array('like', '%' . $username. '%');
            $sea['username'] = $username;
        }

        if($starttime || $endtime){
            if(!$endtime){
                $endtime = date('Y-m-d',time());
            }
            $where['jtime'] = array('between', array(strtotime($starttime), strtotime($endtime)+86400));
            $sea['starttime'] = $starttime;//$_GET["starttime"];
            $sea['endtime'] = $endtime;//$_GET["endtime"];
        }


        if ($ostyle != "") {
            $where['jostyle'] = array("eq", $ostyle);
            $sea['ostyle'] = $ostyle;
        }
        // if($ploss=='0'){
        //  $where['jploss'] = array("egt",0);
        //  $sea['ploss'] = 0;
        // }else if($ploss=='1'){
        //  $where['jploss'] = array("lt",0);
        //  $sea['ploss'] = 1;
        // }
        // （0-亏损  1--盈利 2--平局）
        if ($ploss == '0') {
            $where['jstate'] = array('eq', '0');
            $sea['ploss'] = 0;
        } else if ($ploss == '1') {
            $where['jstate'] = array('eq', '1');
            $sea['ploss'] = 1;
        } else if ($ploss == '2') {
            $where['jstate'] = array('eq', '2');
            $sea['ploss'] = 2;
        }
        if ($ostaus != "") {
            if ($ostaus == '4') {
                $where['jtype'] = '建仓';
                $sea['ostaus'] = 4;
            }
            if ($ostaus == '1') {
                $where['jtype'] = '平仓';
                $sea['ostaus'] = 1;
            }
            if ($ostaus == '2') {
                $where['jtype'] = '爆仓';
                $sea['ostaus'] = 2;
            }
            if ($ostaus == '3') {
                $where['jtype'] = '隔夜利息扣除';
                $sea['ostaus'] = 3;
            }
            if ($ostaus == '5') {
                $where['jtype'] = '止盈';
                $sea['ostaus'] = 5;
            }
            if ($ostaus == '6') {
                $where['jtype'] = '止损';
                $sea['ostaus'] = 6;
            }
        }
        //$where['jtype'] = array("neq",'返点');
        $where['jtype']='平仓';
        $this->assign("sea", $sea);
        $count = $journal->order('jtime desc,balance asc')->where($where)->count();
        $pagecount = 10;
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $start = $page->firstRow;
        $end = $page->listRows;

        $tlist = $journal->order('jtime desc,balance asc')->limit($start, $end)->where($where)->select();

        $tlist_all = $journal->field('jploss,jfee,jtype,jincome')->order('jtime desc,balance asc')->where($where)->select();
        $total_jc = $sumfee = $total_pc = $sumploss = $sumbuymoney =0;
        foreach ($tlist as $key => $val) {
            $ooid = M("userinfo")->where("uid=" . $val['uid'])->getField('oid');
            $tlist[$key]['oid'] = M("userinfo")->where("uid=" . $ooid)->getField('username');
            $tlist[$key]['iddd'] = $val['oid'];
            $tlist[$key]['trade_amount'] = M("order")->where("oid=" . $val['oid'])->getField('trade_amount');
            $tlist[$key]['is_win'] = M("order")->where("oid=" . $val['oid'])->getField('is_win');
            $tlist[$key]['jploss'] = $val['jploss'];
        }

        $rebate = M("agent")->where($where)->sum("add_money");


        foreach ($tlist_all as $key => $val) {
            $sumploss += $val['jploss'];
            $sumfee += $val['jfee'];
            if($val['jtype'] =='建仓'){
                $total_jc +=1;
                $sumbuymoney +=$val['jincome'];
            }elseif($val['jtype'] =='平仓'){
                $total_pc +=1;
            }

        }
        $total_cc = $total_jc - $total_pc;
        $show = $page->show();
        // var_dump($page->firstRow);die;
        // $this->assign('sumgefee',$sumgefee);
        // $this->assign('sumbuymoney',$sumbuymoney);
        // $this->assign('sumploss',$sumploss*(-1));
        // $this->assign('sumfee',$sumfee);
        // $this->assign('tlist',$tlist);

        // $this->assign('show',$show);
        $this->assign('sumgefee', $sumgefee);
        $this->assign('sumbuymoney', $sumbuymoney);
        $this->assign('sumploss', $sumploss * (-1));
        $this->assign('sumfee', $sumfee);
        $this->assign('tlist', $tlist);
        $this->assign('total_jc', $total_jc);
        $this->assign('total_cc', $total_cc);
        $this->assign('total_pc', $total_pc);
        $this->assign('show', $show);
        $this->assign('rebate', $rebate);
        $this->display();
    }

    /**
     * [tlist 成交明细]
     * @return [type] [description]
     * @author wang 990529346@qq.com
     */
    public function tlist()
    {
        $journalObj = M('journal');
        $userObj    = M('userinfo');

        $orderno    = trim(I('get.orderno'));
        $username   = trim(I('get.username'));
        $starttime  = trim(I('get.starttime'));
        $endtime    = trim(I('get.endtime'));
        $tel        = trim(I('get.tel'));
        $ostyle     = trim(I('get.ostyle'));
        $ploss      = trim(I('get.ploss'));
        $operate    = trim(I('get.operate'));
        $oid        = trim(I('get.oid'));
        $puhui_id   = trim(I('get.puhui_id'));
        $jid        = trim(I('get.jid'));

        $map['jtype']   = '平仓';
        $map['th_uid']   = array('exp','is null');

        if($orderno)
        {
            $map['jno']     = $orderno;
            $sea['orderno'] = $orderno;
        }

        if($username)
        {
            $userinfo        = $userObj->field('uid')->where(array('username' => $username,'otype' => 0))->find();
            $map['uid']      = $userinfo['uid'];
            $sea['username'] = $username;
        }

        if($starttime && $endtime)
        {
            $start_time    = strtotime($starttime);
            $end_time      = strtotime($endtime);
            $map['jtime']  = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        } else {
            $start_time    = time()-300;
            $end_time      = time();
            $map['jtime']  = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

        if($tel)
        {
            $telArr          = array();
            $userinfo        = $userObj->field('uid')->where("utel like '%".$tel."%'")->select();
            foreach ($userinfo as $key => $value) {
                  array_push($telArr, $value['uid']);
            }
            $map['uid']      = array('in',implode(',', $telArr));
            $sea['tel']      = $tel;
        }


        if($ostyle)
        {
            if($ostyle == '-1')
            {
                $ostyle = 0;
                $sea['ostyle']   = '-1';
            } else {
                $sea['ostyle']   = $ostyle;
            }
            $map['jostyle']  = array('eq',$ostyle);

        }

        if($ploss)
        {
            if($ploss == '-1')
            {
                $ploss = 0;
                $sea['ploss']   = '-1';
            } else {

                $sea['ploss']   = $ploss;
            }
            $map['jstate']  = array('eq',$ploss);

        }


      if($operate)
      {
        $userid = get_userid($operate,0);
        $map['uid'] = array('in',$userid);
        $sea['operate'] = $operate;
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
      if($oid > 0)
      {
        $userid = get_userid($oid,0);
        $map['uid'] = array('in',$userid);
        $sea['oid'] = $oid;

        $oidinfo = M('userinfo')->field('uid,username')->where(array('oid' => $operate))->select();
        $this->assign('oidinfo',$oidinfo);
      }

      if($puhui_id > 0)
      {
        $userid = get_userid($puhui_id,0);
        $map['uid'] = array('in',$userid);
        $sea['puhui_id'] = $puhui_id;

        $puhuiinfo = M('userinfo')->field('uid,username')->where(array('oid' => $oid))->select();
        $this->assign('puhuiinfo',$puhuiinfo);
      }

      if($jid)
      {
        $userid = get_userid($jid,0);
        $map['uid'] = array('in',$userid);
        $sea['jid'] = $jid;

        $jidinfo = M('userinfo')->field('uid,username')->where(array('oid' => $puhui_id))->select();
        $this->assign('jidinfo',$jidinfo);
      }

        $count =  $journalObj->where($map)->count();
        //echo M()->getLastSql();
        $pagecount = 10;
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $sea;
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();

        $journal     = $journalObj->where($map)->order('oid desc')->limit($page->firstRow,$page->listRows)->select();
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
        }

        if($_GET['export'] == 1)
        {
            return $journal;
        }

        /*订单统计*/
        $total = array();
        $total['jploss']  = $journalObj->where($map)->sum('jploss');
        $total['jfee']    = $journalObj->where($map)->sum('jfee');
        $total['count']   = $journalObj->where($map)->count();

        $oid    = $journalObj->distinct(true)->field('oid')->where($map)->select();
        $oidArr = array();
        foreach ($oid as $key => $value) {
            array_push($oidArr,$value['oid']);
        }
        $oids             = implode(',',array_unique($oidArr));
        $fee              = M('order')->where('oid in('.$oids.')')->sum('fee');
        $trade_amount     = M('order')->where('oid in('.$oids.')')->sum('trade_amount');
        $total['jaccess'] = $trade_amount+$fee;


        /*今日某个订单达成交易*/
        $total['day_count'] = $journalObj->field('oid')->where('TO_DAYS(FROM_UNIXTIME(jtime)) = TO_DAYS(now()) and jtype="建仓" and th_uid is null')->count();


        $this->assign('show',$show);
        $this->assign('sea',$sea);
        $this->assign('tlist',$journal);
        $this->assign('total',$total);

        $this->assign('operate',M('userinfo')->where(array('otype' => 5))->select());
        $this->display();
    }

    /**
     * [tlist 成交明细下载]
     * @return [type] [description]
     * @author wang 990529346@qq.com
     */
    public function tpGetExcel() {
        // 输出到浏览器
        header('Content-Type: application/vnd.ms-excel;charset=utf-8');
        header('Content-Disposition: attachment;filename="shoukuanjilu_download.csv"');
        header('Cache-Control: max-age=0');
        $fp = fopen('php://output', 'a');

        // title
        $title = array(
            '编号', '用户', '上级', '类型', '建仓时间', '平仓时间', '产品信息', '方向', '建仓出金', '手续费', '买价', '卖价', '盈亏', '出入金'
        );
        // 转码
        foreach ($title as $key => $value ) {
            $head[$key] = iconv('UTF-8', 'GBK', $value);
        }
        fputcsv($fp, $head);
        error_reporting(0);
        // 常规下载 大约6W左右 默认值128M
        ini_set('memory_limit', '256M');
        set_time_limit(0);

        $journalObj = M('journal');
        $userObj    = M('userinfo');

        $orderno    = trim(I('get.orderno'));
        $username   = trim(I('get.username'));
        $starttime  = trim(I('get.starttime'));
        $endtime    = trim(I('get.endtime'));
        $tel        = trim(I('get.tel'));
        $ostyle     = trim(I('get.ostyle'));
        $ploss      = trim(I('get.ploss'));
        $operate    = trim(I('get.operate'));
        $oid        = trim(I('get.oid'));
        $puhui_id   = trim(I('get.puhui_id'));
        $jid        = trim(I('get.jid'));

        $map['jtype']   = '平仓';

        if($orderno) {
            $map['jno']     = $orderno;
        }

        if($username) {
            $userinfo = $userObj->field('uid')->where(array('username' => $username,'otype' => 0))->find();
            $map['uid'] = $userinfo['uid'];
        }

        if($starttime && $endtime) {
            $start_time    = strtotime($starttime);
            $end_time      = strtotime($endtime);
            $map['jtime']  = array('between',array($start_time,$end_time));
        } else {
            $start_time    = time()-300;
            $end_time      = time();
            $map['jtime']  = array('between',array($start_time,$end_time));
        }

        if($tel) {
            $telArr = array();
            $userinfo = $userObj->field('uid')->where("utel like '%".$tel."%'")->select();
            foreach ($userinfo as $key => $value) {
                  array_push($telArr, $value['uid']);
            }
            $map['uid'] = array('in',implode(',', $telArr));
        }


        if($ostyle) {
            if($ostyle == '-1')
            {
                $ostyle = 0;
            }
            $map['jostyle']  = array('eq',$ostyle);
        }

        if($ploss) {
            if($ploss == '-1') {
                $ploss = 0;
            }
            $map['jstate']  = array('eq',$ploss);
        }
        if($operate) {
            $userid = get_userid($operate,0);
            $map['uid'] = array('in',$userid);
        }
        if($oid > 0) {
            $userid = get_userid($oid,0);
            $map['uid'] = array('in',$userid);
        }

        if($puhui_id > 0) {
            $userid = get_userid($puhui_id,0);
            $map['uid'] = array('in',$userid);
        }

        if($jid) {
            $userid = get_userid($jid,0);
            $map['uid'] = array('in',$userid);
        }
        $page_count = 2000;
        $count = $journalObj->where($map)->count();
        //echo $count;exit();
        $page = ceil($count/$page_count);

        for($i=0;$i<$page;$i++)
        {
            $tlist = $journalObj->order('jtime desc')->where($map)->limit("".$i*$page_count.",$page_count")->select();
            $formatData = array();
            foreach ($tlist as $key => $val) {
                $ooid = M("userinfo")->where("uid=" . $val['uid'])->getField('oid');
                $username = M("userinfo")->where("uid=" . $ooid)->getField('username');
                if ($val['jostyle'] == 1) {
                    $jostyle = "买跌";
                } else {
                    $jostyle = "买涨";
                }
                //建仓
                $jc = $journalObj->field('jtime, jaccess')->where('oid ='.$val['oid'].' and jtype="建仓"')->find();
                $formatData = array(
                    '\''.iconv('UTF-8', 'GBK', $val['jno']).'\'',
                    '\''.iconv('UTF-8', 'GBK', $val['jusername']),
                    '\''.iconv('UTF-8', 'GBK', $username),
                    '\''.iconv('UTF-8', 'GBK', $val['jtype']),
                    '\''.iconv('UTF-8', 'GBK', date("Y-m-d H:i:s", $jc['jtime'])),
                    '\''.iconv('UTF-8', 'GBK', date("Y-m-d H:i:s", $val['jtime'])),
                    '\''.iconv('UTF-8', 'GBK', $val['remarks']),
                    '\''.iconv('UTF-8', 'GBK', $jostyle),
                    '\''.iconv('UTF-8', 'GBK', $jc['jaccess']),
                    '\''.iconv('UTF-8', 'GBK', $val['jfee']),
                    '\''.iconv('UTF-8', 'GBK', $val['jbuyprice']),
                    '\''.iconv('UTF-8', 'GBK', $val['jsellprice']),
                    '\''.iconv('UTF-8', 'GBK', $val['jploss'] >= 0 ? '+'.$val['jploss']:$val['jploss']),
                    '\''.iconv('UTF-8', 'GBK', $val['jaccess']),
                );
                fputcsv($fp, $formatData);
                unset($formatData);
                /*$data[$key + 1][] = $val['jno'];
                $data[$key + 1][] = $val['jusername'];
                $ooid = M("userinfo")->where("uid=" . $val['uid'])->getField('oid');
                $data[$key + 1][] = M("userinfo")->where("uid=" . $ooid)->getField('username');
                $data[$key + 1][] = $val['jtype'];
                $data[$key + 1][] = date("Y-m-d H:i:s", $val['jtime']);
                $data[$key + 1][] = $val['remarks'];
                if ($val['jostyle'] == 1) {
                    $data[$key + 1][] = "买跌";
                } else {
                    $data[$key + 1][] = "买涨";
                }
                $data[$key + 1][] = $val['jfee'];
                $data[$key + 1][] = $val['jbuyprice'];
                $data[$key + 1][] = $val['jsellprice'];
                $data[$key + 1][] = $val['jploss'] >= 0 ? '+'.$val['jploss']:$val['jploss'];
                $data[$key + 1][] = $val['jaccess'];
                $data[$key + 1][] = $val['jploss'];*/
            }
        }

    }

    /**
     * [tlist 修改订单]
     * @return [type] [description]
     * @author wang 990529346@qq.com
     */
    public function save_order()
    {

        $oid        = trim(I('get.oid'));
        $journalObj = M('journal');
        $userObj    = M('userinfo');
        $orderObj   = M('order');
        $prodctObj  = M('productinfo');

        $map['oid']   = $oid;
        $map['jtype'] = '平仓';

        $list = $journalObj->where($map)->find();


        /*用户信息*/
        $user      = $userObj->field('oid,uid,username,utel,agent_id')->where(array('uid' => $list['uid']))->find();

        /*上级用户*/
        $userOid      = $userObj->field('username')->where(array('uid' => $user['agent_id']))->find();

        /*建仓订单的信息*/
        $journaljc    = $journalObj->field('oid,jaccess,jtime')->where('oid = '.$oid.' and jtype="建仓"')->find();

        //获得产品手续费
        $order            = $orderObj->field('data_now_id,odds')->where(array('oid' => $list['oid']))->find();
        $list['feeprice'] = $prodctObj->where(array('cid' => $order['data_now_id']))->getField('feeprice');
        $list['odds']     = $order['odds'];


        /*订单信息*/
        $list['jc_jtime']   = $journaljc['jtime'];
        $list['jc_jaccess'] = abs($journaljc['jaccess']);
        $list['username']   = $user['username'];
        $list['utel']       = $user['utel'];
        $list['opera_name'] = $userOid['username'];

        $this->assign('list',$list);

        $this->display();
    }


    public function save()
    {
        $orderObj   = M('order');
        $journalObj = M('journal');
        $productObj = M('productinfo');

        $oid       = trim(I('post.oid'));
        $buytime   = strtotime(trim(I('post.buytime')));
        $selltime  = strtotime(trim(I('post.selltime')));
        $ostyle    = trim(I('post.ostyle'));
        $jaccess   = trim(I('post.jaccess'));
        $fee       = trim(I('post.fee'));
        $buyprice  = trim(I('post.buyprice'));
        $sellprice = trim(I('post.sellprice'));
        $ploss     = trim(I('post.ploss'));
        $access    = trim(I('post.access'));

        $data   = array();

        $order  = $orderObj->where(array('oid' => $oid))->find();
        if($order)
        {
            if(($selltime - $buytime) != $order['minute'] * 60)
            {
                $data['code'] = 0;
                $data['msg'] = '平仓时间不正确';
                $this->ajaxReturn($data,'JSON');
            }

            if( $buytime > time() || $selltime > time())
            {
                $data['code'] = 0;
                $data['msg'] = '请不要大于当前时间';
                $this->ajaxReturn($data,'JSON');
            }

            if($jaccess % 100 != 0 || empty($jaccess))
            {
                $data['code'] = 0;
                $data['msg'] = '投资金额有误';
                $this->ajaxReturn($data,'JSON');
            }

            if($ostyle != 1 && $ostyle != 0)
            {
                $data['code'] = 0;
                $data['msg'] = '无效的买入方向';
                $this->ajaxReturn($data,'JSON');
            }

            $product = $productObj->where(array('cid' => $order['data_now_id']))->find();
            $fee_new = ($jaccess * $product['feeprice']) / 100;
            if($fee != $fee_new)
            {
                $data['code'] = 0;
                $data['msg'] = '手续费有误';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($buyprice))
            {
                $data['code'] = 0;
                $data['msg'] = '买入价不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if(empty($sellprice))
            {
                $data['code'] = 0;
                $data['msg'] = '卖出价不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if($ostyle == 0)
            {
                if($sellprice > $buyprice)
                {
                    $money        = ($jaccess - $fee) * $order['odds'];
                    $money_access = ($jaccess - $fee) + $money;
                    if($ploss != $money || $money_access != $access)
                    {
                        $data['code'] = 0;
                        $data['msg'] = '盈亏或出入金不符1';
                        $this->ajaxReturn($data,'JSON');
                    }
                } else if($sellprice == $buyprice)
                {
                    $money        = 0;
                    $money_access = $jaccess - $fee;
                    if($ploss != $money || $money_access != $access)
                    {
                        $data['code'] = 0;
                        $data['msg'] = '盈亏或出入金不符2';
                        $this->ajaxReturn($data,'JSON');
                    }
                } else
                {
                    $money        = $jaccess - $fee;
                    $money_access = 0;
                    if($ploss != -$money || $money_access != $access)
                    {
                        $data['code'] = 0;
                        $data['msg'] = '盈亏或出入金不符3';
                        $this->ajaxReturn($data,'JSON');
                    }
                }
            } else {

                if($sellprice > $buyprice)
                {
                    $money        = $jaccess - $fee;
                    $money_access = 0;
                    if($ploss != -$money || $money_access != $access)
                    {
                        $data['code'] = 0;
                        $data['msg'] = '盈亏或出入金不符';
                        $this->ajaxReturn($data,'JSON');
                    }
                } else if($sellprice == $buyprice)
                {
                    $money        = 0;
                    $money_access = $jaccess - $fee;
                    if($ploss != $money || $money_access != $access)
                    {
                        $data['code'] = 0;
                        $data['msg'] = '盈亏或出入金不符';
                        $this->ajaxReturn($data,'JSON');
                    }
                } else
                {
                    $money        = ($jaccess - $fee) * $order['odds'];
                    $money_access = ($jaccess - $fee) + $money;
                    if($ploss != $money || $money_access != $access)
                    {
                        $data['code'] = 0;
                        $data['msg'] = '盈亏或出入金不符';
                        $this->ajaxReturn($data,'JSON');
                    }
                }
            }

            /*修改订单*/

            $flowObj    = M('MoneyFlow');
            $userObj    = M('userinfo');
            $accountObj = M('accountinfo');
            $journalObj = M('journal');

            $flow = $flowObj->where(array('oid' => $order['oid']))->select();

            foreach ($flow as $key => $value) {
                if($value['user_type'] == 0 && $value['type'] == 1)
                {
                    $user['jiancang']   = $value['change_money'];
                }
                if($value['user_type'] == 0 && $value['type'] == 2)
                {
                    $user['pingcang']   = $value['change_money'];
                    $user['uid']        = $value['uid'];
                }

                /*会员单位*/

                if($value['user_type'] == 2 && $value['type'] == 2)
                {
                    $unit['jia'] = $value['change_money'];
                    $unit['uid']          = $value['uid'];
                }

                if($value['user_type'] == 2 && $value['type'] == 5)
                {
                    $unit['kou'] = -$value['change_money'];
                }

                /*运营中心*/
                if($value['user_type'] == 5 && $value['type'] == 5)
                {
                    $operate['change_money'] = $value['change_money'];
                    $operate['uid']          = $value['uid'];
                }

                /*代理1*/
                if($value['user_type'] == 4 && $value['type'] == 5)
                {
                    $daili1['jia'][]        = $value['change_money'];
                    $daili1['uid']          = $value['uid'];
                }


                /*代理2*/
                if($value['user_type'] == 1 && $value['type'] == 5)
                {
                    $daili2['change_money'] = $value['change_money'];
                    $daili2['uid']          = $value['uid'];
                }
            }

            $map['buytime']      = $buytime;
            $map['selltime']     = date('Y-m-d H:i:s',$selltime);
            $map['ostyle']       = $ostyle;
            $map['fee']          = $fee;
            $map['buyprice']     = $buyprice;
            $map['sellprice']    = $sellprice;
            $map['ploss']        = $ploss;
            $map['trade_amount'] = ($jaccess - $fee);

            $jor['jtime']        = $buytime;
            $jor['jincome']      = $jaccess;
            $jor['jostyle']      = $ostyle;
            $jor['jfee']         = $fee;
            $jor['jaccess']      = -$jaccess;

            if($ploss == 0)
            {
                $jstate = 2;
            } else if($ploss > 0)
            {
                $jstate = 1;
            } else {
                $jstate = 0;
            }
            $jou['jtime']        = $selltime;
            $jou['jincome']      = $access;
            $jou['jstate']       = $jstate;
            $jou['jostyle']      = $ostyle;
            $jou['jfee']         = $fee;
            $jou['jbuyprice']    = $buyprice;
            $jou['jsellprice']   = $sellprice;
            $jou['jaccess']      = $access;
            $jou['jploss']       = $ploss;

            $order_result    = $orderObj->where(array('oid' => $order['oid']))->save($map);
            $jiancang_result = $journalObj->where(array('oid' => $order['oid'],'jtype' => '建仓'))->save($jor);
            if($order_result && $jiancang_result)
            {
                //还原普通用户余额
                 $user_money  = ($user['jiancang'] - $user['pingcang']);
                 $user_result = $accountObj->where(array('uid' => $user['uid']))->setInc('balance',$user_money);


                 //还原会员单位余额
                $unit_jploss = $journalObj->where(array('jtype' => '平仓','oid' => $order['oid']))->getField('jploss');
                if($unit_jploss != 0)
                {
                    if($unit_jploss < 0 || $unit_jploss > 0)
                    {
                        $unit_money  = $unit_jploss;
                        $unit_result = $accountObj->where(array('uid' => $unit['uid']))->setInc('balance',$unit_money);
                    }
                }

                //还原运营中心余额
                 $operate_money  = $operate['change_money'];
                 $operate_result = $accountObj->where(array('uid' => $operate['uid']))->setDec('balance',$operate_money);

                 //还原代理1 余额
                 $daili1_money  = $daili1['jia'][0] - $daili1['jia'][1];
                 $daili1_result = $accountObj->where(array('uid' => $daili1['uid']))->setDec('balance',$daili1_money);

                 //还原代理2 余额
                 $daili2_money  = $daili2['change_money'];
                 $daili2_result = $accountObj->where(array('uid' => $daili2['uid']))->setDec('balance',$daili2_money);

                if($accountObj->where(array('uid' => $order['uid']))->setDec('balance',$jaccess))
                {
                   $chicang['note']         = '用户购买'.$order['ptitle'].'扣除['.$jaccess.']元';
                   $chicang['op_id']        = session('user_id');
                   $chicang['change_money'] = $jaccess;
                   $chicang['balance']      = $accountObj->where(array('uid' => $order['uid']))->sum('balance');
                   $flowObj->where(array('oid' => $order['oid'],'user_type' => 0,'type' => 1))->save($chicang);
                }

            $pingcang_result = $journalObj->where(array('oid' => $order['oid'],'jtype' => '平仓'))->save($jou);
            if($pingcang_result)
            {
                $accountObj->where(array('uid' => $order['uid']))->setInc('balance',$access);
                $pingcang['note']         = '用户对'.$order['ptitle'].'进行平仓增加['.$access.']元';
                $pingcang['op_id']        = session('user_id');
                $pingcang['change_money'] = $access;
                $pingcang['balance']      = $accountObj->where(array('uid' => $order['uid']))->sum('balance');
                $user_results = $flowObj->where(array('oid' => $order['oid'],'user_type' => 0,'type' => 2))->save($pingcang);

                /*会员单位*/
                $user_data = $userObj->field('operate_id,unit_id,leaguer_id,agent_id')->where(array('uid' => $order['uid']))->find();
                $username  = $userObj->where(array('uid' => $user_data['unit_id']))->getField('username');
                $unit_info = $flowObj->where(array('oid' => $order['oid'],'user_type' => 2,'type' => 2))->find();
                if($unit_info){

                    if($ploss > 0)
                    {
                        $is_ture = $accountObj->where(array('uid' => $user_data['unit_id']))->setDec("balance", $ploss);
                        $unit_flow['note'] = '用户对'.$order['ptitle'].'进行平仓['.$username.']扣除['.$ploss.']元';
                    } else {
                        $ploss   = abs($ploss);
                        $is_ture = $accountObj->where(array('uid' => $user_data['unit_id']))->setInc("balance", $ploss);
                        $unit_flow['note'] = '用户对'.$order['ptitle'].'进行平仓['.$username.']增加['.$ploss.']元';
                    }

                    $unit_flow['op_id']        = session('user_id');
                    $unit_flow['change_money'] = $ploss;
                    $unit_flow['balance']      = $accountObj->where(array('uid' => $user_data['unit_id']))->sum('balance');
                    $unit_results = $flowObj->where(array('oid' => $order['oid'],'user_type' => 2,'type' => 2))->save($unit_flow);
                } else {

                    if($ploss > 0)
                    {
                        $is_ture = $accountObj->where(array('uid' => $user_data['unit_id']))->setDec("balance", $ploss);
                        $unit_flow['note'] = '用户对'.$order['ptitle'].'进行平仓['.$username.']扣除['.$ploss.']元';
                    } else {
                        $ploss   = abs($ploss);
                        $is_ture = $accountObj->where(array('uid' => $user_data['unit_id']))->setInc("balance", $ploss);
                        $unit_flow['note'] = '用户对'.$order['ptitle'].'进行平仓['.$username.']增加['.$ploss.']元';
                    }

                    $unit_flow['uid']          = $user_data['unit_id'];
                    $unit_flow['oid']          = $order['oid'];
                    $unit_flow['user_type']    = 2;
                    $unit_flow['type']         = 2;
                    $unit_flow['op_id']        = session('user_id');
                    $unit_flow['change_money'] = $ploss;
                    $unit_flow['balance']      = $accountObj->where(array('uid' => $user_data['unit_id']))->sum('balance');
                    $unit_flow['dateline']     = time();
                    $unit_results = $flowObj->add($unit_flow);
                }

                //运营中心
                $operate   = $userObj->field('feerebate,username')->where(array('uid' => $user_data['operate_id']))->find();
                $operate_addmoney = $fee * ($operate['feerebate']/100);
                if($accountObj->where(array('uid' => $user_data['operate_id']))->setInc('balance',$operate_addmoney))
                {
                    $operate_flow['note']         = '运营中心['.$operate['username'].']获取佣金增加['.$operate_addmoney.']';
                    $operate_flow['op_id']        = session('user_id');
                    $operate_flow['change_money'] = $operate_addmoney;
                    $operate_flow['balance']      = $accountObj->where(array('uid' => $user_data['operate_id']))->sum('balance');
                    $operate_results = $flowObj->where(array('oid' => $order['oid'],'user_type' => 5,'type' => 5))->save($operate_flow);
                }

                //代理1
                $leaguer   = $userObj->field('feerebate,username')->where(array('uid' => $user_data['leaguer_id']))->find();
                $one_addmoney = $jaccess * ($leaguer['feerebate']/100);

                if($accountObj->where(array('uid' => $user_data['unit_id']))->setDec('balance',$one_addmoney))
                {
                    $operateA_flow['note']         = '代理1['.$leaguer['username'].']获取佣金['.$username.']扣除['.$one_addmoney.']元';
                    $operateA_flow['op_id']        = session('user_id');
                    $operateA_flow['change_money'] = $one_addmoney;
                    $operateA_flow['balance']      = $accountObj->where(array('uid' => $user_data['unit_id']))->sum('balance');
                    $flowObj->where(array('oid' => $order['oid'],'user_type' => 2,'type' => 5))->save($operateA_flow);
                }

                $info = $flowObj->where(array('oid' => $order['oid'],'user_type' => 4,'type' => 5))->select();

                if($accountObj->where(array('uid' => $user_data['leaguer_id']))->setInc('balance',$one_addmoney))
                {
                    $daili1_flow['note']         = '代理1['.$leaguer['username'].']获取佣金增加['.$one_addmoney.']元';
                    $daili1_flow['op_id']        = session('user_id');
                    $daili1_flow['change_money'] = $one_addmoney;
                    $daili1_flow['balance']      = $accountObj->where(array('uid' => $user_data['leaguer_id']))->sum('balance');
                    $flowObj->where(array('id' => $info[0]['id'],'oid' => $order['oid'],'user_type' => 4,'type' => 5))->save($daili1_flow);
                }

                //代理2
                $agent   = $userObj->field('feerebate,username')->where(array('uid' => $user_data['agent_id']))->find();
                $two_addmoney = $jaccess * ($agent['feerebate']/100);

                if($accountObj->where(array('uid' => $user_data['leaguer_id']))->setDec('balance',$two_addmoney))
                {
                    $daili1A_low['note']         = '代理2['.$agent['username'].']获取佣金['.$leaguer['username'].']扣除['.$two_addmoney.']元';
                    $daili1A_low['op_id']        = session('user_id');
                    $daili1A_low['change_money'] = $two_addmoney;
                    $daili1A_low['balance']      = $accountObj->where(array('uid' => $user_data['leaguer_id']))->sum('balance');
                    $flowObj->where(array('id' => $info[1]['id'],'oid' => $order['oid'],'user_type' => 4,'type' => 5))->save($daili1A_low);
                }

                if($accountObj->where(array('uid' => $user_data['agent_id']))->setInc('balance',$two_addmoney))
                {
                    $daili2['note']         = '代理2['.$agent['username'].']获取佣金增加['.$two_addmoney.']元';
                    $daili2['op_id']        = session('user_id');
                    $daili2['change_money'] = $two_addmoney;
                    $daili2['balance']      = $accountObj->where(array('uid' => $user_data['agent_id']))->sum('balance');
                    $flowObj->where(array('oid' => $order['oid'],'user_type' => 1,'type' => 5))->save($daili2);
                }

                if($user_results && $unit_results)
                {
                    $data['code'] = 1;
                    $data['msg'] = '修改成功';
                    $this->ajaxReturn($data,'JSON');
                } else {
                    $data['code'] = 0;
                    $data['msg'] = '修改失败';
                    $this->ajaxReturn($data,'JSON');
                }

            }
        }
        else {
            $data['code'] = 0;
            $data['msg'] = '修改失败';
            $this->ajaxReturn($data,'JSON');
        }
    }
}


    public function deldata()
    {
        $oid = trim(I('post.oid'));

        $accountObj = M('accountinfo');
        $orderObj   = M('order');
        $journalObj = M('journal');
        $flowObj    = M('MoneyFlow');

        $order = $orderObj->field('buytime,minute,oid,uid,trade_amount,fee')->where('oid in ('.$oid.') and ostaus = 0')->find();
        $data  = array();
        if(!$order)
        {
            $data['status'] = 0;
            $data['msg']    = '没有找到该订单';
            $this->ajaxReturn($data,'JSON');
        }

        $buytime = $order['buytime'] + ($order['minute'] * 60);
        if(time() > $buytime)
        {
            if($orderObj->where('oid in ('.$oid.') and ostaus = 1')->find())
            {
                $data['status'] = 0;
                $data['msg']    = '产品已经平仓了';
                $this->ajaxReturn($data,'JSON');
            }

        } else {

            if(($buytime - time()) <= 10)
            {
                $data['status'] = 0;
                $data['msg']    = '删除失败！平仓时间低于10秒';
                $this->ajaxReturn($data,'JSON');
            }
        }


        $balance     = $order['trade_amount'] + $order['fee'];

        $accountinfo = $accountObj->where(array('uid' => $order['uid']))->setInc('balance',$balance);
        $orderinfo   = $orderObj->where(array('uid' => $order['uid'],'oid' => $order['oid']))->delete();
        $journalinfo = $journalObj->where(array('uid' => $order['uid'],'oid' => $order['oid']))->delete();
        $flowInfo    = $flowObj->where(array('uid' => $order['uid'],'oid' => $order['oid']))->delete();

        if($orderinfo && $journalinfo && $flowInfo)
        {
            $data['status'] = 1;
            $data['msg']    = '删除成功';
            $this->ajaxReturn($data,'JSON');

        } else {
            $data['status'] = 0;
            $data['msg']    = '删除失败';
            $this->ajaxReturn($data,'JSON');
        }

    }


    //旧
    public function tpaGetExcel() {
        //浏览器输出excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="dzg_card_info.xlsx"');
        header('Cache-Control: max-age=0');

        Vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new PHPExcel();
        $arrHeader[] = array(
            '编号', '用户', '上级', '类型', '操作时间', '产品信息', '方向', '手续费', '买价', '卖价', "账户余额", "出入金", "盈亏"
        );
        set_time_limit(0);


        $tq = C('DB_PREFIX');
        $journal = D('journal');
        $user = D('userinfo');
        $huilist = $user->where("otype = 2")->select();
        $this->assign("huilist", $huilist);
        $where = "";
        $orderno = $_GET['orderno'];
        //获取用户名，生产模糊条件
        $username = $_GET['username'];
        //获取订单时间
        $starttime = date('Y-m-d', strtotime($_GET["starttime"]));
        $endtime = date('Y-m-d', strtotime($_GET["endtime"]));
        //获取订单类型
        $ostyle = $_GET['ostyle'];
        //获取订单盈亏
        $ploss = $_GET['ploss'];
        //获取订单状态
        $ostaus = $_GET['ostaus'];
        $oid = $_GET['oid'];
        if ($oid) {
            $oids = getDownuids($oid);
            $where['uid'] = array("in", implode(',', $oids));
            $sea['oid'] = $oid;
        }
        if ($orderno) {
            $where['jno'] = array('like', '%' . $orderno . '%');
        }
        if ($username) {
            $where['jusername'] = array('like', '%' . $_GET["username"] . '%');
            $sea['username'] = $_GET["username"];
        }
        if ($_GET["starttime"] && $_GET["endtime"]) {
            $starttime = strtotime($starttime . " 00:00:00");
            $endtime = strtotime($endtime . " 23:59:59");
            $where['jtime'] = array('between', array($starttime, $endtime));
            $sea['starttime'] = $_GET["starttime"];
            $sea['endtime'] = $_GET["endtime"];
        }

        if ($ostyle != "") {
            $where['jostyle'] = array("eq", $ostyle);
            $sea['ostyle'] = $ostyle;
        }
        if ($ploss == '0') {
            $where['jploss'] = array("egt", 0);
            $sea['ploss'] = 0;
        } else if ($ploss == '1') {
            $where['jploss'] = array("lt", 0);
            $sea['ploss'] = 1;
        }
        if ($ostaus != "") {
            if ($ostaus == '4') {
                $where['jtype'] = '建仓';
                $sea['ostaus'] = 4;
            }
            if ($ostaus == '1') {
                $where['jtype'] = '平仓';
                $sea['ostaus'] = 1;
            }
            if ($ostaus == '2') {
                $where['jtype'] = '爆仓';
                $sea['ostaus'] = 2;
            }
            if ($ostaus == '3') {
                $where['jtype'] = '返点';
                $sea['ostaus'] = 3;
            }
        }
        $page_count = 2000;
        $count = $journal->where($where)->count();
        $page = ceil($count/$page_count);


        for($i=0;$i<$page;$i++)
        {
            ob_get_contents();
            //创建第二个工作表
            $msgWorkSheet = new \PHPExcel_Worksheet($objPHPExcel, 'card_message'); //创建一个工作表
            $objPHPExcel->addSheet($msgWorkSheet); //插入工作表
            $objPHPExcel->setActiveSheetIndex($i); //切换到新创建的工作表

            $tlist = $journal->order('jtime desc')->where($where)->limit("".$i*$page_count.",$page_count")->select();
            foreach ($tlist as $key => $val) {
                $data[$key + 1][] = $val['jno'];
                $data[$key + 1][] = $val['jusername'];
                $ooid = M("userinfo")->where("uid=" . $val['uid'])->getField('oid');
                $data[$key + 1][] = M("userinfo")->where("uid=" . $ooid)->getField('username');
                $data[$key + 1][] = $val['jtype'];
                $data[$key + 1][] = date("Y-m-d H:i:s", $val['jtime']);
                $data[$key + 1][] = $val['remarks'];
                if ($val['jostyle'] == 1) {
                    $data[$key + 1][] = "买跌";
                } else {
                    $data[$key + 1][] = "买涨";
                }
                $data[$key + 1][] = $val['jfee'];
                $data[$key + 1][] = $val['jbuyprice'];
                $data[$key + 1][] = $val['jsellprice'];
                $data[$key + 1][] = $val['balance'];
                $data[$key + 1][] = $val['jaccess'];
                $data[$key + 1][] = $val['jploss'];
            }
            $arrExcelInfo = array_merge($arrHeader, $tlist);
            $objPHPExcel->getActiveSheet()->fromArray(
                    $arrExcelInfo, // 赋值的数组
                    NULL, // 忽略的值,不会在excel中显示
                    'A1' // 赋值的起始位置
            );
            ob_end_clean();
            unset($tlist);
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');

        $objPHPExcel->disconnectWorksheets();
        unset($objPHPExcel);
    }


    public function daochu()
    {

        $tq = C('DB_PREFIX');
        $journal = D('journal');
        $user = D('userinfo');
        $huilist = $user->where("otype = 2")->select();
        $this->assign("huilist", $huilist);
        $where = "";
        $orderno = $_GET['orderno'];
        //获取用户名，生产模糊条件
        $username = $_GET['username'];
        //获取订单时间
        $starttime = date('Y-m-d', strtotime($_GET["starttime"]));
        $endtime = date('Y-m-d', strtotime($_GET["endtime"]));
        //获取订单类型
        $ostyle = $_GET['ostyle'];
        //获取订单盈亏
        $ploss = $_GET['ploss'];
        //获取订单状态
        $ostaus = $_GET['ostaus'];
        $oid = $_GET['oid'];
        if ($oid) {
            $oids = getDownuids($oid);
            $where['uid'] = array("in", implode(',', $oids));
            $sea['oid'] = $oid;
        }
        if ($orderno) {
            $where['jno'] = array('like', '%' . $orderno . '%');
        }
        if ($username) {
            $where['jusername'] = array('like', '%' . $_GET["username"] . '%');
            $sea['username'] = $_GET["username"];
        }
        if ($_GET["starttime"] && $_GET["endtime"]) {
            $starttime = strtotime($starttime . " 00:00:00");
            $endtime = strtotime($endtime . " 23:59:59");
            $where['jtime'] = array('between', array($starttime, $endtime));
            $sea['starttime'] = $_GET["starttime"];
            $sea['endtime'] = $_GET["endtime"];
        }

        if ($ostyle != "") {
            $where['jostyle'] = array("eq", $ostyle);
            $sea['ostyle'] = $ostyle;
        }
        if ($ploss == '0') {
            $where['jploss'] = array("egt", 0);
            $sea['ploss'] = 0;
        } else if ($ploss == '1') {
            $where['jploss'] = array("lt", 0);
            $sea['ploss'] = 1;
        }
        if ($ostaus != "") {
            if ($ostaus == '4') {
                $where['jtype'] = '建仓';
                $sea['ostaus'] = 4;
            }
            if ($ostaus == '1') {
                $where['jtype'] = '平仓';
                $sea['ostaus'] = 1;
            }
            if ($ostaus == '2') {
                $where['jtype'] = '爆仓';
                $sea['ostaus'] = 2;
            }
            if ($ostaus == '3') {
                $where['jtype'] = '返点';
                $sea['ostaus'] = 3;
            }
        }
        $page_count = 2000;
        $count = $journal->where($where)->count();
        $page = ceil($count/$page_count);
        $tlist = $journal->order('jtime desc')->where($where)->limit("".$page*$page_count.",$page_count")->select();

        $data[0] = array(
            '编号', '用户', '上级', '类型', '操作时间', '产品信息', '方向', '手续费', '买价', '卖价', "账户余额", "出入金", "盈亏"
        );
        foreach ($tlist as $key => $val) {
            $data[$key + 1][] = $val['jno'];
            $data[$key + 1][] = $val['jusername'];
            $ooid = M("userinfo")->where("uid=" . $val['uid'])->getField('oid');
            $data[$key + 1][] = M("userinfo")->where("uid=" . $ooid)->getField('username');
            $data[$key + 1][] = $val['jtype'];
            $data[$key + 1][] = date("Y-m-d H:i:s", $val['jtime']);
            $data[$key + 1][] = $val['remarks'];

            if ($val['jostyle'] == 1) {
                $data[$key + 1][] = "买跌";
            } else {
                $data[$key + 1][] = "买涨";
            }

            $data[$key + 1][] = $val['jfee'];
            $data[$key + 1][] = $val['jbuyprice'];
            $data[$key + 1][] = $val['jsellprice'];
            $data[$key + 1][] = $val['balance'];
            $data[$key + 1][] = $val['jaccess'];
            $data[$key + 1][] = $val['jploss'];

        }
        $name = 'Excelfile';  //生成的Excel文件文件名
        $res = $this->push($data, $name);
    }

    public function push($data='', $name='')
    {   $info = '导出【交易流水】信息';
        $type = 2;
        user_log($info,$type);
        import("Excel.class.php");
        $excel = new Excel();
        $excel->download($data, $name);
    }

    public function gengxin()
    {
        $where['jno'] = I('post.jno');
        $where1['oid'] = I('post.oid');
        $order = D('order');
        $journal = D("journal");
        $buyprice = I('post.buyprice');
        $sellprice = I('post.sellprice');
        $balance = I('post.balance');
        if ($buyprice && $buyprice != '') {
            $dataorder['buyprice'] = $buyprice;
            $datajournal['jbuyprice'] = $buyprice;
        }
        if ($sellprice && $sellprice != '') {
            $dataorder['sellprice'] = $sellprice;
            $datajournal['jsellprice'] = $sellprice;
        }
        if ($balance && $balance != '') {
            $datajournal['balance'] = $balance;
        }
        $a = $order->where($where1)->save($dataorder);
        $b = $journal->where($where)->save($datajournal);
        if ($a && $b) {
            echo 1;
            die;
        } else {
            echo 2;
            die;
        }
    }

    public function getdatanow()
    {
        $where['jno'] = array("eq", I('post.jno'));
        $arr = M('journal')->where($where)->find();
        echo json_encode($arr, true);
        die;
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

    //当前持仓
    public function nowlist(){

        $userObj = M('userinfo');
       

        $journal = D('journal');
        $user = D('userinfo');
        $orderObj = M('order');
        $t2 = trim(I('get.t2',0));
        if($t2){
            $where['u.unit_id'] = $search['t2']=$t2;
        }
        $t4 = trim(I('get.t4',0));
        if($t4){
            $where['u.leaguer_id'] = $search['t4'] = $t4;
        }
        $t1 = trim(I('get.t1',0));
        if($t1){
            $where['u.agent_id'] = $search['t1'] = $t1;
        }
        $thlist = $user->where("otype = 6")->select();
        $this->assign('thlist',$thlist);
        $tehui = trim(I('get.tehui',0));
        if($tehui){
            $where['u.th_uid']=$search['tehui'] = $tehui;
        }
        $yylist = $user->where("otype=5")->select();
        $this->assign('yylist',$yylist);
        $t5 = trim(I('get.t5',0));
        if($t5){
            $uinfo_where['user1.otype'] = array('eq',2);
            $uinfo_where['user1.oid'] = array('eq',$t5);
            $oid = $t2?$t2:-1;
            $puhui_id = $t4?$t4:-1;
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
            $where['u.operate_id'] = $search['t5'] = $t5;
        }

        $where['o.is_settle']=0;
        $orderno = trim(I('get.orderno',''));
        $username = trim(I('get.username'));
        $ostyle = trim(I('get.ostyle'));
        //获取订单状态
        $where['o.ostaus']=0;
        $tel = trim(I('get.tel',0));
        if($tel){
            $where['u.utel'] = $search['tel'] = $tel;
        }
        if($ostyle!=""){
            $where['o.ostyle'] = array("eq",$ostyle);
            $search['ostyle'] = $ostyle;
        }
        if($orderno){//订单号
            $where['o.orderno'] = array('LIKE','%'.$orderno.'%');
            $search['orderno'] = $orderno;
        }

        if($username){
            $where['u.username'] = array('LIKE','%'.$username.'%');
            $search['username'] = $username;
        }
        $starttime = trim(I('get.starttime',0));
        $endtime = trim(I('get.endtime',0));
        if($starttime){
            $search['starttime']=$starttime;
            $starttime = strtotime($starttime);
            if($endtime){
                $search['endtime'] = $endtime;
                $endtime = strtotime($endtime);
            }else{
                $seach['endtime'] = date('Y-m-d');
                $endtime = strtotime(date('Y-m-d'));
            }
            $endtime = $endtime+86400;
            $where['o.buytime'] = array('between',array($starttime,$endtime));
        }else{
            if($endtime){
                $seach['endtime'] = $endtime;
                $endtime=strtotime($endtime)+86400;
                $where['o.buytime'] = array('ELT',$endtime);
            }
        }


        $this->assign('search',$search);
        $count = $orderObj->table('__ORDER__ o')
        ->join('LEFT JOIN __USERINFO__ u ON u.uid=o.uid')
        ->where($where)
        ->count();
        $pagecount = 10;
        $page = new \Think\Page($count, $pagecount);
        $page->parameter = $search; //此处的row是数组，为了传递查询条件
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $this->assign('page',$page->show());
        $this->assign('total',$count);
        $rows = $orderObj->table('__ORDER__ o')->where($where)->field('o.*,u.username,u.utel,data.last,user2.username as managername')
        ->join('LEFT JOIN __USERINFO__ u ON o.uid=u.uid')
        ->join("LEFT JOIN wp_data_now data on data.id = o.data_now_id")
        ->join("join wp_userinfo user2 on u.leaguer_id = user2.uid")
        ->limit($page->firstRow,$page->listRows)
        ->order('o.buytime DESC,o.oid DESC')
        ->select();

        if($rows){
            $userObj=M('userinfo');
            //完善数据获取剩余时间和盈亏
            foreach($rows as &$row_order)
            {
                $row_order['un_surplus'] = strtotime($row_order['finirm_time']) - time();
                $row_order['un_surplus'] = $row_order['un_surplus']>0?$row_order['un_surplus']:0;
                $row_order['surplus'] = $this->time_algorithm($row_order['un_surplus']);
                $row_order['profit'] = $this->profit_algorithm($row_order['buyprice'],$row_order['last'],$row_order['trade_amount'],$row_order['odds']);
            }
            foreach($rows as $v){
                $upid = $userObj->where(array('uid'=>$v['uid']))->getField('oid');
                $v['up_user'] = $userObj->where(array('uid'=>$upid))->getField('username');
                $rs['rows'][]=$v;
            }
        }
        $rows_total = $orderObj->table('__ORDER__ o')->join('LEFT JOIN __USERINFO__ u ON o.uid=u.uid')->where($where)->select();
        $total_fee = $total_trade_amount = 0;
        if($rows_total){
            foreach($rows_total as $item){
                $total_fee +=$item['fee'];
                $total_trade_amount +=$item['trade_amount'];
            }
        }

        $this->assign('total_fee',$total_fee);
        $this->assign('total_trade_amount',$total_trade_amount);
        $this->assign($rs);
        $this->display();
    }

    /**
    *获取下级
    * @data 用户信息
    * @type 是否为json输出
    * @otype 可以扩展
    */
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

    /**
    *jajx刷新剩余时间,当前点位,盈亏
    * @order_type 商品类型的数组
    * @remaining_time 时间和秒的数组
    * @all_order_info 订单信息
    */
    public function ajax_agent($order_type,$remaining_time,$all_order_info)
    {

        $data_now = M('data_now');
        foreach($order_type as $row_type)
        {
            $data_list = $data_now->field('last')->where("id=$row_type")->find();
            $data_lists[$row_type] = $data_list['last'];
        }
        foreach($all_order_info as $k=>$order_info)
        {
            $profit[$k] = $this->profit_algorithm($order_info['action'],$data_lists[$order_info['data_now']],$order_info['initial'],$order_info['interest'],$order_info['ostyle']);
        }
        foreach($remaining_time as &$row_type)
        {
            if($row_type[0]>0)
            {
                $row_type[0] = $row_type[1] - time();
                $row_type[0] = $row_type[0]>0?$row_type[0]:0;
            }
            $date_time[] = $this->time_algorithm($row_type[0]);
        }
        $all_time['remaining_time'] = $remaining_time;
        $all_time['date_time'] = $date_time;
        $data['profit'] = $profit;
        $data['list'] = $data_lists;
        $data['time'] = $all_time;
        echo json_encode($data);
    }

    /**
    *剩余时间
    * @time 时间秒数
    */
    public function time_algorithm($time)
    {
        if($time >= 60){
            $data = date('i:s',$time);
        }else{
            $data = date('i:s',$time);
        }
        return $data;
    }

    /**
    *盈亏算法
    * @action 初始点位
    * @end 当前点位
    * @initial 投资金额
    * @interest 收益利率
    */
    public function profit_algorithm($action,$end,$initial,$interest,$ostyle)
    {
        # 0涨 1跌
        if($ostyle == 0)
        {
            if($end > $action)
            {
                $data = ($initial*$interest);

            } else if($end == $action)
            {
                $data = 0;

            } else {

                $data = -$initial;
            }
        } else {

            if($end < $action)
            {
                $data = ($initial*$interest);

            } else if($end == $action)
            {
                $data = 0;

            } else {

                $data = -$initial;
            }
        }

        return $data;
    }

/**
 * 针对于特别会员订单
 * @author  wang <[990529346@qq.com address]>
 */
    public function specil()
    {
        $journalObj = M('journal');
        $userObj    = M('userinfo');

        $orderno    = trim(I('get.orderno'));
        $username   = trim(I('get.username'));
        $starttime  = trim(I('get.starttime'));
        $endtime    = trim(I('get.endtime'));
        $tel        = trim(I('get.tel'));
        $ostyle     = trim(I('get.ostyle'));
        $ploss      = trim(I('get.ploss'));
        $specil     = trim(I('get.specil'));

        $map['jtype']   = '平仓';
        $map['th_uid']  = array('exp','is not null');

        if($orderno)
        {
            $map['jno']     = $orderno;
            $sea['orderno'] = $orderno;
        }

        if($username)
        {
            $userinfo        = $userObj->field('uid')->where(array('username' => $username,'otype' => 0))->find();
            $map['uid']      = $userinfo['uid'];
            $sea['username'] = $username;
        }

        if($starttime && $endtime)
        {
            $start_time    = strtotime($starttime);
            $end_time      = strtotime($endtime);
            $map['jtime']  = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        } else {
            $start_time    = time()-300;
            $end_time      = time();
            $map['jtime']  = array('between',array($start_time,$end_time));
            $sea['starttime'] = $starttime;
            $sea['endtime']   = $endtime;
        }

        if($tel)
        {
            $telArr          = array();
            $userinfo        = $userObj->field('uid')->where("utel like '%".$tel."%'")->select();
            foreach ($userinfo as $key => $value) {
                  array_push($telArr, $value['uid']);
            }
            $map['uid']      = array('in',implode(',', $telArr));
            $sea['tel']      = $tel;
        }


        if($ostyle)
        {
            if($ostyle == '-1')
            {
                $ostyle = 0;
                $sea['ostyle']   = '-1';
            } else {
                $sea['ostyle']   = $ostyle;
            }
            $map['jostyle']  = array('eq',$ostyle);

        }

        if($ploss)
        {
            if($ploss == '-1')
            {
                $ploss = 0;
                $sea['ploss']   = '-1';
            } else {

                $sea['ploss']   = $ploss;
            }
            $map['jstate']  = array('eq',$ploss);

        }


      if($specil)
      {
         $map['th_uid'] = $specil;
         $sea['specil'] = $specil;
      }


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

        $journal     = $journalObj->where($map)->order('oid desc')->limit($page->firstRow,$page->listRows)->select();
        $journalArr  = array();
        $journalArr1 = array();
        $journalArr2 = array();
        foreach ($journal as $key => $value) {
            array_push($journalArr, $value['uid']);
            array_push($journalArr1, $value['oid']);
            array_push($journalArr2,$value['th_uid']);
        }


        /*用户信息*/
        $journalId = implode(',',array_unique($journalArr));
        $user      = $userObj->field('oid,uid,username,utel')->where('uid in('.$journalId.')')->select();
        $userArr2  = array();
        foreach ($user as $key => $value) {
            array_push($userArr2, $value['oid']);
        }

        /*特会用户信息*/
        $th_uid  = implode(',', array_unique($journalArr2));
        $th_info = $userObj->field('uid,username,utel')->where('uid in ('.$th_uid.')')->select();
        $thArr   = array();
        foreach ($th_info as $key => $value) {
            $thArr[$value['uid']] = $value;
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

            $journal[$key]['jc_jtime']    = $journaljcArr[$value['oid']]['jtime'];
            $journal[$key]['jc_jaccess']  = $journaljcArr[$value['oid']]['jaccess'];
            $journal[$key]['username']    = $userArr[$value['uid']]['username'];
            $journal[$key]['utel']        = $userArr[$value['uid']]['utel'];
            $journal[$key]['opera_name']  = $userArr[$value['uid']]['opera_name'];
            $journal[$key]['th_username'] = $thArr[$value['th_uid']]['username'];
        }

        if($_GET['export'] == 1)
        {
            return $journal;
        }

        /*订单统计*/
        $total = array();
        $total['jploss']  = $journalObj->where($map)->sum('jploss');
        $total['jfee']    = $journalObj->where($map)->sum('jfee');
        $total['count']   = $journalObj->where($map)->count();

        $oid    = $journalObj->distinct(true)->field('oid')->where($map)->select();
        $oidArr = array();
        foreach ($oid as $key => $value) {
            array_push($oidArr,$value['oid']);
        }
        $oids             = implode(',',array_unique($oidArr));
        $fee              = M('order')->where('oid in('.$oids.')')->sum('fee');
        $trade_amount     = M('order')->where('oid in('.$oids.')')->sum('trade_amount');
        $total['jaccess'] = $trade_amount+$fee;


        /*今日某个订单达成交易*/
        $total['day_count'] = $journalObj->field('oid')->where('TO_DAYS(FROM_UNIXTIME(jtime)) = TO_DAYS(now()) and jtype="建仓" and th_uid is not null')->count();

        $this->assign('show',$show);
        $this->assign('sea',$sea);
        $this->assign('tlist',$journal);
        $this->assign('total',$total);

        $this->assign('specil',M('userinfo')->where(array('otype' => 6))->select());
        $this->display();
    }
}