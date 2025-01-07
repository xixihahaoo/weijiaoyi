<?php

namespace Admin\Controller;
use Think\Controller;
class SuperController extends CommonController {
	
	//管理员列表
    public function slist()
    {

		
		$users = D('userinfo');
		//分页
		$count = $users->where('otype=3')->count();
        $pagecount = 20;
        $page = new \Think\Page($count , $pagecount);
//        $page->parameter = $row; //此处的row是数组，为了传递查询条件
        $page->setConfig('first','首页');
        $page->setConfig('prev','&#8249;');
        $page->setConfig('next','&#8250;');
        $page->setConfig('last','尾页');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
        $show = $page->show();
		//查询用户和账户信息
		$ulist = $users
		->join('wp_role ON wp_role.id = wp_userinfo.q')
		->where('otype=3')
		->order(	'uid desc')
		->limit($page->firstRow.','.$page->listRows)
		->select();

		$this->assign('page',$show);
		$this->assign('ulist',$ulist);
		$this->display();
		
	}
	//添加管理员
	public function sadd()
	{

		//实例化userinfo表
		$users = D('userinfo');
		if (IS_POST) {
			$pwd = trim(I('post.upwd'));
			$qrpwd = trim(I('post.upwdqr'));
			if(empty($pwd)){
				$this->error('密码不能为空');
			}
			$data['utime'] = time();
			$data['username'] = trim(I('post.username'));
			$data['username'] = I('post.username');
			$flag = preg_match('/[\x{4e00}-\x{9fa5}]+/u',$data['username']);
			if($flag){
				$this->error('登录名不能用汉字，请使用英文和数字');
			}
			if (trim(I('post.upwd'))!=trim(I('post.upwdqr'))){
				$this->error('密码不一致');
			}
			$data['upwd'] = md5(trim(I('post.upwd')));
			$data['utel'] = I('post.utel');
			$data['otype'] = 3; //网站管理员
			$data['q'] = I('post.q'); //网站权限
			$result = $users->add($data);
			if ($result) {
				$this->success('添加管理员成功', U('Super/slist'));
			} else {
				$this->error('添加失败');
			}

		}else{
			$groupModle=M('role');
        	$res=$groupModle->where(array('status'=>1))->select();
			$this->assign('list',$res);
			$this->display();
		}
	}
	//基本设置
	public function esystem(){

		$config = D('webconfig');
		$isopen = I('post.isopen');
		$webname = I('post.webname');
		$warn = I('post.warn');
		$notice = I('post.notice');
		$blowratio = I('post.blowratio');
		$is_experience = I('post.is_experience');
		$is_type = I('post.is_type');
		$smsname = I('post.smsname');
		$protocol = I('post.protocol');
		$smspwd = I('post.smspwd');
		$integral = I('post.integral');
		$max = I('post.max');
		$limit = I('post.limit');
		$mores = I('post.mores');
		$where = "id=1";
		$dir = "Public/home/sms/sms.txt";
		if($isopen!=""){
			if($isopen==0){
				$config->where($where)->setField('isopen','1');
				
				$this->ajaxReturn("开启成功");		
			}else{
				$config->where($where)->setField('isopen','0');
				$this->ajaxReturn("关闭成功");
			}		
		}elseif($limit!=""){
			$result = $config->where($where)->setField('limit',$limit);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($max!=""){
			$result = $config->where($where)->setField('max',$max);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($warn!=""){
			$result = $config->where($where)->setField('warn',$warn);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($webname!=""){
			$result = $config->where($where)->setField('webname',$webname);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($mores!=""){
			$arr = explode(',',$mores);
			foreach($arr as $key=>$val){
				$uid = M("userinfo")->where("username='$val'")->getField('uid');
				addintegral($uid,2);
			}
			$this->ajaxReturn("赠送成功");
		}elseif($integral!=""){
			$result = $config->where($where)->setField('integral',$integral);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($smsname!="" && $smspwd !=""){
			$str = $smsname.",".$smspwd;
			$result = file_put_contents($dir,$str);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($blowratio!=""){
			$result = $config->where($where)->setField('blowratio',$blowratio);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($protocol!=""){
			$result = $config->where($where)->setField('protocol',$protocol);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($is_type!=""){//echo $is_type;die;
			$result = $config->where($where)->setField('is_type',$is_type);
	 
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($is_experience!=""){
			$result = $config->where($where)->setField('is_experience',$is_experience);
	 
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}elseif($notice!=""){
			$result = $config->where($where)->setField('notice',$notice);
			if($result){
				$this->ajaxReturn("修改成功");
			}else{
				$this->ajaxReturn("修改失败");
			}
		}else{
			$str = explode(",",file_get_contents($dir));
			$sms['smsname'] = $str[0];
			$sms['smspwd'] = $str[1];
			$conf = $config->where($where)->find();		
			$this->assign('conf',$conf);
			$this->assign('sms',$sms);
			
		}
		$this->display();
	}
	//修改管理员
	public function sedit()
    {

		
		$users = D('userinfo');
		if(IS_POST){
			if($users->create()){
				$uid = I('post.uid'); 
				$data['otype'] = I('post.otype'); 
				$data['ustatus'] = I('post.ustatus');
				$data['oid'] = I('post.oid');
				$data['utime'] = I('post.utime');
				$data['username'] = I('post.username');
				$data['upwd'] = md5(I('post.upwd'));
				$data['utel'] = I('post.utel');
				$data['q'] = I('post.q');
				$result = $users->where('uid='.$uid)->save($data);
				/*$group_access = M('auth_group_access')->where(array('uid'=>$uid))->find();
				if($group_access['uid']>0){
					$group['group_id'] = I('post.q');
					M('auth_group_access')->where(array('uid'=>$uid))->save($group);
				}else{
					$map['uid'] = $uid;
					$map['group_id'] = I('post.q');
					M('auth_group_access')->add($map);
				}*/
				if($result === FALSE){
					$this->error("管理员修改失败！");
				}else{
					$info = '修改【'.I('post.utel').'管理员】';
					user_log($info,2);
					$this->success("管理员修改成功",U('Super/slist'));
				}
			}else{
				$this->error($users->getError());
			}
		}else{
			//根据修改管理员的id读取数据
			$uid = I('get.uid');
			$ult = $users->where('uid='.$uid)->find();			
			$this->assign('ult',$ult);
			//权限
			$groupModle=M('role');
        	$res=$groupModle->where(array('status'=>1))->select();
			$this->assign('list',$res);

			$this->display();
		}
	}
	//删除管理员
	public function sdel()
    {
    	$user = D('userinfo');
		//单个删除
		$uid = I('get.uid');
		$sup_admin = array(818);//超级管理员（禁止删除）的uid
		if(in_array($uid,$sup_admin)){
			$this->error("禁止删除超级管理员");
		}
		$result = $user->where('uid='.$uid)->delete();
		if($result!==FALSE){
			$info = '删除【id'.$uid.'管理员】';
			user_log($info,2);
			$this->success("成功删除管理员！",U("Super/slist"));
		}else{
			$this->error('删除失败！');
		}
	}
	//备份数据
	public function backupdb()
	{
		
		
		$users=D('userinfo');//获取用户信息
		$username=$users->field('username')->find();
		
		
		
		
		mysql_query("set names 'utf8'");
		$mysql = "set charset utf8;\r\n";
		$q1 = mysql_query("show tables");
		while ($t = mysql_fetch_array($q1))
		{
		$table = $t[0];
		$q2 = mysql_query("show create table `$table`");
		$sql = mysql_fetch_array($q2);
		$mysql .= $sql['Create Table'] . ";\r\n";
		$q3 = mysql_query("select * from `$table`");
		while ($data = mysql_fetch_assoc($q3))
			{
				$keys = array_keys($data);
				$keys = array_map('addslashes', $keys);
				$keys = join('`,`', $keys);
				$keys = "`" . $keys . "`";
				$vals = array_values($data);
				$vals = array_map('addslashes', $vals);
				$vals = join("','", $vals);
				$vals = "'" . $vals . "'";
				$mysql .= "insert into `$table`($keys) values($vals);\r\n";
			} 
		} 
 
		$filename = APP_PATH.'backup/'.date('Y-m-d_H-i-s').".sql"; //存放路径，默认存放到项目最外层
		echo $filename;
		$fp = fopen($filename, 'w');
		fputs($fp, $mysql);
		fclose($fp);
		$this->success('数据备份成功','/Admin/Index/index');
		$info = '【数据备份成功】';
		user_log($info,2);
	}
	
	
	
	
}