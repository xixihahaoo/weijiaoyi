<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class MonitorController extends CommonController{
    //银行卡
    public function index(){
        $myuid=$_SESSION['cuid'];
        $userinfo = M('userinfo')->where(array('uid' => $myuid))->find();
        if($userinfo['otype'] == 2){
        	$dengji = 'unit_id';
        }else if($userinfo['otype'] == 5){
        	$dengji ='operate_id';
        } else {
            $dengji ='branch_id';
        }

        //获取当前持仓信息
        $modTrade = M('order');
        $str_sql = 'select wp_order.*, wp_data_now.name,wp_data_now.last,wp_userinfo.username,wp_userinfo.utel,user.username as managername from wp_order left join wp_data_now
                        on wp_order.data_now_id=wp_data_now.id left JOIN wp_userinfo on wp_userinfo.uid= wp_order.uid left JOIN wp_userinfo as user on wp_userinfo.leaguer_id= user.uid
                      where wp_userinfo.'.$dengji.'= ' . $myuid . '
                      and wp_order.is_settle = 0
                      order by wp_order.oid desc'; //正在持仓中
        $holdinglist = $modTrade->query($str_sql);
 
        foreach ($holdinglist as $key => $value) {
            $holdinglist[$key]['lefttime'] = strtotime($value['trade_time']) + $value['minute'] * 60 - time();
            $holdinglist[$key]['isowner'] =$value['trade_amount'] * $value['odds'];//赢

            $holdinglist[$key]['islower'] =intval($value['trade_amount']);//输
        }
        $this->assign('status', 1);
        $this->assign('holding', $holdinglist); //当前持仓
        $this->display();
    }
}