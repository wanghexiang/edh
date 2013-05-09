<?php
$_GET['a']=isset($_GET['a'])?htmlspecialchars($_GET['a']):'index';

$userid=intval($_SESSION['ssuser']['userid']);
if(empty($userid)) gourl('index.php?m=user&a=login');
switch($_GET['a'])
{
	case 'index':
			
			$pagesize=10;
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$status=intval($_GET['status']);
			$rscount=$db->getOne("SELECT count(*) FROM ".table('message')." WHERE userid='$userid' AND status='$status'");
			$list=$db->getAll("SELECT * FROM ".table('message')." WHERE userid='$userid' AND status='$status' LIMIT $start,$pagesize ");
			$smarty->assign("list",$list);
			$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=message&status=$status"));
			$smarty->display("message.html");
		break;	
	case 'status':
			$db->query("UPDATE ".table('message')." SET status=1 WHERE userid='$userid' AND id=".intval($_GET['id'])." ");
			gourl();
		break;
	case 'del':
			$db->query("DELETE FROM ".table('message')." WHERE  userid='$userid' AND id=".intval($_GET['id'])."  ");
			gourl();
		break;

}

?>