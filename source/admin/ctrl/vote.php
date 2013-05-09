<?php
if(!defined("CT"))
{
	die('is wrong');
}

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];

if(empty($a))
{
	$a='index';	
}

if($a=='index')
{
$arr=array();
$sql= "select * from ".table('vote')." where 1=1  ";
$sql2="select count(*) from ".table('vote')." where 1=1  ";
$title=strip_tags($_GET['title']);
$url="admin.php?m=vote&";
if($title)
{
$sql.= " and title like '%{$title}%' ";
$sql2.="  and title like '%{$title}%' ";
$smarty->assign("title",$title);
$url.="?title={$title}";
}
$rscount=$db->getOne($sql2);
$pagesize=10;

$page=max(1,intval($_GET['page']));
$start=($page-1)*$pagesize;
$multipage=multipage($rscount,$pagesize,$page,$url);
$sql.=" order by vid desc ";
$sql.=" limit $start,$pagesize ";
$smarty->assign("pagelist",$pagelist);
$res=$db->query($sql);
$arr=array();
while($rs=$db->fetch_array($res))
{
	$rs['dateline']=date("Y-m-d",$rs['dateline']);
	$arr[$rs['vid']]=$rs;	
}
$smarty->assign("votelist",$arr);
$smarty->display("vote.html");	
}elseif($a=='add')
{
	if($_POST)
	{
		$vid=intval($_POST['vid']);
		$title=trim($_POST['title']);
		ckempty($title,"投票名称不能为空");
		$detail=trim($_POST['detail']);
		$logo=trim($_POST['logo']);
		$vtype=intval($_POST['vtype']);
		$isding=intval($_POST['isding']);
		$showtype=intval($_POST['showtype']);
		$mustlogin=intval($_POST['mustlogin']);
		if($vid)
		{
		$db->query("update ".table('vote')." set title='$title',detail='$detail',logo='$logo',vtype='$vtype',isding='$isding',showtype='$showtype',mustlogin='$mustlogin' where vid='$vid' ");
		}else
		{
			$dateline=strtotime(date("Y-m-d H:i:s"));
			$db->query("insert into  ".table('vote')." set  title='$title',detail='$detail',logo='$logo',vtype='$vtype',dateline='$dateline',isding='$isding',showtype='$showtype',mustlogin='$mustlogin' ");
		}
		gourl("admin.php?m=vote&");
	}else
	{
		if(!empty($_GET['vid']))
		{
		$smarty->assign("vote",$db->getRow("select * from ".table('vote')." where vid='$vid' "));
		}
		$smarty->display("vote_add.html");
	}
}elseif($a=='tt')
{
	if($_POST)
	{
		
		$tarr=$_POST['title'];
		$uarr=$_POST['url'];
		if(is_array($tarr))
		{
		foreach($tarr as $key=>$val)
		{
			$db->query("update ".table('vote_tt')."  set title='$val',url='".$uarr[$key]."' where tid='$key' ");	
		}
		}
	
		
		gourl();
	}else
	{
	$arr=array();
	
	$sql="select * from ".table('vote_tt')." where 1=1 ";
	$sql2="select count(*) from ".table("vote_tt")." where 1=1  ";
	$url="admin.php?m=vote&a=tt";
	$title=trim($_GET['title']);
	$catid=intval($_GET['catid']);
	$vid=isset($_GET['vid'])?intval($_GET['vid']):0;
	
	$smarty->assign("vote",$db->getRow("select * from ".table('vote')." where vid='$vid' "));
	if($title)
	{
		$sql.=" and title like '%{$title}%' ";	
		$sql2.=" and title like '%{$title}%' ";	
		$url.="&title={$title}";
		$smarty->assign("title",$title);
	}
	if($catid)
	{
		$sql.=" and catid='$catid' ";
		$sql2.=" and catid='$catid' ";	
		$url.="&catid={$catid}";
		$smarty->assign("cat",$db->getRow("select * from ".table('vote_ttcat')." where catid='$catid' "));
	}
	$url.=$vid?"&vid={$vid}":"";
	$page=intval($page);
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$sql.=" order by tid desc limit $start,$pagesize ";
	$votelist=$db->getAll($sql);
	$smarty->assign("pagesize",$pagelist);
	$smarty->assign("votelist",$votelist);
	$smarty->assign("catlist",$db->getAll("select * from ".table('vote_ttcat')." "));
	$smarty->display("vote_tt.html");
	}
}elseif($a=='del')
{
	$vid=intval($_GET['vid']);
	$db->query("delete from ".table('vote')." where vid='$vid' ");
		//删除相关选项
	$db->query("delete from ".table('vote_sele')." where vid='$vid' ");
	gourl();
}elseif($a=='ttadd')
{
	$smarty->assign("catlist",$db->getAll("select * from ".table('vote_ttcat')." "));
	if($_POST)
	{
		
		$title=trim($_POST['title']);
		$img=trim($_POST['img']);
		$url=trim($_POST['url']);
		$catid=intval($_POST['catid']);
		$tid=intval($_POST['tid']);
		if($tid)
		{
			$db->query("update ".table('vote_tt')." set title='$title',img='$img',url='$url',catid='$catid' where tid='$tid' ");
		}else
		{
		$db->query("insert into ".table('vote_tt')." set title='$title',img='$img',url='$url',catid='$catid' ");
		}
		gourl();
		
	}else{
	$tid=$_GET['tid'];
	if($tid)
	{
		$smarty->assign("vt",$db->getRow("select vt.*,c.cname from ".table('vote_tt')." as vt left join ".table('vote_ttcat')." as c on vt.catid=c.catid  where tid='$tid' "));
	}
	$smarty->display("vote_ttadd.html");
	}
}elseif($a=='ttdel')
{
	$tid=$db->query("delete from ".table('vote_tt')." where tid='$tid' ");
	//删除与该选项有关的
	$db->query("delete from ".table('vote_sele')." where tid='$tid' ");
	gourl();
}elseif($a=='ttcat')
{
	if($_POST)
	{
		$carr=$_POST['cname'];
		foreach($carr as $key=>$val )
		{
			$db->query("update ".table('vote_ttcat')." set cname='$val' where catid='$key' ");
		}
		gourl();
	}
	$smarty->assign("catlist",$db->getAll("select * from ".table('vote_ttcat')." "));
	$smarty->display("vote_ttcat.html");
}elseif($a=='ttcat_add')
{
	$cname=strip_tags(trim($_POST['cname']));
	$db->query("insert into ".table('vote_ttcat')." set cname='$cname' ");
	gourl();
}elseif($a=='ttcat_del')
{
	$catid=intval($_GET['catid']);
	$db->query("delete from ".table('vote_ttcat')." where catid='$catid' ");
	gourl();
}
elseif($a=='selett')
{//投票选项管理
	if($_POST)
	{
		$orderid=$_POST['orderid'];
		foreach($orderid as $key=>$val)
		{
			$db->query("update ".table('vote_sele')." set orderid='$val' where sid='$key' ");	
		}
		gourl();
	}else
	{
	$vid=intval($_GET['vid']);
	$smarty->assign("vote",$vote=$db->getRow("select * from ".table('vote')." where vid='$vid' "));
	$smarty->assign("selelist",$db->getAll("select s.*,t.title from ".table('vote_sele')." as s left join ".table('vote_tt')." as t on s.tid=t.tid where s.vid=".$vote['vid']." "));
	$smarty->display("vote_selett.html");
	}
}elseif($a=='tt2vote')
{
	$tid=$_POST['tid'];
	$vid=intval($_POST['vid']);
	foreach($tid as $key=>$val)
	{
		if(!$db->getOne("select count(*) from ".table('vote_sele')." where tid=".intval($key)." and vid='$vid'  "))
		{
			
		$db->query("insert into ".table('vote_sele')." set tid=".intval($key).",vid='$vid' ");
		}
			
	}
	gourl();
}elseif($a=="seledel")
{
	$sid=intval($_GET['sid']);
	$db->query("delete from ".table('vote_sele')." where sid='$sid' ");
	gourl();	
}




?>