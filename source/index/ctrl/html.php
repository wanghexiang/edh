<?php
//单页管理
if(!defined("CT"))
{
	die("IS WRONG");
}

if($_GET['a']=='js')
{
	$tagname=htmlspecialchars(trim($_GET['tagname']));
	$db->getOne("SELECT content FROM ".table('html')." WHERE tagname='$tagname'  ");
	exit();
}
$catid=intval($_GET['catid']);
$id=intval($_GET['id']);
//判断参数是否正确
if($catid==0 and $id==0)
{
	$catid=$db->getOne("select catid from ".table('html_cat')." order by orderid asc limit 1 ");
	if(!$catid)
	{
		errback('参数出错',"index.php");
	}
}

if($catid)
{
	if(!$db->getOne("select count(*) from ".table('html_cat')." where catid='$catid' ")) errback('参数出错',"index.php");
	$cat=$db->getRow("select * from ".table('html_cat')." where catid='$catid' ");
	$rs=$db->getRow("select * from ".table('html')." where catid='$catid' order by orderid asc limit 1");
}else
{
	$rs=$db->getRow("select * from ".table('html')." where id='$id'");
	$cat=$db->getRow("select * from ".table('html_cat')." where catid=".$rs['catid']." ");
	$catid=$rs['catid'];
}

$smarty->assign("cat",$cat);
$smarty->assign("html",$rs);
$htmllist=$db->getAll("select title,id from ".table('html')." where catid='$catid' order by orderid asc  ");
$smarty->assign("htmllist",$htmllist);
$smarty->assign("where","<a href='{$web['weburl']}'>网站首页</a> > <a href='index.php?m=html&catid={$cat['catid']}'>{$cat['cname']}</a> > {$rs['title']}" );

//seo选项
$smarty->assign("title",$rs['title'].'-'.$web['webtitle']);
$smarty->assign("keywords",$rs['keyword'].','.$web['webkey']);
$smarty->assign("description",$rs['des']);
//seo选项结束
$smarty->display("html.html");

?>