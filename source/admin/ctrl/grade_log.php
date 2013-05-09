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
$url="admin.php?m=grade_log";
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
$rscount=$db->getOne("select count(*) from ".table('grade_log')." b where 1=1  $w ");
$pagelist=multipage($rscount,$pagesize,$page,$url);
$smarty->assign("pagelist",$pagelist);
$res=$db->query("select b.*,u.nickname from ".table('grade_log')." b LEFT JOIN ".table('user')." u ON b.userid=u.userid  where 1=1 $w order by b.id desc limit   $start,$pagesize ");

while($rs=$db->fetch_array($res))
{
	$rs['dateline']=date("Y-m-d H:i:s",$rs['dateline']);
	$arr[]=$rs;
}
$smarty->assign("loglist",$arr);

$smarty->display("grade_log.html");

?>