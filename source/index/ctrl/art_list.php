<?php
$catid=intval($_GET['catid']);
//��ȡ������Ϣ
$catrs=$db->getRow("select * from ".table('art_cat')." where catid='$catid' ");

if(!$catrs or $catrs['t']==1)
{
	gourl("index.php?m=art_cat&catid=$catid");
}
$smarty->assign("catrs",$catrs);
//���·���
$artcat=art_cat($catid);
$smarty->assign("artcat",$artcat);
//���·������



//�������
$url="index.php?m=art_list";
$w=" AND siteid='$cksiteid' ";
//��ȡ��ǰ�������������� Ĭ�������������
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

//��������sql

//��ʼ��ҳ����
$rscount=$db->getOne("select count(1) from ".table('art')." where 1= 1  {$w} ");

$pagesize=ISWAP?10:40;
$page=isset($_GET['page'])?max(1,intval($_GET['page'])):1;
$start=($page-1)*$pagesize;
$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,$url));
//������ҳ����

$smarty->assign("artlist",artlist($w," order by id desc  ",$start,$pagesize));

//��ȡ����  �Ƽ� ��������

//��ȡ��������

$artnew=artlist(" {$w} and isnew=1 "," order by istop desc,id desc ",0,10);
$smarty->assign("artnew",$artnew);
//��ȡ��������
$arthot=artlist(" {$w} and ishot=1 "," order by istop desc,click desc ",0,10);
$smarty->assign("arthot",$arthot);
//�Ƽ�����
$artding=artlist(" {$w} and isding=1 "," order by istop desc,id desc ",0,10);
$smarty->assign("artding",$artding);



//��ǰλ��
$where="<a href=\"index.php\">��վ��ҳ</a>";
if($catid)
{

		$ps=$db->getRow("select catid,cname from ".table('art_cat')." where catid=(select pid from ".table('art_cat')." where catid='$catid' ) ");
		if($ps)
		{
			$where .=" > <a href=\"index.php?m=art_cat&catid=".$ps['catid']."\">".$ps['cname']."</a>";
		}
		$where .=" > <a href='index.php?m=art_list&catid=".$catrs['catid']."'> ".$catrs['cname']."</a> > �����б�";	

}else
{
	$where .=" > ������Ŀ";	
}
$smarty->assign("where",$where);
//seoѡ��
$seo["title"]=$catrs['cname']?$catrs['cname']:$seo["title"];
$seo["keywords"]=$catrs['keyword']?$catrs['keyword']:$seo["keywords"];
$seo["description"]=$catrs['des']?$catrs['des']:$seo["description"];
$smarty->assign("seo",$seo);
//seoѡ�����
if($catrs['listtpl'])
{
	$smarty->display($catrs['listtpl']);
}else
{
$smarty->display("art_list.html");
}
?>