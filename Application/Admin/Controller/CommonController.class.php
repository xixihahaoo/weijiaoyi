<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {

    public function _initialize(){
        /*$auth=new \Think\Auth();
        $uid = $_SESSION['userid'];
        $Model=M('userinfo');
        $res=$Model->where(array('uid'=>$uid))->find();
        $q=$res['q'];
        if($q != 1 && $uid !=''){
            
            if(!$auth->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,$uid)){
            $this->error('你没有权限','',2);
            }
            $rul = M('auth_rule')->field('condition')->where("type= 0")->find();
            $rules = $rul['condition'];
            $arrauth = explode(',', $rules);
            //客户权限
            

            $auth = M('auth_group')->where(array('id'=>$q))->find();
            $this->assign('listauth', $arrauth);
            $this->assign('range', $auth['rules']);
        }   */
        $user= A('Admin/User');
        $user->checklogin();
        //获取管理者的身份
        $uid=$_SESSION['userid'];
        $user = M('userinfo')->where(['uid'=>$uid])->find();
        //获取栏目允许哪类管理者用户
        $cate = M('admin_category');
        $cateArr = $cate->where(['state'=>1])->select();
        $rule = M('role')->where(['id'=>$user['q']])->select();
        $role = explode(',',$rule[0]['rules']);
        foreach ($cateArr as $k => $v){
            if (in_array($v['cid'],$role)) {
                $showArr[$v['cname']]['cid'] = $v['cid'];
                $showArr[$v['cname']]['pid'] = $v['pid'];
                $showArr[$v['cname']]['class'] = $v['class'];
                $showArr[$v['cname']]['url'] = $v['url'];
            }
        }
        
        $this->assign('category',$showArr);
        
        $this->assign('controller',strtolower(CONTROLLER_NAME));
    }
}