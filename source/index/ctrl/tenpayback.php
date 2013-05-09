<?php

//---------------------------------------------------------
//财付通即时到帐支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------
if(!defined("CT"))
{
	die('is wrong');
}

require_once ("api/tenpay/classes/PayResponseHandler.class.php");
require_once("api/tenpay/tenpay_config.php");


/* 创建支付应答对象 */
$resHandler = new PayResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {
	
	//交易单号
	$transaction_id = $resHandler->getParameter("transaction_id");
	
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	
	//支付结果
	$pay_result = $resHandler->getParameter("pay_result");
	
	if( "0" == $pay_result ) {
	
		//------------------------------
		//处理业务开始
		//------------------------------
		
		//注意交易单不要重复处理
		//注意判断返回金额
		
		//------------------------------
		//处理业务完毕
		//------------------------------	
		
		//调用doShow, 打印meta值跟js代码,告诉财付通处理成功,并在用户浏览器显示$show页面.
		$uid = $_SESSION['ssuser']['userid'];
		if($db->getOne("SELECT logid FROM ".table('user_paylog')." WHERE ftype='tenpay' AND orderno='$transaction_id' "))
		{
			errback('请不要重复提交表单','index.php');
		}
		$content=$_SESSION['ssuser']['username']."，您在".date("Y-m-d H:i:s")."用财付通成功充值{$total_fee}元，财付通交易号：{$transaction_id}";
		
		$db->query("UPDATE ".table('user')." SET balance=balance+'$total_fee' WHERE userid='$uid' ");
		
		$db->query("INSERT INTO ".table('user_paylog')." SET userid='$uid',money='$total_fee',dateline=".time().",content='$content',ftype='tenpay',orderno='$transaction_id' ");
		
		errback($content,"index.php?m=bonus&a=log");
		
	
	} else {
		//当做不成功处理
		errback("充值失败请联系网站管理员","http://".DOMAIN);
	}
	
} else {
	errback("财付通认证失败请联系网站管理员","http://".DOMAIN);
}

//echo $resHandler->getDebugInfo();

?>