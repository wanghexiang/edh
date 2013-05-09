<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a='index';	
}
checkpermission("guest",$a);
if($a=='index')
{
	$status=$_GET['status']=intval($_GET['status']);
	$sql="select * from ".table('guest')."   WHERE  status='$status' AND siteid='$siteid' order by  id desc ";
	$sql2="select count(1) from ".table('guest')." WHERE status='$status'  AND siteid='$siteid'  ";
	//开始分页
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page2)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,"admin.php?m=guest&status=$status");
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//分页结束
	$glist=array();
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		if($rs['userid']==0)
		{
			$rs['username']="游客";
		}
		$glist[$rs['id']]=$rs;				
	}
	
	$smarty->assign("glist",$glist);
	$smarty->display("guest.html");
}elseif($a=='reply')
{
	$id=intval($_GET['id']);
	$rs=$db->getRow("select * from ".table('guest')." where id='$id'");
	$smarty->assign("guest",$rs);
	$smarty->display("guest_reply.html");
	
}elseif($a=='reply_db')
{
	$id=intval($_POST['id']);
	$reply=$_POST['reply'];
	$db->query("update ".table('guest')." set reply='$reply' where id='$id' ");
	gourl();
	
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('guest')." where id='$id' ");
	gourl();
}elseif($a=='status')
{
	$id=intval($_GET['id']);
	$status=intval($_GET['status']);
	$db->query("update ".table('guest')." set status='$status' where id='$id' ");
	gourl();
}
?>