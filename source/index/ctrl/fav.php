<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

$_GET['a']=$_GET['a']?htmlspecialchars(trim($_GET['a'])):'shop';
check_login();
$userid=$_SESSION['ssuser']['userid'];
switch($_GET['a'])
{
	case 'shop':
			$shopids=$db->getCols("SELECT shopid FROM ".table('fav_shop')." WHERE userid=".$_SESSION['ssuser']['userid']." ");
			assignlist("shop",10," AND shopid in("._implode($shopids).")","","index.php?m=fav&a=shop" );
			$smarty->display("fav_shop.html");
		break;
	case 'shopadd':
				$shopid=intval($_GET['shopid']);
				$id=$db->getOne("SELECT id FROM ".table('fav_shop')." WHERE shopid='$shopid'  AND userid='$userid' ");
				if(!$id)
				{
					$siteid=$db->getOne("SELECT siteid FROM ".table('shop')." WHERE shopid='$shopid' ");
					$db->query("INSERT INTO ".table('fav_shop')." SET shopid='$shopid',userid='$userid',dateline=".time().",siteid='$siteid' ");
					$db->query("UPDATE ".table('shop')." SET favs=favs+1 WHERE shopid='$shopid' ");
				}
				if(!$_GET['ajax'])
				{
					errback("商店收藏成功","index.php?m=shop&shopid=$shopid");
				}
				exit();
			break;
	case 'shopdel':
				$shopid=intval($_GET['shopid']);
				
				if($db->getOne("SELECT id FROM ".table('fav_shop')." WHERE shopid='$shopid'  AND userid='$userid' "))
				{
					$db->query("DELETE FROM ".table('fav_shop')." WHERE shopid='$shopid' AND userid='$userid' ");
					$db->query("UPDATE ".table('shop')." SET favs=favs-1 WHERE shopid='$shopid' ");
					
				}
				if(!$_GET['ajax'])
				{
					errback("商店收藏取消成功");
				}
				exit();
			break;	
	case 'cai':
			$userid=intval($_SESSION['ssuser']['userid']);
			$pagesize=10;
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$rscount=$db->getOne("SELECT count(1) FROM ".table('fav_cai')." WHERE siteid='$cksiteid' AND userid='$userid' ");
			$list=$db->getAll("SELECT f.shopname,c.* FROM ".table('fav_cai')." f LEFT JOIN ".table('cai')." c ON f.caiid=c.id WHERE f.userid='$userid' AND f.siteid='$cksiteid' ORDER BY f.dateline DESC LIMIT $start,$pagesize   ");
			$pagelist=multipage($rscount,$pagesize,$page,"index.php?m=fav&a=cai");
			$smarty->assign("pagelist",$pagelist);
			$smarty->assign("rscount",$rscount);
			$smarty->assign("list",$list);
			echo 
			$smarty->display("fav_cai.html");
		break;
		
	case 'caiadd':
			$caiid=intval($_GET['caiid']);
			$userid=intval($_SESSION['ssuser']['userid']);
			if(!$db->getOne("select id FROM ".table('fav_cai')." WHERE userid='$userid' AND caiid='$caiid' LIMIT 1 "))
			{
				$cai=$db->getRow("SELECT shopid,siteid FROM ".table('cai')." WHERE id='$caiid' ");
				$shopname=$db->getOne("SELECT shopname FROM ".table('shop')." WHERE shopid=".$cai['shopid']." ");
				$db->query("INSERT INTO ".table('fav_cai')." SET caiid='$caiid',siteid='{$cai['siteid']}',shopid='{$cai['shopid']}',userid='$userid',shopname='$shopname',dateline=".time()." ");
				$db->query("UPDATE ".table('cai')." SET favs=favs+1 WHERE id='$caiid' ");
			}
			if(!$_GET['ajax'])
			{
				errback("美食收藏成功");
			}
		break;
	case 'caidel':
			$caiid=intval($_GET['caiid']);
			$userid=intval($_SESSION['ssuser']['userid']);
			if($db->getOne("select id FROM ".table('fav_cai')." WHERE userid='$userid' AND caiid='$caiid' LIMIT 1 "))
			{
				$db->query("DELETE FROM ".table('fav_cai')." WHERE caiid='$caiid' AND userid='$userid' ");
				$db->query("UPDATE ".table('cai')." SET favs=favs-1 WHERE id='$caiid' ");
			}
			if(!$_GET['ajax'])
			{
				errback("美食收藏取消成功");
			}
		break;
}
?>