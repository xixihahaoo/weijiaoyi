<?php
namespace Home\Controller;
use Think\Controller;
class RegisterController extends Controller {


	public function wxlr() {

        $ouid = I('get.uid');

        $this->redirect('Register/reg?uid='.$ouid);

        exit;
        die();

		$ouid = I('get.uid');
		cookie("ouid", $ouid);
		$wx = M("wechat")->where("wcid = 1")->find();
		$appid = $wx['appid'];
		$appsecret = $wx['appsecret'];
		//  dump($appid);exit;
		//  ".$_SERVER['SERVER_NAME']."
		$redirecturl = urlencode("http://" . 'wei.xcjhjysc.com'. "/Home/User/oauth2");
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=$redirecturl&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
		header("LOCATION: $url");
		#echo $url;
		return;
	}

	public function oauth2() {

		$wx = M("wechat")->where("wcid = 1")->find();
		$appid = $wx['appid'];
		$secret = $wx['appsecret'];
		Vendor('Wxlogin.Wxlogin');
		$weixin = new \Weixinsdk($appid, $secret);

		if (isset($_GET['code'])) {
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" . $secret . "&code=" . $_GET['code'] . "&grant_type=authorization_code";
			$res = $weixin->https_request($url);
			$res = (json_decode($res, true));
			$openid = $res['openid'];
			$access_token = $res['access_token'];
			//判断数据库是否有此openid,有登录，没有跳转注册页面同时把微信个人信息投射到注册页面
			$ishave = M('userinfo')->where("openid='" . $openid . "'")->find();
			cookie("uid", $ishave['uid']);
			if (!$ishave) {
				//微信个人信息
				$url_u = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
				$res_r = $weixin->https_request($url_u);
				$res_r = (json_decode($res_r, true));
				$portrait = $res_r['headimgurl'];
				$nickname = $res_r['nickname'];
				//保存在数据库
				$data['utime'] = time();
				if ($_COOKIE['ouid']) {
					$data['oid'] = $_COOKIE['ouid'];
				} else {
				 //$this->redirect('user/reg');exit;
					// $data['oid'] = '285';
				}
				$data['otype'] = 0;
				$data['lastlog'] = time();
				$data['upip'] = md5($this->get_real_ip() . time());
				$data['openid'] = $openid;
//				$data['username'] = mb_substr($openid,-1,6);
				$data['nickname'] = $nickname;
				$data['portrait'] = $portrait;
				$data['usertype'] = 1;
				$data['uip'] = $_SERVER["REMOTE_ADDR"];
				$data['integrals'] = 10;
				$newusername = M("userinfo")->where("uid =" . $data['oid'])->getField("username");
				$data['managername'] = $newusername;




                Log::debugArr($data, 'wxinfo');
                $acc['uid'] = M("userinfo")->add($data);

				cookie("uid", $acc['uid']);
				M('accountinfo')->add($acc);
				M("managerinfo")->add($acc);



				$this->redirect('user/reg');exit;
			} else {
				if (!$ishave['utel']) {
					$this->redirect('user/reg');exit;
				} else {
					$this->redirect('user/login');exit;
				}
			}
		}
	}


	public function oauth3(){
		$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
		$wx = M("wechat")->where("wcid = 1")->find();
		$appid = $wx['appid'];
		$secret = $wx['appsecret'];
		if(!isset($_GET['code'])){
			$url1 = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=http://".$_SERVER['SERVER_NAME']."/Home/User/getsessopenid&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
			header("Location:".$url1); 
		}else{
			Vendor('Wxlogin.Wxlogin');
			$weixin=new \Weixinsdk($appid,$secret);
			$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$_GET['code']."&grant_type=authorization_code";
            $res = $weixin->https_request($url);
            $res=(json_decode($res, true));
			$openid = $res['openid'];
			session('wxopenid',$openid);
			$this->redirect('user/login');
		}
	}



