<?php

namespace Admin\Controller;
use Think\Controller;
class AuthController extends CommonController {


	//管理员列表
    public function authlist()
    {

		
        $groupModel=M('auth_group');
        $res=$groupModel->select();
        $this->assign('list',$res);
        $this->display();
		
	}
	//添加管理员
	public function do_addauth()
	{
		
        if(!I('title')==''){
            $groupModel=M(auth_group);
            $data['title']=I('title');
            $data['status']='0';
            $title=I('title');
            $res=$groupModel->where(array('title'=>$title))->find();
            if($res==''){
                $res=$groupModel->data($data)->add();
                if($res){
                    $this->success('添加角色成功','',2);
                }else {
                    $this->error('添加失败','',2);
                }
            }else {
                $this->error('角色名已经存在','',2);
            }
            
        }else {
            $this->error('请输入角色名','',2);
        }
	}
	
	public function addauth(){
		$groupModle=M('auth_group');
        $res=$groupModle->where(array('status'=>0))->select();
        $this->assign('list',$res);
        $this->display();
	}

    public function do_addgroup(){
        $groupModle=M(auth_group);
        $arrrules=$_POST['menu'];
        if(!$arrrules==''){
            $title=I('post.title');
            $res=$groupModle->where(array('title'=>$title))->find();
            //dump($res);die();
            if($res['rules']!=''){
                $this->error('权限已经存在','',2);
            }
            
            //遍历数组读取选中的值
            $rules='';
            foreach ( $arrrules as $val){
                $rules=$val.','.$rules;
            }
            $data['title']=$title;
            $data['rules']=$rules.'1,2,48';
            $data['status']='1';
            $res=$groupModle->where(array('title'=>$title))->data($data)->save();
            if($res){
                $this->success('添加成功','',2);
            }else {
                $this->error('添加失败','',2);
            }
        }else{
//
            $this->error('请选权限','',2);
        }
        
        
    }


    //删除角色
    public function adel(){
        $id = I('get.id');
        if($id == 1){
            $this->error('此管理员为系统超级管理员不能删除','',2);
        }else{
            $group = M('auth_group')->where(array('id'=>$id))->delete();
            if($group){
                $this->success('删除成功');
            }
        }
        
    }
	
	
	
	
	
	
	
}