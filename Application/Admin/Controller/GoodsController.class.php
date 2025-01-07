<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController {
    public function gadd()
	{

		
		//实例化数据表
		$goods = D('productinfo');
		$goodtype = D('catproduct');
		//获取所有商品分类			
		$catgood = $goodtype->select();
		$this->assign('catgood',$catgood);
		//判断如果是post提交，则添加数据，否则显示视图
		if(IS_POST){
			if($goods->create()){
				$result = $goods->add();
				if($result){
					$info = '添加商品';
					$type = 2;
					user_log($info,$type);
//					echo "<script> alert('添加商品成功');window.location.href='{:U('Goods/glist')}';</script>";
					$this->success('添加商品成功',U('Goods/glist'));
				}else{
					$this->error('添加商品失败');
				}
			}else{
				$this->error($goods->getError());
			}
		}else{
			$this->display();
		}
	}


	public function glist(){
		//判断用户是否登陆
		// $user   = A('Admin/User');
		// $user->checklogin();
		
		$tq 	= C('DB_PREFIX');
		$goods 	= D('productinfo p');
		$step 	= I('get.step');

		$count 		= $goods->count();

        $pagecount 	= 15;

        $page 		= new \Think\Page($count , $pagecount);

        $page->setConfig('first','首页');

        $page->setConfig('prev','&#8249;');

        $page->setConfig('next','&#8250;');

        $page->setConfig('last','尾页');

        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% ');
		
        $show = $page->show();

		$goodlist = $goods->
			field('p.*,d.flag')->
			join('LEFT JOIN __DATA_NOW__ d ON p.cid=d.id')->
		order('p.cid desc')->
		limit($page->firstRow.','.$page->listRows)->
		select();

		$optionIdArr = array();
		foreach ($goodlist as $key => $value) {
			array_push($optionIdArr,$value['pid']);
		}

		$optionIdStr = implode(',',$optionIdArr);

    	$dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->where('option_id in ('.$optionIdStr.')')->select();

        $dealTimeRs1    = array();
        foreach($dealTimeRs as $k => $v)
        {
            $start_time = substr($v['deal_time_start'], 0, 2).':'.substr($v['deal_time_start'], -2, 2);
            $end_time   = substr($v['deal_time_end'], 0, 2).':'.substr($v['deal_time_end'], -2, 2);

            $dealTimeRs1[$v['option_id']]['deal_time']  .= $start_time.'-'.$end_time.'<br>';
        }



        $this->assign('dealTimeRs1', $dealTimeRs1);
		$this->assign('goodlist',$goodlist);
		$this->assign('page',$show);
		$this->display();
	}

	/**
	 * 更改休市上市状态，ajax
	 * $pid  id号
	 * $flag 状态类型，1开市，0休市
	 * author:somanywf
	 */
	public function setflag(){
		if(IS_AJAX){
			$pid = I('get.pid',0);
			$flag = I('get.flag',0);
			if($pid<0 || !in_array($flag,array(0,1))){
				$this->ajaxReturn(array('msg'=>'参数错误',code=>0));
			}
			$data_now = M('data_now');
			$res=$data_now->where(array('id'=>$pid))->save(array('flag'=>$flag));
			if($res){
				if($flag == 1){
					$info = '修改为【开市】状态';
				}else{
					$info = '修改为【休市】状态';
				}
				$type = 2;
				user_log($info,$type);
				$this->ajaxReturn(array('msg'=>'修改成功','code'=>1));
			}
			$this->ajaxReturn(array('msg'=>'修改失败','code'=>0));
		}
		$this->error('访问的页面不存在');
	}


    /**
     * @functionname: good_time_edit
     * @author: wang
     * @description: 设置每个商品的一天中的交易时间
     * @note:
     */
    public function good_time_edit()
    {
        $dealTimeObj    = M('option_deal_time');

        $optionId       = trim(I('get.option_id'));
        $goodTimeRs     = $dealTimeObj->where('option_id='.$optionId)->select();

        foreach($goodTimeRs as $k => $v)
        {
            $goodTimeRs[$k]['deal_time_start1'] = substr($v['deal_time_start'], 0, 2) . ':' . substr($v['deal_time_start'], -2, 2);
            $goodTimeRs[$k]['deal_time_end1']   = substr($v['deal_time_end'], 0, 2) . ':' . substr($v['deal_time_end'], -2, 2);

        }

        $this->assign('option_id', $optionId);
        $this->assign('goodTimeRs', $goodTimeRs);
        $this->display();
    }



    /**
     * @functionname: good_time_edit_opt
     * @author: FrankHong
     * @date: 2016-11-15 17:44:34
     * @description: 商品交易时间处理
     * @note: 先删除数据，重新增加数据
     */
    public function good_time_edit_opt()
    {
        $timeCode   = I('post.time_code');
        $optionId   = I('post.option_id', 0);
        $dealType   = I('post.deal_type', 1);


        if(!$optionId)
            outjson(array('status' => 0, 'ret_msg' => '参数错误'));

        $timeStart  = $timeCode['time_start'];
        $timeEnd    = $timeCode['time_end'];
        $timeType   = $dealType['time_type'];
        $dataAdd    = array();

        if(empty($timeStart) || empty($timeEnd))
            outjson(array('status' => 0, 'ret_msg' => '时间不能为空'));


        $dealTimeObj    = M('option_deal_time');
        $dealTimeRs     = $dealTimeObj->where('option_id='.$optionId)->select();
        $dealTimeCount  = count($dealTimeRs);

        $dealTimeObj->where('option_id='.$optionId)->limit($dealTimeCount)->delete();

        $count      = count($timeStart);
        $k          = 1;
        for($i = 0; $i < $count; $i++)
        {
            if(!empty($timeStart[$i]))
            {
                $dataAdd[$i]['deal_time_start'] = str_replace(':', '', $timeStart[$i]);
                $dataAdd[$i]['deal_time_end']   = str_replace(':', '', $timeEnd[$i]);
                $dataAdd[$i]['time_order']      = $k;
                $dataAdd[$i]['deal_time_type']  = $timeType[$i];
                $dataAdd[$i]['option_id']       = $optionId;

                $k++;
            }
        }


        $flag           = $dealTimeObj->addAll($dataAdd);
        if($flag)
            outjson(array('status' => 1, 'ret_msg' => '保存成功'));
        
    }









	public function gtype()
	{

		
		$goodtype = D('catproduct');
		$typelist = $goodtype->select();
		
		$this->assign('typelist',$typelist);
		$this->display();
	}
	
	public function gtypeadd()
	{

		if(IS_POST){
			//实例化数据表
			$goodtype = D('catproduct');
			//自动验证表单
			if($goodtype->create()){
				//添加数据
				$result = $goodtype->add();
				if($result){
					$this->success('添加成功',U('Goods/typelist'));
				}else{
					$this->error('添加失败');
				}
			}else{
				//自动验证返回结果
				$this->error($goodtype->getError());
			}
		}else{
			$this->display();	
		}		
	}
	public function gedit()
	{

		$tq=C('DB_PREFIX');
		$pinfo = D('productinfo');
		//$catp = D('catproduct');
		//判断执行，如果是post提交，执行修改方法，否则显示页面
		if(IS_POST){
			//自动验证表单
			if($pinfo->create()){
				//获取修改表单的数据，并做处理
				$postpid = I('post.pid');
				$data['ptitle'] = I('post.ptitle');
				// $data['company'] = I('post.company');
				// $data['uprice'] = I('post.uprice');
				$data['feeprice'] = I('post.feeprice');
				// $data['wave'] = I('post.wave');
				// $data['gefee'] = I('post.gefee');
		    	$data['odds'] = I('post.odds');
				$data['minute'] = I('post.minute');
				$data['point'] = I('post.point');
				$data['maxhands'] = I('post.maxhands');
				$data['maxcounts'] = I('post.maxcounts');
				$data['mstart_time'] = I('post.mstart_time');
				$data['mend_time'] = I('post.mend_time');
				$data['astart_time'] = I('post.astart_time');
				$data['aend_time'] = I('post.aend_time');
				$result = $pinfo->where('pid='.$postpid)->save($data);
				if($result === FALSE){
					$this->error("修改失败！");
				}else{
					$info = '修改商品【'.I('ptitle').'】信息';
					$type = 2;
					user_log($info,$type);
					$this->success("修改成功",U('Goods/glist'));
				}
			}else{
				//自动验证返回结果
				$this->error($pinfo->getError());
			}
		}else{
			//通过获取的id查找该条数据
			$getpid = I('get.pid');
			$editgood = $pinfo->where('pid='.$getpid)->find();
			//商品分类获取
			//$pclist = $catp->select();
			//获取油，白银，铜的实时价格
			//$this->assign('pclist',$pclist);
			// echo "<pre>";
			// var_dump($editgood);die;
			$this->assign('editgood',$editgood);
			$this->display();
		}
	}
	public function gdel(){
		$pinfo = D('productinfo');
		//批量删除id
		$arrpid = I('post.pid');
		//单个删除
		$pid = I('get.pid');
		
		if(IS_POST){
			//批量删除
			$result = $pinfo->where('pid in('.implode(',',$arrpid).')')->delete();
			if($result!==FALSE){
				$this->success("成功删除{$result}条！",U("Goods/glist"));
			}else{
				$this->error('删除失败！');
			}
		}else{
			//单条记录删除
			$result = $pinfo->where('pid='.$pid)->delete();
			if($result!==FALSE){
				$this->success("成功删除！",U("Goods/glist"));
			}else{
				$this->error('删除失败！');
			}
		}
	}


	public function number(){
 
 		$you_z=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=0 and o.ostaus=0 and o.is_hide=0 and p.cid=1 group by p.cid ");
		$you_d=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=1  and o.ostaus=0 and o.is_hide=0 and p.cid=1 group by p.cid ");
		$yin_z=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=0   and o.ostaus=0 and o.is_hide=0 and p.cid=2 group by p.cid ");
		$yin_d=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=1  and o.ostaus=0  and o.is_hide=0 and p.cid=2 group by p.cid ");
		$tong_z=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=0 and o.ostaus=0 and o.is_hide=0 and p.cid=3 group by p.cid ");
		$tong_d=M()->query("select sum(p.wave*o.onumber) as num from wp_order o join wp_productinfo p on o.pid=p.pid where o.ostyle=1 and o.ostaus=0 and o.is_hide=0 and p.cid=3 group by p.cid ");
		$num=array();
		$you_z1=$you_z[0]['num'];
		$you_d1=$you_d[0]['num'];
		$yin_z1=$yin_z[0]['num'];
		$yin_d1=$yin_d[0]['num'];

		$tong_z1=$tong_z[0]['num'];
		$tong_d1=$tong_d[0]['num'];
		$num['you_z']=empty($you_z1)?0:$you_z1;
		$num['you_d']=empty($you_d1)?0:$you_d1;
		$num['yin_z']=empty($yin_z1)?0:$yin_z1;
		$num['yin_d']=empty($yin_d1)?0:$yin_d1;
		$num['tong_z']=empty($tong_z1)?0:$tong_z1;
		$num['tong_d']=empty($tong_d1)?0:$tong_d1;
		$this->ajaxReturn($num);
	}
	//调取分类的点差
    public function diancha($cname){
        $at= M('catproduct')->where("cname='$cname'")->find();
        return $at;
    }
}