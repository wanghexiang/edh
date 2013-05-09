<?php

check_login();
$a=$_REQUEST['a'];
if(empty($a))
{
	$a='index';	
}
checkpermission("art_cat",$a);
if($a=='index')
{
	$sql="select * from ".table('art_cat')." where pid=0    order by orderid asc ";
	$res=$db->query($sql);
	$catlist=array();
	while($rs=@$db->fetch_array($res))
	{
		$rs['child']=$db->getAll("select * from ".table('art_cat')." where pid=".$rs['catid']."   order by orderid asc");
		$catlist[$rs['catid']]=$rs;
		
	}
	$smarty->assign("catlist",$catlist);
	$smarty->display("art_cat.html");  
}elseif($a=='add') 
{
	$plist=$db->getAll("select catid,cname from ".table('art_cat')." where pid=0  ");
	$smarty->assign("plist",$plist);
	$catid=intval($_GET['catid']);
	if($catid)
	{
	$rs=$db->getRow("select * from ".table('art_cat')." where catid='$catid'   ");
	if($rs['pid'])
	{
		$rs['pname']=$db->getOne("select cname from ".table('art_cat')." where catid=".$rs['pid']." ");
	}
	$smarty->assign("cat",$rs);
	}
	$smarty->display("art_cat_add.html");
}elseif($a=='add_db')
{
	$catid=intval($_POST['catid']);
	$pid=intval($_POST['pid']);
	$cname=$_POST['cname'];
	$keyword=$_POST['keyword'];
	$info=$_POST['info'];
	$cattpl=$_POST['cattpl'];
	$listtpl=$_POST['listtpl'];
	$contpl=$_POST['contpl'];
	$t=intval($_POST['t']);
	//如果是编辑
	if($catid)
	{
		$db->query("update ".table('art_cat')." set pid='$pid',cname='$cname',keyword='$keyword',info='$info',cattpl='$cattpl',listtpl='$listtpl',contpl='$contpl',t='$t' where catid='$catid' ");
	}else
	{//如果是添加
		if ($pid)
		{
			$ps=$db->getRow("SELECT listtpl,contpl FROM ".table('art_cat')." WHERE catid='$pid' ");
			$listtpl=$listtpl?$listtpl:$ps['listtpl'];
			$contpl=$contpl?$contpl:$ps['contpl'];
		}else
		{
			$cattpl=$cattpl?$cattpl:"art_cat.html";
			$listtpl=$listtpl?$listtpl:"art_list.html";
			$contpl=$contpl?$contpl:"art.html";
			
		}
		$sql="insert into ".table('art_cat')." set pid='$pid',cname='$cname',keyword='$keyword',info='$info',cattpl='$cattpl',listtpl='$listtpl',contpl='$contpl',t='$t',siteid='$siteid' ";
		$db->query($sql);
	}
	gourl("admin.php?m=art_cat");
	
}elseif($a=='order')
{
	$idarr=$_POST['catid'];
	$orderid=$_POST['orderid'];
	foreach($idarr as $key=>$val)
	{
		$o=intval($orderid[$key]);
		$db->query("update ".table('art_cat')." set orderid=".$o." where catid='$val' ");
	}
	gourl();
}elseif($a=='del')
{
	$catid=intval($_GET['catid']);
	$ct=$db->getOne("select count(*) from ".table('art_cat')." where pid='$catid' ");
	if($ct>0) errback('该分类下还有子分类,请先删除！');
	$db->query("delete from ".table('art_cat')." where catid='$catid' ");
	//删除分类下的文章
	//$db->query("delete from ".table('art')." where catid='$catid' ");
	gourl();
}elseif($a=='getcat')
{
	header("Content-type:text/html;charset=gb2312");
	$pid=intval($_POST['pid']);
	$op="<option>请选择分类</option>";
	if($pid)
	{
	$catlist=$db->getAll("select catid,cname from ".table('art_cat')." where pid='$pid' ");
	foreach($catlist as $t)
	{
	$op.="<option value=\"".$t['catid']."\">".$t['cname']."</option>";	
	}
	}
	echo $op;
}