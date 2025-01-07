<?php
use Org\Util\QidianSmsApi;
use Org\Util\QixinSmsApi;
use Org\Util\Alidayu;

/**
 * 生成二维码
 * @param  string $url   url连接
 * @param  integer $size 尺寸 纯数字
 */
function qrcode($url, $size)
{
    Vendor('Phpqrcode.phpqrcode');
    QRcode::png($url, false, QR_ECLEVEL_L, $size, 2, false, 0xFFFFFF, 0x000000);
}

function getIsbuy($mypid)
{
    $time = date("Y-m-d", time());
    $y = date('w', time());
    $ultime = strtotime($time . " 04:00:00");
    $urtime = strtotime($time . " 07:00:00");
    if ($y != 6 && $y != 0) {
        if (($y == 1) && (time() < $ultime)) {
            return 1;
        }
        if (time() > $ultime && time() < $urtime) {
            return 1;
        }
    } else if ($y == 6) {
        if (time() < $ultime) {

        } else {
            return 1;
        }
    } else if ($y == 0) {
        return 1;
    }
}

function get_url()
{
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

function Getfield($t)
{
    return M("webconfig")->where("id =1")->getField($t);
}

function is_mobile()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = Array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "android", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte");
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}

//积分赠送
function addintegral($uid, $type, $num)
{
    $number = M("webconfig")->where("id = 1")->getField("integral");
    if ($type == 1) {
        $remarks = "登陆";
        $d = date("d", time());
        if ($uid) {
            $a = M("userinfo")->where("uid=" . $uid)->find();
            if ($d != $a['days']) {
                $data['uid'] = $uid;
                $data['addtime'] = date("Y-m-d H:i:s", time());
                $data['remark'] = $remarks;
                $data['number'] = $number;
                $data1['days'] = $d;
                $data1['integrals'] = $number + $a['integrals'];
                M("integral")->add($data);
                M("userinfo")->where("uid=" . $uid)->save($data1);

            }
        }
    } else if ($type == 2) {
        $remarks = "手动";
        if ($uid) {
            $a = M("userinfo")->where("uid=" . $uid)->find();
            $data['uid'] = $uid;
            $data['addtime'] = date("Y-m-d H:i:s", time());
            $data['remark'] = $remarks;
            $data['number'] = $number;
            $data1['integrals'] = $number + $a['integrals'];
            M("integral")->add($data);
            M("userinfo")->where("uid=" . $uid)->save($data1);
        }
    } else if ($type == 3) {
        $remarks = "交易";
        if ($uid) {
            $a = M("userinfo")->where("uid=" . $uid)->find();
            $data['uid'] = $uid;
            $data['addtime'] = date("Y-m-d H:i:s", time());
            $data['remark'] = $remarks;
            $data['number'] = $num;
            $data1['integrals'] = $num + $a['integrals'];
            M("integral")->add($data);
            M("userinfo")->where("uid=" . $uid)->save($data1);
        }
    }

}

/**
 * 使用curl获取远程数据
 * @param  string $url url连接
 * @return string      获取到的数据
 */
function curl_get_contents($url)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
    curl_setopt($ch, CURLOPT_HEADER, 1);                //是否显示头部信息
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
    curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);   //用户访问代理 User-Agent
    curl_setopt($ch, CURLOPT_REFERER, _REFERER_);        //设置 referer
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);          //跟踪301
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
    $r = curl_exec($ch);
    curl_close($ch);
    var_dump($r);
    exit;
    return $r;
}

