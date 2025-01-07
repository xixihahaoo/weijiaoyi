<?php
/**
 * @author: FrankHong
 * @datetime: 2016/11/8 15:07
 * @filename: ToolsController.class.php
 * @description: 代码样例
 * @note:
 * 1.手机验证码使用样例
 * 
 */

namespace Home\Controller;
use Think\Controller;


use Org\Util\Alidayu;


class ToolsController extends Controller
{

      public function index()
    {


        $returnRs   = $this->get_mobile_code('11111');

        vD($_SESSION);
        vD($returnRs);



    }


    /**
     * @functionname: get_mobile_code
     * @author: FrankHong
     * @date: 2016-11-08 15:09:33
     * @description: 获取手机验证码 起点接口
     * @note:
     * @return array
     * @param string $mobile  手机号
     * @param int $mobile_code_time  手机验证码有效期，默认2*60
     */
    public function get_mobile_code($mobile = '', $mobile_code_time = 2)
    {

        if(empty($mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号不能为空');

        if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号格式错误');

        //一分钟内不能重复获取
        if (time() - session('mobile_code_time') < 60 * 1)
            return array('ret_code' => 0, 'ret_msg' => '您获取验证码太频繁了，请稍后再获取！');

        //判断该手机号码是否还在有效期内, 120s
        if (($mobile == session('mobiles')) && (time() - session('mobile_code_time') < 60 * $mobile_code_time))
            return array('ret_code' => 1, 'ret_msg' => '该号码在1分钟内已经获取过验证码，可继续使用！');

        $res    = sms_qidian_send_code($mobile);

        if ($res['ret_code'] == 1)
        {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

			$mObj   = M();
            $addArr = array(
                'mobile'        => $mobile,
                'mobile_code'   => $res['ret_msg'],
                'type'          => 1
            );
            $mObj->table('log_mobile_code')->add($addArr);

            return array('ret_code' => 1, 'ret_msg' => '短信发送成功');
        }
        else
        {
            return array('ret_code' => 0, 'ret_msg' => $res['ret_msg']);
        }
    }


    /**
     * @functionname: get_mobile_code_qixin
     * @author: FrankHong
     * @date: 2016-11-19 18:01:39
     * @description: 获取手机验证码--启信接口
     * @note:
     * @return array
     * @param string $mobile  手机号
     * @param int $mobile_code_time  手机验证码有效期，默认2*60
     */
    public function get_mobile_code_qixin($mobile = '', $mobile_code_time = 2)
    {

        if(empty($mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号不能为空');

        if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号格式错误');

        //一分钟内不能重复获取
        if (time() - session('mobile_code_time') < 60 * 1)
            return array('ret_code' => 0, 'ret_msg' => '您获取验证码太频繁了，请稍后再获取！');

        //判断该手机号码是否还在有效期内, 120s
        if (($mobile == session('mobiles')) && (time() - session('mobile_code_time') < 60 * $mobile_code_time))
            return array('ret_code' => 1, 'ret_msg' => '该号码在1分钟内已经获取过验证码，可继续使用！');

        $res    = sms_qixin_send_code($mobile);

        if ($res['ret_code'] == 1)
        {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

			$mObj   = M();
            $addArr = array(
                'mobile'        => $mobile,
                'mobile_code'   => $res['ret_msg'],
                'type'          => 2
            );
            $mObj->table('log_mobile_code')->add($addArr);

            return array('ret_code' => 1, 'ret_msg' => '短信发送成功');
        }
        else
        {
            return array('ret_code' => 0, 'ret_msg' => $res['ret_msg']);
        }
    }


    /**
     * @functionname: get_mobile_code_alidayu
     * @author: FrankHong
     * @date: 2016-12-15 12:26:18
     * @description:  获取手机验证码--阿里大于
     * @note:
     * @return array
     * @param string $mobile
     * @param int $mobile_code_time
     */
    public function get_mobile_code_alidayu($mobile = '', $mobile_code_time = 1)
    {

        if(empty($mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号不能为空');

        if (!preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
            return array('ret_code' => 0, 'ret_msg' => '手机号格式错误');

        //一分钟内不能重复获取
        if (time() - session('mobile_code_time') < 60 * 1)
            return array('ret_code' => 0, 'ret_msg' => '您获取验证码太频繁了，请稍后再获取！');

        //判断该手机号码是否还在有效期内, 120s
        if (($mobile == session('mobiles')) && (time() - session('mobile_code_time') < 60 * $mobile_code_time))
            return array('ret_code' => 1, 'ret_msg' => '该号码在'.$mobile_code_time.'分钟内已经获取过验证码，可继续使用！');

        $res    = sms_alidayu_send_code($mobile);

        if ($res['ret_code'] == 1)
        {
            session('mobile_code', $res['ret_msg']);
            session('mobile_code_time', time());
            session('mobiles', $mobile);

			$mObj   = M();
            $addArr = array(
                'mobile'        => $mobile,
                'mobile_code'   => $res['ret_msg'],
                'type'          => 3
            );
            $mObj->table('log_mobile_code')->add($addArr);

            return array('ret_code' => 1, 'ret_msg' => '短信发送成功');
        }
        else
        {
            return array('ret_code' => 0, 'ret_msg' => $res['ret_msg']);
        }
    }


 /**
  * 短信验证码 注册用户
  * @author wang <990529346@qq.com>
  */
    public function smsverify(){

        $mobile = trim(I('post.mobile'));

        $user = M('userinfo')->where('utel='.$mobile.' and otype=0')->find();

        if($user) {
            $code = array();
            $code['ret_code'] = 'error';
            $code['ret_msg']  = '该手机号码已经被注册了';
            $this->ajaxReturn($code);  
        } else {

            $code = $this->get_mobile_code($mobile);
            $this->ajaxReturn($code);
        }
    }


}