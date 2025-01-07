<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class WebController extends CommonController{
    //银行卡
    public function index(){
        $myuid=$_SESSION['cuid'];
        $account = M('accountinfo')->where(array('uid'=>$myuid))->find();
        if(IS_POST){
            $npw = I('post.npw');
            $rpw = I('post.rpw');
            $oldpw = I('post.oldpw');
            if($account['pwd'] != ''){
                if(md5($oldpw) != $account['pwd']){
                    $this->error('原始密码不正确');
                }
            }
            if($npw != $rpw){
                $this->error('两次密码不一致!');
            }
            if($rpw == ''){
                $this->error('交易密码不能为空!');
            }
            $data['pwd'] = md5($npw);
            $accountinfo = M('accountinfo')->where(array('uid'=>$myuid))->save($data);
            if($accountinfo){
                $this->success('修改成功!');
            }
        }else{
            $this->assign('account',$account['pwd']);
            $this->display();
        }
        
    }
    public function login(){
        $myuid=$_SESSION['cuid'];
        $userinfo = M('userinfo')->where(array('uid'=>$myuid))->find();
        if(IS_POST){
            $npw = I('post.npw');
            $rpw = I('post.rpw');
            $opw = I('post.opw');
            if($userinfo['upwd'] != md5($opw)){
                if(md5($oldpw) != $account['pwd']){
                    $this->error('原始密码不正确');
                }
            }
            if($npw != $rpw){
                $this->error('两次密码不一致!');
            }
            if($npw == ''){
                $this->error('密码不能为空!');
            }
            $data['upwd'] = md5($npw);
            $u = M('userinfo')->where(array('uid'=>$myuid))->save($data);
            if($u){
                $this->success('修改成功!');
            }
        }else{
            $this->display();
        }
    }


    /**
     * @functionname: my_info
     * @author: FrankHong
     * @date: 2017-03-24 12:06:54
     * @description: 个人账户信息
     * @note:
     */
    public function my_info()
    {
        $accountObj     = M('accountinfo');
        $myuid          = $_SESSION['cuid'];
        $accountInfo    = $accountObj->where(array('uid' => $myuid))->find();


        $this->assign('balance', $accountInfo['balance']);
        $this->display('myinfo');

    }
}