<?php
//����Ա��½

$a=$_REQUEST['a'];
if($a=='login')
{
	
	$adminname=trim($_POST['adminname']);
	$password=trim($_POST['password']);
	$yzm=strtoupper(trim($_POST['yzm']));
	if($yzm!=$_SESSION['code']) 
	{
		errback('��֤�����');
	}
	$shopid=$db->getOne("select shopid from ".table('shopadmin')." where adminname='$adminname' ");
	if(!$shopid)
	{
		errback('��û�й���Ȩ��')	;
	}
	$ssadmin=$db->getRow("select siteid,adminname,shopid,adminid from ".table('shopadmin')." where adminname='$adminname' and password='".umd5($password)."' ");
	$ip=$_SERVER['REMOTE_ADDR'];
	$ztime=time();
	if($ssadmin)
	{
		$_SESSION['ssadminshop']=$ssadmin;
		$_SESSION['adminshop']=$db->getRow("SELECT siteid,shopid,shopname FROM ".table('shop')." WHERE shopid='$shopid' ");	
		$logdesc="{$adminname}��½�ɹ���";
		//������־
		$db->query("insert into ".table('shopadmin_log')."(adminname,ip,ztime,logdesc) values('$adminname','$ip','$ztime','$logdesc')");
		gourl("shopadmin.php?m=iframe&");
	}else
	{
		$logdesc="{$adminname}��½ʧ�ܣ�";
		//������־
		$db->query("insert into ".table('shopadmin_log')."(adminname,ip,ztime,logdesc) values('$adminname','$ip','$ztime','$logdesc')");
		errback('�û��������������');
		
	}
	
}elseif($a=='logout')
{
	$_SESSION['ssadminshop']='';
	$_SESSION['adminshop']='';
	gourl("shopadmin.php");	
}
?>