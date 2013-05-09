<?php
if(!defined("CT"))
{
	die('is wrong');
}

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];

	$arr=array();
	$pagesize=20;
	$userid=intval($_GET['userid']);
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$url="admin.php?m=paylog&a=log";
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
	$rscount=$db->getOne("select count(*) from ".table('user_paylog')." b where 1=1  $w ");
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$smarty->assign("pagelist",$pagelist);
	$res=$db->query("select b.*,u.nickname from ".table('user_paylog')." b LEFT JOIN ".table('user')." u ON b.userid=u.userid  where 1=1 $w order by b.logid desc limit   $start,$pagesize ");
	
	while($rs=$db->fetch_array($res))
	{
		$rs['dateline']=date("Y-m-d H:i:s",$rs['dateline']);
		$arr[$rs['logid']]=$rs;
	}
	$smarty->assign("loglist",$arr);
	//获取可用金额
	if($userid)
	{
		$smarty->assign("balance",$db->getOne("select balance from ".table('user')." where userid='$userid' "));
	}
	$smarty->display("paylog.html");


?>