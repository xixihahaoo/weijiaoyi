<?php

namespace Admin\Controller;
use Think\Controller;
class MenberController extends CommonController {
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

            $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where)->where('ustatus=0 and otype=2')->field($field)->order($tq.'userinfo.uid desc')->select();
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

            $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where.' and otype=2')->field($field)->order($tq.'userinfo.uid desc')->select();

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
            $temp_where['otype']=2;
            // $temp_where['ustatus']=0;
            $operate_id = I('get.uid',0);
            if($operate_id){
                $temp_where['operate_id'] = $operate_id;
                $operate = $user->where(array('uid'=>$operate_id))->getField('username');
                $this->assign('operate',$operate);
                $row['uid'] = $operate_id;
            }

            $count = $user->where($temp_where)->count();
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


            $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($temp_where)->field($field)->order($tq.'userinfo.uid desc')->limit($page->firstRow.','.$page->listRows)->select();
            //循环用户id，获取该用户的所有订单数
            $ocount = 0;
            foreach($ulist as $k => $v){
                $ids=$user->field('uid')->where(array('unit_id'=>$v['uid']))->getField('uid',true);

                $where_temp['uid'] =array('IN',$ids);
                $ulist[$k]['ocount'] = $order->where($where_temp)->count();
                $ocount +=$ulist[$k]['ocount'];
                $ulist[$k]['balance'] = number_format($ulist[$k]['balance'],2);

                $trade_amount =$ulist[$k]['trade_amount'] =  M('userinfo')
                    ->field($tq.'order.trade_amount')
                    ->join($tq.'order ON '.$tq.'order.uid = '.$tq.'userinfo.uid')
                    ->where($tq."userinfo.unit_id = ".$v['uid']." AND ".$tq."order.ostaus = 0")
                    ->sum('wp_order.trade_amount');

                $assure = $ulist[$k]['assure'] = $user->field('assure')->where(array('uid'=>$v['uid']))->getField('assure');
                if($assure){
                    $ulist[$k]['ratio'] = $trade_amount/$assure;//比例
                }else{
                    $ulist[$k]['ratio'] = $trade_amount;//比例
                }
                $ulist[$k]['num'] = $this->get_subordinate_num($v);
            }

            $total_unit = $user->where(array('otype'=>2))->count();//会员单位
            $total_leaguer=$user->where(array('otype'=>4))->count();//普通会员
            $total_agent = $user->where(array('otype'=>1))->count();//经纪人

            if($operate_id){
                $total_unit = $user->where(array('operate_id'=>$operate_id,'otype'=>2))->count();//会员单位
                $total_leaguer=$user->where(array('operate_id'=>$operate_id,'otype'=>4))->count();//普通会员
                $total_agent = $user->where(array('operate_id'=>$operate_id,'otype'=>1))->count();//经纪人
            }
            $this->assign(array('total_unit'=>$total_unit,'total_leaguer'=>$total_leaguer,'total_agent'=>$total_agent));
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
        $this->redirect('Menber/wxlist');
    }
    /**
     * 添加会员
     * */
    public function madd(){


        $user       = D('userinfo');
        $account    = D('accountinfo');
        $manager    = D('managerinfo');
        $mbankinfo  = D('bankinfo');

        if(IS_POST){
            if($data=$user->create()){
                $data['utime']=time();
                $data['upwd']=md5(I('post.upwd'));
                $data['oid']=I('post.operate');
                $data['managername']=session('username');
                $data['otype'] = 2;
                $data['utime']=date(time());
                $data['rebate']=I('post.rebate');
                $data['feerebate']=I('post.feerebate');
                $data['gefeebate']=I('post.gefeebate');
                $data['assure']=I('post.assure');
                $data['operate_id']=I('post.operate');
                $data['username'] = I('post.username');
                $data['th_uid'] = I('th_uid');
                $flag = preg_match('/[\x{4e00}-\x{9fa5}]+/u',$data['username']);
                if($flag){
                    $this->error('登录名不能用汉字，请使用英文和数字');
                }

                if(empty($data['th_uid']))
                {
                    $this->error('特会不能为空');
                }

                $result = $user->add($data);
                if($result){
                    $balance = I('post.balance',0);
                    if($balance>0){

                        $account->data(array('balance'=>$balance,'uid'=>$result))->add();

                        $now_money = $account->where('uid='.$result)->getField('balance');

                        $balance_log['bptype'] = '充值';
                        $balance_log['bptime'] = time();
                        $balance_log['bpprice'] =$balance;
                        $balance_log['remarks'] = '手动充值';
                        $balance_log['uid'] = $result;
                        $balance_log['isverified'] =1;
                        $balance_log['cltime'] = time();
                        $balance_log['shibpprice'] = $now_money;
                        $balance_log['pay_type'] = 0;//支付类型，0手动
                        $balance_log['b_type'] =1;

                        $balance_id = M('balance')->add($balance_log);
                        //资金流水记录表
                        $money_log['uid'] = $result;
                        $money_log['type'] = 4;//充值
                        $money_log['oid'] = $balance_id;//
                        $money_log['note'] ='管理员对['.$data['username'].']充值'.$balance.'元';
                        $money_log['op_id'] =$_SESSION['userid']?$_SESSION['userid']:0;
                        $money_log['user_type'] = 2;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                        $money_log['change_money'] = $balance;
                        $money_log['balance'] = $now_money;
                        $money_log['dateline'] = time();
                        $money_log['tempdate'] = date('Y-m-d H:i:s');
                        $money_log_id = M('money_flow')->add($money_log);
                        user_log('手动充值',2);
                    }else{
                        $ac['uid'] = $result;
                        $account->add($ac);
                        //创建身份证信息表
                    }

                    $mg['brokerid'] = I('post.brokerid');
                    $mg['uid'] = $result;
                    //创建账户表

                    $manager->add($mg);
                    $info = '添加会员【'.I('post.utel').'】';
                    $type = 2;
                    user_log($info,$type);
                    $bank['uid'] = $result;
                    $bank['bankname'] = I('post.bankname');
                    $bank['province'] = I('post.province');
                    $bank['city']     = I('post.city');
                    $bank['busername'] = I('post.busername');
                    $bank['banknumber'] = I('post.banknumber');
                    $mbankinfo->add($bank);
                    $this->success('添加成功',U('Menber/mlist'));
                }else{
                    $this->error("添加失败");
                }
            }else{
                $this->error($user->getError());
            }
        }else{
            $thlist = M('userinfo')->where(array('otype'=>6))->select();
            $operate = M('userinfo')->where(array('otype'=>5))->select();
            $this->assign('list',$operate);
            $this->assign('thlist',$thlist);
            $this->display();
        }
    }

    public function mupdate(){

        $user = D('userinfo');
        $manager = D('managerinfo');
        $mbankinfo = D('bankinfo');
        $acinfo = D('accountinfo');
        if(IS_POST){
            $ajax = I('get.ajax');
            $uid = I('post.uid');
            $rebate = I('post.rebate');
            $feerebate = I('post.feerebate');
            $data['username'] = I('username');
            $data['utel'] = I('utel');
            $data['address'] = I('address');
//          $data['brokerid'] = I('brokerid');
            $data['th_uid'] = I('th_uid');
            $data['operate_id'] = I('operate_id');
            $data['comname'] = I('comname');
            $data['bc_config'] = I('bc_config');
            $data['comqua'] = I('comqua');
            $data['assure'] = I('post.assure');
            $data['rebate'] = $rebate;
            $data['feerebate'] = $feerebate;
            $upwd = I('upwd');
            $map['bankname'] = I('bankname');
            $map['province'] = I('province');
            $account['balance'] = I('post.balance',0);

            if(empty($data['th_uid']))
            {
                $this->error('特会不能为空');
            }

            if($account['balance'] !=0){
                $now_money = M('accountinfo')->where(array('uid'=>$uid))->getField('balance');
                if($account['balance']>0)
                {
                    $resultAcinfo = $acinfo->where('uid='.$uid)->setInc('balance',$account['balance']);
                    //获取最新账户余额
                    $newmoney = $acinfo->where('uid='.$uid)->getField('balance');
                    //账户加款
                    $datas['bptype'] = '充值';
                    $datas['bptime'] = time();
                    $datas['bpprice'] = $account['balance'];
                    $datas['remarks'] = '账户加款';
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
                    $money_log['note'] ='管理员对['.$data['username'].']账户加款'.$account['balance'].'元';
                    $money_log['op_id'] =$_SESSION['userid']?$_SESSION['userid']:0;
                    $money_log['user_type'] = M('userinfo')->where(array('uid' => $uid))->getField('otype');//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                    $money_log['change_money'] = $account['balance'];
                    $money_log['balance'] = $now_money + $account['balance'];
                    $money_log['dateline'] = time();
                    $money_log['tempdate'] = date('Y-m-d H:i:s');
                    $money_log_id = M('money_flow')->add($money_log);
                    user_log('账户加款',2);
                }
                else
                {
                    $account['balance'] = abs($account['balance']);
                    $user_balance = $acinfo->where('uid='.$uid)->getField('balance');
                    $user_balance>0?$user_balance:0;
                    if($account['balance']>$user_balance)
                    {
                        $account['balance'] = $user_balance;
                    }
                    $resultAcinfo = $acinfo->where('uid='.$uid)->setDec('balance',$account['balance']);
                    $account['balance'] = '-'.$account['balance'];

                    //获取最新账户余额
                    $newmoney = $acinfo->where('uid='.$uid)->getField('balance');
                    //账户减款
                    $datas['bptype'] = '充值';
                    $datas['bptime'] = time();
                    $datas['bpprice'] = $account['balance'];
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
                    $money_log['note'] ='管理员对['.$data['username'].']账户减款'.$account['balance'].'元';
                    $money_log['op_id'] =$_SESSION['userid']?$_SESSION['userid']:0;
                    $money_log['user_type'] = 1;//1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                    $money_log['change_money'] = $account['balance'];
                    $money_log['balance'] = $now_money + $account['balance'];
                    $money_log['dateline'] = time();
                    $money_log['tempdate'] = date('Y-m-d H:i:s');
                    $money_log_id = M('money_flow')->add($money_log);
                    user_log('账户减款',2);
                }

            }

            $map['city'] = I('city');
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
            $editlt = $user->where('uid='.$uid)->save($data);
            if($editlt!==FALSE){
                $info = '修改【'.I('post.utel').'】会员信息';
                $type = 2;
                user_log($info,$type);
                $bank['bankname'] = I('post.bankname');
                $bank['province'] = I('post.province');
                $bank['city'] = I('post.city');
                $bank['busername'] = I('post.busername');
                $bank['banknumber'] = I('post.banknumber');
                $mbankinfo->where("uid=$uid")->save($bank);
                $this->success("修改成功",U("Menber/mlist"));
            }else{
                $this->error('修改失败');
            }

            if($ajax=="rebate"){
                $result = $user->where('uid='.$uid)->setField('rebate',$rebate);
                if($result){
                    $info = '修改【'.I('post.utel').'】会员信息';
                    $type = 2;
                    user_log($info,$type);
                    $this->ajaxReturn('修改成功');
                }else{
                    $this->ajaxReturn('修改失败');
                }
            }else if($ajax=="feerebate"){
                $result = $user->where('uid='.$uid)->setField('feerebate',$feerebate);
                if($result){
                    $info = '修改【'.I('post.utel').'】会员信息';
                    $type = 2;
                    user_log($info,$type);
                    $this->ajaxReturn('修改成功');
                }else{
                    $this->ajaxReturn('修改失败');
                }
            }

        }else{
            $uid = I('get.uid');
            $us = $user->
                table('__USERINFO__ u')->
                join("LEFT JOIN __ACCOUNTINFO__ a ON u.uid=a.uid")->
                field('u.*,a.balance')->
            where('u.uid='.$uid)->
            find();
            // vD($us);die;
            $mg = $manager->where('uid='.$uid)->find();
            $bankinfo = M('bankinfo')->where('uid='.$uid)->find();
            $operate_id = $user->where('uid='.$us['operate_id'])->find();
            $thlist = M('userinfo')->where(array('otype'=>6))->select();
            $yunying = M('userinfo')->where(array('otype'=>5))->select();
            $this->assign('bankinfo',$bankinfo);
            $this->assign('thlist',$thlist);
            $this->assign('operate_id',$operate_id);
            $this->assign('yunying',$yunying);
            $this->assign('us',$us);
            $this->assign('mg',$mg);
            $this->display();
        }
    }
    //微信基本配置
    public function wxinfo(){

        

        $wechat=D('wechat');
        if (IS_POST) {
            header("Content-type: text/html; charset=utf-8");
                if(!$wechat->create()){
                      // 如果创建失败 表示验证没有通过 输出错误提示信息
                    $this->error($wechat->getError());
                }else{
                    //添加
                    if (I('post.wcid')=='') {
                        $info = '添加【微信】基本信息';
                        $type = 2;
                        user_log($info,$type);
                        $data=$wechat->create();
                        $wechat->add($data);
                    }else{
                    //修改
                        $info = '修改【微信】基本信息';
                        $type = 2;
                        user_log($info,$type);
                        $data['wcid']=I('post.wcid');
                        $data=$wechat->create();
                        $wechat->save($data);
                    }

                };

        }
        $wx=$wechat->find();
        $this->assign('wx',$wx);
        $this->display();
    }
    //出来微信htpp地址方法
    function https_request($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
        curl_close($curl);
        return $data;
    }


    public function upstatus()
    {
        $userinfo = M('Userinfo');
        $Accountinfo = M('Accountinfo');
        $id   = trim(I('post.id'));
        $type = trim(I('post.type'));
        $ustatus = $userinfo->where("uid=" . $id)->getField('ustatus');//获取当前状态
        if ($type == '11') {
            if ($ustatus == '1') {//交易冻结
                $type = '0';//解除冻结
            } else if ($ustatus == '3') {//全部冻结
                $type = '2';//解除交易冻结 出金继续冻结
            }
        } else if($type == '21') {//出金解冻

            if ($ustatus == '2') {//出金冻结
                $type = '0';//解除冻结
            } else if ($ustatus == '3') {//全部冻结
                $type = '1';//解除出金冻结 交易继续冻结
            }
        } else if($type == '31') {//全部解冻
            $type = '0';
        } else if($type == '1') {//交易冻结
            if ($ustatus == '2') {//当前出金也处于冻结状态
                $type = '3';//全部都冻结了
            } else {
                $type = '1';
            }
        } else if($type == '2') {//出金冻结
            if ($ustatus == '1') {//当前交易也处于冻结状态
                $type = '3';//全部都冻结了
            } else {
                $type = '2';
            }
        }  else if($type == '3'){//全部冻结
            $type = '3';
        } else if($type == '7'){//销户
            //判断资金
            $moneys['uid'] = array('eq', $id);
            $money = $Accountinfo->where($moneys)->getField('balance');
            if ($money <= '0.00') {
                $type = '7';
            } else {
                $data['state']=2;
                $data["info"]="不具备销户条件：账号金额必须为：0.00元";
                $this->ajaxReturn($data);
                exit();
            }
        }

        $res["ustatus"] = $type;

        $resut = $userinfo->where("uid=" . $id)->save($res);

        if($resut){
            $data['state']=1;
            $data["info"]="操作成功！";
            if($type == 1){
                $info = 'id【'.$id.'交易冻结】';
            }else if($_REQUEST['type'] == 2){
                $info = 'id【'.$id.'出金冻结】';
            }else{
                $info = 'id【'.$id.'解冻】';
            }
            user_log($info,2);
        }else{
            $data['state']=2;
            $data["info"]="操作失败！";
        }
        $this->ajaxReturn($data);

    }


    function frozen(){
        $id = I('post.id');
        $data['frozen']=I('post.frozen');
        $res = M('accountinfo')->where(array('uid'=>$id))->save($data);
    }

    public function check_tel(){
        $tel=I('get.tel',0);
        if($tel){
            $count=M('userinfo')->where(array('utel'=>$tel))->count();
            if($count){
                $this->ajaxReturn(array('msg'=>'电话已经被使用','status'=>0));
            }
            $this->ajaxReturn(array('msg'=>'电话可用','status'=>1));
        }
        $this->ajaxReturn(array('msg'=>'请完善电话信息','status'=>0));
    }


