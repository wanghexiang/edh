<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

require_once("includes/cls_comment.php");
$a=$_REQUEST['a'];
if($a=='addcomment')
{
	addcomment("cai_comment","index.php?m=cai&id=");	
}elseif($a=='delicious')
{
	$caiid=intval($_GET['caiid']);
	if(pingcai($caiid,1))
	{
		$db->query("update ".table('cai')." set delicious=delicious+1 where id='$caiid'");
		errback('感谢您的支持 ^_^');
	}else
	{
		errback('您已经投过了！');
	}
}elseif($a=='undelicious')
{
	$caiid=intval($_GET['caiid']);
	if(pingcai($caiid,2))
	{
		$db->query("update ".table('cai')." set undelicious=undelicious+1 where id='$caiid'");
		errback('感谢您的支持 ^_^');
	}else
	{
		errback('您已经投过了！');
	}
	
}

$id=intval($_GET['id']);

if(empty($id))
{
	gourl("index.php");
}
$shopcarinfo=shopcarinfo();
$smarty->assign("totalmoney",$shopcarinfo['totalmoney']);
$smarty->assign("shopcart",$shopcarinfo['shoplist']);
//增加点击率
$db->query("update ".table('cai')." set click=click+1 where id='$id' ");
$cai=$db->getRow("SELECT * FROM ".table('cai')." WHERE id='$id' ");
$cai['content']=$db->getOne("SELECT content FROM  ".table('cai_data')." where id='$id' ");
$cai['cname']=$db->getOne("SELECT cname FROM ".table('cai_cat')." WHERE catid=".intval($cai['catid'])." ");
$cai['dname']=$db->getOne("SELECT dname FROM ".table('cai_do')." WHERE doid=".intval($cai['doid'])." ");
$cai['wname']=$db->getOne("SELECT wname FROM ".table('cai_wei')." WHERE weiid=".intval($cai['weiid'])." ");
//判断是否可以购买
$cai['shopping']=1;//可购买
$cai['dateline']=date("Y-m-d",$cai['dateline']);
if(SHOWWEEK)
{
	if($cai['week'.getweek()]==0)
	{
		$cai['shopping']=0;
	}
}
if(OPENTIME && ($opentype!='doing'))
{
	$cai['shopping']=0;
}
if($cai['oos']==1)
{
	$cai['shopping']=0;
	
}
//判断是否被收藏
if($_SESSION['ssuser']['userid'])
{
	if($db->getOne("select id FROM ".table('fav_cai')." WHERE userid='{$_SESSION['ssuser']['userid']}' AND caiid='$id' LIMIT 1 "))
	{
		$cai['isfav']=1;
	}else
	{
		$cai['isfav']=0;
	}
}
//判断结束
$smarty->assign("cai",$cai);
$shopid=$cai['shopid'];
$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' AND visible=0    ");

if(!$shop)
{
	errback("店铺不存在或者已经禁止");
}
$_GET['shopid']=$shopid;
if($isfav)
{
	$shop['isfav']=1;
}
$smarty->assign("shop",$shop);
$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid='$shopid' ");
$opentype='doing';
if($shopconfig['opentime']==1)
{
	$hs=date("H");
	
	$h=$hs{0}==0?$hs{1}:$hs;
	if($h<$shopconfig['starthour'] or ($h==$shopconfig['starthour'] && date("i")<$shopconfig['startminute']))
	{
		$opentype='will';//未开时
	}elseif($h>$shopconfig['endhour'] or($h==$shopconfig['endhour'] && date("i")>$shopconfig['endminute']))
	{
		$opentype='done';//一结束
	}else
	{
		$opentype='doing';
	}
}
$shop['opentype']=$opentype;
$smarty->assign("shopconfig",$shopconfig);

//获取标签
$tagname=$db->getCols("select tagname from ".table('cai_tags')." where caiid='$id' ");
$tagname=implode(",",$tagname);
$smarty->assign("tagname",$tagname);
//获取分类
$caicat=$db->getAll("select catid,cname from ".table('cai_cat')." WHERE shopid='$shopid' order by orderid asc ");
$smarty->assign("caicat",$caicat)	;
//获取推荐
$sql="select id,title from ".table('cai')." ";

//获取推荐美食
$caiding=shopcailist($cai['shopid']," and isding=1 "," order by id desc ",0,ISWAP?5:CAI_INDEXDING);
$smarty->assign("caiding",$caiding);
//获取热门美食
$caihot=shopcailist($cai['shopid']," and ishot=1 "," order by click desc ",0,ISWAP?5:CAI_INDEXHOT);
$smarty->assign("caihot",$caihot);
//获取最新美食
$cainew=shopcailist($cai['shopid']," and isnew=1 "," order by id desc ",0,ISWAP?5:CAI_INDEXNEW);
$smarty->assign("cainew",$cainew);

//获取上下篇
$sql.=" where catid=".$cai['catid']." AND shopid=".$_SESSION['ssshopid']." ";
$nx=$db->getRow($sql." and id>".$id." order by id asc ");
if($nx)
{
	$nextrs="<a href=\"index.php?m=cai&id=".$nx['id']."\">".$nx['title']."</a>";
}else
{
	$nextrs="已经是最后一条记录";
}
$lx=$db->getRow($sql." and id<'$id' order by id desc ");
if($lx)
{
	$lastrs="<a href=\"index.php?m=cai&id=".$lx['id']."\">".$lx['title']."</a>";
}else
{
	$lastrs="已经是第一条记录";	
}
$smarty->assign("nextrs",$nextrs);
$smarty->assign("lastrs",$lastrs);
//当前位置
$where="<a href=\"".$web['weburl']."\">网站首页</a>";
$where.="-<a href=\"index.php?m=cai_cat&id={$cai['catid']}\">".$cai['cname']."</a>";
$where.="-".$cai['title'];
$smarty->assign("where",$where);


commentlist("cai_comment","index.php?m=cai&",$id,$_SESSION['ssshopid']);
//seo选项
$seo=array(
	"title"=>$cai['title'].'-'.$web['webtitle'],
	"keywords"=>$cai['keyword'].','.$web['webkey'],
	"description"=>$cai['des']
);

$smarty->assign("seo",$seo);
//seo选项结束
$smarty->display("cai.html");

?>