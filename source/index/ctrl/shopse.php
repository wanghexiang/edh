<?php
if(!defined("CT"))
{
	die("IS WRONG");
}
//行业分类,
require_once("config/gcate.php");
extract($_GET);
$gid=intval($_GET['gid']);

$gcate[$gid]=$gcate[$gid]?$gcate[$gid]:0;
$_GET['a']=$_GET['a']?htmlspecialchars(trim($_GET['a'])):'index';

switch($_GET['a'])
{
	case 'index':
		$userid=intval($_SESSION['ssuser']['userid']);
		//区域选择
		$provinces=provinces($cksiteid);
		$smarty->assign("provinces",$provinces);
		if($_GET['provinceid'])
		{
			$_GET['provinceid']=intval($_GET['provinceid']);
			$citys=citys(intval($_GET['provinceid']));
			$towns=towns(intval($_GET['cityid']));
			$smarty->assign("citys",$citys);
			$smarty->assign("towns",$towns);
		}
		//店铺类目
		$_GET['catid']=intval($_GET['catid']);
		$catlist=$db->getAll("SELECT * FROM ".table('shop_cat')." WHERE catid IN(".$gcate[$gid].")  ORDER BY orderindex ASC ");
		$smarty->assign("catlist",$catlist);
		//起送金额
		$_GET['smid']=intval($_GET['smid']);
		$smlist=$db->getAll("SELECT * FROM ".table('shop_sendmoney')." ORDER BY orderindex ASC ");
		$smarty->assign("smlist",$smlist);
		//平均消费
		$_GET['amid']=intval($_GET['amid']);
		$amlist=$db->getAll("SELECT * FROM ".table('shop_avgmoney')." ORDER BY orderindex ASC ");
		$smarty->assign("amlist",$amlist);
		
		//区域结束
		$sw=$gcate[$gid]?" AND s.catid in(".$gcate[$gid].") ":" AND s.catid in(0) ";
		$shopids=array();
		if(intval($_GET['provinceid']))
		{
			$sw.=" AND s.provinceid=".intval($_GET['provinceid'])." ";
			if(intval($_GET['cityid']))
			{
				$sw.=" AND s.cityid=".intval($_GET['cityid'])." ";
				if(intval($_GET['townid']))
				{
					$sw.=" AND s.townid=".intval($_GET['townid'])." ";
				}
				
			}
			
		}
		
		if($_GET['catid'])
		{
			
			$sw.=" AND s.catid=".intval($_GET['catid'])." ";
		}
		if($amid)
		{
			$sw.=" AND s.amid=$amid ";
		}
		if($smid)
		{
			$sw.=" AND s.smid=$smid ";
		}
		
		$order='';
		$_GET['orderby']=isset($_GET['orderby'])?htmlspecialchars(trim($_GET['orderby'])):'orders';
		switch($_GET['orderby'])
		{
			case 'orders ':
					$order=" ORDER BY s.orders DESC";
				break;
			
			case 'new':
					$order=" ORDER BY s.shopid DESC ";
				break;
			
			default :
					$order="ORDER BY s.orders DESC ";
				break;
		}
		
		$smarty->assign("shopnum",$shopnum=$db->getOne("SELECT count(*) FROM ".table("shop")." s    WHERE s.siteid='$cksiteid' AND s.visible=0 $sw "));
		
		
		//调用收藏
		$favshops=$db->getCols("SELECT shopid FROM ".table('fav_shop')." WHERE userid=".$userid." ");
		//调用购物车信息
		$shopcarinfo=shopcarinfo();
		
		$smarty->assign("shopcart",$shopcarinfo['shoplist']); 
		$smarty->assign("totalmoney",$shopcarinfo['totalmoney']);
		$pagesize=ISWAP?12:21;
		$page=max(1,intval($_GET['page']));
		$start=($page-1)*$pagesize;
		$sql="SELECT s.shopid,s.shopname,s.logo,s.favs,s.orders,s.phone,s.address,s.info,s.sendarea,c.opentime,c.starthour,c.endhour,c.startminute,c.endminute,c.showweek,c.minprice FROM ".table('shop')." s  LEFT JOIN ".table('shopconfig')." c ON s.shopid=c.shopid WHERE s.siteid='$cksiteid' AND s.visible=0 $sw  $order  LIMIT $start,$pagesize ";


		$res=$db->query($sql);
		while($rs=$db->fetch_array($res))
		{
			if($favshops)
			{
				if(in_array($rs['shopid'],$favshops))
				{
					$rs['isfav']=1;
				}
				
			}
			$shoplist[]=$rs;
		}
		$smarty->assign("shoplist",$shoplist);
		$smarty->assign("pagelist",multipage($shopnum,$pagesize,$page,"index.php?m=shopse&provinceid=$provinceid&cityid=$cityid&townid=$townid&catid=$catid&smid=$smid&amid=$amid&orderby=".$_GET['orderby']));
		
		//seo项
		$smarty->assign("title",$web['webtitle']);
		$smarty->assign("keywords",$web['webkey']);
		$smarty->assign("description",$web['webdesc']);
		$smarty->display("shopse.html");
	break;	
}

?>