/**
 * 设置全民经纪人佣金比例
 */
public function rate()
{
    $uid       = trim(I('get.uid'));
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
 * 修改会员单位保证金
 * @author wang <[990529346@qq.com address]>
 */
    public function save_field()
    {
        $uid   = trim(I('post.uid'));
        $field = trim(I('post.field'));
        $value = trim(I('post.value'));

        $accountObj = M('accountinfo');

        $data  = Array();

        if (!is_numeric($value))
        {
            $data['status'] = 0;
            $data['msg']    = '输入的内容不合法';
            $this->ajaxReturn($data,'JSON');
        }

        if(isset($uid) && isset($field))
        {

            if($accountObj->where(array('uid' => $uid))->find())
            {
                $result = $accountObj->where(array('uid' => $uid))->setField("$field",$value);
            } else {

                $map['uid']    = $uid;
                $map['frozen'] = $value;
                $result = $accountObj->add($map);
            }
            if($result)
            {
                $data['status'] = 1;
                $data['msg']    = '修改成功';
                $this->ajaxReturn($data,'JSON');
            } else {
                $data['status'] = 0;
                $data['msg']    = '修改失败';
                $this->ajaxReturn($data,'JSON');
            }

        } else {
            $data['status'] = 0;
            $data['msg']    = '非法参数';
            $this->ajaxReturn($data,'JSON');
        }

    }

}