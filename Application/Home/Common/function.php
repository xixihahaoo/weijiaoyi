<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/12
 * Time: 9:05
 */


function changephone($phone)
{
	$phone = substr_replace($phone,'****','4','3'); 
	return $phone;
}

function checkorderstatus($ordid){
    $Ord=M('Balance');
    $isverified=$Ord->where('balanceno='.$ordid)->getField('isverified');
    if($isverified==1){
        return true;
    }else{
        return false;
    }
}
function recommend($ordid,$money){
 
    $Ord=M('balance');
 $uid = $Ord->where("balanceno='$ordid'")->getField('uid');

        $money=$money;
        $rid=M("userinfo")->field("rid")->where("uid=$uid")->find();
        $rid=$rid['rid'];
if($rid!=0){


       $recommend = M("webconfig")->field("recommend")->where("id=1")->find();$recommend=$recommend['recommend'];
       
      $balance= M("accountinfo")->field("balance")->where("uid=$rid")->find();$balance=$balance['balance'];
      $data['balance']=$balance+$money*$recommend/100;
        M("accountinfo")->where("uid=$rid")->save($data);
        $data2['uid']=$rid;
        $data2['jno']=date("YmdHis",time());
        $data2['jtype']="推广";
        $data2['jtime']=time();
        $data2['jincome']=$money*$recommend/100;
        $data2['remarks']="第".$uid."号会员充值".$money."元";
        $data2['balance']=$balance+$money*$recommend/100;
    M("journal")->add($data2);
        $rid2=M("userinfo")->field("rid")->where("uid=$rid")->find();
        $rid2=$rid2['rid'];
    if($rid2!=0){
       $recommend = M("webconfig")->field("recommend,recommend2")->where("id=1")->find();
       $recommend2=$recommend['recommend2'];
       $recommend=$recommend['recommend'];
        
      $balance= M("accountinfo")->field("balance")->where("uid=$rid2")->find();$balance=$balance['balance'];
      $data4['balance']=$balance+$money*$recommend/100;
        M("accountinfo")->where("uid=$rid2")->save($data4);
        $data3['uid']=$rid;
        $data3['jno']=date("YmdHis",time());
        $data3['jtype']="推广";
        $data3['jtime']=time();
        $data3['jincome']=$money*$recommend/100*$recommend2/100;
        $data3['remarks']="第".$rid."号会员的下级被推广人".$uid."充值".$money."元";
        $data3['balance']=$balance+$money*$recommend/100*$recommend2/100;
    M("journal")->add($data3);
    }
    }

  
}

function orderhandle($parameter){
    $ordid=$parameter['order_no'];
    $data['isverified']  =1;
    $Ord=M('balance');
	$data['cltime']  = time();
	$i = $Ord->where("balanceno='$ordid'")->find();
	if($i['isverified'] == 0){
        $uid = $Ord->where("balanceno='$ordid'")->getField('uid');
        //设置手续费
		$poundage = M('financial_setting')->where(array('type'=>1))->find();
        $poundage = $poundage/100;
        //手续费
        $shouxufei = $parameter['order_amount'] * $poundage;
		//充值金额
		$data['bpprice']  = $parameter['order_amount'] - $shouxufei;
		$data['remarks']  ='充值成功';
		$balance = M('Accountinfo')->where("uid=".$uid)->getField('balance');
		$balance = $balance + $parameter['order_amount'] - $shouxufei;
		$da['balance'] = $balance;
		//更新总账户
		M('accountinfo')->where("uid=".$uid)->save($da);
		//更新充值金额及状态
		$Ord->where("balanceno='$ordid'")->save($data);

        //发放体验券
        $data['limit'] = array('elt',$balance);
        $data['status'] = 1;
        $coupon = M('coupon')->where($data)->order('value desc')->find();
        if($coupon['id'] !=''){
            //增加用户
            $map['cid'] = $coupon['id'];
            $map['uid'] = $uid;
            $map['status'] = 1;
            $map['modified'] = time();
            M('coupon_user')->add($map);
        }
	}
}


function branch_id($uid)
{

    $info = M("userinfo")->field("otype,oid,uid")->where("uid='$uid'")->find();


    if(isset($info))
    {
        if ($info['otype'] == 7) {

            return $info['uid'];
        } else {
            return branch_id($info['oid']);
        }
    }
    else

    {
        return null;
    }
}


//判断单个规格商品是否休市中
function shijian($pid){

         $time = M('option_deal_time')->where(array('option_id' => $pid))->select();

         $date = time(); //当前时间

         foreach ($time as $key => $value) {
             

               if($value['deal_time_type'] == 2){

                   $end_time = tradetimetotime($value['deal_time_end']) + 24 * 60 * 60;
                   if($date <= tradetimetotime($value['deal_time_start'])){
                      
                      $date = time() + 24 * 60 * 60;
                   }
                  
               } else {
  
                   $end_time    = tradetimetotime($value['deal_time_end']);
               }

                   $start_time  = tradetimetotime($value['deal_time_start']);

                //判断周六时间段
                if (date('w') == 6) {

                    $end_time = $end_time - 24 * 60 * 60;

                    if($value['deal_time_type'] == 2) {

                      if(time() <= $end_time){

                         $res = $end_time;
                      }
                    }

                } else if(date('w') == 0) {

                     $res = 0;

                } else {
                    if($date >= $start_time && $date <= $end_time){
                        
                        if(date('Y-m-d',$end_time) != date('Y-m-d',time())){

                              $res = $end_time;

                        } else {

                             $res = $end_time;
                        }
                    }
                }
}

  if($res) {
      return $res;
  } else{
      return 0;
  }
}


//判断多个产品规格是否休市中
function shijianAll($pid){

         $pid = M('productinfo')->where(array('cid' => $pid))->getField('group_concat(pid)');

         $time = M('option_deal_time')->where('option_id in ('.$pid.')')->select();

         $date = time(); //当前时间

         foreach ($time as $key => $value) {
             

               if($value['deal_time_type'] == 2){

                   $end_time = tradetimetotime($value['deal_time_end']) + 24 * 60 * 60;
                   if($date <= tradetimetotime($value['deal_time_start'])){
                      
                      $date = time() + 24 * 60 * 60;
                   }
                  
               } else {
  
                   $end_time    = tradetimetotime($value['deal_time_end']);
               }

                   $start_time  = tradetimetotime($value['deal_time_start']);

                //判断周六时间段
                if (date('w') == 6) {

                    $end_time = $end_time - 24 * 60 * 60;

                    if($value['deal_time_type'] == 2) {

                      if(time() <= $end_time){

                         $res = $end_time;
                      }
                    }

                } else if(date('w') == 0) {

                     $res = 0;

                } else {
                    if($date >= $start_time && $date <= $end_time){
                        
                        if(date('Y-m-d',$end_time) != date('Y-m-d',time())){

                              $res = $end_time;

                        } else {

                             $res = $end_time;
                        }
                    }
                }
}

  if($res) {
      return $res;
  } else{
      return 0;
  }
}


//时间戳转换
function tradetimetotime($ntime) {
  return strtotime(date('Y-m-d ' . substr($ntime, 0, 2) . ':' . substr($ntime, 2, 4) . ':00'));
}