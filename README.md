# MT4、期货、外汇、数字货币，微交易，时间盘，三级分销，行情交易 交易所 php源码
# 开源代码仅供参考学习，请勿用于非法用途！！！

![img.png](https://raw.githubusercontent.com/xixihahaoo/weijiaoyi/main/png/1.png)
![img.png](https://raw.githubusercontent.com/xixihahaoo/weijiaoyi/main/png/2.png)
![img.png](https://raw.githubusercontent.com/xixihahaoo/weijiaoyi/main/png/3.png)
![img.png](https://raw.githubusercontent.com/xixihahaoo/weijiaoyi/main/png/4.png)

**环境要求：**

> Php5.6  mysql5.7 nginx redis
>
> 项目数据库配置信息在 Application/Common/config.php中

> **前台测试账户**
>
> 域名：http://127.0.0.1
>
> 用户：111	111111

> **后台测试账户**
>
> 域名：http://127.0.0.1/admin
>
> 运营中心：	001		123456
>
> 会员单位：	002		123456
>
> 代理：	003		123456


**系统返佣规则**
> 运营中心：			收取用户下单手续费  由总后台按比例设置
>
> 会员单位：			与用户对赌  当会员单位资金低于总后台设置的风控金额时，自动转为特会模式，一旦转为特会模式，除去总后台 所有人不参与分佣。
>
> 代理：			收取用户 (下单金额+手续费)  由会员单位设置佣金比例，此代理的分佣金额，由会员单位全部承担  			(不管会员单位输平赢，都会进行分佣)
>
> 全民经纪人(三级)：	收取用户 (下单金额+手续费)  由会员单位设置各个层级佣金比例，此经纪人分佣的金额，由会员单位全部承担	(不管会员单位输平赢，都会进行分佣)


**程序用到的进程**

> 使用 supervisord 管理进程
>
> **1：平仓**
>
>	进程名称		weijiaoyi_pingcang
>
>	平仓路径		/var/www/html/weijiaoyi/cli.php Home/Handle/position

>;微交易项目(平仓)
>
>[program:weijiaoyi_pingcang]
>
>command=/www/server/php/56/bin/php /var/www/html/weijiaoyi/cli.php Home/Handle/position
>
>autorestart=true
>
>autostart=true

>**2：接收数据源 websocket**

>	使用ssh
>
>	cd /var/www/html/weijiaoyi/Workerman/GatewayWorker/
>
>	执行 /www/server/php/56/bin/php start.php restart -d  (用来启动进程)
>
>	业务逻辑都在:
>	/var/www/html/weijiaoyi/Workerman/GatewayWorker/Applications/YourApp/Event.php  （需要修改里面的数据库连接密码等信息）

>

# 数据源对接：
> **数据源使用地址（备注）：http://39.107.99.235:1008/market/market.php**
>
> 行情接收启动命令： 启动前请确定ip已授权，行情对接完成
>
> 启动前需要修改：Events.php 将数据库信息改为自己的
> ![img.png](https://raw.githubusercontent.com/xixihahaoo/weijiaoyi/main/png/img.png)
>
> 启动命令： /www/server/php/56/bin/php /var/www/html/weijiaoyi/Workerman/GatewayWorker//start.php restart -d
>
> 目录：weijiaoyi 换成你的项目实际目录
>
> 命令启动完毕之后，修改对应的html、将连接的websocket地址改成你自己的服务器， 如果域名为https，前缀需要使用wss
> 并在nginx配置代理即可
>
> 例如：
> ![img.png](https://raw.githubusercontent.com/xixihahaoo/weijiaoyi/main/png/img_1.png)



