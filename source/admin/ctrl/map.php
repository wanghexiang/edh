<?php
if(!defined("CT"))
{
	die('is wrong');
}

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];

if(empty($a))
{
	$a='index';	
}
if($a=='index')
{
	if(file_exists("mapdata.php"))
	{
		$rs=unserialize(file_get_contents("mapdata.php"));
		$smarty->assign("rs",$rs);
	}
	
	$smarty->display("map.html");
}elseif($a=='post')
{
	$title=htmlspecialchars($_POST['title']);
	$phone=htmlspecialchars($_POST['phone']);
	$area=htmlspecialchars($_POST['area']);
	$address=htmlspecialchars($_POST['address']);
	$info=$_POST['info'];
	file_put_contents("mapdata.php",serialize(array(
	"title"=>$title,
	"phone"=>$phone,
	"area"=>$area,
	"address"=>$address,
	"info"=>$info
	)));
	gourl();
}
?>