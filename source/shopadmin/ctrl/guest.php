<?php

check_login();
$a=$_GET['a']=isset($_GET['a'])?htmlspecialchars($_GET['a']):'index';
$shopid=$_SESSION['adminshop']['shopid'];
if($a=='index')
{
	$status=isset($_GET['status'])?intval($_GET['status']):0;
	$sql="select * from ".table('guest')."   WHERE  shopid='$shopid' AND status='$status' order by id desc ";
	$sql2="select count(*) from ".table('guest')."   WHERE shopid='$shopid' AND status='$status' ";
	//��ʼ��ҳ
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=isset($_GET['page'])?max(1,intval($_GET['page'])):1;
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,'shopadmin.php?m=guest&status=$status');
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//��ҳ����
	$glist=array();
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		$glist[$rs['id']]=$rs;
		if($rs['userid']==0)
		{
			$glist[$rs['id']]['username']="�ο�";
		}
		if($rs['status']==0)
		{
			$glist[$rs['id']]['dotype']="<a href=\"shopadmin.php?m=guest&a=dotype&id=".$rs['id']."&status=1\">���</a> &nbsp;&nbsp;<a href=\"shopadmin.php?m=guest&a=dotype&id=".$rs['id']."&status=2\">��ֹ</a> ";
		}elseif($rs['status']==1)
		{
			$glist[$rs['id']]['dotype']="<a href=\"shopadmin.php?m=guest&a=dotype&id=".$rs['id']."&status=2\">��ֹ</a> ";
		}else
		{
			$glist[$rs['id']]['dotype']="<a href=\"shopadmin.php?m=guest&a=dotype&id=".$rs['id']."&status=1\">���</a>";
		}
	
	}
	
	$smarty->assign("glist",$glist);
	$smarty->display("guest.html");
}elseif($a=='reply')
{
	$id=intval($_GET['id']);
	$rs=$db->getRow("select * from ".table('guest')." where id='$id' AND shopid='$shopid' ");
	$smarty->assign("guest",$rs);
	$smarty->display("guest_reply.html");
	
}elseif($a=='reply_db')
{
	$id=intval($_POST['id']);
	$reply=$_POST['reply'];
	$db->query("update ".table('guest')." set reply='$reply' where id='$id'  AND shopid='$shopid'  ");
	gourl();
	
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('guest')." where id='$id'  AND shopid='$shopid'   ");
	gourl();
}elseif($a=='dotype')
{
	$id=intval($_GET['id']);
	$status=intval($_GET['status']);
	$db->query("update ".table('guest')." set status='$status' where id='$id'  AND shopid='$shopid'  ");
	gourl();	
}
?>