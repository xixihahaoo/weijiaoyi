<?php

namespace Admin\Controller;
use Think\Controller;
class SystemController extends CommonController{
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
        $this->display('Super/esystem');
    }

    /**
     * 用户注销
     */
    public function signinout()
    {
        // 清楚所有session
        header("Content-type: text/html; charset=utf-8");
        session(null);
        redirect(U('Admin/User/signin'), 2, '正在退出登录...');
    }
}