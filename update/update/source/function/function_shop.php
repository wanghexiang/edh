<?php

function getshopinfo($shopid,$smarty=0)
{
	global $db;
	$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' AND visible>=0    "); 
	$content=$db->getOne("SELECT content FROM ".table('shop_data')." WHERE shopid='$shopid' ");
	$content && $shop['content']=$content;
	if($_SESSION['ssuser']['userid']){
		$isfav=$db->getOne("SELECT shopid FROM ".table('fav_shop')." WHERE userid=".intval($_SESSION['ssuser']['userid'])." AND shopid='$shopid'  ");
	}
	if($isfav)
	{
		$shop['isfav']=1;
	}
	$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid='$shopid' ");
	$opentype='doing';
	if($shopconfig['opentime']==1)
	{
		$opentype=opentype($shopconfig['starthour'],$shopconfig['startminute'],$shopconfig['endhour'],$shopconfig['endminute']);
	}
	$shop['opentype']=$opentype;
	if($smarty)
	{
		$GLOBALS['smarty']->assign("shop",$shop);
		$GLOBALS['smarty']->assign("shopconfig",$shopconfig);
	}
	 
	return array("shop"=>$shop,"shopconfig"=>$shopconfig);
	
}

?>