<?php
//管理员登陆

$a=$_REQUEST['a'];
if($a=='login')
{
	
	$adminname=trim($_POST['adminname']);
	$password=trim($_POST['password']);
	$yzm=strtoupper(trim($_POST['yzm']));
	if($yzm!=$_SESSION['code']) 
	{
		errback('验证码出错！');
	}
	$shopid=$db->getOne("select shopid from ".table('shopadmin')." where adminname='$adminname' ");
	if(!$shopid)
	{
		errback('您没有管理权限')	;
	}
	$ssadmin=$db->getRow("select siteid,adminname,shopid,adminid from ".table('shopadmin')." where adminname='$adminname' and password='".umd5($password)."' ");
	$ip=$_SERVER['REMOTE_ADDR'];
	$ztime=time();
	if($ssadmin)
	{
		$_SESSION['ssadminshop']=$ssadmin;
		$_SESSION['adminshop']=$db->getRow("SELECT siteid,shopid,shopname FROM ".table('shop')." WHERE shopid='$shopid' ");	
		$logdesc="{$adminname}登陆成功！";
		//插入日志
		$db->query("insert into ".table('shopadmin_log')."(adminname,ip,ztime,logdesc) values('$adminname','$ip','$ztime','$logdesc')");
		gourl("shopadmin.php?m=iframe&");
	}else
	{
		$logdesc="{$adminname}登陆失败！";
		//插入日志
		$db->query("insert into ".table('shopadmin_log')."(adminname,ip,ztime,logdesc) values('$adminname','$ip','$ztime','$logdesc')");
		errback('用户名或者密码出错！');
		
	}
	
}elseif($a=='logout')
{
	$_SESSION['ssadminshop']='';
	$_SESSION['adminshop']='';
	gourl("shopadmin.php");	
}
?>