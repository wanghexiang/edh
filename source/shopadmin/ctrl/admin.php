<?php

check_login();
$a=$_REQUEST['a'];
if(empty($a))
{
	$a='index';
}
$shopid=$_SESSION['adminshop']['shopid'];
if($a=='index')
{
	$adminname=trim($_GET['adminname']);
	$url="shopadmin.php?m=admin&";
	$sql="select * from ".table('shopadmin')." where shopid='$shopid' ";
	$sql2="select count(*) from ".table('shopadmin')." where shopid='$shopid' ";
	if($adminname)
	{
		$sql.=" AND adminname like '%".$adminname."%'";
		$sql2.=" AND adminname like '%".$adminname."%' ";	
		$smarty->assign("adminname",$adminname);
		$url.="&adminname={$adminname}";
	}
	$sql.="order by adminid desc";
	//��ʼ��ҳ
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//������ҳ
	$res=$db->query($sql);
	$arr=array();
	while($rs=@$db->fetch_array($res))
	{
		$arr[$rs['adminid']]=$rs;
		$arr[$rs['adminid']]['dotype']=$rs['status']==1?"<a href=\"shopadmin.php?m=admin&a=dotype&adminid=".$rs['adminid']."&status=0\">��ֹ</a>":"<a href=\"shopadmin.php?m=admin&a=dotype&adminid=".$rs['adminid']."&status=1\">���</a>"	;
	}
	$smarty->assign("adminlist",$arr);
	$smarty->display("admin.html");
}
elseif($a=='add')
{
	$smarty->display("admin_add.html");	
}elseif($a=='add_db')
{
	$adminname=trim($_POST['adminname']);
	ckempty($adminname,"�û�������Ϊ�գ�");
	$email=trim($_POST['email']);
	if(!(is_email($email))) errback('���䲻�Ϸ�');
	$pwd1=trim($_POST['pwd1']);
	cklong($pwd1,"���볤�Ƚ���7-50",50,7);
	$pwd2=trim($_POST['pwd2']);
	if($pwd1!=$pwd2) errback("�����������벻һ��");
	$ct=$db->getOne("select count(*) from ".table('shopadmin')." where adminname='$adminname'  ");
	if($ct) errback("���û����ѱ�ע��"); 
	$db->query("insert into ".table('shopadmin')."(adminname,email,password,shopid,siteid) values('$adminname','$email','".umd5($pwd1)."','$shopid','$siteid') ");
	gourl();
	
}elseif($a=="del")
{
	$adminid=intval($_GET['adminid']);
	$db->query("delete from ".table('shopadmin')." where adminid='$adminid' AND shopid='$shopid' ");
	gourl();
}elseif($a=='chpwd')
{
	$adminname=$_GET['adminname'];
	$smarty->assign("adminname",$adminname);
	$smarty->display("admin_chpwd.html");
}elseif($a=='chpwd_db')
{
	$adminname=trim($_POST['adminname']);
	$pwd1=trim($_POST['pwd1']);
	cklong($pwd1,"���볤�Ƚ���7-50",50,7);
	$pwd2=trim($_POST['pwd2']);
	if($pwd1!=$pwd2) errback("�����������벻һ��");
	$db->query("update ".table('shopadmin')." set password='".umd5($pwd1)."' where adminname='$adminname' AND shopid='$shopid'  ");
	gourl("shopadmin.php?m=admin&");
}
?>

