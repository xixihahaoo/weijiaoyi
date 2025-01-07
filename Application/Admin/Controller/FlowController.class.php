<?php

namespace Admin\Controller;
use Think\Controller;
class FlowController extends CommonController {


  public function money_flow()
  {
       
       $MoneyFlow            = M('MoneyFlow');
       $userinfo             = M('userinfo');
       $UserinfoRelationship = M('UserinfoRelationship');
       $bankinfo             = M('bankinfo');

       $utel      = trim(I('get.utel'));
       $type      = trim(I('get.type'));
       $yunying   = trim(I('get.yunying'));
       $jingjiren = trim(I('get.jingjiren'));
       $user      = trim(I('get.user'));
       $starttime = trim(I('get.starttime'));
       $endtime   = trim(I('get.endtime'));
       $operator  = trim(I('get.operator'));  //操作人
       $user_type = trim(I('get.user_type')); //用户类型


       if($utel) {
          $searchArr = array();
          $where['utel'] = array('like','%'.$utel.'%');
          $info = $userinfo->where($where)->select();
          foreach ($info as $key => $value) {
              array_push($searchArr,$value['uid']);
          }
          $searchId = implode(',',array_unique($searchArr));
          $map['uid'] = array('in',$searchId);
          $sea['utel'] = $utel;
       }

       if($type) {
            $map['type'] = $type;
            $sea['type'] = $type;
       }

       if($operator) {
            $map['op_id'] = $operator;
            $this->assign('op_id',$operator);
            $sea['operator'] = $operator;
       }

        if($yunying) {

          $relation = $UserinfoRelationship->where(array('parent_user_id' => $yunying))->select();
          $relationArr = array();
          $relationArr1 = array();
          foreach ($relation as $key => $value) {
             array_push($relationArr,$value['user_id']);
          }
          $relationId = implode(',',array_unique($relationArr));
          $users = $UserinfoRelationship->where('parent_user_id in('.$relationId.')')->select();
            foreach ($users as $key => $value) {
               array_push($relationArr1,$value['user_id']);
            }
            $userId = implode(',',array_unique($relationArr1));
            $map['uid'] = array('in',$userId);
            $sea['yunying'] = $yunying;
        }

        if($jingjiren) {
            $relationArr2 = array();
          $jingjiren_user = $UserinfoRelationship->where('parent_user_id in('.$jingjiren.')')->select();
            foreach ($jingjiren_user as $key => $value) {
               array_push($relationArr2,$value['user_id']);
            }
            $userId1 = implode(',',array_unique($relationArr2));
            $map['uid'] = array('in',$userId1);
            $sea['jingjiren'] = $jingjiren;
            $this->assign('jingjiren',$this->get_username($jingjiren));
        }

        if($user) {
            $map['uid'] = $user;
            $sea['user'] = $user;
            $this->assign('user',$this->get_username($user));
        }

        if($starttime && $endtime) {
            $start_time = strtotime($starttime);
            $end_time   = strtotime($endtime)+24*60*60-1;
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = date('Y-m-d',$start_time);
            $sea['endtime']   = date('Y-m-d',$end_time);
        } else {
            $start_time = strtotime();
            $end_time   = strtotime()+24*60*60-1;
            $map['dateline'] = array('between',''.$start_time.','.$end_time.'');
            $sea['starttime'] = date('Y-m-d',time());
            $sea['endtime']   = date('Y-m-d',time());
        }

       /*用户类型*/
       if($user_type)
       {
          if($user_type == '-1')
          {
            $map['user_type'] = array('eq',0);
          } else {
            $map['user_type'] = array('eq',$user_type);
          }
          $sea['user_type'] = $user_type;
       }

       if (!empty($map)) {
         # code...

       $count = $MoneyFlow->where($map)->count();   //总数量
       $pagecount = 15;   //每页显示的数量
       $page = new \Think\Page($count, $pagecount);
       $page->parameter = $sea; //此处的row是数组，为了传递查询条件
       $page->setConfig('first', '首页');
       $page->setConfig('prev', '&#8249;');
       $page->setConfig('next', '&#8250;');
       $page->setConfig('last', '尾页');
       $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
       $show = $page->show();
       $Flow = $MoneyFlow->where($map)->order('id  desc')->limit($page->firstRow, $page->listRows)->select();
       $Flow_money = $MoneyFlow->where($map)->sum('change_money');

       $flowArr = array();
       $flowArr2 = array();
       foreach ($Flow as $key => $value) {
          array_push($flowArr,$value['uid']);
          array_push($flowArr2,$value['op_id']);
       }
       $flowId  = implode(',',array_unique($flowArr));
       $flowId1 = implode(',',array_unique($flowArr2));

       $info = $userinfo->where('uid in('.$flowId.')')->select();
       $infoArr = array();
       foreach ($info as $key => $value) {
          $infoArr[$value['uid']] = $value;
       }

       $info1 = $userinfo->where('uid in('.$flowId1.')')->select();
       $infoArr1 = array();
       foreach ($info1 as $key => $value) {
          $infoArr1[$value['uid']] = $value;
       }

       $bank = $bankinfo->where('uid in('.$flowId.')')->select();
       $infoArr2 = array();
       foreach ($bank as $key => $value) {
            $infoArr2[$value['uid']] = $value;
       }

       $bank1 = $bankinfo->where('uid in('.$flowId1.')')->select();
       $infoArr3 = array();
       foreach ($bank1 as $key => $value) {
            $infoArr3[$value['uid']] = $value;
       }

       foreach ($Flow as $key => $value) {

           $Flow[$key]['busername']     = $infoArr2[$value['uid']]['busername'];
           $Flow[$key]['username']      = $infoArr[$value['uid']]['username'];
           $Flow[$key]['utel']          = $infoArr[$value['uid']]['utel'];

           $Flow[$key]['account']       = $Flow[$key]['change_money'];

           $Flow[$key]['operator']      = $infoArr1[$value['op_id']]['username'];
           $Flow[$key]['operator_name'] = $infoArr3[$value['op_id']]['busername'];
       }

       $this->assign('flow',$Flow);
       $this->assign('page',$show);
       $this->assign('sea',$sea);
       $this->assign('yunying',$userinfo->where('otype=5')->select());
       $this->assign('money',$Flow_money);
       $this->assign('info',M('userinfo')->where(array('otype' =>3))->select());
       }
       $this->display();
  }
}