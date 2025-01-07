<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\DbConnection;
use \Workerman\Connection\AsyncTcpConnection;
use \Workerman\Lib\Timer;
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{

    /**
     *  AsyncTcpConnection 异步客户端
     *  不进行数据库监控 使用当前 onWorkerStart 即可 否则使用下一个
     *  $businessWorker->id 只开一个进程
     * @param $businessWorker 
     */
    public static function onWorkerStart($businessWorker) {

      if ($businessWorker->id == 0) {
        
        global $db;

        $db     = new DbConnection('localhost', '3306', 'root', '123456', 'weijiaoyi');

        $option = $db->select('group_concat(distinct(code))')->from('wp_data_now')->column();

        $dataId = $option[0];

        $con    = new AsyncTcpConnection('ws://39.107.99.235/ws');


        $redis = new redis();

        $redis -> connect('127.0.0.1',6379);

        $redis->set('value',$dataId);


        Timer::add(5, function()use($redis)
        {
            $status = self::checkAsync($redis);
  
            if($status == 1)
            {
                 posix_kill(posix_getppid(), SIGUSR1);
            }
        });


        $con->onConnect = function($con) use($dataId)
        {

            $payload = json_encode(array(
                'event' => 'REG',
                'Key' => $dataId
            ));

            $con->send($payload);
        };

        $con->onMessage = function($con, $msg) {

            $data = json_decode($msg, true);
            $data = $data['body'];
            $code = $data['StockCode'];

            if(!empty($code))
            {
              $post_data = array(
                'code'      => $code,
                'last'      => $data['Price'],
                'open'      => $data['Open'],
                'lastClose' => $data['LastClose'],
                'high'      => $data['High'],
                'low'       => $data['Low'],
                'quoteTime' => date("y-m-d H:i:s", $data['LastTime'])
              );
            }

            global $db;

            $db->update('wp_data_now')->cols($post_data)->where("code = '$code'")->query();

            $message = json_encode($data);
            Gateway::sendToGroup($code,$message);
        };

        $con->onClose = function($con) {
            echo '断开';
          $con->reConnect(1);
        };

        $con->connect();

      }
    }



    public static function checkAsync($redis)
    {
        global $db;

        $option = $db->select('group_concat(distinct(code))')->from('wp_data_now')->column();

        $dataId = $option[0];

        $value  = $redis->get('value');

        $str    = strcmp($dataId,$value);

        if($str != 0)
        {
            $redis->set('value',$dataId);

            return 1;
        }
    }




    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id) {
        Gateway::sendToClient($client_id, json_encode(array(
            'type'      => 'init',
            'client_id' => $client_id
        )));
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message) {
        // 向所有人发送 
        //Gateway::sendToAll("$client_id said $message");
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
       // 向所有人发送 
       //GateWay::sendToAll("$client_id logout");
   }
}