    /**
     * @functionname: login
     * @author: wang
     * @description: 用户登录
     * @note:
     *
     */
	public function login()
	{

		$utel 		= trim(I('post.utel'));
		$password 	= trim(I('post.password'));

		$userinfo 	= M("userinfo");

		//微信帐号直接登录状态
		// if($_SESSION['wxopenid']){
		// 	$user = $userinfo->where(array('openid'=>$_SESSION['wxopenid'],'otype'=>0))->find();
		// 	if($user){
		// 		session('lastlog',NULL);
		// 		session('lastlog',$user['lastlog']);
		// 		$map123['lastlog'] 	= time();
		// 		$map123['upip'] 	= md5($this->get_real_ip() . time());
		// 		$userinfo->where(array('openid'=>$_SESSION['wxopenid'],'otype'=>0))->save($map123);
		// 		cookie("phone", $utel);
				
		// 		session('uid', $user['uid']); // 当前用户id
		// 		session('husername', $user['username']); // 当前用户昵称
		// 		session('uotype', $user['otype']); // 当前用户昵称
		// 		session('upip', $user['upip']); // 当前用户昵称
		// 		session('portrait', $user['portrait']); // 当前用户昵称
		// 		cookie("isout", '1', 3600);

		// 		$data['status'] = 1;
		// 		$data['msg'] 	= '登录成功,正在跳转';
		// 		$this->ajaxReturn($data,'JSON');
		// 	}
		// }

		if (IS_AJAX) {


			if(empty($utel))
			{
				$data['status'] = 0;
				$data['msg'] 	= '手机号码不能为空';
				$this->ajaxReturn($data,'JSON');
			}

			if(empty($password))
			{
				$data['status'] = 0;
				$data['msg'] 	= '密码不能为空';
				$this->ajaxReturn($data,'JSON');
			}

			$where = array();

			$where['utel'] 	= $utel;
			$where['otype'] = 0;

			$result = $userinfo->where($where)->field('uid,username,upwd,utime,openid,vertus,otype,portrait,lastlog')->find();

			session('lastlog',NULL);
			session('lastlog',$result['lastlog']);
	 		$map123['lastlog'] 	= time();
			$map123['upip'] 	= md5($this->get_real_ip() . time());
			$userinfo->where('utel ="' . $utel . '"')->save($map123);
			cookie("phone", I('post.utel'));

			if ($result['upwd'] === md5($password)) {
				// 存储session
				session('uid', $result['uid']); // 当前用户id
				session('husername', $result['username']); // 当前用户昵称
				session('uotype', $result['otype']); // 当前用户昵称
				session('upip', $map123['upip']); // 当前用户昵称
				session('portrait', $result['portrait']); // 当前用户昵称
				session('wxopenid',$result['openid']);
				cookie("isout", '1', 3600);
				
				$data['status'] = 1;
				$data['msg'] 	= '登录成功,正在跳转';
				$this->ajaxReturn($data,'JSON');

			} else {
				$data['status'] = 0;
				$data['msg'] 	= '登录失败 手机号或密码不正确';
				$this->ajaxReturn($data,'JSON');
			}
		}

		$this->assign("phone", $_COOKIE['phone']);
		$this->display();
	}


    /**
     * @functionname: reg
     * @author: wang
     * @description: 注册页面
     * @note:
     *
     */
    public function reg()
    {

        $ouid       = I('get.uid');

        $up_name    = M("userinfo")->where("uid=" . $ouid)->getField('username');

        $this->assign("up_name", $up_name);
        $this->assign("ouid", $ouid);

        $this->display();
    }


