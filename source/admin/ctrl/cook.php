<?php
if(!defined("CT"))
{
	die('is wrong');
}

check_login();
$a=isset($_GET['a'])?htmlspecialchars($_GET['a']):htmlspecialchars($_POST['a']);
if(empty($a))
{
	$a='index';
}
checkpermission("cook",$a);
if($a=='index')
{
	$nickname=isset($_GET['nickname'])?htmlspecialchars($_GET['nickname']):htmlspecialchars($_POST['nickname']);
	$sql="select cookid,nickname,isding from ".table('cook')." ";
	$sql.=$nickname?" where nickname like '%{$nickname}%'":"";
	$smarty->assign("cooklist",$db->getAll($sql));
	$smarty->display("cook.html");
}elseif($a=='add')
{
	$cookid=intval($_GET['cookid']);
	
	if($cookid)
	{
	$rs=$db->getRow("select * from ".table('cook')." where cookid='$cookid' ");	
	$smarty->assign("cook",$rs);
	}

	$smarty->display("cook_add.html");
	
}elseif($a=='post')
{
	$cookid=intval($_POST['cookid']);
	$nickname=htmlspecialchars(trim($_POST['nickname']));
	$weibo=htmlspecialchars(trim($_POST['weibo']));
	$pic=htmlspecialchars(trim($_POST['pic']));
	$info=htmlspecialchars(trim($_POST['info']));
	$url=htmlspecialchars(trim($_POST['url']));
	$content=trim($_POST['content']);
	if($cookid)
	{
		$sql="update ".table('cook')." set nickname='$nickname',weibo='$weibo',pic='$pic',info='$info',url='$url',content='$content' where cookid='$cookid' ";
		$db->query($sql);
		errback("厨师编辑成功");
	}else
	{
		$sql="insert  into ".table('cook')." set nickname='$nickname',weibo='$weibo',pic='$pic',info='$info',url='$url',content='$content'  ";
		$db->query($sql);
		errback("厨师添加成功");
	}
	
	
}elseif($a=='ding')
{
	$cookid=intval($_GET['cookid']);
	$isding=intval($_GET['isding']);
	$db->query("update ".table('cook')." set isding='$isding' where cookid='$cookid' ");
	gourl();
}elseif($a=='del')
{
	$cookid=intval($_GET['cookid']);
	$db->query("delete from ".table('cook')." where cookid='$cookid' ");
	gourl();
}elseif($a=='cai')
{
	$cookid=isset($_GET['cookid'])?intval($_GET['cookid']):0;
	if(!$cookid)
	{
		errback('请选择厨师');
	}
	$smarty->assign("cookid",$cookid);
	$sql="select cc.*,c.title from ".table('cook_cai')." cc  "
		." left join ".table('cai')." c on cc.caiid=c.id where cc.cookid='$cookid' ";
	$smarty->assign("cailist",$db->getAll($sql));
	$smarty->display("cook_cai.html");
	
}elseif($a=='caidel')
{
	$id=isset($_GET['id'])?intval($_GET['id']):0;
	$db->query("delete from ".table('cook_cai')." where id='$id' ");
	gourl();
}elseif($a=='cailist')
{
	$cailist=array();
	$cookid=isset($_GET['cookid'])?intval($_GET['cookid']):0;
	if(!$cookid)
	{
		errback('请选择厨师');
	}
	$smarty->assign("cookid",$cookid);
	$idarr=$db->getCols("select caiid from ".table('cook_cai')." where cookid='$cookid' ");
	$sql="select id,title from ".table('cai')."  ";
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		if(!in_array($rs['id'],$idarr))
		{
			$cailist[]=$rs;
		}
	}
	$smarty->assign("cailist",$cailist);
	$smarty->display("cook_cailist.html");
}elseif($a=='addcai')
{
	$caiid==$_POST['caiid'];
	$cookid=isset($_POST['cookid'])?intval($_POST['cookid']):0;
	if(!$cookid)
	{
		errback('请选择厨师');
	}

	if(is_array($caiid))
	{
		foreach($caiid as $c)
		{
			if($c)
			{
				$db->query("insert into ".table('cook_cai')." set cookid='$cookid',caiid='$c' ");
			}
		}
	}
	gourl("admin.php?m=cook&a=cai&cookid={$cookid}");
}
?>