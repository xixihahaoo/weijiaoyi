<?php
// 本类由系统自动生成，仅供测试用途
/*
 *
 *author:Aiuh
 *获取首页需要的各项Ajax信息
 */
namespace Home\Controller;
use Think\Controller;

class AjaxController {
	public function index() {
		echo isBuyable(123);
	}
	/*获取首页的信息
		余额，代金券数量
		交易信息。

	*/
	public function Ajaxhome() {

		$result = array();
		//获取用户余额
		//
		$article = M('article')->where(array('is_open' => 1))->order('id desc')->find();

		$userid = session('user_id');
		$user = M("user");
		$userinfo = $user->WHERE(array('id' => $userid))->find();
		$money = $userinfo['money'];
		$result['money'] = '&yen' . $money;

		$option = M("option");
		$options = $option->select();
		$resultoptions = array();
		foreach ($options as $key => $option) {
			if ($option['Diff'] < 0) {
				$options[$key]['color'] = 'green';
			} elseif ($option['Diff'] == 0) {
				$options[$key]['color'] = 'white';
			} else {
				$options[$key]['color'] = 'red';
			}
		}
		$this->assign('list', $options);
		$this->assign('article', $article);
		$html = $this->fetch('productList');
		$result['options'] = $html;
		echo json_encode($result);
	}
	public function HoldingPrice() {
		$option = M("data_now");
		$options = $option->field('id,last')->select();
		$resultoptions = array();
		echo json_encode($options);
	}
}