<?php
require_once(ROOT_PATH."source/function/function_follow.php");
$_GET['a']=$_GET['a']?htmlspecialchars(trim($_GET['a'])):'index';
switch($_GET['a'])
{
	case 'index':
			$uids=getfollows(intval($_SESSION['ssuser']['userid']));
			$uids=array_merge(array(intval($_SESSION['ssuser']['userid'])),$uids);
			assignlist("ordershare",10,"  AND siteid='$cksiteid' AND userid in("._implode($uids).")"," ORDER BY id DESC ","index.php?m=ordershare");
			$smarty->display("ordershare.html");
		break;
	case 'my':
			$userid=$_GET['userid']?intval($_GET['userid']):intval($_SESSION['ssuser']['userid']);
			assignlist("ordershare",10," AND userid='$userid' "," ORDER BY id DESC","index.php?m=ordershare");
			$smarty->display("ordershare.html");
		break;	
	
}
?>