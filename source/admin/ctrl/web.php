<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a='index';
}
checkpermission("web",$a);
if($a=='index')
{
$rs=$db->getRow("select * from ".table('web')." WHERE siteid='$siteid' ");
$smarty->assign("web",$rs);
$smarty->display("web.html");
	
}elseif($a=='add_db')
{
	$webname=$_POST['webname'];
	$webtitle=$_POST['webtitle'];
	$weburl=$_POST['weburl'];
	$webkey=$_POST['webkey'];
	$webdesc=$_POST['webdesc'];
	$beian=$_POST['beian'];
	$webgg=$_POST['webgg'];
	$address=$_POST['address'];
	$webqq=$_POST['webqq'];
	$webmsn=$_POST['webmsn'];
	$phone=$_POST['phone'];
	$weboff=$_POST['weboff'];
	$offwhy=$_POST['offwhy'];
	$weblogo=trim($_POST['weblogo']);
	$wapurl=trim($_POST['wapurl']);
	$ct=$db->getOne("select count(*) from ".table('web')." WHERE siteid='$siteid' ");	
	if($ct==0)
	{
		$db->query("INSERT INTO ".table('web')." set webname='$webname',siteid='$siteid'  ");

	}
	$sql="update ".table('web')." set webname='$webname',webtitle='$webtitle',weburl='$weburl',webkey='$webkey', ".
		" webdesc='$webdesc',beian='$beian',address='$address',webqq='$webqq',webmsn='$webmsn',phone='$phone', webgg='$webgg',".
		" weboff='$weboff',offwhy='$offwhy',weblogo='$weblogo',wapurl='$wapurl' WHERE siteid='$siteid' ";
	$db->query($sql);
	gourl("admin.php?m=web");
}
?>