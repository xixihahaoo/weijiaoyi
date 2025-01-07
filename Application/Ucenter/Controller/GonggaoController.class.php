<?php
// 本类由系统自动生成，仅供测试用途
namespace Ucenter\Controller;
use Ucenter\Controller\CommonController;
class GonggaoController extends CommonController{
    //银行卡
    public function index(){
        $fid       = M('newsclass')->where(array('type' => 0))->getField('fid');
        $newsclass = M('newsinfo')->where(array('ncategory'=>$fid))->select();
        $this->assign('list',$newsclass);
        $this->display();
    }
    public function newslist(){
        $id   = I('get.id');
        $list = M('newsinfo')->where(array('nid' => $id))->find();
        $this->assign('list',$list);
        $this->display();
    }
}