function getJson($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

/****************************
 * /*  手机短信接口（www.ussns.com）
 * /* 参数：$mob        手机号码
 * /*        $content    短信内容
 *****************************/
function sendsms($mob, $content)
{
    $dir = "Public/home/sms/sms.txt";
    $str = explode(",", file_get_contents($dir));
    $username = $str[0];
    $pwd = $str[1];
    $type = 0;// type=0 短信接口
    if ($type == 0) {
        /////////////////////////////////////////短信接口 开始/////////////////////////////////////////////////////////////
        $post_data = array(
            'username' => $username,
            'pwd' => $pwd,
            'msg' => urlencode($content),//短信内容 编码处理
            'phone' => $mob,//发送手机号，多号码用半角逗号","分割
        );
        $smsapi = 'www.ussns.com/Api/send';//API地址
        header("Content-type:text/html;charset=utf-8");
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents('http://' . $smsapi, false, $context);
        if ($result == '888') {
            return true;//echo('恭喜：发送成功！');
        } else {
            return false;//echo('错误：发送失败！');
        }
        /////////////////////////////////////////短信接口 结束/////////////////////////////////////////////////////////////
    } else {
        return false;
    }
}

/**
 * 返佣操作
 *
 * @param $oid
 * @return bool
 */
function backmoneysystem($oid)
{
    $fields = "wp_userinfo.uid as uid,wp_userinfo.username,wp_userinfo.oid as uoid,wp_order.fee as fee";
    $order = M("order")->field($fields)->join("wp_userinfo ON wp_userinfo.uid = wp_order.uid")->where("wp_order.oid=" . $oid)->find();
    $uid = $order['uid'];//用户id
    $username = $order['username'];//用户名
    $fee = $order['fee'] * 0.01;//手续费
    $ouid = $order['uoid'];//用户上级
    //获取用户上级信息
    $oneup = M("userinfo")->where("uid=" . $ouid)->find();
    $oneupotype = $oneup['otype'];
    if ($oneupotype == 1) {//上级是经纪人，上级必有普通会员，上上级必有会员单位
        //给经纪人反金
        addbackmoeny($oid, $ouid, $fee * $oneup['feerebate']);
        //给普通会员反金
        $twoup = M("userinfo")->where("uid=" . $oneup['oid'])->find();//获取普通会员的信息
        addbackmoeny($oid, $twoup['uid'], $fee * $twoup['feerebate']);
        //给会员单位反金
        $threeup = M("userinfo")->where("uid=" . $twoup['oid'])->find();//获取会员单位的信息
        addbackmoeny($oid, $threeup['uid'], $fee * $threeup['feerebate']);
    } else if ($oneupotype == 4) {//上级是普通会员,上级必有会员单位
        //给普通会员反金
        addbackmoeny($oid, $ouid, $fee * $oneup['feerebate']);
        //给会员单位反金
        $twoup = M("userinfo")->where("uid=" . $oneup['oid'])->find();//获取普通会员的信息
        addbackmoeny($oid, $twoup['uid'], $fee * $twoup['feerebate']);
    } else if ($oneupotype == 2) {//上级是会员单位
        //给会员单位反金
        addbackmoeny($oid, $ouid, $fee * $oneup['feerebate']);
    } else if ($oneupotype == 3) {
        return true;
    }
}

/**
 * 返佣操作
 * @param $oid
 * @param $uid
 * @param $money
 */
function addbackmoeny($oid, $uid, $money)
{
    $orderno = 'FJ' . time() . rand(1, 1000);
    $field = "wp_order.onumber,wp_productinfo.ptitle,wp_order.ostyle,wp_productinfo.uprice,wp_order.buyprice,wp_order.sellprice";
    $user = M("userinfo")->join("wp_accountinfo ON wp_accountinfo.uid = wp_userinfo.uid")->where("wp_userinfo.uid=" . $uid)->find();
    $order = M("order")->field($field)->join("wp_productinfo on wp_productinfo.pid = wp_order.pid")->where("wp_order.oid=" . $oid)->find();
    $jour['jno'] = $orderno;
    $jour['uid'] = $uid;
    $jour['jtype'] = '手续费反金';
    $jour['jtime'] = date(time());
    $jour['number'] = $order['onumber'];
    $jour['remarks'] = $order['ptitle'];
    $jour['balance'] = $user['balance'];
    $jour['jusername'] = $user['username'];
    $jour['jostyle'] = $order['ostyle'];
    $jour['juprice'] = $order['uprice'];
    $jour['jfee'] = 0;
    $jour['jincome'] = $order['onumber'] * $order['uprice'];
    $jour['jbuyprice'] = $order['buyprice'];
    $jour['jsellprice'] = $order['sellprice'];
    $jour['jaccess'] = $money;
    $jour['jploss'] = 0;
    $jour['oid'] = $oid;
    if ($ploss > 0) {
        $jour['jstate'] = 1;
    } else {
        $jour['jstate'] = 0;
    }
    $jour['gefee'] = 0;
    $jour['explain'] = '反金';
    M("journal")->add($jour);
    $dd['balance'] = $user['balance'] + $money;
    M("accountinfo")->where("uid=" . $uid)->save($dd);
}


//会员单位对赌模式
function updata_init($uid, $ploss,$tradeid)
{
    $accountinfo = M('accountinfo');
    $unit_id     = get_unit_id($uid);

    $info = $accountinfo->where(array('uid' => $unit_id))->find();
    $user = M('userinfo')->where(array('uid' => $unit_id))->getField('username');
    if($info)
    {
        if ($ploss > 0) {

            $is_ture = $accountinfo->where(array('uid' => $unit_id))->setDec("balance", $ploss);
            $type    = 1;

            //会员单位流水记录
            $order = M('order')->where(array('oid' => $tradeid))->find();
            money_flow($unit_id,2,2,$ploss,'用户对'.$order['ptitle'].'进行平仓['.$user.']扣除['.$ploss.']元',$order['oid']);

        }
        if ($ploss < 0) {

            $ploss = abs($ploss);
            $is_ture = $accountinfo->where(array('uid' => $unit_id))->setInc("balance", $ploss);
            $type    = 1;

            //会员单位流水记录
            $order = M('order')->where(array('oid' => $tradeid))->find();
            money_flow($unit_id,2,2,$ploss,'用户对'.$order['ptitle'].'进行平仓['.$user.']增加['.$ploss.']元',$order['oid']);
        }

        if($is_ture)
        {
             return $type;
        }
    }

}


/**
 * 设置特别会员对赌
 * @return [type] [wang 990529346@qq.com]
 */
function special($uid, $ploss,$tradeid)
{
    $userObj    = M('userinfo');
    $accountObj = M('accountinfo');
    $orderObj   = M('order');
    $journalObj = M('journal'); 
    $specialLog = M('SpecialLog');

    $unit_id      = $userObj->where(array('uid' => $uid))->getField('unit_id');
    $ptitle       = $orderObj->where(array('oid' => $tradeid))->getField('ptitle');
    $unit_account = $accountObj->field('uid,balance,frozen')->where(array('uid' => $unit_id))->find();
    $user         = $userObj->field('uid,username,th_status')->where(array('uid' => $unit_id))->find();


    $warn         = M('webconfig')->getField('warn');   //风控报警阈值

    if($unit_account['balance'] <= $warn)
    {
        if($user['th_status'] == 1)
        {
            $userObj->where(array('uid' => $user['uid']))->setField('th_status',2);
            $datas = array('unit_id' => $user['uid'],'note' =>'会员单位资金不足更改为特会对赌模式','create_time' => time());
            $specialLog->add($datas);
        }

        $th_info = $userObj->field('uid,username')->where('uid = (select th_uid from wp_userinfo where uid = '.$unit_account['uid'].')')->find();
        $th_uid  = $th_info['uid'];
        $data['th_uid'] = $th_uid;

        $orderResult    = $orderObj->where(array('oid' => $tradeid))->save($data);
        $journalResult  = $journalObj->where(array('oid' => $tradeid))->save($data);
        if($orderResult && $journalResult)
        {
            if($ploss > 0)
            {
                $is_ture  = $accountObj->where(array('uid' => $th_uid))->setDec("balance", $ploss);
                money_flow($th_uid,2,6,$ploss,'用户对'.$ptitle.'进行平仓特别会员['.$th_info['username'].']扣除['.$ploss.']元',$tradeid);
            }

            if ($ploss <= 0) {

                $ploss    = abs($ploss);
                $is_ture  = $accountObj->where(array('uid' => $th_uid))->setInc("balance", $ploss);
                money_flow($th_uid,2,6,$ploss,'用户对'.$ptitle.'进行平仓特别会员['.$th_info['username'].']增加['.$ploss.']元',$tradeid);
            }
        }
        $type = $th_uid;
        return $type;

    } else {

            if($user['th_status'] == 2)
            {
                $userObj->where(array('uid' => $user['uid']))->setField('th_status',1);
                $datas = array('unit_id' => $user['uid'],'note' =>'会员单位资金充足更改为对赌模式','create_time' => time());
                $specialLog->add($datas);
            }

            if ($ploss > 0) {

                $is_ture = $accountObj->where(array('uid' => $unit_id))->setDec("balance", $ploss);
                money_flow($unit_id,2,2,$ploss,'用户对'.$ptitle.'进行平仓会员单位['.$user['username'].']扣除['.$ploss.']元',$tradeid);
            }

            if ($ploss <= 0) {

                $ploss   = abs($ploss);
                $is_ture = $accountObj->where(array('uid' => $unit_id))->setInc("balance", $ploss);
                money_flow($unit_id,2,2,$ploss,'用户对'.$ptitle.'进行平仓会员单位['.$user['username'].']增加['.$ploss.']元',$tradeid);
            }
        $type = 'true';
        return $type;
    }
}



/*获取会员单位*/
function get_unit_id($uid)
{
    $info = M("userinfo")->field("otype,oid,uid")->where(array('uid' => $uid))->find();

    if(isset($info))
    {
        if ($info['otype'] == 2) {
            return $info['uid'];
        }
        else
        {
            return get_unit_id($info['oid']);
        }
    }
    else
    {
        return null;
    }
}



function leaguer_id($uid)
{

    $info = M("userinfo")->field("otype,oid,uid")->where("uid='$uid'")->find();


    if(isset($info))
    {
        if ($info['otype'] == 4) {

            return $info['uid'];
        } else {
            return leaguer_id($info['oid']);
        }
    }
    else

    {
        return null;
    }



}
//运营中心
function operate_id($uid)
{

    $info = M("userinfo")->field("otype,oid,uid")->where("uid='$uid'")->find();



    if(isset($info)) {

        if ($info['otype'] == 5) {

            return $info['uid'];
        } else {
            return operate_id($info['oid']);
        }
    }
    else

    {
        return null;
    }

}

function agent_id($uid)
{
    $info = M("userinfo")->field("otype,oid,uid,agenttype")->where("uid='$uid'")->find();

    if(isset($info)) {


        if ($info['otype'] == 1) {

            return $info['uid'];
        } else {
            return agent_id($info['oid']);
        }
    }
    else

    {
        return null;
    }
}

function level_number($uid, $level)
{
    if ($level == 1) {
        $number = M("userinfo")->where("oid='$uid'")->count('uid');    //一级总共有多少人。
        return $number;
    }
    if ($level == 2) {
        $info = M("userinfo")->field("uid")->where("oid='$uid'")->select();
        $number=0;
        foreach ($info as $key => $value) {
            foreach ($value as $key2 => $vo) {
                $number += M("userinfo")->where("oid=" . $vo)->count('uid');
            }
        }
        return $number;
    }
    if ($level == 3) {
        $info = M("userinfo")->field("uid")->where("oid='$uid'")->select();
        foreach ($info as $key => $value) {
            $info2 = M("userinfo")->field("uid")->where("oid=" . $value['uid'])->select();
            foreach ($info2 as $key => $vo) {
                // $array[]=$vo['uid'];
                $info3 = M("userinfo")->field("uid")->where("oid=" . $vo['uid'])->select();
                foreach ($info3 as $key => $v1) {
                    $array[] = $v1;
                }
            }
        }
        $number = count($array);
        return $number;
    }
}

/**
 * 获取指定等级返佣信息
 * @param $uid
 * @param $level
 * @return array
 */
function level_info($uid, $level){
    $agentobj = M('agent a');
    $select = "a.uid,a.add_money,a.ratio,a.order_id,a.username";
    if(in_array($level,array(1,2,3))){
        $where=array('a.oid'=>$uid,'a.level'=>$level);

        $info = $agentobj->
        field($select)->
        join('__ORDER__ o ON o.oid = a.order_id')->
        where($where)->
        order("a.id desc")->
        select();
/*        $sql = $agentobj->getlastsql();
        echo $sql.'<br />';*/
        return $info;
    }
    return array();

}

/**
 * 获取是否盈利中文字符串
 * @param int $id
 * @return mixed|string
 */
function is_win($id=-1){
    $error_msg = '未定义';

    if(in_array($id,array(0,1,2))){
        $arr = array(0=>'亏损', 1=>'盈利', 2=>'平局');
        if(isset($arr[$id])){
            return $arr[$id];
        }
    }

    return $error_msg;
}

/**
 * @functionname: vD
 * @author: FrankHong
 * @date: 2016-11-08 16:03:12
 * @description: 友好的调试输出
 * @note:
 */
function vD($arr)
{
    header('content-type:text/html;charset=utf-8');
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
}



/**
 * 生成用户流水
 *@author wang
 */

function money_flow($uid,$type,$user_type,$money,$msg,$oid)
{
    if($oid)
    {
       $map['oid'] = $oid;
    }

    $map['uid']          = $uid;
    $map['type']         = $type;
    $map['note']         = $msg;
    $map['op_id']        = $uid;
    $map['user_type']    = $user_type;
    $map['change_money'] = $money;
    $map['balance']      = M('accountinfo')->where(array('uid' => $uid))->sum('balance');
    $map['dateline']     = time();
    M("MoneyFlow")->add($map);
}


/**
 * @functionname: outjson
 * @author: FrankHong
 * @date: 2016-11-16 11:44:23
 * @description: 输出json
 * @note: 输出json，常用于前后台json交互时，后台输出json数据
 * @param $data
 * @param bool $flag
 */
function outjson($data, $flag = true)
{
    header('Content-type: application/json');
    echo json_encode($data, $flag);
    die();
}


/**
 * @functionname: write_log
 * @author: FrankHong
 * @date: 2017-03-28 10:57:53
 * @description: 增加脚本运行日志
 * @note:
 * @param int $type
 * @param string $scriptName
 * @param string $note
 */
function write_log($scriptName = '', $note = '', $type = 0)
{
	$logObj = M();
	$logArr = array(
		'type'          => $type,
		'script_name'   => $scriptName,
		'note'          => $note,
		'create_time'	=> time()
	);

	$logObj->table('log_cli')->add($logArr);
	unset($logObj);
}


/**
 * @functionname: write_log_temp
 * @author: FrankHong
 * @date: ${DATE} ${TIME}
 * @description: 用于临时性的记录当前运行的平仓脚本
 * @note:
 * @param string $scriptName
 * @param string $note
 * @param int $type
 */
function write_log_temp($scriptName = '', $note = '', $type = 0)
{
	$logObj = M();
	$logArr = array(
		'type'          => $type,
		'script_name'   => $scriptName,
		'note'          => $note,
		'create_time'	=> time()
	);

	$logId	= $logObj->table('log_cli_temp')->add($logArr);
	unset($logObj);
	return $logId;
}


/**
 * @functionname: get_log_temp
 * @author: FrankHong
 * @date: 2017-03-28 13:24:22
 * @description: 得到临时的订单id
 * @note:
 */
function get_log_temp()
{
	$logObj = M();

	$logIdArr	= $logObj->table('log_cli_temp')->select();

	$oidArr		= array();
	foreach($logIdArr as $k => $v)
	{
		//array_merge($oidArr, unserialize($v['note']));
		//vD(unserialize($v['note']));
		foreach(unserialize($v['note']) as $k1 => $v1)
		{
			$oidArr1[]	= $v1;
		}
	}
//	vD(count($oidArr1));
//	vD(count(array_unique($oidArr1)));

	return $oidArr1;
}



/**
 * @functionname: get_userid
 * @author: wang
 * @date: 2016-11-16 11:44:23
 * @description: 找到所有下级的user_id
 */
function get_userid($uid)
{
    $info    = M("userinfo")->field("otype,oid,uid")->where('oid in('.$uid.')')->select();
    $infoArr = array();

    foreach ($info as $key => $value) {
        array_push($infoArr,$value['uid']);
    }

    $infoId = implode(',',array_unique($infoArr));
    if($info[0]['otype'] != 0)
    {
      return get_userid($infoId);
    }
    return $infoId;

}

/**
 * @functionname: get_superior
 * @author: wang
 * @date: 2016-11-16 11:44:23
 * @description: 找到该用户的上级id
 * @data: $uid 用户的uid $num 几级用户
 */

function get_superior($uid,$num)
{
    $info    = M("userinfo")->field("otype,oid,uid")->where(array('uid' => $uid))->find();

	if($info)
	{
		if($info['otype'] != $num)
		{
		  return get_superior($info['oid'],$num);
		}
		return $info['uid'];
	}
	else
	{
		  return null;
	}

}



function log_weixinshangcheng($balanceNo = '', $note = '', $status = 1)
{
	$logObj = M();
	$logArr = array(
		'balance_no'    => $balanceNo,
		'note'          => $note,
		'create_date'	=> date('Y-m-d H:i:s'),
		'status'		=> $status
	);

	$logId	= $logObj->table('log_weixinshangcheng')->add($logArr);

	unset($logObj);
	return $logId;
}


/**
 * @functionname: curl
 * @author: wang
 * @date: 2016-11-16 11:44:23
 * @description: 请求数据
 */

function curl($url)
{
    $data = array();

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_TIMEOUT, 5);  //设置超时

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $data['data'] = curl_exec($curl);

    $data['Code'] = curl_getinfo($curl,CURLINFO_HTTP_CODE);

    curl_close($curl);

    return $data;
}



