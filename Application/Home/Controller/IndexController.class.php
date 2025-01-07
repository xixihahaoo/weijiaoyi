<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\Gateway;

//交易首页
class IndexController extends CommonController {

    public function binding()
    {
        Gateway::$registerAddress = '127.0.0.1:1238';
        
        $uid    = trim(I('post.client_id'));

        $group  = explode(',',trim(I('post.group')));

        foreach ($group as $key => $value) {

            Gateway::joinGroup($uid,$value);
        }
        
        var_export(Gateway::getAllClientCount());   //获取当前在线连接总数（多少client_id在线）。
    }


    public function send_message()
    {
      Gateway::$registerAddress = '127.0.0.1:1238';

      $message  = 'hello';

      Gateway::sendToAll($message);

      var_export(Gateway::getAllClientSessions());
    }


    /**
     * 产品列表
     * @author wang <990529346@qq.com>
    **/
    
	public function  index()
	{

		// $Moption = M("data_now");
		
  //       $class = M('OptionClassify')->cache(true)->order('id asc')->select();

  //       foreach ($class as $key => $value) {
   
	 //        $map['pid'] 	= array('in',$value['id']);

	 //        $result = $Moption->field('id,code,last,open,lastClose,high,low,flag,name')->where($map)->select();

  //           foreach ($result as $key => $v) {
                
  //               if(shijianAll($v['id']) == 0)
  //               {
  //                   $result[$key]['flag'] = 0;
  //               }
  //           }
	       
  //        	foreach ($result as $k => &$val) {
	                 
  //            	$dd[$value['name']][$k] = $val;
  //        	}
  //       }

  //        $this->assign('result',$dd);
		//      $this->display();
        

        $Moption    = M("data_now");
        
        $class      = M('OptionClassify')->cache(true)->order('id asc')->select();

        $parArr     = array();

        foreach ($class as $key => $value) {
            array_push($parArr,$value['id']);
        }

        $pid = implode(',', array_unique($parArr));

        $option = $Moption->field('id,code,last,open,lastClose,high,low,flag,name,pid,length')->where('pid in('.$pid.')')->select();

        foreach ($option as $key => $v) {
                
            if(shijianAll($v['id']) == 0)
            {
                $option[$key]['flag'] = 0;
            }
        }

        $this->assign('class',$class);
        $this->assign('option',$option);
        $this->display();

	}



    /**
     * 产品详情
     * @author wang <990529346@qq.com>
     */
    public function product(){


        $id   		= trim(I('get.id'));

        $option  	= M('data_now')->where(array('id'=>$id))->find();

        if(!$option)
        {
        	$this->redirect('index');
        }
        
        $product 	    = M('productinfo')->where(array('cid' => $option['id']))->select();

        $productData    = array(); 
        foreach ($product as $key => $value) {

            if(shijian($value['pid']) != 0)
            {
                $productData[$key]['feeprice']  = $value['feeprice'];
                $productData[$key]['time']      = $value['minute'] * 60;
                $productData[$key]['odds']      = $value['odds'] * 100;
            }
        }

        if($this->user_id)
        {
        	$balance = M('accountinfo')->where(array('uid' => $this->user_id))->getField('balance');
        	$this->assign('balance',$balance);
        }

        if(!$productData)
        {
            $option['flag'] = 0;
        }

        $this->assign('productData',$productData);
        $this->assign('option',$option);
        $this->display();
    }


    /**
     * 生成图标
     * @author wang <990529346@qq.com>
     */
    public function highcharts()
    {
        $code     = trim(I('get.code'));
        $interval = trim(I('get.interval'));
        $type 	  = trim(I('get.type')); 
        $height   = trim(I('get.height'));
        $length   = trim(I('get.length'));  //产品代码长度

        $display = $type == 'area' ? 'highcharts' : 'highstockTest';

        $this->assign('code',$code);
     	  $this->assign('interval',$interval);
        $this->assign('height',$height);
        $this->assign('length',$length);
        $this->display($display);
    }
}
