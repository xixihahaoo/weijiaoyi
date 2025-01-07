<?php
class Config{
//    private $cfg = array(
//        //接口请求地址，固定不变，无需修改
//        'url'=>'https://pay.swiftpass.cn/pay/gateway',
//	   //测试商户号，商户需改为自己的
//        'mchId'=>'101500035224',
//	   //测试密钥，商户需改为自己的
//        'key'=>'64def53cd1fb23fb59ab79391ba3b2b4',
//	   //版本号默认为2.0
//        'version'=>'1.0'
//       );


	 private $cfg = array(
        //接口请求地址，固定不变，无需修改
        'url'=>'https://pay.swiftpass.cn/pay/gateway',
	   //测试商户号，商户需改为自己的
        'mchId'=>'101580038935',
	   //测试密钥，商户需改为自己的
        'key'=>'530b907e4b2c3b8eb746e590840a2aad',
	   //版本号默认为2.0
        'version'=>'1.0'
       );
    
    public function C($cfgName){
        return $this->cfg[$cfgName];
    }
}
