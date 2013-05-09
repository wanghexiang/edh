<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
$a='index';	
}
checkpermission("link",$a);

if($a=='index')
{
	$rs=$db->getAll("select * from ".table('link')." WHERE siteid='$siteid' order by orderid asc ");
	$smarty->assign("linklist",$rs);
	$smarty->display("link.html");
}elseif($a=='add')
{
	$id=intval($_GET['id']);
	if($id){
		$smarty->assign("rs",$db->getRow("select * from ".table('link')." where id='$id' AND siteid='$siteid' "));
	}
	$smarty->display("link_add.html");
	
}elseif($a=='add_db')
{
	$id=intval($_POST['id']);
	$title=trim($_POST['title']);
	$linkurl=$_POST['linkurl'];
	$linkimg=$_POST['linkimg'];
	$linktype=intval($_POST['linktype']);
	if($id)
	{
		$sql="update ".table('link')." set title='$title',linkurl='$linkurl',linkimg='$linkimg',linktype='$linktype' where id='$id' AND siteid='$siteid' ";
	}else
	{
		$sql="insert into ".table('link')." SET siteid='$siteid', title='$title',linkurl='$linkurl',linkimg='$linkimg',linktype='$linktype' ";	
	}
	$db->query($sql);
	gourl();
}elseif($a=='order')
{
	$idarr=$_POST['id'];
	$orderarr=$_POST['orderid'];
	foreach($idarr as $key=>$val)
	{
		$db->query("update ".table('link')." set orderid=".intval($orderarr[$key])." where id='$val' AND siteid='$siteid' ");
	}
	gourl();
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('link')." where id='$id' AND siteid='$siteid' ");
	gourl();
}
?>