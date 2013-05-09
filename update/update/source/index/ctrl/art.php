<?php

$id=intval($_GET['id']);
require_once("includes/cls_comment.php");
$a=$_GET['a'];
if($a=='addcomment')
{
	addcomment("art_comment","index.php?m=art&id=",$cksiteid);	
}
if(empty($id))
{
	gourl("index.php");
}



//获取文章详情
$art=$db->getRow("select a.*,d.content,c.cname,c.contpl from ".table('art')." as a LEFT JOIN ".table('art_data')." d ON a.id=d.id  left join ".table('art_cat')." as c on a.catid=c.catid  where a.id='$id' ");
if(empty($art))
{
	gourl("index.php");
}
//增加点击数
$db->query("update ".table('art')." set click=click+1 where id='$id' ");
$smarty->assign("art",$art);
$catid=$art['catid'];


//获取当前分类或子类的文章 默认子类才有文章
$childid=getartchildid($catid);

$w="";
if($childid)
{
$ids=_implode($childid);
$w.=" and catid in({$ids}) ";

}else
{
	if($catid)
	{
	$w= " and  catid ='{$catid}' ";
	}
}
//获取热门  推荐 最新文章

//获取最新文章
$artnew=artlist(" {$w} and isnew=1 "," order by  id desc ",0,10);
$smarty->assign("artnew",$artnew);
//获取最热文章
$arthot=artlist(" {$w} and ishot=1 "," order by  click desc ",0,10);
$smarty->assign("arthot",$arthot);
//推荐文章
$artding=artlist(" {$w} and isding=1 "," order by  id desc ",0,10);
$smarty->assign("artding",$artding);

//获取网站分类
$artcat=art_cat($catid);

$smarty->assign("artcat",$artcat);
//获取上下篇文章
$sql=" select id,title from ".table('art')." where 1=1  ";
$nx=$db->getRow($sql." and id>'$id' order by id asc limit 1");
if($nx)
{
$nextart="<a href=\"index.php?m=art&id=".$nx['id']."\">".$nx['title']."</a>";
}else
{
$nextart="已经是最后一篇";	
}
$smarty->assign("nextrs",$nextart);
$lt=$db->getRow($sql." and id<'$id' order by id desc limit 1 ");

if($lt)
{
$lastart="<a href=\"index.php?m=art&id=".$lt['id']."\">".$lt['title']."</a>";	
}else
{
$lastart="已经是第一篇";	
}
$smarty->assign("lastrs",$lastart);
//当前位置
$where="::<a href=\"index.php\">网站首页</a>";
$ps=$db->getRow("select catid,cname from ".table('art_cat')." where catid=(select pid from ".table('art_cat')." where catid=".$art['catid']." ) ");
if($ps)
{
	$where .=" > <a href=\"index.php?m=art_cat&catid=".$ps['id']."\">".$ps['cname']."</a>";
}
$where .=" > <a href=\"index.php?m=art_cat&catid=".$art['catid']."\">".$art['cname']."</a>"." > ".$art['title'];

$smarty->assign("where",$where);

commentlist("art_comment","index.php?m=art",$id);
//seo选项
$seo=array(
	"title"=>$art['title'].$seo['title'],
	"keywords"=>$art['keyword'].$seo['keywords'],
	"description"=>$art['des'],
);
$smarty->assign("seo",$seo);
//seo选项结束
if($art['contpl'])
{
	$smarty->display($art['contpl']);	
}else
{
$smarty->display("art.html");
}
?>