<?php

namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {

    public function index()
    {



        $userObj    = M('userinfo');
        $accountObj = M('accountinfo');
        $orderObj   = M('order');
        $balanceObj = M('balance');

        $map['otype'] = 5;

        $count = $userObj->field('uid')->where($map)->count();
        $pagecount = 15;
        $page = new \Think\Page($count, $pagecount);
        $page->setConfig('first', '首页');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '尾页');
        $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $page->show();

        $userinfo = $userObj->where($map)->limit($page->firstRow,$page->listRows)->select();
        $userArr  = array();
        foreach ($userinfo as $key => $value) {
            array_push($userArr,$value['uid']);
        }
        $userId = implode(',',array_unique($userArr));


        $accountinfo = $accountObj->where('uid in('.$userId.')')->select();
        $accountArr  = array();
        foreach ($accountinfo as $key => $value) {
            $accountArr[$value['uid']] = $value;
        }


        foreach ($userinfo as $key => $value) {
            $userinfo[$key]['balance']   = isset($accountArr[$value['uid']]['balance']) ? $accountArr[$value['uid']]['balance'] : 0;
            $userinfo[$key]['frozen']    = isset($accountArr[$value['uid']]['frozen']) ? $accountArr[$value['uid']]['frozen'] : 0;
            $userinfo[$key]['feerebate'] = $value['feerebate'].'%';
            $userinfo[$key]['ustatus']   = $value['ustatus'] == 1 ? '冻结' : '正常';
        }

        //用户个数统计
        $where['otype']      = 0;
        $where['utel']       = array('exp','is not null');
        $total['user_count'] = $userObj->field('uid')->where($where)->count();

        //用户订单统计
        $total['order_count'] = $orderObj->field('oid')->count();

        //用户交易总额
        $total['trade_amount'] = $orderObj->sum('trade_amount')+$orderObj->sum('fee');

        //用户充值
        $total['bpprice'] = $balanceObj->where('bptype = "充值" and status =1 and isverified = 1')->sum('bpprice');

        //今日已有n个订单达成交易
        $total['day_count'] = $orderObj->field('oid')->where('TO_DAYS(FROM_UNIXTIME(buytime)) = TO_DAYS(now())')->count();

        $this->assign('page',$show);
        $this->assign('userinfo',$userinfo);
        $this->assign('total',$total);
        $this->display();
    }




    public function mlist()
    {
        //判断用户是否登陆
//        $user= A('Admin/User');
//        $user->checklogin();

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

                /*				$ids = get_unit_id($v['uid']);
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
//			$ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where.' and ustatus=0 adn otype=2')->field($field)->order($tq.'userinfo.uid desc')->select();
            $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where($where.' and otype=2')->field($field)->order($tq.'userinfo.uid desc')->select();
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
            $count = $user->where('ustatus=0 and otype=2')->count();
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
//			$ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where('ustatus=0 and otype=2')->field($field)->order($tq.'userinfo.uid desc')->limit($page->firstRow.','.$page->listRows)->select();
            $ulist = $user->join($tq.'accountinfo on '.$tq.'userinfo.uid='.$tq.'accountinfo.uid','left')->where('otype=2')->field($field)->order($tq.'userinfo.uid desc')->limit($page->firstRow.','.$page->listRows)->select();
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

	public function olist($oid,$youjia,$returnrate){
		// var_dump(111);die;
		$returnrate = $returnrate/100;
		$fee = 0;
         //获取账户余额
        $uid=$_SESSION['uid'];
        $users = D('userinfo');
        $username = $_SESSION['husername'];
        $user=M('accountinfo')->where('uid='.$uid)->find();
		$t = M('order')->where($tq.'oid='.$oid)->find();
		if($t['ostaus'] == 1)
		{
			return true;
		}
        if($youjia<=0)
        {
        }
        else{
        //先修改订单信息，返回成功信息后修改账户余额和添加日志记录
        $orderno= build_order_no();
        $tq=C('DB_PREFIX');
        $myorder=M('order')->join($tq.'catproduct on '.$tq.'order.pid='.$tq.'catproduct.cid')->where($tq.'order.oid='.$oid)->find();
        $order=M('order');
        $order->selltime=date(time());//平仓时间
        $order->ostaus=1;//是否平仓
        $order->sellprice=$youjia;//当前油价
		if($myorder['ostyle'] == '1')
		{
			if($youjia > $myorder['buyprice'])
			{
				$ykzj = $myorder['money']*$returnrate*(-1);
				$bdyy = 0;
			}else if($youjia == $myorder['buyprice'])
			{
				$ykzj = 0;
				$bdyy = $myorder['money'];
			}else{
				$ykzj = $myorder['money']*$returnrate;
				$bdyy = $ykzj+$myorder['money'];
			}
		}else{
			if($youjia > $myorder['buyprice'])
			{
				$ykzj = $myorder['money']*$returnrate;
				$bdyy = $ykzj+$myorder['money'];
			}else if($youjia == $myorder['buyprice']){
				$ykzj = 0;
				$bdyy = $myorder['money'];
			}else{
				$ykzj = $myorder['money']*$returnrate*(-1);
				$bdyy = 0;
			}
		}
        $order->ploss=$ykzj;//盈亏资金
        $order->fee=0;//手续费
		$msg= $order->save();

        if ($msg) {
            $myprice=M('accountinfo')->where('uid='.$uid)->find();
			//更改帐户余额 开始
            $acco= M('accountinfo');
            $acco->uid=$uid;
            $acco->balance=$myprice['balance']+$bdyy;
            $acco->save();
			//更改帐户余额 结束

            //根据商品id查询商品
            $goods=M('catproduct')->where('cid='.$myorder['pid'])->find();
            //用户亏损了，返点
            if($ykzj<0){
                $thisuser = $users->field('otype,oid')->where('uid='.$uid)->find(); //查询该用户级别
                $otype = $thisuser['otype'];            //用户类型
                $ouid = $thisuser['oid'];               //上级id
                //如果有oid，是分销用户
                if($ouid!=""){
                    if($otype==0){
                        $otype = "客户";//此id用户是普通客户，oid为代理用户id
                        $agent = $users->field('oid,rebate,feerebate,otype,username')->where('uid='.$ouid)->find();//查上级返点比例
                        $agent_user=M('accountinfo')->where('uid='.$ouid)->find();//查上级帐户信息
                        if($agent['otype']==1){//上级是经纪人
                            $agent_rebate = $agent['rebate'];               //经纪人盈亏返点
                            $agent_feerebate = $agent['feerebate'];         //经纪人手续费返点
                            $menber_id = $agent['oid'];                     //经纪人的上级id

                            if($menber_id!=""){
                                $menber = $users->field('rebate,feerebate,username')->where('uid='.$menber_id)->find();//普通会员信息
                                $menber_rebate = $menber['rebate'];                 //会员盈亏返点
                                $menber_feerebate = $agent['feerebate'];            //会员手续费返点
                                $newykzj = abs($ykzj);
                                $menber_ploss = $newykzj*$menber_rebate/100;            //会员盈亏反金
                                $menber_feeploss = $fee*$menber_feerebate/100;      //会员手续费反金
                                $agent_ploss = $menber_ploss*$agent_rebate/100;                 //代理盈亏反金
                                $agent_feeploss = $menber_feeploss*$agent_feerebate/100;        //代理手续费反金
                                $menber_user=M('accountinfo')->where('uid='.$menber_id)->find();//普通会员帐户信息
                                //写两条记录，一条代理，一条会员
                                $distribution = M('journal');
                                $disj['jno']=$orderno;                                      //订单号
                                $disj['uid'] = $ouid;                                       //经纪人id
                                $disj['jtype'] = '返点';                                    //类型
                                $disj['jtime'] = date(time());                              //操作时间
                                $disj['balance'] = $agent_user['balance']+$agent_ploss+$agent_feeploss;         //账户余额
                                $disj['jfee'] = $agent_feeploss;                            //手续费反金
                                $disj['jploss'] = $agent_ploss;                             //盈亏反金
                                $disj['jaccess'] = $agent_feeploss+$agent_ploss;            //出入金额
                                $disj['jusername'] = $agent['username'];                    //用户名
                                $disj['oid'] = $oid;                                    //订单id
                                $disj['explain'] = '代理反金';                                  //操作标记
                                $disj['remarks'] = $goods['cname'];                        //产品名称
                                $disj['number'] = $myorder['onumber'];                      //数量
                                $disj['jostyle'] = $myorder['ostyle'];                      //涨、跌
                                $disj['jbuyprice'] = $myorder['buyprice'];                  //入仓价
                                $disj['jsellprice'] = $youjia;                              //平仓价
                                $distribution->add($disj);

                                //写入会员记录
                                $distribution = M('journal');
                                $mdisj['jno']=$orderno;                                     //订单号
                                $mdisj['uid'] = $ouid;                                      //用户id
                                $mdisj['jtype'] = '返点';                                     //类型
                                $mdisj['jtime'] = date(time());                             //操作时间
                                $mdisj['balance'] = $menber_user['balance']+$menber_ploss+$menber_feeploss;         //账户余额
                                $mdisj['jfee'] = $menber_feeploss;                          //手续费反金
                                $mdisj['jploss'] = $menber_ploss;                           //盈亏反金
                                $mdisj['jaccess'] = $menber_feeploss+$menber_ploss;         //出入金额
                                $mdisj['jusername'] = $menber['username'];                  //用户名
                                $mdisj['oid'] = $oid;                                   //订单id
                                $mdisj['explain'] = '会员反金';                             //操作标记
                                $mdisj['remarks'] = $goods['cname'];                       //产品名称
                                $mdisj['number'] = $myorder['onumber'];                     //数量
                                $mdisj['jostyle'] = $myorder['ostyle'];                     //涨、跌
                                $mdisj['jbuyprice'] = $myorder['buyprice'];                 //入仓价
                                $mdisj['jsellprice'] = $youjia;                             //平仓价
                                $distribution->add($mdisj);
                            }
                        }else if($agent['otype']==2){//如果上级是平台
                            $menber_rebate = $agent['rebate'];              //代理盈亏返点
                            $menber_feerebate = $agent['feerebate'];        //代理手续费返点
							$newykzj = abs($ykzj);
                            $menber_ploss = $newykzj*$menber_rebate/100;            //会员盈亏反金
                            $menber_feeploss = $fee*$menber_feerebate/100;      //会员手续费反金
                            //echo $ykzj*$menber_rebate/100;
                            //echo $menber_rebate.'----------------';
                            //写入会员记录
                            $distribution = M('journal');
                            $mdisj['jno']=$orderno;                                     //订单号
                            $mdisj['uid'] = $ouid;                                      //用户id
                            $mdisj['jtype'] = '返点';                                     //类型
                            $mdisj['jtime'] = date(time());                             //操作时间
                            $mdisj['balance'] = $user['balance']+$menber_ploss+$menber_feeploss;            //账户余额
                            $mdisj['jfee'] = $menber_feeploss;                          //手续费反金
                            $mdisj['jploss'] = $menber_ploss;                           //盈亏反金
                            $mdisj['jaccess'] = $menber_feeploss+$menber_ploss;         //出入金额
                            $mdisj['jusername'] = $agent['username'];                   //用户名
                            $mdisj['oid'] = $oid;                                   	//订单id
                            $mdisj['explain'] = '会员反金';                             //操作标记
                            $mdisj['remarks'] = $goods['cname'];                       //产品名称
                            $mdisj['number'] = $myorder['onumber'];                     //数量
                            $mdisj['jostyle'] = $myorder['ostyle'];                     //涨、跌
                            $mdisj['jbuyprice'] = $myorder['buyprice'];                 //入仓价
                            $mdisj['jsellprice'] = $youjia;                             //平仓价
                            $distribution->add($mdisj);
                        }else{
                            //上级是平台

                        }
                    }else if($otype==1){
                        //此id用户是代理
                        $menber = $users->field('oid,rebate,feerebate,otype')->where('uid='.$ouid)->find();
                        if($menber['oid']!=""){
                            $menber_rebate = $menber['rebate'];             //会员盈亏返点
                            $menber_feerebate = $menber['feerebate'];       //会员手续费返点
                            $menber_ploss = $newykzj*$menber_rebate/100;            //会员盈亏反金
                            $menber_feeploss = $fee*$menber_feerebate/100;      //会员手续费反金
                            //写入会员记录
                            $distribution = M('journal');
                            $mdisj['jno']=$orderno;                                     //订单号
                            $mdisj['uid'] = $ouid;                                      //用户id
                            $mdisj['jtype'] = '返点';                                     //类型
                            $mdisj['jtime'] = date(time());                             //操作时间
                            $mdisj['balance'] = $user['balance']+$menber_ploss+$menber_feeploss;            //账户余额
                            $mdisj['jfee'] = $menber_feeploss;                          //手续费反金
                            $mdisj['jploss'] = $menber_ploss;                           //盈亏反金
                            $mdisj['jaccess'] = $menber_feeploss+$menber_ploss;         //出入金额
                            $mdisj['jusername'] = $menber['username'];                  //用户名
                            $mdisj['oid'] = $oid;                                   //订单id
                            $mdisj['explain'] = '会员反金';                                 //操作标记
                            $mdisj['remarks'] = $goods['cname'];                       //产品名称
                            $mdisj['number'] = $myorder['onumber'];                     //数量
                            $mdisj['jostyle'] = $myorder['ostyle'];                     //涨、跌
                            $mdisj['jbuyprice'] = $myorder['buyprice'];                 //入仓价
                            $mdisj['jsellprice'] = $youjia;                             //平仓价
                            $distribution->add($mdisj);
                        }
                    }else if($otype==2){
                        //此id用户是会员

                    }
                }else{
                    //不是分销用户

                }
            }
            //添加平仓日志表
            //随机生成订单号
            $myjournal=M('journal');
            $journal['jno']=$orderno;                                       //订单号
            $journal['uid'] = $uid;                                         //用户id
            $journal['jtype'] = '平仓';                                       //类型
            $journal['jtime'] = date(time());                               //操作时间
            $journal['jincome'] = $bdyy;                                    //收支金额【要予以删除】
            $journal['number'] = $myorder['onumber'];                       //数量
            $journal['remarks'] = $goods['cname'];                         //产品名称
            $journal['balance'] = $user['balance']+$bdyy;                   //账户余额
            if ($bdyy > $myorder['money']){
                  $journal['jstate']=1;                                     //盈利还是亏损
            }else{
                  $journal['jstate']=0;
            }
            $journal['jusername'] = $username;                              //用户名
            $journal['jostyle'] = $myorder['ostyle'];                       //涨、跌

            //$journal['juprice'] = $uprice;                                //单价
            $journal['juprice'] = $myorder['money'];                                  	//单价
            $journal['jfee'] = $fee;                                        //手续费
            $journal['jbuyprice'] = $myorder['buyprice'];                   //入仓价
            $journal['jsellprice'] = $youjia;                               //平仓价
            $journal['jaccess'] = $bdyy;                                    //出入金额
            $journal['jploss'] = $ykzj;                                     //盈亏资金
            $journal['oid'] = $oid;                                         //改订单流水的订单id
            $journal['explain'] = $otype.'平仓';
            $myjournal->add($journal);
            $order->where('oid='.$oid)->setField('commission',$journal['balance']);
        }else{
           $msg="平仓失败，稍后平仓";
        }

       return $msg;
        }
    }
}