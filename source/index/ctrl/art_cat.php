<?php

$catid=intval($_GET['catid']);
//获取分类信息
$catrs=$db->getRow("select * from ".table('art_cat')." where catid='$catid'  ");
if($catrs && $catrs['t']==0)
{
	gourl("index.php?m=art_list&catid=$catid");
}

//文章分类
$artcat=art_cat($catid);
$smarty->assign("artcat",$artcat);
//文章分类结束

//选择下级分类及文章
$lists=array();
$res=$db->query("SELECT catid,cname FROM ".table('art_cat')." WHERE   pid='$catid'   ");

while($rs=$db->fetch_array($res))
{
	
	if($catid)
	{
		$rs['arts']=$db->getAll("SELECT a.title,a.id,a.dateline,a.catid,c.cname FROM ".table('art')." a LEFT JOIN ".table('art_cat')." c ON a.catid=c.catid   WHERE a.catid=".$rs['catid']." AND siteid='$cksiteid' ORDER BY id DESC LIMIT 10 ");
	}else
	{
		$catids=$db->getCols("SELECT catid FROM ".table('art_cat')." WHERE pid=".$rs['catid']."   ");
		$catids[]=$rs['catid'];
		$rs['arts']= $db->getAll("SELECT a.title,a.id,a.catid,a.dateline,c.cname FROM ".table('art')." a LEFT JOIN ".table('art_cat')." c ON a.catid=c.catid WHERE a.catid in("._implode($catids).") AND  a.siteid='$cksiteid' ORDER BY id DESC LIMIT 10  "); 
		
	}
	$lists[]=$rs;
}

$smarty->assign("artlist",$lists);


//获取最新文章
$w=" AND siteid='$cksiteid' ";
$artnew=artlist(" {$w} and isnew=1 "," order by istop desc,id desc ",0,10);
$smarty->assign("artnew",$artnew);
//获取最热文章
$arthot=artlist(" {$w} and ishot=1 "," order by istop desc,click desc ",0,10);
$smarty->assign("arthot",$arthot);
//推荐文章
$artding=artlist(" {$w} and isding=1 "," order by istop desc,id desc ",0,10);
$smarty->assign("artding",$artding);

//当前位置
$where="<a href=\"index.php\">网站首页</a>";
if($catid)
{
if($childid)
{
	
	$where .=" > ".$catrs['cname'] ." > 文章列表";
}else
{
	$ps=$db->getRow("select catid,cname from ".table('art_cat')." where id=(select pid from ".table('art_cat')." where catid='$catid' ) ");
	if($ps)
	{
	$where .=" > <a href=\"index.php?m=art_cat&catid=".$ps['catid']."\">".$ps['cname']."</a>";
	}
	$where .=" > ".$catrs['cname']." > 文章列表";	
}
}else
{
	$where .=" > 文章栏目";	
}
$smarty->assign("where",$where);
//seo选项
$seo["title"]=$catrs['cname']?$catrs['cname']:$seo["title"];
$seo["keywords"]=$catrs['keyword']?$catrs['keyword']:$seo["keywords"];
$seo["description"]=$catrs['des']?$catrs['des']:$seo["description"];
$smarty->assign("seo",$seo);
//seo选项结束
if(!$catrs)
{
	$smarty->display("art_cat.html");
	
}else
{
	
	$smarty->assign("catrs",$catrs);
	if($catrs['cattpl'])
	{
		$smarty->display($catrs['cattpl']);		
	}else
	{
		$smarty->display("art_cat.html");	
	}
	
}





?>