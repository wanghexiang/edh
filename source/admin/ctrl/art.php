<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a="index";	
}
checkpermission("art",$a);
if($a=="index")
{
	$url="admin.php?m=art&".$_SERVER['QUERY_STRING'];
	$catlist=$db->getAll("select catid,cname from ".table('art_cat')." where pid=0 ");
	$smarty->assign("catlist",$catlist);
	//开始处理数据
	$cat1=intval($_GET['cat1']);
	$cat2=intval($_GET['cat2']);
	$title=$_GET['title'];
	$isding=intval($_GET['isding']);
	$isnew=intval($_GET['isnew']);
	$ishot=intval($_GET['ishot']);
	$sql="select a.*,c.cname from ".table('art')." as a left join ".table('art_cat')." as  c on a.catid=c.catid where  a.siteid='$siteid'  ";
	$sql2="select count(*) from ".table('art')." where siteid='$siteid' ";
	if($cat2)
	{
		$sql.=" and a.catid='$cat2' ";
		$sql2.=" and catid='$cat2' ";
		$smarty->assign("cat2",$db->getRow("select catid,cname from ".table('art_cat')." where catid='$cat2' "));
		$smarty->assign("cat1",$db->getRow("select catid,cname from ".table('art_cat')." where catid=(select pid from ".table('art_cat')." where catid= '$cat2') "));
		
	}elseif($cat1)
	{
		$sql.=" and (a.catid in(select catid from ".table('art_cat')." where pid='$cat1') or a.catid='$cat1')";
		$sql2.="and  (catid in(select catid from ".table('art_cat')." where pid='$cat1' ) or a.catid='$cat1') ";
		$smarty->assign("cat1",$db->getRow("select catid,cname from ".table('art_cat')." where catid='$cat1' "));
	}
	if($isnew)
	{
		$sql.=" and a.isnew =1 ";
		$sql2.=" and isnew=1 ";
		$smarty->assign("isnew",1);
	}
	if($ishot)
	{
		$sql.=" and a.ishot=1 ";
		$sql2.=" and ishot=1 ";
		$smarty->assign("ishot",$ishot);
	}
	if($isding)
	{
	$smarty->assign("isding",$isding);
	$sql.=" and a.isding=1 ";
	$sql2.=" and isding=1";
	}
	
	
	if($title)
	{
		$sql .=" and a.title like '%".$title."%' ";
		$sql2.=" and title like '%".$title."%' ";
		$smarty->assign("art_title",$title);
	}
	$sql.=" order by a.id desc ";
	//开始分页
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,$url));

	//结束分页
	$rsarr=array();
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		$rsarr[$rs['id']]=$rs;	
	}
	
	
	$smarty->assign("artlist",$rsarr);
	$smarty->display("art.html");
}elseif($a=="add")
{
	//获取文章分类
	$catlist=$db->getAll("select catid,cname from ".table('art_cat')." where pid=0    ");
	$id=intval($_GET['id']);

	if($id)
	{
		$rs=$db->getRow("select a.*,d.content,c.cname,c.pid from ".table('art')." as a LEFT JOIN ".table('art_data')." d ON a.id=d.id  left join ".table('art_cat')." as c on a.catid=c.catid  where a.id='$id' ");
		
		if($rs['pid']>0)
		{
			$rs['pname']=$db->getOne("select cname from ".table('art_cat')." where catid=".$rs['pid']." ");
		}
		$smarty->assign("art",$rs);
		
	
	}

	$smarty->assign("catlist",$catlist);
	$smarty->display("art_add.html");
}elseif($a=="add_db")
{
	$title=$_POST['title'];
	ckempty($title,"标题必写");
	$cat1=intval($_POST['cat1']);
	
	$cat2=intval($_POST['cat2']);
	$catid=$cat2?$cat2:$cat1;
	ckempty($catid,"分类必选");
	$keyword=trim($_POST['keyword']);
	$des=$_POST['des'];
	$content=trim($_POST['content']);
	$id=intval($_POST['id']);
	$userid=intval($_SESSION['ssuser']['userid']);
	$isding=intval($_POST['isding']);
	$isnew=intval($_POST['isnew']);
	$ishot=intval($_POST['ishot']);
	if($id)
	{
		$sql="update ".table('art')." set title='$title',catid='$catid',keyword='$keyword',des='$des',isding='$isding',isnew='$isnew',ishot='$ishot' where id='$id' ";
		$db->query($sql);
		$db->query("UPDATE ".table('art_data')." SET  content='$content' WHERE id='$id' " );
	}else
	{
		$dateline=strtotime(date("y-m-d H:i:s"));
		$sql="insert into ".table('art')."(title,catid,keyword,des,dateline,userid,isnew,isding,ishot,siteid)  ".
			" values('$title','$catid','$keyword','$des','$dateline','$userid','$isnew','$isding','$ishot','$siteid')";
		$db->query($sql);
		$id=$db->insert_id();
		$db->query("INSERT INTO ".table('art_data')." SET id='$id',content='$content' " );	
	}
	
	gourl();
}elseif($a=="del")
{
	$idarr=$_POST['id'];
	foreach($idarr as $t)
	{
	$db->query("delete from ".table('art')." where id='$t'  AND siteid='$siteid' ");
	}
	gourl();
}elseif($a=='isnew')
{
	$id=intval($_GET['id']);
	$t=intval($_GET['t']);
	$db->query("update ".table('art')." set isnew='$t' where id='$id'  AND siteid='$siteid' ");
	
}elseif($a=='isding')
{
	$id=intval($_GET['id']);
	$t=intval($_GET['t']);
	$db->query("update ".table('art')." set isding='$t' where id='$id'  AND siteid='$siteid' ");
}elseif($a=='ishot')
{
	$id=intval($_GET['id']);
	$t=intval($_GET['t']);
	$db->query("update ".table('art')." set ishot='$t' where id='$id'  AND siteid='$siteid' ");
	
}elseif($a=='istop')
{
	$id=intval($_GET['id']);
	$t=$_GET['t']?time():0;
	$db->query("update ".table('art')." set istop='$t' where id='$id'  AND siteid='$siteid' ");
}
?>