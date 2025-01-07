<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;

class UserController extends CommonController {

    /**
     * 个人中心
     * @author wang <990529346@qq.com>
     */
	public function index()
	{		

		$info 		= M('userinfo')->where(array('uid' => $this->user_id))->find();
		$account 	= M('accountinfo')->where(array('uid' => $this->user_id))->find();

		$hostlink = $_SERVER['HTTP_HOST'];
		$url      = "http://" . $hostlink . U('Register/wxlr') . "?uid=" . $this->user_id;
		
		$this->assign('info',$info);
		$this->assign('account',$account);
		$this->assign('url', $url);

		$this->display();
	}


    /**
     * 绑定银行卡
     * @author wang <990529346@qq.com>
     */
	public function banks()
	{
        $bank = M('bankinfo')->where(array('uid' => $this->user_id))->find();

        $city = M('city')->where(array('level' => 1))->select();

        if($bank['province'])
        {
        	$myCity = M('city')->field('name')->where('parent_id = (select id from wp_city where joinname = "'.$bank['province'].'")')->select();
        	$this->assign('myCity',$myCity);
        }

        $this->assign('bank',$bank);
        $this->assign('city',$city);

        $this->display();
	}


    /**
     * 审核绑定银行卡信息
     * @author wang <990529346@qq.com>
     */
    public function binding(){

        $data = array();

        if (IS_AJAX) {
            $user = M('bankinfo')->where(array('uid' => $this->user_id))->find();
            if (!$user['j_bankNo']) {

                $j_name       = trim(I('post.j_name'));     //姓名
                $Card         = trim(I('post.Card'));       //身份证号码
                $bankName     = trim(I('post.bankName'));  //银行名称
                $province     = trim(I('post.province'));  //开户所在省
                $city         = trim(I('post.city'));       //开户所在市
                $branch       = trim(I('post.branch'));    //支行名称
                $j_bankNo     = trim(I('post.j_bankNo'));  //银行卡号码

                if (empty($j_name)) {
                    $data['status'] = 0;
                    $data['msg'] = '开户名不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (is_numeric($j_name) || mb_strlen($j_name) > 15) {
                    $data['status'] = 0;
                    $data['msg'] = '开户名填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }
                
                if(empty($Card)) {

                    $data['status'] = 0;
                    $data['msg'] = '身份证号码不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

               if(!preg_match("/(^\d{15}$)|(^\d{17}([0-9]|X)$)/",$Card)) {

                    $data['status'] = 0;
                    $data['msg'] = '身份证号码填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($bankName)) {

                    $data['status'] = 0;
                    $data['msg'] = '银行名称不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($province)) {

                    $data['status'] = 0;
                    $data['msg'] = '请填写开户所在省';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($city)) {

                    $data['status'] = 0;
                    $data['msg'] = '请填写开户所在市';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($branch)) {
                    $data['status'] = 0;
                    $data['msg'] = '支行名称不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (empty($j_bankNo)) {
                    $data['status'] = 0;
                    $data['msg'] = '银行卡号不能为空';
                    $this->ajaxReturn($data, 'JSON');
                }

                if (!is_numeric($j_bankNo)) {
                    $data['status'] = 0;
                    $data['msg'] = '银行卡号填写不正确';
                    $this->ajaxReturn($data, 'JSON');
                }


                $data['uid'] 		= $this->user_id;
                $data['busername']  = $j_name;
                $data['bankname']   = $bankName;
                $data['banknumber'] = $j_bankNo;
                $data['branch']     = $branch;
                $data['card']       = $Card;
                $data['province']   = $province;
                $data['city']       = $city;

                $bankinfoObj 		= M('bankinfo');
                $is_exist = $bankinfoObj->field('banknumber')->where(array('uid' => $data['uid']))->find();

                if ($is_exist) {

                    $bank = $bankinfoObj->where(array('uid' => $data['uid']))->save($data);

                } else {

                    $bank = $bankinfoObj->add($data);
                }
            }

            if ($bank) {
                $data['status'] = 1;
                $data['msg'] = '修改成功';
                $this->ajaxReturn($data, 'JSON');
            } else {
                $data['status'] = 0;
                $data['msg'] = '修改失败';
                $this->ajaxReturn($data, 'JSON');
            }
        }
        $this->error('您访问的页面不存在','index');
    }

    /**
     * 省市联动
     * @author wang <990529346@qq.com>
     */
    public function city(){
         if(IS_AJAX) {
             $id = I('post.id');
             $city = M('city')->where(array('parent_id' => $id))->select();
             if(!$city) {
                    $this->ajaxReturn('不存在','JSON');
             } else {
                    $this->ajaxReturn($city,'JSON');
             }
        } else {
             $this->ajaxReturn('程序异常','JSON');
        }
    }

    /**
     * 修改密码
     * @author wang <990529346@qq.com>
     */
    public function password_retrieval()
    {
    	if(IS_AJAX)
    	{	
    		$userObj 	= M('userinfo');

    		$data 		= array();

    		$used_password 	= trim(I('post.used_password'));
    		$new_password 	= trim(I('post.new_password'));
    		$news_password 	= trim(I('post.news_password'));

    		if(empty($used_password))
    		{
    			$data['status'] = 0;
    			$data['msg']	= '请填写旧密码';
    			$this->ajaxReturn($data,'JSON');
    		}

    		if(empty($new_password) || empty($news_password))
    		{
    			$data['status'] = 0;
    			$data['msg']	= '请填写新密码';
    			$this->ajaxReturn($data,'JSON');
    		}

    		if($new_password !== $news_password)
    		{
    			$data['status'] = 0;
    			$data['msg']	= '新密码必须相同';
    			$this->ajaxReturn($data,'JSON');
    		}

    		$info 		= $userObj->field('upwd')->where(array('uid' => $this->user_id))->find();

    		$password 	= md5($used_password);

    		if($password != $info['upwd'])
    		{
    			$data['status'] = 0;
    			$data['msg']	= '旧密码填写错误';
    			$this->ajaxReturn($data,'JSON');
    		}

    		$status 	= $userObj->where(array('uid' => $this->user_id))->setField('upwd',md5($new_password));

    		if($status)
    		{
    			$data['status'] = 1;
    			$data['msg']	= '修改成功';
    			$this->ajaxReturn($data,'JSON');
    		} else {

    			$data['status'] = 0;
    			$data['msg']	= '修改失败';
    			$this->ajaxReturn($data,'JSON');
    		}

    	} else {

    		$this->display();
    	}
    }


    /**
     * 资金流水
     * @author wang <990529346@qq.com>
     */
    public function capital()
    {
    	$flowObj 	= M('money_flow');

		$p 		 	= 1;

		$pagecount	= 10;

		$count   	= $flowObj->where(array('uid' => $this->user_id,'user_type' => 0))->count();

    	$flow 	 	= $flowObj->where(array('uid' => $this->user_id,'user_type' => 0))->order('id desc')->page($p,$pagecount)->select();

    	foreach ($flow as $key => $value) {
    		
    		$flow[$key]['note'] = str_replace('用户','',$value['note']);
        	$note  				= explode('[',$flow[$key]['note']);
            $flow[$key]['note'] = $note[0];

            switch ($value['type']) {
            	case 1:
            		$flow[$key]['type'] = '购买';
            		break;
            	case 2:
            		$flow[$key]['type'] = '平仓';
            		break;

            	case 3:
            		$flow[$key]['type'] = '提现';
            		break;

            	case 4:
            		$flow[$key]['type'] = '充值';
            		break;

            	case 5:
            		$flow[$key]['type'] = '佣金';
            		break;

            	default:
            		# code...
            		break;
            }
    	}
    	
    	$this->assign('flow',$flow);
    	$this->assign('count',ceil($count / $pagecount));
    	$this->display();
    }


    public function capitalPage()
    {
    	if(IS_AJAX)
    	{
    		$flowObj 	= M('money_flow');

			$page 		= trim(I('post.page'));
			if($page <= 1 || empty($page))
			{
				$page = 2;
			} else {
				$page = $page;
			}

			$pagecount	= 10;

    		$flow 	 	= $flowObj->where(array('uid' => $this->user_id,'user_type' => 0))->order('id desc')->page($page,$pagecount)->select();

	    	foreach ($flow as $key => $value) {
	    		
	    		$flow[$key]['note'] = str_replace('用户','',$value['note']);
	        	$note  				= explode('[',$flow[$key]['note']);
	            $flow[$key]['note'] = $note[0];

	            switch ($value['type']) {
	            	case 1:
	            		$flow[$key]['type'] = '购买';
	            		break;
	            	case 2:
	            		$flow[$key]['type'] = '平仓';
	            		break;

	            	case 3:
	            		$flow[$key]['type'] = '提现';
	            		break;

	            	case 4:
	            		$flow[$key]['type'] = '充值';
	            		break;

	            	case 5:
	            		$flow[$key]['type'] = '佣金';
	            		break;

	            	default:
	            		# code...
	            		break;
	            }

	            $flow[$key]['dateline'] = date('Y-m-d H:i:s',$value['dateline']);
	    	}

    		$this->ajaxReturn($flow,'JSON');

    	} else {
    		$data['status'] = 0;
    		$data['msg'] 	= '非法操作';
    		$this->ajaxReturn($data,'JSON');
    	}
    }


    /**
     * 用户入金
     * @author wang <990529346@qq.com>
     */
    public function recharge()
    {

		if (IS_AJAX) {


            $balance = trim(I('post.balance'));
            $paytype = trim(I('post.paytype'));

            if(empty($balance))
            {
                $data['status'] = 0;
                $data['msg']    = '充值金额不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if($balance <= 0 || !is_numeric($balance))
            {
                $data['status'] = 0;
                $data['msg']    = '非法的充值金额';
                $this->ajaxReturn($data,'JSON');  
            }

            if(empty($paytype))
            {
                $data['status'] = 0;
                $data['msg']    = '请选择支付方式';
                $this->ajaxReturn($data,'JSON');  
            }

            $financial  = M('financial_setting')->where('type=' . 1)->find();
            if($balance < $financial['min_monery'])
            {
                $data['status'] = 0;
                $data['msg']    = '充值金额不能小于'.$financial['min_monery'].'';
                $this->ajaxReturn($data,'JSON');  
            }

            if($balance > $financial['max_monery'])
            {
                $data['status'] = 0;
                $data['msg']    = '充值金额不能大于'.$financial['max_monery'].'';
                $this->ajaxReturn($data,'JSON');  
            }


            $ultime = $this->tradetimetotime($financial['starttime']);
            $urtime = $this->tradetimetotime($financial['endtime']);

            if (time() < $ultime || time() > $urtime)
            {
                $data['status'] = 0;
                $data['msg']    = '当前时间不能充值';
                $this->ajaxReturn($data,'JSON');
            } else {

                $data['status'] = 1;
                $this->ajaxReturn($data,'JSON');
            }

		} else {

            $result     = M('accountinfo')->where('uid=' . $this->user_id)->find();
            $financial  = M('financial_setting')->where('type=' . 1)->find();
            
            $this->assign('financial',$financial);
            $this->assign('result', $result);
            $this->display();
        }
    }


    /**
     * 用户出金
     * @author wang <990529346@qq.com>
     */
    public function withdrawals()
    {

        $bank = M('bankinfo')->where(array('uid' => $this->user_id))->find();

        $bank['banknumber'] = substr_replace($bank['banknumber'],'**** **** **** ',0,mb_strlen($bank['banknumber'])-4);

        $financial = M('financial_setting')->where(array('type'=>2))->find();
        $this->assign('financial',$financial);
        $this->assign('bank',$bank);
        $this->assign('balance',M('accountinfo')->where(array('uid' => $this->user_id))->getField('balance'));
        $this->display();
    }


    /**
     * 用户出金审核
     * @author wang <990529346@qq.com>
     */
    public function withdrawals_check()
    {
        if(IS_AJAX)
        {

            $money = trim(I('post.money'));

            if(empty($money))
            {
                $data['status'] = 0;
                $data['msg']    = '提现金额不能为空';
                $this->ajaxReturn($data,'JSON');
            }

            if($money <= 0 || !is_numeric($money))
            {
                $data['status'] = 0;
                $data['msg']    = '提现金额非法';
                $this->ajaxReturn($data,'JSON');
            }

            //后台结算实际提现金额
            $financial  = M('financial_setting')->where(array('type'=>2))->find();
            $shibpprice = round($money - ($money * ($financial['poundage'] / 100)),2);


            if($money < $financial['min_monery'] || $money > $financial['max_monery'])
            {
                $data['status'] = 0;
                $data['msg']    = '提现金额最低'.$financial['min_monery'].'最多'.$financial['max_monery'].'';
                $this->ajaxReturn($data,'JSON');
            }


            $ultime = $this->tradetimetotime($financial['starttime']);
            $urtime = $this->tradetimetotime($financial['endtime']);

            if (time() < $ultime || time() > $urtime)
            {
                $data['status'] = 0;
                $data['msg']    = '当前时间不能提现';
                $this->ajaxReturn($data,'JSON');
            }


           //判断用户冻结状态
            $status = M('userinfo')->where(array('uid' => $this->user_id))->getField('ustatus');
            if ($status == 2)
            {
                $data['status'] = 0;
                $data['msg']    = '你的账户被冻结';
                $this->ajaxReturn($data,'JSON');
            }

            $balance = M('accountinfo')->where(array('uid' => $this->user_id))->getField('balance');
            if($money > $balance)
            {
                $data['status'] = 0;
                $data['msg']    = '余额不足';
                $this->ajaxReturn($data,'JSON');
            }


            $bank = M('bankinfo')->where(array('uid' => $this->user_id))->find();
            if($bank['banknumber'])
            {
                //提现表
                $balances['bptype']     = '提现';
                $balances['balanceno']  = 'TX'.time().rand(100000, 999999);
                $balances['bptime']     = date(time());
                $balances['bpprice']    = $money;
                $balances['shibpprice'] = $shibpprice;
                $balances['uid']        = $this->user_id;
                $balances['isverified'] = 0;
                $balances['remarks']    = $bank['busername'] . '<br />' . $bank['bankname'] . '<br />' . $bank['banknumber'] . '<br />' . $bank['branch'];

                //提现记录
                $bournals['btype']      = '提现';
                $bournals['btime']      = date(time());
                $bournals['bprice']     = $money;
                $bournals['uid']        = $this->user_id;
                $bournals['username']   = $_SESSION['husername'];
                $bournals['isverified'] = 0;
                $bournals['bno']        = $this->build_order_no();
                $bournals['balance']    = $balance - $money;

                //插入提现记录
                $balance_result = M('balance')->add($balances);
                $bournal_result = M('bournal')->add($bournals);

                if($balance_result && $bournal_result)
                {
                    if(M('accountinfo')->where('uid=' . $this->user_id)->setDec('balance',$money))
                    {
                        //增加用户提现流水记录
                        $money_log['uid']          = $this->user_id;
                        $money_log['type']         = 3;     //提现
                        $money_log['oid']          = $balance_result;//
                        $money_log['note']         = '用户申请提现扣除['.$money.']元';
                        $money_log['op_id']        = $this->uid;
                        $money_log['user_type']    = 0;     //1代理(2)，0用户 1代理(2) 4代理(1) 2会员单位 5运营中心
                        $money_log['change_money'] = $money;
                        $money_log['balance']      = $balance - $money;
                        $money_log['dateline']     = time();
                        M('money_flow')->add($money_log);

                        $data['status'] = 1;
                        $data['msg']    = '提现成功';
                        $this->ajaxReturn($data,'JSON');
                    } else {
                        $data['status'] = 0;
                        $data['msg']    = '提现失败';
                        $this->ajaxReturn($data,'JSON');
                    }
                } else {
                        $data['status'] = 0;
                        $data['msg']    = '提现失败';
                        $this->ajaxReturn($data,'JSON');
                }

            } else {

                $data['status'] = 0;
                $data['msg']    = '尚未绑定银行卡';
                $this->ajaxReturn($data,'JSON');
            }

        } else {

            $data['status'] = 0;
            $data['msg']    = '非法操作';
            $this->ajaxReturn($data,'JSON');
        }
    }


    /**
     * 退出登录
     * @author wang <990529346@qq.com>
     */
    public function logout()
    {
        session(null);
        cookie(null);
        $this->redirect('Index/index');
    }


	public function userlogin() {

		//判断用户是否已经登录
		if (!isset($_SESSION['uid'])) {
			$this->redirect('User/login');
		}
	}


	//随机生成订单编号
	public function build_order_no() {
		return date(time()) . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 3);
	}


    //转换时间戳
    public function tradetimetotime($ntime) {
        return strtotime(date('Y-m-d ' . substr($ntime, 0, 2) . ':' . substr($ntime, 2, 4) . ':00'));
    }
}