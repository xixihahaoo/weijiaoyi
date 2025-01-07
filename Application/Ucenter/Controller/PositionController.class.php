<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class PositionController extends CommonController{
   public function nowlist(){
        $orderObj = M('order');
		//var_dump($_SESSION);
		
		
		$order_where['orders.is_settle'] = array('eq',0);
		$count = $orderObj->where($order_where)->table('wp_order orders')
		->join("join wp_userinfo user1 on user1.uid = orders.uid")
		->count();
		//var_dump($count);
		$page	=	new \Think\Page($count,1); 
		$order_info = $orderObj->where($order_where)->field('orders.*')->table('wp_order orders')
		->join("join wp_userinfo user1 on user1.uid = orders.uid")
		->limit($page->firstRow.','.$page->listRows)
		->select();
		//var_dump($order_info);
		$page = $page->show();
		$this->assign("page",$page);
		$this->assign('order_info', $order_info);
        $this->display();
    }
}