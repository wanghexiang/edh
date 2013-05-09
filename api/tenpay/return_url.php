<?php

//---------------------------------------------------------
//财付通即时到帐支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------
if(!defined("CT"))
{
	die('is wrong');
}

require_once("$root/includes/init.php");
require_once ("./classes/PayResponseHandler.class.php");
require_once("tenpay_config.php");


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
		
		$content=$_SESSION['ssuser']['nickname']."，您在".date("Y-m-d H:i:s")."用财付通成功充值{$total_fee}元，财付通交易号：{$transaction_id}";
		if($db->getOne("SELECT id FROM ".table('user_bonus')." WHERE userid='$uid' "))
		{
			$db->query("UPDATE ".table('user_bonus')." SET bonus=bonus+'$total_fee' WHERE userid='$uid' ");
		}else
		{
			$db->query("INSERT INTO ".table('user_bonus')." SET userid='$uid',bonus='$total_fee' ");
		}
		$db->query("INSERT INTO ".table('user_bonus_log')." SET userid='$uid',bonus='$total_fee',dateline=".time().",content='$content' ");
		
		errback($content,"index.php?m=bonus&a=log");
		
		/*$show = "http://localhost/tenpay/show.php";
		$resHandler->doShow($show);
		*/
	
	} else {
		//当做不成功处理
		errback("充值失败请联系网站管理员","http://".DOMAIN);
	}
	
} else {
	errback("支付宝认证失败请联系网站管理员","http://".DOMAIN);
}

//echo $resHandler->getDebugInfo();

?>