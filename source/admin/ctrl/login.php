<?php
//����Ա��½

$a=$_GET['a']?$_GET['a']:$_POST['a'];
if($a=='login')
{
	
	$adminname=trim($_POST['adminname']);
	$password=trim($_POST['password']);
	$yzm=strtoupper(trim($_POST['yzm']));
	if($yzm!=$_SESSION['code']) 
	{
		errback('��֤�����');
	}
	$c=$db->getOne("select count(*) from ".table('admin')." where adminname='$adminname' ");
	if($c==0)
	{
		errback('�û��������������')	;
	}
	$ct=$db->getOne("select adminid from ".table('admin')." where adminname='$adminname' and password='".umd5($password)."' ");
	$ip=$_SERVER['REMOTE_ADDR'];
	$dateline=time();
	if($ct)
	{
		$_SESSION['ssadmin']=$rs=$db->getRow("select adminid,siteid,adminname,isfounder,zuid from ".table('admin')." where adminname='$adminname' ");		
		$_SESSION['ssadmin']['sitename']=$db->getOne("SELECT sitename FROM ".table('sites')." WHERE siteid=".$_SESSION['ssadmin']['siteid']." ");
		$_SESSION['ssadmin']['pers']=unserialize($db->getOne("SELECT content FROM ".table('admin_zu')." WHERE id=".$rs['zuid']." "));	
		$logdesc="{$adminname}��½�ɹ���";
		//������־
		$db->query("insert into ".table('admin_log')."(adminname,ip,dateline,logdesc) values('$adminname','$ip','$dateline','$logdesc')");
		gourl("admin.php?m=iframe");
	}else
	{
		$logdesc="{$adminname}��½ʧ�ܣ�";
		//������־
		$db->query("insert into ".table('admin_log')."(adminname,ip,dateline,logdesc) values('$adminname','$ip','$dateline','$logdesc')");
		errback('�û��������������');
		
	}
	
}elseif($a=='logout')
{
	$_SESSION['ssadmin']='';
	gourl("admin.php?m=index&");	
}
?>