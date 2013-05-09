<?php
$_GET['a']=$_GET['a']?htmlspecialchars(trim($_GET['a'])):'index';
switch($_GET['a'])
{
	case 'index':
			$_GET['userid']=$_GET['userid']?intval($_GET['userid']):$_SESSION['ssuser']['userid'];
			gourl("index.php?m=blog&userid=".$_GET['userid']);
			if(!$_GET['userid'])
			{
				errback("гКох╣гб╪","index.php?m=user&a=login");
			}
			$user=$db->getRow("SELECT * FROM ".table('user')." WHERE userid=".$_GET['userid']." ");
			$smarty->assign("user",$user);
			$smarty->display("member.html");
		break;
}

?>