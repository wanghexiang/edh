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
		errback('��л����֧�� ^_^');
	}else
	{
		errback('���Ѿ�Ͷ���ˣ�');
	}
}elseif($a=='undelicious')
{
	$caiid=intval($_GET['caiid']);
	if(pingcai($caiid,2))
	{
		$db->query("update ".table('cai')." set undelicious=undelicious+1 where id='$caiid'");
		errback('��л����֧�� ^_^');
	}else
	{
		errback('���Ѿ�Ͷ���ˣ�');
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
//���ӵ����
$db->query("update ".table('cai')." set click=click+1 where id='$id' ");
$cai=$db->getRow("SELECT * FROM ".table('cai')." WHERE id='$id' ");
$cai['content']=$db->getOne("SELECT content FROM  ".table('cai_data')." where id='$id' ");
$cai['cname']=$db->getOne("SELECT cname FROM ".table('cai_cat')." WHERE catid=".intval($cai['catid'])." ");
$cai['dname']=$db->getOne("SELECT dname FROM ".table('cai_do')." WHERE doid=".intval($cai['doid'])." ");
$cai['wname']=$db->getOne("SELECT wname FROM ".table('cai_wei')." WHERE weiid=".intval($cai['weiid'])." ");
//�ж��Ƿ���Թ���
$cai['shopping']=1;//�ɹ���
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
//�ж��Ƿ��ղ�
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
//�жϽ���
$smarty->assign("cai",$cai);
$shopid=$cai['shopid'];
$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' AND visible=0    ");

if(!$shop)
{
	errback("���̲����ڻ����Ѿ���ֹ");
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
		$opentype='will';//δ��ʱ
	}elseif($h>$shopconfig['endhour'] or($h==$shopconfig['endhour'] && date("i")>$shopconfig['endminute']))
	{
		$opentype='done';//һ����
	}else
	{
		$opentype='doing';
	}
}
$shop['opentype']=$opentype;
$smarty->assign("shopconfig",$shopconfig);

//��ȡ��ǩ
$tagname=$db->getCols("select tagname from ".table('cai_tags')." where caiid='$id' ");
$tagname=implode(",",$tagname);
$smarty->assign("tagname",$tagname);
//��ȡ����
$caicat=$db->getAll("select catid,cname from ".table('cai_cat')." WHERE shopid='$shopid' order by orderid asc ");
$smarty->assign("caicat",$caicat)	;
//��ȡ�Ƽ�
$sql="select id,title from ".table('cai')." ";

//��ȡ�Ƽ���ʳ
$caiding=shopcailist($cai['shopid']," and isding=1 "," order by id desc ",0,ISWAP?5:CAI_INDEXDING);
$smarty->assign("caiding",$caiding);
//��ȡ������ʳ
$caihot=shopcailist($cai['shopid']," and ishot=1 "," order by click desc ",0,ISWAP?5:CAI_INDEXHOT);
$smarty->assign("caihot",$caihot);
//��ȡ������ʳ
$cainew=shopcailist($cai['shopid']," and isnew=1 "," order by id desc ",0,ISWAP?5:CAI_INDEXNEW);
$smarty->assign("cainew",$cainew);

//��ȡ����ƪ
$sql.=" where catid=".$cai['catid']." AND shopid=".$_SESSION['ssshopid']." ";
$nx=$db->getRow($sql." and id>".$id." order by id asc ");
if($nx)
{
	$nextrs="<a href=\"index.php?m=cai&id=".$nx['id']."\">".$nx['title']."</a>";
}else
{
	$nextrs="�Ѿ������һ����¼";
}
$lx=$db->getRow($sql." and id<'$id' order by id desc ");
if($lx)
{
	$lastrs="<a href=\"index.php?m=cai&id=".$lx['id']."\">".$lx['title']."</a>";
}else
{
	$lastrs="�Ѿ��ǵ�һ����¼";	
}
$smarty->assign("nextrs",$nextrs);
$smarty->assign("lastrs",$lastrs);
//��ǰλ��
$where="<a href=\"".$web['weburl']."\">��վ��ҳ</a>";
$where.="-<a href=\"index.php?m=cai_cat&id={$cai['catid']}\">".$cai['cname']."</a>";
$where.="-".$cai['title'];
$smarty->assign("where",$where);


commentlist("cai_comment","index.php?m=cai&",$id,$_SESSION['ssshopid']);
//seoѡ��
$seo=array(
	"title"=>$cai['title'].'-'.$web['webtitle'],
	"keywords"=>$cai['keyword'].','.$web['webkey'],
	"description"=>$cai['des']
);

$smarty->assign("seo",$seo);
//seoѡ�����
$smarty->display("cai.html");

?>