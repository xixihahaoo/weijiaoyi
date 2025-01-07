<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class MoneyController extends CommonController{
    //银行卡
    public function bank(){
        $myuid=$_SESSION['cuid'];
        if(IS_POST){
            $bank = M('bankinfo')->where(array('uid'=>$myuid))->find();
            if($bank){
                 $data['banknumber'] = I('post.banknumber');
                 $data['uid'] = $myuid;
                 $res = M('bankinfo')->where(array('uid'=>$myuid))->save($data);
                 //echo M('bankinfo')->getLastSql();die;
                 if($res){
                    $info = '修改银行卡信息';
                    user_log($info,2);
                    $this->success('修改成功');
                 }else{
                    $this->error("只允许修改银行卡号!"); 
                 }
            }else{
                $this->error("请联系上级会员进行绑定信息!"); 
            }
        }else{
            $bank = M('bankinfo')->where(array('uid'=>$myuid))->find();
            $this->assign('bank',$bank);
            $this->display();
        }
        
    }
    //提现申请
    public function moneyadd(){
        $myuid=$_SESSION['cuid'];
        if(IS_POST){
            $bank = M('bankinfo')->where(array('uid'=>$myuid))->find();
            $account = M('accountinfo')->where(array('uid'=>$myuid))->find();
            if($account['pwd'] == ''){
                $this->error('请先设置交易密码!',U('Web/index'),2);
            }
            if($bank['banknumber'] == ''){
                $this->error("请先绑定银行卡号",U('Money/bank')); 
            }
            if($account['pwd'] !=md5(I('post.pwd'))){
                $this->error('交易密码不正确!');
            }
            $money = I('post.money');
            $userinfo = M('userinfo as u')->field('u.assure,u.otype,u.username, a.balance,a.frozen')->join('wp_accountinfo as a ON a.uid = u.uid')->where(array('u.uid'=>$myuid))->find();


            if($money <= 0 || !is_numeric($money)){
                $this->error('提现金额不正确!');
            }


            if($userinfo['balance'] - $userinfo['frozen'] < $money){
                $this->error("提现金额不能大于可提现金额");
            }
            $userinfo = M('accountinfo')->where(array('uid'=>$myuid))->setDec('balance', $money);

            $accountNow = M('accountinfo')->field('balance')->where(array('uid'=>$myuid))->find();


            if($userinfo){
                $bank = M('bankinfo')->where(array('uid'=>$myuid))->find();

                $map['bptype'] = '提现';
                $map['bptime'] = time();
                $map['bpprice'] = $money;
                $map['remarks'] = $bank['busername'].'<br/>'.$bank['bankname'].'<br/>'.$bank['banknumber'].'<br/>'.$bank['branch'];
                $map['uid'] = $myuid;
                $map['isverified'] = 0;
                $map['shibpprice'] = $money;
                $res =M('balance')->add($map);

                //money_flow
                $moneyData  = array(
                    'uid'           => $myuid,
                    'user_type'     => 2,
                    'oid'           => $res,
                    'type'          => 3,
                    'op_id'         => $myuid,
                    'change_money'  => $money,
                    'balance'   => $accountNow['balance'],
                    'dateline'  => time(),
                    'note'      => '会员单位['.$userinfo['username'].']申请取现扣除['.$money.']元'
                );
                M('money_flow')->add($moneyData);

                if($res){
                    $info = '会员单位['.$userinfo['username'].']申请提现['.$money.']元';
                    user_log($info, 2);
                    $this->success('操作成功');
                }
            }
        }else{
            $userinfo = M('userinfo as u')->field('u.assure,u.otype,a.balance,a.frozen')->join('wp_accountinfo as a ON a.uid = u.uid')->where(array('u.uid'=>$myuid))->find();
            //dump($userinfo);die;

            $bank = M('bankinfo')->where(array('uid'=>$myuid))->find();

            $this->assign('banklist', $bank);
//            dump($bank);
            $this->assign('list',$userinfo);
            $this->display();
        }
    }
    //设置
    public function base(){
        $myuid=$_SESSION['cuid'];
        if(IS_POST){
            if(I('post.feerebate')>100){
                $this->error('返佣比例不能超过100%');
            }
            $data['feerebate'] = I('post.feerebate');
            $userinfo = M('userinfo')->where(array('uid'=>$myuid))->save($data);
            if($userinfo){
                $this->success('操作成功');
            }
        }else{
            $userinfo = M('userinfo')->where(array('uid'=>$myuid))->find();
            $this->assign('list',$userinfo);
            $this->display();
        }
        
    }
    //提现列表
    public function moneylist(){
        $myuid=$_SESSION['cuid'];
        $bank = M('balance')->where(array('uid'=>$myuid))->select();
        //dump($bank);die;
        $this->assign('list',$bank);
        $this->display();
    }
}