        /**
     * @functionname: register
     * @author: wang
     * @description: 处理注册
     * @note:
     * 现规定：
     * 通过链接，uid参数，可以是会员单位、代理1、代理2、用户（经纪人）的uid
     * 通过填写，只能是机构的编码，会员单位、代理1、代理2
     *
     */
    public function register()
    {

        if (IS_AJAX)
        {
            $user   = D('userinfo');
            //检查用户名
            header("Content-type: text/html; charset=utf-8");
            //检查手机验证码
            $code   = session('mobile_code');;
            $verify = trim(I('post.code'));


            //验证码正确时，处理
            if ($code == $verify)
            {
                $tuijianUid         = trim(I('post.tuijian_uid'));
                $data['username']   = trim(I('post.username'));
                $data['utel']       = trim(I('post.utel'));
                $data['upwd']       = md5(trim(I('post.upwd')));

                //如果有推荐的id
                if ($tuijianUid)
                {
                    $tuijianrenInfo  = $user->where(array('uid'=>$tuijianUid))->find();

                    if($tuijianrenInfo['otype'] == 0)
                    {
                        if($tuijianrenInfo['agenttype'] != 2)
                        {
                            $datas['status'] = 0;
                            $datas['msg']	 = '推荐人不存在，请确认推荐人的用户名123！';
                            $this->ajaxReturn($datas,'JSON');
                        }

                        $data['oid']        = $tuijianrenInfo['oid'];
                        $data['rel_id']     = $tuijianUid;
                    }
                    else
                    {
                        $data['oid']        = $tuijianUid;
                        $data['rel_id']     = 0;
                    }

					//$data['branch_id']	= branch_id($tuijianUid);
                    $data['operate_id'] = operate_id($tuijianUid);
                    $data['unit_id']    = get_unit_id($tuijianUid);
                    $data['leaguer_id'] = leaguer_id($tuijianUid);
                    //$data['agent_id']   	= agent_id($tuijianUid);
                }
                else //没有推荐的id
                {
                    $oid_name   = trim(I('post.oid_name'));

                    $whereArr['otype']      = array('in', '2,4,1');
                    $whereArr['username']   = $oid_name;

                    $oid    = M('userinfo')->where($whereArr)->getField('uid');


                    if (!$oid)
                    {
                        $datas['status'] = 0;
                        $datas['msg']	 = '推荐人不存在，请确认推荐人的用户名！';
                        $this->ajaxReturn($datas,'JSON');
                    }

                    //$data['branch_id']  = branch_id($oid);
                    $data['oid']        = $oid;
                    $data['operate_id'] = operate_id($oid);
                    $data['unit_id']    = get_unit_id($oid);
                    $data['leaguer_id'] = leaguer_id($oid);
                    //$data['agent_id']   = agent_id($oid);
                }

                if(!$data['unit_id'])
                {
                    $datas['status'] = 0;
                    $datas['msg']	 = '推荐人不存在，请确认推荐人的用户名！';
                    $this->ajaxReturn($datas,'JSON');
                }


                $uname  = $user->where(array('utel'=>$data['utel'], 'otype'=>'0'))->find();
                if ($uname)
                {
                    $datas['status'] = 0;
                    $datas['msg']	 = '手机号已经存在了';
                    $this->ajaxReturn($datas,'JSON');
                }
                else
                {
                //插入数据库

                    $data['utime'] 		= time();

                    $data['otype'] 		= 0;
                    $data['lastlog'] 	= time();
                    $data['upip'] 		= md5($this->get_real_ip() . time());

                    $data['nickname'] 	= $data['username'];
                    $data['usertype'] 	= 1;
                    $data['uip']        = $_SERVER["REMOTE_ADDR"];
                    $data['integrals'] 	= 10;

                    $newusername 		 = M("userinfo")->where("uid =" . $data['oid'])->getField("username");
                    $data['managername'] = $newusername;

                    $data['agenttype']	 = 2;	

                    $userid = M("userinfo")->add($data);

                    cookie("uid", $userid);
                    M('accountinfo')->add(array('uid' => $userid));
                    M("managerinfo")->add(array('uid' => $userid));

                    if ($userid)
                    {
                        $datas['status'] = 1;
                    	$datas['msg']	 = '注册成功';
                    	$this->ajaxReturn($datas,'JSON');
                    }
                    else
                    {
                        $datas['status'] = 0;
                    	$datas['msg']	 = '注册失败';
                    	$this->ajaxReturn($datas,'JSON');
                    }
                }
            }
            else
            {
                $datas['status'] = 0;
            	$datas['msg']	 = '验证码错误';
            	$this->ajaxReturn($datas,'JSON');
            }
		}
        else
        {
            $datas['status'] = 0;
        	$datas['msg']	 = '非法访问';
        	$this->ajaxReturn($datas,'JSON');
        }
	}

    /**
     * @functionname: get_real_ip
     * @author: wang
     * @description: 获取IP信息
     * @note:
     */
	public function get_real_ip() {
		$ip = false;
		if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) {
				array_unshift($ips, $ip);
				$ip = FALSE;
			}
			for ($i = 0; $i < count($ips); $i++) {
				if (!eregi("^(10|172\.16|192\.168)\.", $ips[$i])) {
					$ip = $ips[$i];
					break;
				}
			}
		}
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
}