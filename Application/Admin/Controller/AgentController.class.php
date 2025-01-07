<?php

namespace Admin\Controller;
use Think\Controller;
class AgentController extends CommonController {



  public function flow()
  {


      $username   = trim(I('get.username'));
      $tel        = trim(I('get.tel'));
      $starttime  = trim(I('get.starttime'));
      $endtime    = trim(I('get.endtime'));
      $operate    = trim(I('get.operate'));
      $oid        = trim(I('get.oid'));
      $puhui_id   = trim(I('get.puhui_id'));
      $jid        = trim(I('get.jid'));


      $userinfo = M('userinfo');
      $agent    = M('agent a');

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

      if($operate)
      {
          $map['a.user_id'] = array('in',get_userid($operate));
          $sea['operate'] = $operate;
      }

      if($oid)
      {
          $map['a.user_id'] = array('in',get_userid($oid));

          $all_oid = $userinfo->where(array('operate_id' => $operate,'otype' =>2))->select();
          $sea['oid'] = $oid;
          $this->assign('all_oid',$all_oid);
      }

      if($puhui_id)
      {
          $map['a.user_id'] = array('in',get_userid($puhui_id));

          $all_puhui = $userinfo->where(array('oid' => $oid,'otype' =>4))->select();
          $sea['puhui_id'] = $puhui_id;
          $this->assign('all_puhui',$all_puhui);
      }

      if($jid)
      {
          $map['a.user_id'] = array('in',get_userid($jid));

          $all_jid = $userinfo->where(array('oid' => $puhui_id,'otype' =>1))->select();
          $sea['jid'] = $jid;
          $this->assign('all_jid',$all_jid);
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
      $this->assign('info',$info);
      $this->assign('show',$show);
      $this->assign('operate',M('userinfo')->where(array('otype' => 5))->select());
      $this->display();
  }

  /**
   * 导出表格
   * @author wang  <[990529346@qq.com address]>
   */
  
  public function tpgetexcel()
  {


        $username   = trim(I('get.username'));
        $tel        = trim(I('get.tel'));
        $starttime  = trim(I('get.starttime'));
        $endtime    = trim(I('get.endtime'));
        $operate    = trim(I('get.operate'));
        $oid        = trim(I('get.oid'));
        $puhui_id   = trim(I('get.puhui_id'));
        $jid        = trim(I('get.jid'));

        if(!$strtotime || !$endtime)
        {
          $this->error('只允许导出24小时的数据');
        }

        


        $userinfo = M('userinfo');
        $agent    = M('agent a');

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

        if($operate)
        {
            $map['a.user_id'] = array('in',get_userid($operate));
            $sea['operate'] = $operate;
        }

        if($oid)
        {
            $map['a.user_id'] = array('in',get_userid($oid));

            $all_oid = $userinfo->where(array('operate_id' => $operate,'otype' =>2))->select();
            $sea['oid'] = $oid;
            $this->assign('all_oid',$all_oid);
        }

        if($puhui_id)
        {
            $map['a.user_id'] = array('in',get_userid($puhui_id));

            $all_puhui = $userinfo->where(array('oid' => $oid,'otype' =>4))->select();
            $sea['puhui_id'] = $puhui_id;
            $this->assign('all_puhui',$all_puhui);
        }

        if($jid)
        {
            $map['a.user_id'] = array('in',get_userid($jid));

            $all_jid = $userinfo->where(array('oid' => $puhui_id,'otype' =>1))->select();
            $sea['jid'] = $jid;
            $this->assign('all_jid',$all_jid);
        }
    }


    /**
     * 经纪人列表
     * @author wang <[990529346@qq.com address]>
     */
    public function agentlist()
    {
      $tq     = C('DB_PREFIX');
      $user   = M('userinfo');
      $agent  = M('agent');

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


      $map['agenttype'] = 2;

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

      foreach ($list as $key => $value) {
        $list[$key]['profit'] = $agent->where(array('user_id' => $value['uid']))->sum('profit');
      }


      $listArr = array();
      $uidData = $user->distinct(true)->field('uid')->where($map)->select();
      foreach ($uidData as $key => $value) {
        array_push($listArr,$value['uid']);
      }
      $uid    = implode(',',$listArr);
      $sea['profit'] = $agent->where('user_id in('.$uid.')')->sum('profit');
      

      $this->assign('sea',$sea);
      $this->assign('page',$show);
      $this->assign('list',$list);
      $this->assign('operate',$user->field('uid,username')->where(array('otype' =>5))->select());
      $this->assign('count',$count);
      $this->display();
    }

    //经纪人申请列表
    public function apply_agentlist(){
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
        $this->display('User/agentlist');
    }
}