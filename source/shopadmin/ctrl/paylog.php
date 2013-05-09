<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):'index';
$shopid=$_SESSION['adminshop']['shopid'];
switch($_GET['a'])
{
	case 'index':
			$smarty->assign('balance',$db->getOne("SELECT balance FROM ".table('shop')." WHERE shopid='$shopid'  "));
			assignlist('shop_paylog',20," AND shopid='$shopid' ",' ORDER BY id DESC ','shopadmin.php?m=paylog');
			$smarty->display("paylog.html");
		break;
}

?>