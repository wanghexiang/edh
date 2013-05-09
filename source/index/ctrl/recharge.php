<?php
if(!defined("CT"))
{
	die('Is wrong');
}

$_GET['a']=$_GET['a']?trim($_GET['a']):"index";
check_login();
switch($_GET['a'])
{
	case 'index':
			$paylist=array();
			if(ALIPAY==1)
			{
				$paylist[]="<a href='index.php?m=recharge&a=pay&type=alipay'>支付宝充值</a>";
			}
			if(TENPAY==1)
			{
				$paylist[]="<a href='index.php?m=recharge&a=pay&type=tenpay'>财付通充值</a>";
			}
			$smarty->assign("paylist",$paylist);
			$smarty->display("recharge.html");
			break;
	case 'pay':
			$_GET['type']=htmlspecialchars($_GET['type']);
			$url='index.php?m=recharge&a=payto';
			if($_GET['type']=='alipay')
			{
				$url="api/alipay/alipayto.php";
			}
			if($_GET['type']=='tenpay')
			{
				$url='api/tenpay/tenpayto.php';
			}
			
			$smarty->assign("payaction",$url);
			$out_trade_no=$_SESSION['ssuser']['userid'].time();
			$smarty->assign("out_trade_no",$out_trade_no);
			$smarty->display("recharge_pay.html");
			break;
	
}
?>