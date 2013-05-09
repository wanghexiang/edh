<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.2
 * 日期：2011-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 
 * TRADE_FINISHED(表示交易已经成功结束，为普通即时到帐的交易状态成功标识);
 * TRADE_SUCCESS(表示交易已经成功结束，为高级即时到帐的交易状态成功标识);
 */
 if(!defined("CT"))
{
	die('is wrong');
}
require_once("api/alipay/alipay.config.php");
require_once("api/alipay/lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($aliapy_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
    $out_trade_no	= $_GET['out_trade_no'];	//获取订单号
    $trade_no		= $_GET['trade_no'];		//获取支付宝交易号
    $total_fee		= $_GET['total_fee'];		//获取总价格	
	$uid = $_SESSION['ssuser']['userid'];
	if($db->getOne("SELECT logid FROM ".table('user_paylog')." WHERE ftype='alipay' AND orderno='$trade_no' "))
	{
		errback('请不要重复提交表单','index.php');
	}
	//充值到账户
	$db->query("UPDATE ".table('user')." SET balance=balance+'$total_fee' WHERE userid='$uid' ");
	
	$content=$_SESSION['ssuser']['nickname']."，您在".date("Y-m-d H:i:s")."用支付宝成功充值{$total_fee}元，订单号：{$out_trade_no}，支付宝交易号：{$trade_no}";
	$db->query("INSERT INTO ".table('user_paylog')." SET userid='$uid',money='$total_fee',dateline=".time().",ftype='alipay',orderno='$trade_no',content='$content' ");
	
	errback($content,"index.php?m=bonus&a=log");
	
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数，比对sign和mysign的值是否相等，或者检查$responseTxt有没有返回true
    errback( "验证失败，交易不成功","index.php");
}
?>
        <title>支付宝即时到帐接口</title>
	</head>
    <body>
    </body>
</html>