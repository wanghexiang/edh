<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
$a='index';	
}
checkpermission("cai_cat",$a);
if($a=='index')
{
	$pagesize=20;
	$page=max(intval($_GET['page']),1);
	$start=($page-1)*$pagesize;
	$rscount=$db->getOne("SELECT count(catid) FROM ".table('cai_cat')."   ");
	$catlist=$db->getAll("select catid,cname,orderid from ".table('cai_cat')." order by orderid asc LIMIT $start,$pagesize ");
	$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"admin.php?m=cai_cat"));
	$smarty->assign("catlist",$catlist);
	$smarty->display("cai_cat.html"); 
	
}elseif($a=='add_db')
{ 
	$cname=$_POST['cname'];
	$catid=$_POST['catid'];
	if($catid)
	{
		$orderid=intval($_POST['orderid']);
		$db->query("update ".table('cai_cat')." set cname='$cname',orderid='$orderid' where catid='$catid'  ");
	}else
	{
		$db->query("insert into ".table('cai_cat')."(cname) values('$cname') ");	
	}
	gourl("admin.php?m=cai_cat");
	
}elseif($a=='del')
{
	$catid=intval($_GET['catid']);
	$db->query("delete from ".table('cai_cat')." where catid='$catid' ");
	gourl();
}


?>