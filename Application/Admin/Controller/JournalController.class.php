<?php
namespace Admin\Controller;
use Think\Controller;
class JournalController extends CommonController {

    public function userlog(){


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
        $this->display('User/userlog');
    }
}