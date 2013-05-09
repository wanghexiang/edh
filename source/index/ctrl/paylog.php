<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

empty($_SESSION['ssuser']['userid']) && gourl("index.php");

$userid=intval($_SESSION['ssuser']['userid']);
assignlist("user_paylog",10," AND userid='$userid' "," ORDER BY logid DESC ","index.php?m=paylog"  );
$smarty->assign("balance",$db->getOne("SELECT balance FROM ".table('user')." WHERE userid='$userid' LIMIT 1 "));
$smarty->display("user_paylog.html");

?>