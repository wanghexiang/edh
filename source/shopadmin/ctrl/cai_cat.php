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
	$catlist=$db->getAll("select catid,cname,orderid from ".table('cai_cat')." WHERE shopid='$shopid' order by orderid asc ");
	$smarty->assign("catlist",$catlist);
	$smarty->display("cai_cat.html"); 
	
}elseif($a=='add_db')
{
	$cname=$_POST['cname'];
	$catid=$_POST['catid'];
	if($catid)
	{
		$orderid=intval($_POST['orderid']);
		$db->query("update ".table('cai_cat')." set cname='$cname',orderid='$orderid' where catid='$catid' AND shopid='$shopid' ");
	}else
	{
		$db->query("insert into ".table('cai_cat')." SET cname='$cname',shopid='$shopid'  ");	
	}
	gourl("shopadmin.php?m=cai_cat&");
	
}elseif($a=='del')
{
	$catid=intval($_GET['catid']);
	$db->query("delete from ".table('cai_cat')." where catid='$catid' AND shopid='$shopid' ");
	gourl();
}


?>