<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

$smarty->assign("catcailist",catcailist());//���������ʳ
//��ȡ����
$caicat=$db->getAll("select catid,cname from ".table('cai_cat')." order by orderid asc ");
$smarty->assign("caicat",$caicat)	;
//��ȡ����
$cai_do=$db->getAll("select id,dname from ".table('cai_do')." order by orderid asc ");
$smarty->assign("cai_do",$cai_do);
//��ȡ��ζ
$cai_wei=$db->getAll("select id,wname from ".table('cai_wei')." order by orderid asc ");
$smarty->assign("cai_wei",$cai_wei);
$catid=isset($_GET['catid'])?intval($_GET['catid']):intval($_POST['catid']);
$doid=isset($_GET['doid'])?intval($_GET['doid']):intval($_POST['doid']);
$weiid=isset($_GET['weiid'])?intval($_GET['weiid']):intval($_GET['weiid']);
$title=isset($_GET['title'])?trim(htmlspecialchars($_GET['title'])):trim(htmlspecialchars($_POST['title']));
$url="index.php?m=cai_cat&";
$sql="select id,title,price,thum_img from ".table('cai')." where   visible=1 ";
$sql2=" select count(*) from ".table('cai')." where visible=1 ";
$w="";
if($doid)
{
	
	$w.=" and doid='$doid' ";
	$url.="&doid={$doid}";
	$smarty->assign("dors",$db->getRow("select id,dname from ".table('cai_do')." where id='$doid' "));
}
if($catid)
{
	$w.=" and catid='$catid' ";
	$url.="&catid={$catid}";
	$catrs=$db->getRow("select * from ".table('cai_cat')." where catid='$catid' ");
	$smarty->assign("catrs",$catrs);
}
if($weiid)
{
	$w.=" and weiid='$weiid' ";
	$url.="&weiid={$weiid}";
	$smarty->assign("weirs",$db->getRow("select id,wname from ".table('cai_wei')." where id='$weiid' "));
	
}
if($title)
{
	$w.=" and title like '%$title%' ";
	$url.="&title={$title}";
	$smarty->assign("cai_title",$title);
}

//��ȡ���Ų�
$cai_listhot=ISWAP?5:CAI_LISTHOT;
$smarty->assign("caihot",cailist($w." and ishot=1 ","",0,$cai_listhot));
//��ȡ�Ƽ���
$cai_listding=ISWAP?5:CAI_LISTDING;
$smarty->assign("caiding",cailist($w." and isding=1 ","",0,$cai_listding));
//��ȡ�²�
$cai_listnew=ISWAP?5:CAI_LISTNEW;
$smarty->assign("cainew",cailist($w." and isnew=1 ","",0,$cai_listnew));
//��ʼ��ҳ����
$pagesize=ISWAP?5:CAI_LIST;
$page=isset($_GET['page'])?max(1,intval($_GET['page'])):1;
$start=($page-1)*$pagesize;
$rscount=$db->getOne($sql2);
$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,$url));
//��ҳ����
$cailist=cailist($w,"",$start,$pagesize);
$smarty->assign("cailist",$cailist);

$where="<a href=\"".$web['weburl']."\">��վ��ҳ</a> > <a href='index.php?m=cai_cat&'>��ʳ��ȫ</a> ";
if($catid)
{
	$where.="-".$catrs['cname'];
}
$smarty->assign("where",$where);
//seoѡ��
$smarty->assign("title",($catrs['cname']?$catrs['cname'].'-':"").$web['webtitle']);
$smarty->assign("keywords",($catrs['cname']?$catrs['cname'].',':"").$web['webkey']);
$smarty->assign("description",($catrs['cname']?$catrs['cname'].',':"").$web['webdesc']);
//seoѡ�����



$smarty->display("cai_cat.html");
?>