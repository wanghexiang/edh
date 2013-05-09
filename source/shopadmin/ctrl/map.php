<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

check_login();
$a=$_REQUEST['a'];

if(empty($a))
{
	$a='index';	
}
$shopid=$_SESSION['adminshop']['shopid'];
if($a=='index')
{

	$rs=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' limit 1 ");
	$smarty->assign("rs",$rs);
	$smarty->display("map.html");
}elseif($a=='post')
{
	$shopname=htmlspecialchars($_POST['shopname']);
	$phone=htmlspecialchars($_POST['phone']);
	$area=htmlspecialchars($_POST['area']);
	list($lat,$lng)=explode(",",$area);
	$address=htmlspecialchars($_POST['address']);
	$info=$_POST['info'];
	$qq=htmlspecialchars($_POST['qq']);
	$sendarea=htmlspecialchars($_POST['sendarea']);
	$sendmeter=intval($_POST['sendmeter']);
	
	$db->query("UPDATE ".table('shop')." SET shopname='$shopname',phone='$phone',address='$address',info='$info',lat=".floatval($lat).",lng=".floatval($lng).",qq='$qq',sendarea='$sendarea',sendmeter='$sendmeter' WHERE shopid='$shopid' ");
		
	
	gourl();
}
?>