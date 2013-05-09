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

if($a=='index')
{
	gourl('shopadmin.php?m=bonus&a=log');
}elseif($a=='log')
{
	$arr=array();
	$pagesize=20;
	$userid=intval($_GET['userid']);
	$page=intval($_GET['page']);
	$url="shopadmin.php?m=bonus&a=log";
	if($userid)
	{
	$w= " and userid='$userid' " ;
	$url.="&userid={$userid}";
	$smarty->assign("user",$db->getRow("select * from ".table('user')." where userid='$userid' "));
	}
	$rscount=$db->getOne("select count(*) from ".table('user_bonus_log')." where 1=1  $w ");
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);

	$smarty->assign("pagelist",$pagelist);
	$res=$db->query("select * from ".table('user_bonus_log')." where 1=1 $w order by logid desc limit $start,$pagesize ");
	
	while($rs=$db->fetch_array($res))
	{
		$rs['dateline']=date("Y-m-d H:i:s",$rs['dateline']);
		$arr[$rs['logid']]=$rs;
	}
	$smarty->assign("loglist",$arr);
	//获取可用金额
	$smarty->assign("bonus",$db->getOne("select bonus from ".table('user_bonus')." where userid='$userid' "));
	$smarty->display("bonus_log.html");
}

?>