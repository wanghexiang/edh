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
	$flashlist=$db->getAll("select * from ".table('flash')." WHERE shopid='$shopid' order by forder asc ");
	$smarty->assign("flashlist",$flashlist);
	$smarty->display("flash.html");
}elseif($a=='add_db')
{
	$fid=intval($_POST['fid']);
	$forder=intval($_POST['forder']);
	$ftitle=trim($_POST['ftitle']);
	$furl=	trim($_POST['furl']);
	$fimg=trim($_POST['fimg']);
	if($fid)
	{
	$sql="update ".table('flash')." set forder='$forder',ftitle='$ftitle',furl='$furl',fimg='$fimg' where fid='$fid' AND shopid='$shopid'  ";
	}else
	{
		$sql="insert into ".table('flash')." set forder='$forder',ftitle='$ftitle',furl='$furl',fimg='$fimg',shopid='$shopid' ";
	}
	$db->query($sql);
	gourl("shopadmin.php?m=flash&");
}elseif($a=="del")
{
	$db->query("delete from ".table('flash')." where  fid=".intval($_GET['fid'])." and shopid='$shopid'  ");	
	gourl();
}

?>