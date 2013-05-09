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
	gourl('admin.php?m=bonus&a=log');
}elseif($a=='log')
{
	$arr=array();
	$pagesize=20;
	$userid=intval($_GET['userid']);
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$url="admin.php?m=bonus&a=log";
	$_GET['nickname']=htmlspecialchars($_GET['nickname']);
	if($userid)
	{
	$w= " and b.userid='$userid' " ;
	$url.="&userid={$userid}";
	$smarty->assign("user",$db->getRow("select * from ".table('user')."   where  userid='$userid' "));
	}
	if($_GET['nickname'])
	{
		$w.=" AND u.nickname='".$_GET['nickname']."' ";
		$url.="&nickname={$_GET['nickname']}";
		
	}
	$rscount=$db->getOne("select count(*) from ".table('user_bonus_log')." b where 1=1  $w ");
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$smarty->assign("pagelist",$pagelist);
	$res=$db->query("select b.*,u.nickname from ".table('user_bonus_log')." b LEFT JOIN ".table('user')." u ON b.userid=u.userid  where 1=1 $w order by b.logid desc limit   $start,$pagesize ");
	
	while($rs=$db->fetch_array($res))
	{
		$rs['dateline']=date("Y-m-d H:i:s",$rs['dateline']);
		$arr[$rs['logid']]=$rs;
	}
	$smarty->assign("loglist",$arr);
	//获取可用金额
	if($userid)
	{
		$smarty->assign("bonus",$db->getOne("select bonus from ".table('user_bonus')." where userid='$userid' "));
	}
	$smarty->display("bonus_log.html");
}

?>