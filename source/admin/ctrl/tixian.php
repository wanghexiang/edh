<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):'index';
$shopid=$_SESSION['adminshop']['shopid'];
switch($_GET['a'])
{
	case 'index':
			$url='shopadmin.php?m=tixian';
			$w='';
			if(isset($_GET['status']))
			{
				$w.=" AND status=".intval($_GET['status'])."  ";
				$url.="&status=".intval($_GET['status']);
			}
			assignlist("shop_tixian",10,$w," ORDER BY id DESC ",$url);
			$smarty->display("tixian.html");
		break;
	case 'do':
			$id=intval($_GET['id']);
			if($_GET['op']=='post')
			{
				$reply=htmlspecialchars($_POST['reply']);
				$db->query("UPDATE ".table('shop_tixian')." SET reply='$reply',redateline=".time().",status=1 WHERE id='$id' ");
				gourl("admin.php?m=tixian");
			}else
			{
				$smarty->assign("tixian",$db->getRow("SELECT * FROM ".table('shop_tixian')." WHERE id='$id' AND status=0  "));
				$smarty->display("tixian_do.html");
			}
			
		break;
}

?>