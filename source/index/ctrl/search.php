<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

$userid=intval($_SESSION['ssuser']['userid']);
//调用收藏
$favshops=$db->getCols("SELECT shopid FROM ".table('fav_shop')." WHERE userid=".$userid." "); 
//调用购物车信息
$shopcarinfo=shopcarinfo();

$smarty->assign("shopcart",$shopcarinfo['shoplist']);
$smarty->assign("totalmoney",$shopcarinfo['totalmoney']);

$_GET['keyword']=$keyword=get_post('keyword',"h")?get_post('keyword',"h"):$_GET['keyword'];
switch($a)
{
	case 'cai':
			if($keyword)
			{
				$w.=" AND title like '%{$keyword}%'  ";
			}
			$pagesize=15;
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$rscount=$db->getOne("SELECT count(1) FROM ".table('cai')." WHERE siteid='$cksiteid' $w  ");
			$sql="SELECT * FROM ".table('cai')."  WHERE  siteid='$cksiteid' $w  LIMIT $start,$pagesize   ";
			$res=$db->query($sql);
			while($rs=$db->fetch_array($res))
			{
				$shopinfo=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid=".intval($rs['shopid'])." ");
				if($favshops)
				{
					if(in_array($rs['shopid'],$favshops))
					{
						$rs['isfav']=1;
					}
					
				}
				$rs['shopname']=$shopinfo['shopname'];
				 
				if($shopcarinfo['caiids'][$rs['id']])
				{
					$rs['in_cart']=1;
				}
				$cailist[]=$rs;
			}
			$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=search&m=cai&keyword=".urlencode($keyword)));
			$smarty->assign("cailist",$cailist);
			$smarty->display("search_cai.html");
		break;
	case 'index':
	case "shop":
			$pagesize=15;
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$_GET['keyword']=$keyword=htmlspecialchars(trim($_GET['keyword']));
			if($_GET['keyword'])
			{
				$rscount=$db->getOne("SELECT count(1) FROM ".table('shop')." WHERE siteid='$cksiteid' AND visible=0 AND shopname LIKE '%".$_GET['keyword']."%' ");
			
				$sql="SELECT s.shopid,s.shopname,s.logo,s.phone,s.address,s.info,s.sendarea,c.opentime,c.starthour,c.endhour,c.startminute,c.endminute,c.showweek,c.minprice FROM ".table('shop')." s  LEFT JOIN ".table('shopconfig')." c ON s.shopid=c.shopid WHERE s.siteid='$cksiteid' AND s.visible=0 AND s. shopname LIKE '%".$_GET['keyword']."%'  LIMIT $start,$pagesize ";
				
			}else
			{
				$rscount=$db->getOne("SELECT count(1) FROM ".table('shop')." WHERE  siteid='$cksiteid' AND visible=0  ");
				$sql="SELECT s.shopid,s.shopname,s.logo,s.phone,s.address,s.info,s.sendarea,c.opentime,c.starthour,c.endhour,c.startminute,c.endminute,c.showweek,c.minprice FROM ".table('shop')." s  LEFT JOIN ".table('shopconfig')." c ON s.shopid=c.shopid WHERE s.siteid='$cksiteid' AND s.visible=0   LIMIT $start,$pagesize ";
			}
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
			$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=search&m=shop&keyword=".urlencode($keyword)));
			$smarty->assign("shoplist",$shoplist);
			$smarty->display("search_shop.html");
		break;
	case 'people':
			$pagesize=15;
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$w='';
			 
			if($_GET['keyword'])
			{
				$w.=" AND nickname like '{$_GET['keyword']}%'  ";
			}
			$rscount=$db->getOne("SELECT count(*) FROM ".table('user')." WHERE 1=1 $w ");
			$userlist=array();
			$list=$db->getAll("select * FROM ".table('user')." WHERE 1=1 $w ORDER BY userid DESC  LIMIT $start,$pagesize");
			if($_SESSION['ssuser']['userid'])
			{
				$follows=follows($_SESSION['ssuser']['userid']);
			}
			foreach($list as $u)
			{
				if($follows[$u['userid']])
				{
					$u['isfollowed']=1;
				}
				$userlist[]=$u;
			}
			$pagelist=multipage($rscount,$pagesize,$page,"index.php?m=search&m=people&keyword=".urlencode($keyword));
			$smarty->assign("userlist",$userlist);
			$smarty->display("search_people.html");
		break;
	case "caipu":
			$w='';
			if($keyword)
			{
				$w.=" AND title like '%{$keyword}%'  ";
			}
			assignlist("caipu",24,$w," order by id desc","index.php?=search&a=caipu&keyword=".urlencode($keyword));
			$smarty->display("search_caipu.html");
		break;
}



?>