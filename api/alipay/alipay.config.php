<?php

//合作身份者id，以2088开头的16位纯数字
$aliapy_config['partner']      = '2088302422505850';

//安全检验码，以数字和字母组成的32位字符
$aliapy_config['key']          = '72ovd7tigkv1p073ffx481glzkk6977f';

//签约支付宝账号或卖家支付宝帐户
$aliapy_config['seller_email'] = 'shapaba@shapaba.com';

//页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
//return_url的域名不能写成http://localhost/create_direct_pay_by_user_php_gb/return_url.php ，否则会导致return_url执行无效
//更改域名即可  比如 hck.com 则：http://hck.com/api/alipay/return_url.php
$aliapy_config['return_url']   = 'http://hck.koufukeji.com/index.php?m=alipayback';
//更改域名即可  比如 hck.com 则：http://hck.com/api/alipay/notify_url.php
//服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
$aliapy_config['notify_url']   = 'http://hck.koufukeji.com/api/alipay/notify_url.php';

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//签名方式 不需修改
$aliapy_config['sign_type']    = 'MD5';

//字符编码格式 目前支持 gbk 或 utf-8
$aliapy_config['input_charset']= 'gbk';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$aliapy_config['transport']    = 'https';
?>