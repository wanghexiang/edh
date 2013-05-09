<?php

check_login();
$a=trim($_GET['a']?$_GET['a']:$_POST['a']);
if(empty($a))
{
	$a='index';	
}
checkpermission("canwei",$a);
if($a=='index')
{ 
	$sql="select * from ".table('room')." order by room_men desc, id desc ";
	$sql2="select count(*) from ".table('room')." ";
	//开始分页
	$rscount=$db->getOne($sql2);
	$pagesize=30;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,"admin.php?m=canwei&");
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//结束分野
	$res=$db->query($sql);
	$roomlist=array();
	while($rs=@$db->fetch_array($res))
	{
		$roomlist[$rs['id']]=$rs;
	}
	$smarty->assign("roomlist",$roomlist);
	$smarty->display("canwei.html");
}
elseif($a=='add')
{
	$id=intval($_GET['id']);
	
	if($id)
	{
	$rs=$db->getRow("select * from ".table("room")."  where id='$id'");
	}
	
	$smarty->assign("rs",$rs);
	$smarty->display("canwei_add.html");
}elseif($a=='add_db')
{
	$room=$_POST['room'];
	ckempty($room,"房间名称不能够为空");
	$room_men=intval($_POST['room_men']);
	$room_pic=$_POST['room_pic'];
	$room_desc=$_POST['room_desc'];
	$room_content=$_POST['room_content'];
	$id=intval($_POST['id']);
	if($id)
	{
		$sql="update ".table('room')." set room='$room',room_men='$room_men',room_pic='$room_pic',room_desc='$room_desc', ".
			" room_content='$room_content' where id='$id' ";
		$db->query($sql);
		
	}else
	{
		$sql="insert into ".table('room')."(room,room_men,room_pic,room_desc,room_content) ".
			" values('$room','$room_men','$room_pic','$room_desc','$room_content')";
		$db->query($sql);
	}
	
	gourl();
	
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table("room")." where id='$id' ");
	gourl();
	
}elseif($a=='dotype')
{
	$id=intval($_GET['id']);
	$room_type=intval($_GET['room_type']);
	$db->query("update ".table('room')." set room_type='$room_type' where id='$id' ");
}elseif($a=='order')
{
	$pagesize=30;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$w='';
	$url="admin.php?m=canwei&a=order&t=".$_GET['t'];
	$w=isset($_GET['t'])?" AND status=".intval($_GET['t'])." ":" ";
	$rscount=$db->getOne("SELECT count(*) FROM ".table('roomorder')." WHERE 1=1 $w  ");
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$orderlist=$db->getAll("select * from ".table('roomorder')." WHERE 1=1 $w  order by id DESC limit $start,$pagesize ");
	$smarty->assign("orderlist",$orderlist);
	$smarty->assign("pagelist",$pagelist);
	
	$smarty->display("canwei_order.html");
}elseif($a=='orderstatus')
{
	$status=intval($_GET['status']);
	$id=intval($_GET['id']);
	$db->query("update ".table('roomorder')." set status='$status' where id='$id' ");
	header("Location:".$_SERVER['HTTP_REFERER']);
}elseif($a=='orderreply')
{
	$id=intval($_POST['id']);
	$content=htmlspecialchars($_POST['content']);
	$db->query("update ".table('roomorder')." set reply='$content' where id='$id' ");
	
}elseif($a=='orderdel')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('roomorder')." where id='$id' ");
	header("Location:".$_SERVER['HTTP_REFERER']);
	
}elseif($a=='getorderreply')
{
	$id=intval($_GET['id']);
	header("Content-type:text/html;charset=gb2312");
	
	echo $db->getOne("SELECT reply FROM ".table('roomorder')."  WHERE id='$id' LIMIT 1 ");
}
?>