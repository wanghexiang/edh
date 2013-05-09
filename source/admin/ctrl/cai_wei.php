<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
$a='index';	
}
$smarty->assign("menu",4);
if($a=='index')
{
	$catlist=$db->getAll("select id,wname,orderid from ".table('cai_wei')." order by orderid asc ");
	$smarty->assign("catlist",$catlist);
	$smarty->display("cai_wei.html"); 
	
}elseif($a=='add_db')
{
	$wname=$_POST['wname'];
	$id=$_POST['id'];
	if($id)
	{
		$orderid=intval($_POST['orderid']);
		$db->query("update ".table('cai_wei')." set wname='$wname',orderid='$orderid' where id='$id' ");
	}else
	{
		$db->query("insert into ".table('cai_wei')."(wname) values('$wname') ");	
	}
	gourl();
	
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('cai_wei')." where id='$id' ");
	gourl();
}


?>