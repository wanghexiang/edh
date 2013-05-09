<?php
$catid=intval($_GET['catid']);
//获取分类信息
$catrs=$db->getRow("select * from ".table('art_cat')." where catid='$catid' ");

if(!$catrs or $catrs['t']==1)
{
	gourl("index.php?m=art_cat&catid=$catid");
}
$smarty->assign("catrs",$catrs);
//文章分类
$artcat=art_cat($catid);
$smarty->assign("artcat",$artcat);
//文章分类结束



//分类结束
$url="index.php?m=art_list";
$w=" AND siteid='$cksiteid' ";
//获取当前分类或子类的文章 默认子类才有文章
if($catid)
{
	$childid=getartchildid($catid);
	
	$url.="&catid=$catid";
	if($childid)
	{
	$ids=_implode(array_merge($childid,array($catid)));
	$w .=" and catid in({$ids})";
	}else
	{
		if($catid)
		{
		$w=" and catid='$catid'";
		}
	}
}

if($_GET['title'])
{
	$_GET['title']=htmlspecialchars($_GET['title']);
	$url.="&title=".$_GET['title'];
	$w.=" and title like '%".$_GET['title']."%'";
}

//热门文章sql

//开始分页处理
$rscount=$db->getOne("select count(1) from ".table('art')." where 1= 1  {$w} ");

$pagesize=ISWAP?10:40;
$page=isset($_GET['page'])?max(1,intval($_GET['page'])):1;
$start=($page-1)*$pagesize;
$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,$url));
//结束分页处理

$smarty->assign("artlist",artlist($w," order by id desc  ",$start,$pagesize));

//获取热门  推荐 最新文章

//获取最新文章

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

		$ps=$db->getRow("select catid,cname from ".table('art_cat')." where catid=(select pid from ".table('art_cat')." where catid='$catid' ) ");
		if($ps)
		{
			$where .=" > <a href=\"index.php?m=art_cat&catid=".$ps['catid']."\">".$ps['cname']."</a>";
		}
		$where .=" > <a href='index.php?m=art_list&catid=".$catrs['catid']."'> ".$catrs['cname']."</a> > 文章列表";	

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
if($catrs['listtpl'])
{
	$smarty->display($catrs['listtpl']);
}else
{
$smarty->display("art_list.html");
}
?>