<?php
namespace Admin\Controller;
use Think\Controller;
class FinanceController extends CommonController {

    public function financial_setting(){

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
            $this->display("User/financial_setting");
        }
    }

    public function recharge(){


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
        $this->display('User/'.$template);
    }
}