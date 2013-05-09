<?php
if(!defined("CT"))
{
	die("IS WRONG");
}
//载入模型
loadModel(array('cai'));
$userid=intval($_SESSION['ssuser']['userid']);
$smarty->assign("shopnum",$db->getOne("SELECT count(1) FROM ".table("shop")." "));
$smarty->assign("cainum",$db->getOne("SELECT count(1) FROM ".table('cai')." "));
//调用收藏
$favshops=$db->getCols("SELECT shopid FROM ".table('fav_shop')." WHERE userid=".$userid." AND siteid='$cksiteid' ");
$smarty->assign("favshops",$favshops);
//调用购物车信息

$shopcarinfo=shopcarinfo();
$smarty->assign("shopcart",$shopcarinfo['shoplist']);
$smarty->assign("totalmoney",$shopcarinfo['totalmoney']);
$shoplist=array();
$pagesize=5;
$page=max(1,intval($_GET['page']));
$page=min($page,100);
$start=($page-1)*$pagesize;
if($favshops)
{
	$rscount=$db->getOne("SELECT COUNT(*) FROM ".table('fav_shop')." WHERE userid='$userid' AND siteid='$cksiteid'   ");
	$shopids=$db->getCols("SELECT shopid FROM ".table('fav_shop')." WHERE userid='$userid' AND siteid='$cksiteid'    LIMIT $start,$pagesize   ");
	$sql="SELECT s.* FROM   ".table('shop')." s  WHERE shopid in(".implode(",",$shopids).") AND s.visible=0 LIMIT $start,$pagesize ";
}else
{
	$rscount=$db->getOne("SELECT COUNT(*) FROM ".table('shop')." WHERE  siteid='$cksiteid' AND isrecommend=1 AND visible=0 ");
	$sql="SELECT * FROM  ".table('shop')." WHERE siteid='$cksiteid'  AND  visible=0  AND isrecommend=1 ORDER BY shopid DESC  LIMIT $start,$pagesize ";
}
$res=$db->query($sql);
while($rs=$db->fetch_array($res))
{
	//计算店铺距离
	if($_SESSION['ssuser']['lat']<>0){
			$rs['distance']=distanceByLnglat($_SESSION['ssuser']['lat'],$_SESSION['ssuser']['lng'],$rs['lat'],$rs['lng']);
	}
	$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid=".$rs['shopid']." ");
	$rs['shopconfig']=$shopconfig;
	$opentype="doing";
	if($shopconfig['opentime']==1)
	{
		$opentype=opentype($shopconfig['starthour'],$shopconfig['startminute'],$shopconfig['endhour'],$shopconfig['endminute']);
	}
	$rs['opentype']=$opentype;
	
	if($favshops)
	{
		$rs['isfav']=1;
	}
	$cat=array();
	 
	if($shopconfig['showweek']){
		 $rs['caicat']=$caiModel->getByweek($rs['shopid'],3);
	}else{
		$res2=$db->query("SELECT catid,cname FROM ".table('cai_cat')." WHERE shopid=".$rs['shopid']." ");
		while($rs2=$db->fetch_array($res2))
		{
			$rs2['cailist']=shopcailist($rs['shopid']," AND catid=".$rs2['catid']);
			$cat[]=$rs2;
		}
		$rs['caicat']=$cat;
	}
	
	$shoplist[]=$rs;
}


$smarty->assign("shoplist",$shoplist);
$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=index"));
/*留言板*/
$guestlist=$db->getAll("SELECT * FROM ".table('guest')." WHERE status=1 AND siteid='$cksiteid' ORDER BY id DESC LIMIT 10 ");
$smarty->assign("guestlist",$guestlist);
//seo项
$smarty->assign("title",$web['webtitle']);
$smarty->assign("keywords",$web['webkey']);
$smarty->assign("description",$web['webdesc']);
if($userid){
	$day=date("Y-m-d");
	$smarty->assign("isqiandao",$db->getOne("SELECT id FROM ".table('qiandao')." WHERE userid='$userid' AND day='$day' "));	
}

$smarty->display("index.html");

?>