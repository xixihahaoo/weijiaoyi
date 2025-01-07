<?php
/**
 * 权限管理相关
 * User: poplar
 * email: 675541457@qq.com
 * Date: 2017/3/31
 * Time: 11:21
 */

namespace Admin\Controller;

class AuthorityController extends CommonController {
    /**
     * 权限组列表
     */
    public function index(){
        $cateArr = M('admin_category')->where(['state'=>1])->select();
        $admin_user = M('role')->where(['status'=>1])->select();
        foreach ($admin_user as $k => $v){
            $rule = explode(',',$v['rules']);
            $str='';
            foreach($cateArr as $sk => $sv){
                if ($sv['pid']!=0) {
                    if(in_array($sv['cid'],$rule)){
                        $showArr[$v['id']] = [
                            'name'=>$v['name'],
                            'str'=>$str.$sv['cname'],
                        ];
                        $str = $showArr[$v['id']]['str'].',';
                    }
                }
            }
        }
        $this->assign('showArr',$showArr);
        $this->display();
    }

    /**
     * 编辑权限
     */
    public function edit(){
        $id = I('get.id',0);
        $role = M('role')->where(array('id'=>$id))->find();
        $rule = explode(',',$role['rules']);
        if(!$role){
            $this->error('不存在该分组');
        }else{
            $cateArr = M('admin_category')->where(['state'=>1])->select();
            foreach ($cateArr as $k => $v){
                if($v['pid'] == 0){
                    foreach ($cateArr as $sk => $sv){
                        if($sv['pid'] == $v['cid']){
                            $showArr[$v['cid']]['cname'] = $v['cname'];
                            $childCateArr[$sv['cid']]['name'] = $sv['cname'];
                            $childCateArr[$sv['cid']]['pid'] = $v['cid'];
                        }
                    }
                }
            }
        }
        $this->assign('rule',$rule);
        $this->assign('id',$id);
        $this->assign('cateArr',$showArr);
        $this->assign('childCateArr',$childCateArr);
        $this->display();


    }

    /**
     * 更新权限
     */
    public function update(){
        $rids = I('post.rules');
        $rules = implode(',',$rids);
        $id = I('post.id');
        $category = M('admin_category');
        $cateArr = $category->where(['state'=>1])->select();
        foreach($cateArr as $k => $v){
            if(in_array($v['cid'],$rids)){
                $fcate = $category->field('cid')->where(['cid'=>$v['pid']])->select();
                $rules = $rules . ',' . $fcate[0]['cid'];
            }
        }
        $admin = M('role')->where(['id'=>$id])->save(['rules'=>$rules]);
        if($admin){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }

    }

    /**
     * 设置权限功能
     */
    public function setrules(){
        $uid = I('get.id',0);
        $user_rulesObj = M('user_rules');
        if(IS_POST){
            $data['uid'] = I('post.id');
            $rids = I('post.rules');
            if($rids){
                $data['rules'] = implode(',',$rids);
            }
            $is_have = $user_rulesObj->where(array('uid'=>$data['uid']))->find();
            if($is_have){
                $rs = $user_rulesObj->where(array('uid'=>$data['uid']))->save($data);
            }else{
                $rs = $user_rulesObj->add($data);
            }
            if($rs){
                $this->success('修改成功');
            }else{
                $this->error('更新失败');
            }
        }else{
//            $uid = 2861;//测试用户
            $userinfo = M('userinfo')->field('otype,username,nickname,utel')->where(array('uid'=>$uid,'ustatus'=>0))->find();
            if(empty($userinfo)){
                $this->error('该用户不存在或已经被冻结');
            }
            if(!in_array($userinfo['otype'],array(2,5,6))){
                $this->error('非机构会员无权限相关设置');
            }
            $user_relationObj = M('userinfo_relationship');

            $ruleObj = M('rule');
            $parent_id = $user_relationObj->where(array('user_id'=>$uid))->getField('parent_user_id');

            $parent_rules = $user_rulesObj->where(array('uid'=>$parent_id))->getField('rules');

            if($parent_rules){//父级权限
                $parent_rules_arr = explode(',',$parent_rules);
                $rules = $ruleObj
                    ->where(array('extent'=>2,'rid'=>array('IN',$parent_rules_arr)))
                    ->field('rid,title,type')
                    ->select();

            }else{//若无父级则默认全部
                $rules = $ruleObj
                    ->where(array('extent'=>2))
                    ->field('rid,title,type')
                    ->select();
            }
            //0默认分类，1项目管理，2机构管理，3订单管理，4资金管理，5报表管理
            $cate=array(0=>'默认分类',1=>'项目管理',2=>'机构管理',3=>'订单管理',4=>'资金管理',5=>'报表管理',6=>'权限管理',7=>'系统设置',8=>'客户管理',9=>'管理员管理',
                10=>'机构控制台',11=>'机构管理',12=>'交易商管理',13=>'订单管理',14=>'资金管理',15=>'推广管理',16=>'个人中心',17=>'申请提现',18=>'编辑权限');
            $otype_arr = array(2=>'结算会员',5=>'运营中心',6=>'经济会员');
            $myrules = $user_rulesObj->where(array('uid'=>$uid))->getField('rules');
            $my_rules = explode(',',$myrules);
            $userinfo['otype_str'] = $otype_arr[$userinfo['otype']];
            $this->assign('user',$userinfo);
            $this->assign('my_rules',$my_rules);
            $this->assign('id',$uid);
            $this->assign('cate',$cate);
            $this->assign('rules',$rules);
            $this->display();
        }
    }

    public function extract(){}
}