<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

empty($_SESSION['ssuser']['userid']) && gourl("index.php");
$a=$_REQUEST['a'];
if(empty($a))
{
	$a='log';	
}

if($a=='index')
{
	gourl('index.php?m=bonus&a=log');
}elseif($a=='log')
{
	$userid=intval($_SESSION['ssuser']['userid']);
	$arr=array();
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$rscount=$db->getOne("select count(*) from ".table('user_bonus_log')." where userid=".$userid." ");

	$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=bonus&a=log"));
	$res=$db->query("select * from ".table('user_bonus_log')." where userid=".$userid." order by logid desc limit $start,$pagesize ");
	
	while($rs=$db->fetch_array($res))
	{
		$rs['dateline']=date("Y-m-d ",$rs['dateline']);
		$arr[$rs['logid']]=$rs;
	}
	$smarty->assign("loglist",$arr);
	//获取可用金额
	$smarty->assign("bonus",$db->getOne("select bonus from ".table('user_bonus')." where userid='$userid' "));
	$smarty->display("bonus_log.html");
}

?>