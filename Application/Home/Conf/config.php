<?php
return array(
    //'配置项'=>'配置值'
   'SHOW_PAGE_TRACE'=>false,
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
    ),

    //短信发送文件
    'MESSAGEMANE' => 'szjf1230',
    'MESSAGEPATH' => 'http://open.96xun.com/Api/SendSms',
    'MEASSAGEPASSWORD' => 'ZH123456zh',

    'stspage' => 'Home/User/memberinfo',

    /*默认模版分类*/
    //'DEFAULT_THEME'    =>    'Default',
    'DEFAULT_THEME'    =>    'Yongli',

);