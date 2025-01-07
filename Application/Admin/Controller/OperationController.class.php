<?php

namespace Admin\Controller;
use Think\Controller;
class OperationController extends CommonController {
    //会员列表
    public function mlist()
    {


        $tq=C('DB_PREFIX');
        $user = D('userinfo');
        $order = D('order');
        $account = D('accountinfo');
        $step = I('get.step');

        $field = $tq.'userinfo.username as username,'.$tq.'userinfo.utel as utel,'.$tq.'userinfo.utime as utime,'.$tq.'userinfo.uid as uid,'.$tq.'userinfo.otype as otype,'.$tq.'userinfo.ustatus as ustatus,'.$tq.'userinfo.oid as oid,'.$tq.'userinfo.address as address,'.$tq.'userinfo.portrait as portrait,'.$tq.'userinfo.lastlog as lastlog,'.$tq.'userinfo.managername as managername,'.$tq.'userinfo.comname as comname,'.$tq.'userinfo.comqua as comqua,'.$tq.'userinfo.rebate as rebate,'.$tq.'userinfo.feerebate as feerebate,'.$tq.'accountinfo.balance as balance,'.$tq."userinfo.assure,".$tq.'accountinfo.frozen';

        if($step == "search"){
            $keywords = '%'.I('post.keywords').'%';
            $where['username|utel'] = array('like',$keywords);

            $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->where('ustatus=0 and otype=5')->field($field)->order($tq.'userinfo.uid desc')->select();
            //循环用户id，获取该用户的所有订单数,以及账户余额
            foreach($ulist as $k => $v){
                $ocount = $order->where($tq.'order.uid='.$v['uid'])->count();
                $ulist[$k]['ocount'] = $ocount;
                $ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
                $ulist[$k]['utime'] = date("Y-m-d",$ulist[$k]['utime']);

/*              $ids = get_unit_id($v['uid']);
                $where_temp['uid'] =array('IN',$ids);
                $ulist[$k]['ocount'] = $order->where($where_temp)->count();
                $ulist[$k]['ocount'] = $ocount;
                $ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
                $ulist[$k]['utime'] = date("Y-m-d",$ulist[$k]['utime']);
                $ocount +=$ulist[$k]['ocount'];*/
            }

            if($ulist){
                $this->ajaxReturn($ulist);
            }else{
                $this->ajaxReturn("null");
            }
        }else if($step == "sxsearch"){
            $key = I('post.sxkey');
            $formula = I('post.formula');
            $sxvalue = I('post.sxvalue');
            if($key=="utime"){
                $sxvalue = strtotime($sxvalue);
            }
            if($key=="uid"){
                $key = $tq."userinfo.uid";
            }
            if($sxvalue=="会员"){
                $sxvalue = 0;
            }else if($sxvalue == "经纪人"){
                $sxvalue = 2;
            }else{
                $sxvalue =$sxvalue;
            }
            switch($formula){
                case "eq":
                    $formula = " = '".$sxvalue."'";
                    break;
                case "neq":
                    $formula = " <> '".$sxvalue."'";
                    break;
                case "gt":
                    $formula = " > '".$sxvalue."'";
                    break;
                case "lt":
                    $formula = " < '".$sxvalue."'";
                    break;
                case "bh":
                    $formula = " like '%".$sxvalue."%'";
                    break;
                case "bbh":
                    $formula = " no like '%".$sxvalue."%'";
                    break;
                default:
                    $formula = " = '".$sxvalue."'";
            }
            $where = $key.$formula;
            //查询用户和账户信息
//          $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where.' and ustatus=0 adn otype=2')->field($field)->order($tq.'userinfo.uid desc')->select();
            $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where.' and otype=5')->field($field)->order($tq.'userinfo.uid desc')->select();
            //$this->ajaxReturn($user->getLastSql());
            //循环用户id，获取该用户的所有订单数,以及账户余额
            foreach($ulist as $k => $v){
                $ocount = $order->where($tq.'order.uid='.$v['uid'])->count();
                $ulist[$k]['ocount'] = $ocount;
                $ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
                $ulist[$k]['utime'] = date("Y-m-d",$ulist[$k]['utime']);
            }
            if($ulist){
                $this->ajaxReturn($ulist);
            }else{
                $this->ajaxReturn("null");
            }
        }else{
            //分页
            $count = $user->where('ustatus=0 and otype=5')->count();
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
//          $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where('ustatus=0 and otype=2')->field($field)->order($tq.'userinfo.uid desc')->limit($page->firstRow.','.$page->listRows)->select();
            $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where('otype=5')->field($field)->order($tq.'userinfo.uid desc')->limit($page->firstRow.','.$page->listRows)->select();
            //循环用户id，获取该用户的所有订单数

            $ocount = 0;
            foreach($ulist as $k => $v){
                $ids_arr = $user->field('uid')->where(array('unit_id'=>$v['uid']))->select();
                $ids='';
                foreach($ids_arr as $item){
                    if(!$ids){
                        $ids=implode(',',$item);
                    }else{
                        $ids .=','.implode(',',$item);
                    }
                }

                $where_temp['uid'] =array('IN',$ids);
                //$v['uid'];
                $ulist[$k]['ocount'] = $order->where($where_temp)->count();
                $ocount +=$ulist[$k]['ocount'];
                $ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);
                $ulist[$k]['num'] = $this->get_subordinate_num($v);

            }