/**
 * @functionname: sms_qidian_send_code
 * @author: FrankHong
 * @date: 2016-11-08 15:19:41
 * @description: 发送手机号
 * @note:
 * 例子
 * sms_qidian_send_code('15688889065', '微操盘' , '您的验证码是：', 1)
 *
 *
 * @return array
 * @param $mobile
 * @param string $sign_msg 签名信息，默认验证码
 * @param string $content  签名主体内容，默认  您的验证码是：
 * @param int $sign_where 签名位置，默认1 在左侧， 2右侧
 */
function sms_qidian_send_code($mobile, $sign_msg = '验证码', $content = '您的验证码是：', $sign_where = 1)
{
    $returnRs   = array('ret_code' => 0, 'ret_msg' => '');
    if (empty($mobile) || !preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
    {
        $returnRs['ret_msg']    = '手机号码错误！';
        return $returnRs;
    }

    $mobile_verify  = get_six_num();
    $r_sign         = '【'.$sign_msg.'】';
    $r_content      = $content.$mobile_verify;

    if($sign_where == 1)
        $r_content  = $r_sign.$r_content;
    else
        $r_content  = $r_content.$r_sign;


    $smsObj = new QidianSmsApi(C('SMS_USERNAME'), C('SMS_PASSWORD'));
    $res    = $smsObj->sendSMS($mobile, $r_content);
    $res    = $smsObj->execResult($res);

    if ($res['Status'] != 1)
    {
        $returnRs['ret_code']   = 0;
        $returnRs['ret_msg']    = '系统繁忙，发送失败！';
        return $returnRs;
    }
    else
    {
        $returnRs['ret_code']   = 1;
        $returnRs['ret_msg']    = $mobile_verify;
        return $returnRs;
    }
}


/**
 * @functionname: sms_qixin_send_code
 * @author: FrankHong
 * @date: 2016-11-19 18:02:33
 * @description: 发送手机号--启信
 * @note:  http://www.ussns.com/Api/index.html
 * 例子
 * sms_qixin_send_code('15688889065', '微操盘' , '您的验证码是：', 1)
 *
 *
 * @return array
 * @param $mobile
 * @param string $sign_msg 签名信息，默认验证码
 * @param string $content  签名主体内容，默认  您的验证码是：
 * @param int $sign_where 签名位置，默认1 在左侧， 2右侧
 */
function sms_qixin_send_code($mobile, $sign_msg = '验证码', $content = '您的验证码是：', $sign_where = 1)
{
    $returnRs   = array('ret_code' => 0, 'ret_msg' => '');
    if (empty($mobile) || !preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
    {
        $returnRs['ret_msg']    = '手机号码错误！';
        return $returnRs;
    }

    $mobile_verify  = get_six_num();
    $r_sign         = '【'.$sign_msg.'】';
    $r_content      = $content.$mobile_verify;

    if($sign_where == 1)
        $r_content  = $r_sign.$r_content;
    else
        $r_content  = $r_content.$r_sign;


    $smsObj = new QixinSmsApi(C('SMS_USERNAME'),C('SMS_PASSWORD'));
    $res    = $smsObj->sendSMS($mobile, $r_content);

    $res    = $smsObj->getResult($res,$mobile_verify);

    if ($res['ret_code'] != 1)
    {
        $returnRs['ret_code']   = 0;
        $returnRs['ret_msg']    = '系统繁忙，发送失败！';
        return $returnRs;
    }
    else
    {
        $returnRs['ret_code']   = 1;
        $returnRs['ret_msg']    = $mobile_verify;
        return $returnRs;
    }
}


/**
 * @functionname: sms_alidayu_send_code
 * @author: FrankHong
 * @date:
 * @description:
 * @note:
 * object(stdClass)#10 (2) {
 * ["result"]=>
 * object(stdClass)#11 (3) {
 * ["err_code"]=>
 * string(1) "0"
 * ["model"]=>
 * string(26) "105034655820^1106969866067"
 * ["success"]=>
 * bool(true)
 * }
 * ["request_id"]=>
 * string(12) "3bt4kfioxbdv"
 * }
 * @return array
 * @param $mobile
 */
function sms_alidayu_send_code($mobile)
{
    $returnRs   = array('ret_code' => 0, 'ret_msg' => '');

    if (empty($mobile) || !preg_match('/^(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/', $mobile))
    {
        $returnRs['ret_msg']    = '手机号码错误！';
        return $returnRs;
    }

    $mobile_verify  = get_six_num();

    $returnObj      = Alidayu::SendRegCode($mobile, $mobile_verify);

    $returnObj1     = $returnObj->result;
    if($returnObj1->success)
    {
        $returnRs['ret_code']   = 1;
        $returnRs['ret_msg']    = $mobile_verify;
    }
    else
    {
        $returnRs['ret_code']   = 0;
        $returnRs['ret_msg']    = '系统繁忙，发送失败！';
    }

    return $returnRs;

}

/**
 * @functionname: get_six_num
 * @author: FrankHong
 * @date: 2016-11-08 15:24:22
 * @description: 生成随机的6位数字
 * @note: 常用于6位数字手机验证码
 * @return int
 */
function get_six_num()
{
    return mt_rand(100000, 999999);
}