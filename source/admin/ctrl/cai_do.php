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
	$catlist=$db->getAll("select id,dname,orderid from ".table('cai_do')." order by orderid asc ");
	$smarty->assign("catlist",$catlist);
	$smarty->display("cai_do.html"); 
	
}elseif($a=='add_db')
{
	$dname=$_POST['dname'];
	$id=$_POST['id'];
	if($id)
	{
		$orderid=intval($_POST['orderid']);
		$db->query("update ".table('cai_do')." set dname='$dname',orderid='$orderid' where id='$id' ");
	}else
	{
		$db->query("insert into ".table('cai_do')."(dname) values('$dname') ");	
	}
	gourl();
	
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('cai_do')." where id='$id' ");
	gourl();
}


?>