<?php
/**
 * 代金券相关功能 coupon
 * User: poplar
 * mail: 675541457@qq.com
 * Date: 2017/1/19
 * Time: 17:39
 */
namespace Admin\Controller;
use Think\Controller;
class CouponController extends CommonController {
    public function index(){
        
        
        $this->assign('title','体验券管理');
        $couponObj = M('coupon c');
        $where=array();
        $count = $couponObj->where($where)->count();
        $page_size = 15;
        $page = new \Think\Page($count , $page_size);
//        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $data['page'] = $page->show();
        $data['rows'] = $couponObj->where($where)->field()->limit($page->firstRow.','.$page->listRows)->order('id DESC')->select();
        if($data['rows']){
            foreach($data['rows'] as &$v){
                $v['end_time'] = $v['end_time']-86400;
            }
        }

        $this->assign($data);
        $this->display('');
//        dump($data);
    }

    public function add(){
        if(IS_POST && IS_AJAX){
            $data = $this->_solve_data();
            $data['createtime']=time();
            $res=array('msg'=>'添加成功','status'=>1);
                if(empty($data['title'])){
                    $res=array('msg'=>'请填写代金券标题','status'=>0);
                    $this->ajaxReturn($res);
                }

            $couponObj = M('coupon');
            $res['id'] = $couponObj->add($data);
//            $res['id']=100;//测试数字
            $is_add = I('post.is_add');
            if($is_add && $res['id'] && $data['type']==1){//增加快捷发送代金券功能。允许快捷发放。前台允许快捷，有代金券id,并且类型为1会员模式
                $unit = I('post.unit');
                $agent = I('post.agent');
                $leaguer = I('post.leaguer');
                $where_user['ustatus'] = 0;
//                $where_user['otype'] =array('neq','3');
                //仅仅给下一级发放代金券，发放范围有待重新指定
                if($leaguer){
                    $where_user['leaguer_id']=$leaguer;
                    $where_user['otype'] = 0;//给普通会员发放
                }elseif($agent){
                    $where_user['agent_id']=$agent;
                    $where_user['otype'] = 4;//给代理会员发放
                }elseif($unit){
                    $where_user['unit_id'] =$unit;
                    $where_user['otype'] = 1;//给经纪人发放
                }
                $ids_arr = M('userinfo')->where($where_user)->getField('uid',true);
                if($ids_arr){
                    foreach($ids_arr as $k=>$v){
                        $coupon_user[$k]['uid']=$v;
                        $coupon_user[$k]['cid']=$res['id'];
                        $coupon_user[$k]['modified']=time();
                    }
                    M('coupon_user')->addAll($coupon_user);
                    $count = count($coupon_user);
                    $couponObj->where(array('id'=>$res['id']))->save(array('total'=>$count));//更新数目
                }

            }

            $this->ajaxReturn($res);
        }

        $this->display();
    }

    public function edit(){
        $couponObj = M('coupon');
        if(IS_POST && IS_AJAX) {
            $data = $this->_solve_data();
            $id = I('post.id');
            if($id <1){
                $this->ajaxReturn(array('msg'=>'更新失败','status'=>0));
            }
            unset($data['value']);//金额不可变
            unset($data['title']);//标题不可变
            unset($data['type']);//类型不可变
            $result = $couponObj->where(array('id'=>$id))->save($data);
            if($result){
                $this->ajaxReturn(array('msg'=>'更新成功','status'=>1));
            }
            $this->ajaxReturn(array('msg'=>'更新失败','status'=>0));
        }else{
            $id = trim(I('get.id'), 0);
            $id = (int)$id;
            $res = array('msg' => '查找成功', 'status' => 1);
            if ($id < 1) {
                $res = array('msg' => 'id错误', 'status' => 0);
            }

            $res['data'] = $couponObj->where(array('id' => $id))->find();
            if ($res['data']) {
                $res['data']['begin_time'] = !empty($res['data']['begin_time']) ? date('Y-m-d', $res['data']['begin_time']) : '';
                $res['data']['end_time'] = !empty($res['data']['end_time']) ? date('Y-m-d', $res['data']['end_time']) : '';
                $res['data']['type_str'] = $res['data']['type']==1?'入金送券':'充值送券';
                $this->assign($res);
            }
            $this->display();
        }

    }

    /**
     * 删除代金券
     * 会员模式的代金券如果有未使用的则不允许删除
     * 取消删除功能
     */
    public function del(){
        $this->ajaxReturn(array('msg'=>'禁用删除功能','status'=>0));
        if(IS_AJAX){
            $id = trim(I('get.id'));
            $couponObj = M('coupon');
            $couponUser = M('coupon_user u');
            $where_time=array(
                array('c.begin_time'=>array('elt',time()),
                'c.end_time'=>array('gt',time()+86400)),
                array('c.end_time'=>0),
                array('c.begin_time'=>0),
                '_logic'=>'OR'
            );
            $flag = $couponUser->
            join('__COUPON__ c ON c.id=u.cid')->
            where(array('u.cid'=>$id,'u.status'=>1,'c.status'=>1,$where_time))->
            count();
            if($flag){
                $this->ajaxReturn(array('msg'=>'尚有有效代金券未使用，无法删除','status'=>'0'));
            }
            $res = $couponObj->where(array('id'=>$id))->delete();
            if($res){
                $this->ajaxReturn(array('msg'=>'删除成功','status'=>1));
            }
        }
    }

