<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
$a='index';	
}
checkpermission("nav",$a);

if($a=='index')
{

	$sql="select * from ".table('nav')." where pid=0 order  by orderid asc ";
	$sql2="select count(*) from ".table('nav')." where pid=0 ";
	//开始分页
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//结束
	$res=$db->query($sql);
	$navlist=array();
	while($rs=@$db->fetch_array($res))
	{
		$rs['pname']="顶级导航";
		$rs['child']=$db->getAll("select * from ".table('nav')." where pid=".$rs['id']);
		$navlist[$rs['id']]=$rs;
		
	}
	$smarty->assign("navlist",$navlist);
	$smarty->display("nav.html");
}elseif($a=='add')
{
	$plist=$db->getAll("select id,title from ".table('nav')." where pid=0 ");
	$smarty->assign("plist",$plist);
	$id=intval($_GET['id']);
	if($id)
	{
	$rs=$db->getRow("select id,pid,title,navurl,ctype from ".table('nav')." where id='$id' ");
	if($rs['pid'])
	{
		$rs['pname']=$db->getOne("select title from ".table('nav')." where id=".$rs['pid']." ");
	}
	$smarty->assign("nav",$rs);
	}
	$smarty->display("nav_add.html");
}elseif($a=='add_db')
{
	$id=intval($_POST['id']);
	$pid=intval($_POST['pid']);
	$title=$_POST['title'];
	$navurl=trim($_POST['navurl']);
	$ctype=intval($_POST['ctype']);

	//如果是编辑
	if($id)
	{
		$db->query("update ".table('nav')." set pid='$pid',title='$title',navurl='$navurl',ctype='$ctype' where id='$id' ");
	}else
	{//如果是添加
		$sql="insert into ".table('nav')."(pid,title,navurl,ctype) values('$pid','$title','$navurl','ctype')";
		
		$db->query($sql);
	}
	delsqlcache("nav.sql");
	gourl("admin.php?m=web_nav&");
	
}elseif($a=='order')
{
	$idarr=$_POST['id'];
	$orderid=$_POST['orderid'];
	
	foreach($idarr as $key=>$val)
	{
		$o=intval($orderid[$key]);
		$db->query("update ".table('nav')." set orderid=".$o." where id='$val' ");
	}
	delsqlcache("nav.sql");
	gourl();
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('nav')." where id='$id' ");
	delsqlcache("nav.sql");
	gourl();
}elseif($a=='getnav')
{
	header("Content-type:text/html;charset=gb2312");
	$pid=intval($_POST['pid']);
	$op="<option>请选择导航</option>";
	if($pid)
	{
	$navlist=$db->getAll("select id,title from ".table('nav')." where pid='$pid' ");
	foreach($navlist as $t)
	{
	$op.="<option value=\"".$t['id']."\">".$t['title']."</option>";	
	}
	}
	echo $op;
}