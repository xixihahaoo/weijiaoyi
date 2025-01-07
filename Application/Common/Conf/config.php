<?php
return array(
	//'配置项'=>'配置值'
	/* 数据库设置 */
	'DB_TYPE' => 'mysql', // 数据库类型
	'DB_HOST' => 'localhost', // 服务器地址
	'DB_NAME' => 'weijiaoyi', // 数据库名
	'DB_USER' => 'root', // 用户名
	'DB_PWD' => '123456', // 密码
	'DB_PORT' => '3306', // 端口
	'DB_PREFIX' => 'wp_', // 数据库表前缀
	'DB_FIELDTYPE_CHECK' => false, // 是否进行字段类型检查
	'DB_FIELDS_CACHE' => true, // 启用字段缓存
	'DB_CHARSET' => 'utf8', // 数据库编码默认采用utf8
	'DB_DEPLOY_TYPE' => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
	'DB_RW_SEPARATE' => false, // 数据库读写是否分离 主从式有效
	'DB_MASTER_NUM' => 1, // 读写分离后 主服务器数量
	'DB_SLAVE_NO' => '', // 指定从服务器序号
	'DB_SQL_BUILD_CACHE' => false, // 数据库查询的SQL创建缓存
	'DB_SQL_BUILD_QUEUE' => 'file', // SQL缓存队列的缓存方式 支持 file xcache和apc
	'DB_SQL_BUILD_LENGTH' => 20, // SQL缓存的队列长度
	'DB_SQL_LOG' => false, // SQL执行日志记录
	'DB_BIND_PARAM' => false, // 数据库写入数据自动参数绑定
	/* 错误页面模板 */
	// 'TMPL_ACTION_ERROR'     =>  MODULE_PATH.'View/Public/error.html', // 默认错误跳转对应的模板文件
	// 'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/Public/success.html', // 默认成功跳转对应的模板文件
	// 'TMPL_EXCEPTION_FILE'   =>  MODULE_PATH.'View/Public/exception.html',// 异常页面的模板文件
	"WXPAY" => array(
		'url' => 'https://pay.swiftpass.cn/pay/gateway', //接口请求地址，固定不变，无需修改
		'mchId' => '102510112612', //测试商户号，商户需改为自己的
		'key' => 'a9e4d86f2171eb84ab9d2c605a06d243', //测试密钥，商户需改为自己的
		'version' => '2.0', //版本号默认为2.0
		'notify_url' => 'http://wei.xcjhjysc.com/Home/Weixin/notify', //通知地址
		'callback_url' => 'http://wei.xcjhjysc.com/Home/User/memberinfo', //前台返回地址
	),
	
	"Agent" => array(
		'one' => 0.2, //返给上一级的盈利比例
		'two' => 0.3, //返给上两级的盈利比例
		"three" => 0.5, //返给上三级的盈利比例
	),

	"Alidayu" =>array(
		'appkey' =>'23562149',
		'secretKey' =>'fd8c1ddb154e9cc7d6dd80d0a3664e1c',
		'sms' =>'SMS_15470135',
	),

    'SMS_USERNAME'          =>  'xinyuan0717',     	//当前系统客户短信平台用户名
    'SMS_PASSWORD'          =>  'XY@54321@xy', 		//当前系统客户短信平台密码

	'UNIT_BALANCE' => 5000, //会员单位资金账户 低于此值不能购买

);