    public function show_u(){
        $id = trim(I('get.id',0));
        $res['id'] = $id = (int)$id;
        $res['rows'] = array();
        if($id >1){
            $coupon_userObj = M('coupon_user c');

            $count = $coupon_userObj->where(array('c.cid'=>$id))->count();
            $page_size = 10;
            $page = new \Think\Page($count , $page_size);
//          $page->parameter = $search; //传递查询条件
            $res['page'] = $page->show();

            $res['cou_type'] = M('coupon')->where(array('id'=>$id))->getField('type');
            $res['rows'] = $coupon_userObj->
                join('LEFT JOIN __USERINFO__ u ON c.uid = u.uid')->
                where(array('c.cid'=>$id))->
                field('c.uid,c.status,u.username,u.utel,u.nickname,u.otype,c.modified')->
                limit($page->firstRow.','.$page->listRows)->
                order('c.status ASC,c.modified DESC')->
                select();
            $type_arr = array('0'=>'客户',1=>'经纪人',2=>'会员单位','3'=>'超级管理员',4=>'普通会员');
            if($res['rows']){
                foreach($res['rows'] as &$v){
                    $v['otype_str'] = isset($type_arr[$v['otype']])&&!empty($type_arr[$v['otype']])?$type_arr[$v['otype']]:'未定义';
                    $v['status_str'] = $v['status'] == 1 ?'<font color=green>未使用</font>':'<font color=red>已使用</font>';
                }
            }
        }
        $this->assign($res);
        $this->display();
    }

    /**
     * 发放代金券
     */
    public function send_coupon(){
        if(!IS_POST){//表单展示页面
            $res['id'] = $id = trim(I('get.id'),0);
            if(!empty($id)){
                $coupon_userObj = M('coupon_user');
                $where_user = array('otype'=>array('IN','0,1,2,4'),'ustatus'=>0);
                $userObj = M('userinfo');
                $temp_uids = $coupon_userObj->where(array('cid'=>$id))->getField('uid',true);

                if(is_array($temp_uids)){
                    $except_ids = implode(',',$temp_uids);
                }else{
                    $except_ids = $temp_uids;
                }
                if(!empty($except_ids)){
                    $where_user['uid'] = array('NOT IN',$except_ids);
                }
                $res['rows'] = $userObj->
                where($where_user)->
                field('username,uid,utel,otype,nickname')->
                order('otype ASC,uid DESC')->
                select();
            }
            $this->assign($res);
            $this->display();
        }else{//提交表单信息
            $id = (int)trim(I('post.id'),0);
            $user_ids = I('post.ids');
            if($id<1 || empty($user_ids)){
                $this->error('代金券或会员不存在',U('Coupon/show_u',array('id'=>$id)));
            }
            $data = array();
            foreach($user_ids as $v){
                $data[]=array('uid'=>$v,'cid'=>$id,'modified'=>time());
            }
            $res = M('coupon_user')->addAll($data);
            if($res){//发放成功，更新代金券数量
                $this->update_count($id);
            }
            $this->success('发放成功',U('Coupon/show_u',array('id'=>$id)));
        }
    }
    /**
     * 获取前台数值
     * @return mixed
     */
    private function _solve_data(){
        $data['title'] = trim(I('post.title','代金券'));
        $data['value'] = trim(I('post.value',0));
        $data['floor_limit'] = trim(I('post.floor_limit',0));
        $data['top_limit'] = trim(I('post.top_limit',0));
        $data['limit'] = trim(I('post.limit',0));
        $data['begin_time'] = trim(I('post.begin_time',0));
        $data['end_time'] = trim(I('post.end_time',0));
        $data['type'] = I('post.type');//1会员模式，2验证码模式，现阶段为会员模式。trim(I('post.type',1));
        $data['total'] = trim(I('post.total',0));
        $data['modified'] = time();

        if($data['begin_time']) $data['begin_time'] = strtotime($data['begin_time']);
        if($data['end_time']) $data['end_time'] = strtotime($data['end_time'])+86400;//结束时间，包括当天。

        return $data;
    }
    
    public function get_users(){
        $uid = (int)I('get.uid');
        $otype = I('get.otype','');
        $res['data'] = get_my_users($uid,$otype);
        $res['msg']= '测试成功';
        $this->ajaxReturn($res);
    }

    /**
     * 更新代金券数量
     */
    public function update_count(){
        $id = (int)trim(I('param.id',0));
        if($id < 1){
            if(IS_AJAX){
                $this->ajaxReturn(array('msg'=>'不存在该代金券','status'=>0));
            }
        }
        $coupon_userObj = M('coupon_user');
        $count = $coupon_userObj->where(array('cid'=>$id,'status'=>1))->count();
        $res = M('coupon')->where(array('id'=>$id))->save(array('total'=>$count));
        if(IS_AJAX){
            $this->ajaxReturn(array('msg'=>'更新成功','status'=>1,'data'=>$count));
        }
    }
}