            $this->assign('page',$show);
            $this->assign('ocount',$ocount);
            $this->assign('ulist',$ulist);
        }

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
        $this->assign('onumber',$onumber);
        $this->assign('anumber',$anumber);
        $this->assign('ucount',$userCount);
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
        $this->redirect('Operation/wxlist');
    }
    /**
     * 添加运营中心
     * */
    public function madd(){


        $user = D('userinfo');
        $account = D('accountinfo');
        $manager = D('managerinfo');
        $mbankinfo = D('bankinfo');
        if(IS_POST){
            if($data=$user->create()){
                $data['utime']  = date(time());
                $data['upwd']   = md5(I('post.upwd'));
                $data['username'] = I('post.username');
                $flag = preg_match('/[\x{4e00}-\x{9fa5}]+/u',$data['username']);
                if($flag){
                    $this->error('登录名不能用汉字，请使用英文和数字');
                }
                $data['utime']=date(time());
                $data['rebate']=I('post.rebate');
                $data['feerebate']=I('post.feerebate');
                $data['gefeebate']=I('post.gefeebate');
                $data['assure']=I('post.assure');
                $data['linkman'] = I('post.linkman');

                // $data['branch_id']   = trim(I('post.branch'));
                // $data['oid']         = trim(I('post.branch'));
                // $data['managername'] = $user->where(array('uid' => $data['branch_id']))->getField('username');
                // if(empty($data['branch_id']))
                // {
                //     $this->error('交易所分部为必选参数');
                // }
                // 
                $data['oid']=session('userid');
                $data['managername']=session('username');



                $result = $user->add($data);
                if($result){
                    $mg['brokerid'] = I('post.brokerid');
                    $mg['uid'] = $result;
                    $ac['uid'] = $result;
                    //创建账户表
                    $account->add($ac);
                    //创建身份证信息表
                    $manager->add($mg);
                    $info = '添加运营中心【'.I('post.utel').'】';
                    $type = 5;
                    user_log($info,$type);
                    $bank['uid'] = $result;
                    $bank['bankname'] = I('post.bankname');
                    $bank['province'] = I('post.province');
                    $bank['city'] = I('post.city');
                    $bank['busername'] = I('post.busername');
                    $bank['banknumber'] = I('post.banknumber');
                    $mbankinfo->add($bank);
                    $this->success('添加成功',U('Operation/mlist'));
                }else{
                    $this->error("添加失败");
                }
            }else{
                $this->error($user->getError());
            }
        }else{

            //$this->assign('branch',$user->field('uid,username')->where(array('otype' => 7))->select());
            $this->display();
        }
    }

    public function mupdate(){
        
        $acinfo = D('accountinfo');
        $user = D('userinfo');
        $manager = D('managerinfo');
        $mbankinfo = D('bankinfo');
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
            $data['linkman'] = I('post.linkman');
            $data['rebate'] = $rebate;
            $data['feerebate'] = $feerebate;

            // $data['oid']         = I('post.brache');
            // $data['branch_id']   = I('post.brache');

            // $data['managername'] = $user->where(array('uid' => $data['branch_id']))->getField('username');

            $upwd = I('upwd');
            $map['bankname'] = I('bankname');
            $map['province'] = I('province');
            $map['city'] = I('city');
            $balance = I('post.balance');

            if($balance)
            {
                $now_money = M('accountinfo')->where(array('uid'=>$uid))->getField('balance');
                if($balance>0) {
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
                    $money_log['user_type'] = 5;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                    $money_log['change_money'] = $balance;
                    $money_log['balance'] = $now_money + $balance;
                    $money_log['dateline'] = time();
                    $money_log['tempdate'] = date('Y-m-d H:i:s');
                    $money_log_id = M('money_flow')->add($money_log);
                    user_log('账户加款',2);
                } else {
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
                    //var_dump($datas);exit();
                    M("balance")->add($datas);
                    //资金流水记录表
                    $money_log['uid'] = $uid;
                    $money_log['type'] = 4;//充值
                    $money_log['oid'] = 0;//
                    $money_log['note'] ='管理员对['.$data['username'].']账户减款'.$balance.'元';
                    $money_log['op_id'] =$_SESSION['userid']?$_SESSION['userid']:0;
                    $money_log['user_type'] = 5;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                    $money_log['change_money'] = $balance;
                    $money_log['balance'] = $now_money + $balance;
                    $money_log['dateline'] = time();
                    $money_log['tempdate'] = date('Y-m-d H:i:s');
                    $money_log_id = M('money_flow')->add($money_log);
                    user_log('账户减款',2);
                }

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

            M('accountinfo')->where('uid='.$uid)->save($map);
            $editlt = $user->where('uid='.$uid)->save($data);
            
            $sql    = 'update wp_userinfo set `branch_id` = '.$data['branch_id'].' where uid='.$uid.'';
            $branch = M()->query($sql);
          //  echo M()->getLastSql();die;

            if($editlt!==FALSE){
                $manager_data['brokerid'] = I('post.brokerid');
                $manager->where("uid=$uid")->save($manager_data);
                $bank['bankname'] = I('post.bankname');
                $bank['province'] = I('post.province');
                $bank['city'] = I('post.city');
                $bank['busername'] = I('post.busername');
                $bank['banknumber'] = I('post.banknumber');
                $mbankinfo->where("uid=$uid")->save($bank);
                $info = '修改【'.I('post.utel').'】运营中心信息';
                $type = 2;
                user_log($info,$type);

                if(!empty($data['branch_id']))
                {
                    /*查询下级所有用户的uid*/
                    $dataResult = $user->field('uid')->where(array('operate_id' => $uid))->select();
                    $dataArr    = array();
                    foreach ($dataResult as $key => $value) {
                        array_push($dataArr,$value['uid']);
                    }
                    $dataId     = implode(',',array_unique($dataArr));
                    //$user->where('uid in('.$dataId.')')->setField('branch_id',$data['branch_id']);
                    $sql    = 'update wp_userinfo set `branch_id` = '.$data['branch_id'].' where uid in('.$dataId.')';
                    M()->query($sql);
                    /*End*/
                }

                $this->success("修改成功",U("Operation/mlist"));
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
            $us = $user->where('uid='.$uid)->find();
            $mg = $manager->where('uid='.$uid)->find();
            $accountinfo = M('accountinfo')->where('uid='.$uid)->find();
            $bankinfo = M('bankinfo')->where('uid='.$uid)->find();
            $this->assign('bankinfo',$bankinfo);
            $this->assign('us',$us);
            $this->assign('mg',$mg);
            $this->assign('accountinfo',$accountinfo);
            $this->assign('brache',M('userinfo')->field('uid,username')->where(array('otype' => 7))->select());
            $this->display();
        }
    }



    function freeze(){
        $id = I('post.id');
        $data['frozen']=I('post.frozen');

        $res = M('accountinfo')->where(array('uid'=>$id))->save($data);
    }


    public function upstatus(){
        $id   = I('post.id');
        $type = I('post.type');

        $res["ustatus"] = $type;
        $resut = M("userinfo")->where("uid=" . $id)->save($res);

        if($resut){
            if($type == 1){
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

}