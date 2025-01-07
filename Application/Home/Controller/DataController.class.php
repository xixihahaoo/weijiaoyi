<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\Gateway;

//获取K线图
class DataController extends CommonController {

    public function getData()
    {
        $code        = trim(I('get.code'));
        $interval    = trim(I('get.interval'));
        $rows        = trim(I('get.rows'));

        if(!empty($code))
        {
            if( is_numeric($interval)){
                $interval = $interval.'m';
            }

            $url = 'http://39.107.99.235:1008/redis.php?code='.$code.'&time='.$interval.'&rows='.$rows.'';
            $json_data 	= $this->http_request($url);
            die($json_data);
        }
    }

    /**
     * curl 请求
     * @param wang li
     */
    public function http_request($URI, $isHearder = false, $post = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);          //单位 秒，也可以使用
        curl_setopt($ch, CURLOPT_HEADER, $isHearder);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
        if(strpos($URI, 'https') === 0){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if($post){
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
