<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

        public function _initialize(){

	        // 需要跳过登陆验证的路由
	        $excluded_rotuers = array(
	            '/Home/Pay/yy_pay_notify',
	        );
	        if(in_array(__ACTION__, $excluded_rotuers)){
	            return;
	        }

	        $isopen  = $this->isopen();

	        if($isopen == 0)
	        {
	        	die('平台已关闭');
	        }


          	if (!isset($_SESSION['uid'])) {

             	$this->redirect('Register/login');
             	die();

          	}else{

	          	$this->user_id = session('uid');
		  	}	  
    }

	public function isopen() {

		$stye = M('webconfig')->select();

		return $stye[0]['isopen'];
	}
}