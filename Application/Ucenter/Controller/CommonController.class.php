<?php
namespace UCenter\Controller;
use Think\Controller;
class CommonController extends Controller {

        public function _initialize(){
         //判断用户是否已经登录
          if (!isset($_SESSION['cuid'])) {
          	//直接跳转页面
             $this->redirect('Admin/User/signin'); 
          }
          else{
          	if($_SESSION['warn'] == ''){
          		$tq=C('DB_PREFIX');
          		$config = M('webconfig')->field('warn')->find();
          		$arr = explode('|', $config['warn']);
          		$warn_money = $arr[0]*10000;//资金
          		$warn_ratio = $arr[1]/100;//比例
          		$my_id = $_SESSION['cuid'];
          		$trade_amount = M('userinfo')
          		->field($tq.'order.trade_amount')
          		->join($tq.'order ON '.$tq.'order.uid = '.$tq.'userinfo.uid')
          		->where($tq."userinfo.unit_id = $my_id AND ".$tq."order.ostaus = 0")
          		->sum('wp_order.trade_amount');
          		$userinfo = M('userinfo')->field('assure,otype')->where(array('uid'=>$my_id))->find();
          		$ratio = $trade_amount/$userinfo['assure'];//比例
          		//echo $warn_money;die;
          		if($userinfo['assure'] < $warn_money || $ratio>$warn_ratio){
          			if($userinfo['otype'] == 2){
          				$this->assign('warn',1);
          			}
          		}


                $accountObj     = M('accountinfo');
                $accountInfo    = $accountObj->where(array('uid' => $my_id))->find();

                $this->assign('myBalance', $accountInfo['balance']);
          	}
          	}



            $otype = M("userinfo")->where("uid = " . $_SESSION['cuid'])->getField("otype");
            $limitArray = array(1, 4, 2);

            if(in_array($otype, $limitArray))
            {
                $is_agent   = $otype;
            }
            else
            {
                $is_agent   = 0;
            }



            //D($is_agent);
            $this->assign("is_agent_new", $is_agent);

          }
    }
