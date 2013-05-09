<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

$aion=array("index","maps","users");
if(!in_array($_GET['a'],$aion))
{
	$_GET['a']='index';
}
if($_GET['a']=='index')
{
	if($_GET['shopid'])
	{
		$latlng=$db->getRow("SELECT lat,lng FROM ".table('shop')." WHERE  shopid=".intval($_GET['shopid'])."  ");
		$smarty->assign("latlng",$latlng);
	}
	$hotarea=$db->getAll("SELECT * FROM ".table('hotarea')." WHERE siteid=".$cksiteid." ");
	$smarty->assign("hotarea",$hotarea);
	$smarty->assign("shopcats",$db->getAll("SELECT * FROM ".table('shop_cat')." ORDER BY orderindex DESC "));
	$smarty->display("maps.html");
	exit();
}elseif($_GET['a']=='maps')
{
	$shopname=iconv("utf-8","gbk",trim($_GET['shopname']));
	$bounds=str_replace(array("(",")"),"",$_GET['bounds']);
	$center=str_replace(array("(",")"),"",$_GET['center']);
	$catid=intval($_GET['catid']);
	$w='';
	if($shopname)
	{
		$w=" AND shopname like '%".$shopname."%' ";
	}
	$w.=$catid?" AND catid='$catid' ":"";
	
	list($lat,$lng)=explode(",",$center);
	$m=explode(",",$bounds);
	$arr=array();
	$page=max(1,intval($_GET['page']));
	$pagesize=15;
	$start=($page-1)*$pagesize;
	$url="index.php?m=maps&bounds=".$_GET['bounds']."&center=".$_GET['center']."&catid=$catid&shopname=$shopname";
	$rscount=$db->getOne("SELECT COUNT(*) FROM ".table('shop')." WHERE  siteid='$cksiteid' AND visible=0  AND (lat>'$m[1]' AND lat<'$m[3]' AND lng>'$m[0]' AND lng<'$m[2]') $w ");
	$maps['list']=$db->getAll("SELECT * FROM ".table('shop')."  WHERE  siteid='$cksiteid' AND visible=0  AND (lat>'$m[1]' AND lat<'$m[3]' AND lng>'$m[0]' AND lng<'$m[2]')  $w   ORDER BY shopid DESC  LIMIT $start,$pagesize ");
	
	$pagelist=mappages($rscount,$pagesize,$page,$url);
	if($pagelist)
	{
		$maps['pagelist']=$pagelist;
	}
	if($maps['list'])
	{
		echo json_encode( iconvstr('gbk','utf-8',$maps));
	}
	exit();
}

function mappages($num, $perpage, $curpage, $mpurl,$page=10) {
		
		$shownum = $showkbd = FALSE;
		$multipage = '';
		$mpurl .= strpos($mpurl, '?') ? '&' : '?';
		$page=6;
		
		$realpages = 1;
		if($num > $perpage) {
			$offset = 2;

			$realpages = @ceil($num / $perpage);
			$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;

			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if($to - $from < $page) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}

			$multipage = ($curpage > 1 && !$simple ? '<a href="javascript:;" onclick="markfun('.($curpage - 1).')"   class="prev" > Ê×Ò³</a>' : '').
				($curpage - $offset > 1 && $pages > $page ? '<a href="javascript:;" onclick="markfun(1)"   class="first" >1 ...</a>' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
				'<a href="javascript:;" onclick="markfun('.$i.')" >'.$i.'</a>';
			}

			$multipage .= ($to < $pages ? '<a href="javascript:;" onclick="markfun('.$pages.')" class="last" >... '.$realpages.'</a>' : '').
			($curpage < $pages && !$simple ? '<a href="javascript:;" onclick="markfun('.($curpage + 1).')" " class="next" >ÏÂÒ»Ò³</a>' : '');

			$multipage = $multipage ? '<div class="breadcrumb"><div class=" pages">'.($shownum && !$simple ? '<em>&nbsp;'.$num.'&nbsp;</em>' : '').$multipage.'</div></div>' : '';
		}
		$maxpage = $realpages;
		return $multipage;
	}
	


?>