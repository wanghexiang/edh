<?php
check_login();
$a=get('a');
$a=$a?$a:"index";
$shopid=intval($_SESSION['adminshop']['shopid']);
$userid=intval($_SESSION['ssuser']['userid']);
switch($a){
	case "index":
		
			$userid=$db->getOne("select userid FROM ".table('shop')." WHERE shopid='$shopid' ");
			 
			$userid &&  $user=$db->getRow("select userid,username,nickname FROM ".table('user')." WHERE userid='$userid' ");
			 
			 
			$smarty->assign("user",$user);
			$smarty->display("binduser.html");
		break;
	
	case 'bind':
			
			$db->query("update ".table('user')." SET shopid='$shopid' WHERE userid='$userid' ");
			$db->query("update ".table('shop')." SET userid='$userid' WHERE shopid='$shopid' ");
			gourl();
		break;
}

?>