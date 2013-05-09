<?php

check_login();
$a=$_REQUEST['a'];
if(empty($a))
{
	$a='index';	
}

if($a=='index')
{
	$catid=intval($_GET['catid']);
	$sql="select * from ".table('html')." where 1=1 " ;
	$sql.=$catid?" and catid='$catid' ":"";
	$sql2="select count(*) from ".table('html')." ";
	$sql2.=$catid?" and catid='$catid' ":"";
	$sql.=" order by orderid asc";
	//开始分页
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//结束
	$rsarr=array();
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		if($rs['isnav']==0)
		{
			$rs['isnav']="<a href='web_admin.php?m=html&a=isnav&id={$rs['id']}'><img src='images/no.gif'></a>";
		}else
		{
			$rs['isnav']="<a href='web_admin.php?m=html&a=noisnav&id={$rs['id']}'><img src='images/yes.gif'></a>";
		}
		$rsarr[$rs['id']]=$rs;
	}
	
	$smarty->assign("htmllist",$rsarr);
	$smarty->display("html.html");
}elseif($a=='add')
{
	
	$id=intval($_GET['id']);
	if($id)
	{
		$rs=$db->getRow("select h.*,c.cname from ".table('html')." as h left join ".table('html_cat')." as c on h.catid=c.catid  where  id='$id' ");
	}
	$smarty->assign("rs",$rs);
	$smarty->assign("tag_t",'{$html_标签}');
	$smarty->assign("catlist",$db->getAll("select catid,cname from ".table('html_cat')." order by orderid asc  "));
	$smarty->display("html_add.html");
	
}elseif($a=='add_db')
{
	$title=trim($_POST['title']);
	$tagname=trim($_POST['tagname']);
	$keyword=$_POST['keyword'];
	$des=trim($_POST['des']);
	$content=trim($_POST['content']);
	$id=intval($_POST['id']);
	$catid=intval($_POST['catid']);
	$isnav=intval($_POST['isnav']);
	if($id)
	{
		$sql="update ".table('html')." set catid='$catid',title='$title',tagname='$tagname',keyword='$keyword',des='$des',content='$content',isnav='$isnav' where id='$id' ";
	}else
	{
		$ct=$db->getOne("select count(*) from ".table('html')." where tagname='$tagname' ");
		if($ct>0)
		{
			$tagname .=$ct;
		}
		$sql="insert into ".table('html')."(catid,title,tagname,keyword,des,content,isnav) values('$catid','$title','$tagname','$keyword','$des','$content','$isnav') ";
	}

	$db->query($sql);
	
	gourl();
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$tagname=$db->getOne("select tagname from ".table('html')." where id='$id' ");
	$db->query("delete from ".table('html')." where id='$id' ");

	gourl();
}elseif($a=='order')
{
	$idarr=$_POST['id'];
	$orderarr=$_POST['orderid'];
	foreach($idarr as $key=>$val)
	{
		$db->query("update ".table('html')."  set orderid=".$orderarr[$key]." where id='$val' ");
	}
	gourl();
}elseif($a=='cat')
{
	$smarty->assign("catlist",$db->getAll("select * from ".table('html_cat')." order by orderid asc "));
	$smarty->display("html_cat.html");
	
}elseif($a=='catadd_db')
{
	$cname=trim(strip_tags($_POST['cname']));
	$catid=intval($_POST['catid']);
	$orderid=intval($_POST['orderid']);
	if($catid)
	{
	$db->query("update ".table('html_cat')." set orderid='$orderid',cname='$cname' where catid='$catid' ");
	}else
	{
		$db->query("insert into ".table('html_cat')." set orderid='$orderid',cname='$cname' ");
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	
}elseif($a=='catdel')
{
	$catid=intval($_GET['catid']);
	$db->query("delete from ".table('html_cat')." where catid='$catid' ");
	header("Location: ".$_SERVER['HTTP_REFERER']);
}elseif($a=='isnav')
{
	$id=intval($_GET['id']);
	$db->query("update ".table('html')." set isnav=1 where id='$id' ");
	gourl();
}elseif($a=='noisnav')
{
	$id=intval($_GET['id']);
	$db->query("update ".table('html')." set isnav=0 where id='$id' ");
	gourl();
}
?>