<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class GiftController extends Controller {
    public function gadd()
	{
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		if(IS_POST){
			$geft = D('gift');
			header("Content-type: text/html; charset=utf-8");
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './giftimg'; // 设置附件上传根目录
            $info   =   $upload->upload();
            if($info==""){
				$idcover = I('post.input-file');
			}else{
	            if(!$info) {// 上传错误提示错误信息    
	                $this->error($upload->getError());
	            }else{
	            	// 上传成功 获取上传文件信息   
	              	foreach($info as $file){      
	                	$idcover= $file['savepath'].$file['savename'];
	           		}
				}
			}
			if($geft->create()){
				$geft->addtime = time();
				$geft->pimg = $idcover;
				
				$result = $geft->add();
				if($result){
					$this->success("添加成功",U('Gift/glist'));
				}else{
					$this->error("添加失败");
				}
			}else{
				$this->error($geft->getError());				
			}
		}else{
			$this->display();
		}
	}
	public function glist(){
		//判断用户是否登陆
		$user= A('Admin/User');
		$user->checklogin();
		
		$tq=C('DB_PREFIX');
		$gift = D('gift');

		$count = $gift->count();
		$pagecount = 20;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $row; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','&#8249;');
		$page->setConfig('next','&#8250;');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		
		$show = $page->show();
		$giftlist = $gift->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		$this->assign('giftlist',$giftlist);
		$this->assign('page',$show);
		$this->display();
	}
	public function gdel(){
		$pinfo = D('gift');
		//单个删除
		$pid = I('get.id');
		//单条记录删除
		$result = $pinfo->where('id='.$pid)->delete();
		if($result!==FALSE){
			$this->success("成功删除！",U("Gift/glist"));
		}else{
			$this->error('删除失败！');
		}
	}
	public function gtlist(){
		$user = M("userinfo");
		$integral = M("integral");
		$huilist = $user->where("otype = 2")->select();
		$this->assign("huilist",$huilist);
		$jlist = $user->where("otype = 1")->select();
		$this->assign("jlist",$jlist);
		$where = "";
		//获取用户名，生产模糊条件
		$username = $_GET['username'];
		//获取订单时间
		$starttime = $_GET["starttime"];
		$endtime = $_GET["endtime"];
		
		$oid = $_GET['oid'];
		if($oid)
		{
			$oids = getDownuids($oid);
			$where['wp_userinfo.uid'] = array("in",implode(',',$oids));
			$sea['oid'] = $oid;
		}
		$jid = $_GET['jid'];
		if($jid)
		{
			$jids = M("userinfo")->field("uid")->where("oid=".$jid)->select();
			foreach($jids as $val){
				$jids[] = $val['uid'];
			}
			$where['wp_userinfo.uid'] = array("in",implode(',',$jids));
			$sea['jid'] = $jid;
		}
		if($username){
			$where['wp_userinfo.username'] = array('like','%'.$_GET["username"].'%');
			$sea['username'] = $_GET["username"];
		}
		if($_GET["starttime"] && $_GET["endtime"]){
			$starttime = $starttime.' 00:00:00';
			$endtime = $endtime.' 23:59:59';
			$where['wp_integral.addtime'] = array('between',array($starttime,$endtime));
			$sea['starttime'] = $_GET["starttime"];
			$sea['endtime'] = $_GET["endtime"];
		}
		$where['remark']=array("eq",'兑换');
		$this->assign("sea",$sea);
		$fields = "wp_userinfo.username as username,wp_userinfo.uid as uid,wp_integral.addtime as addtime,wp_integral.number as number,wp_gift.title as title,wp_gift.intmoney as intmoney,wp_integral.id as id,wp_userinfo.integrals as integrals,wp_userinfo.address as address";
		$count = $integral->field($fields)->join("wp_gift ON wp_gift.id = wp_integral.giftid")->join("wp_userinfo ON wp_userinfo.uid = wp_integral.uid")->where($where)->count();				
		$pagecount = 10;
		$page = new \Think\Page($count , $pagecount);
		$page->parameter = $sea; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		$start = $page->firstRow;
		$end = $page->listRows;
		$tlist = $integral->field($fields)->join("wp_gift ON wp_gift.id = wp_integral.giftid")->join("wp_userinfo ON wp_userinfo.uid = wp_integral.uid")->limit($start,$end)->where($where)->select();
		// echo $integral->getLastsql();
		foreach($tlist as $key=>$val)
		{
			$ooid = $user->where("uid=".$val['uid'])->getField('oid');
			$tlist[$key]['oid']=$user->where("uid=".$ooid)->getField('username');
			$tlist[$key]['iddd']=$val['oid'];
		}
		$show = $page->show();
		$this->assign('tlist',$tlist);
		$this->assign('show',$show);
		$this->display();
	}
}