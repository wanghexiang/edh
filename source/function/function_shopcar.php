<?php
//购物车信息
function shopcarinfo($shopid=0)
{
	global $db,$ss_id,$cksiteid;
	$shopid=intval($shopid);
	$money=0;
	$userid=intval($_SESSION['ssuser']['userid']);
	$wu=$userid?"(s.userid=".$userid." OR s.ssid='{$ss_id}')" : "   s.ssid='{$ss_id}' ";
	if($shopid){
		$shops=array($shopid);
	}else{
		$shops=$db->getCols("SELECT DISTINCT shopid  FROM ".table('shopcar')." s WHERE $wu AND siteid='$cksiteid' ");
	}
	$shoplist=$shopids=array();
	
	
	if($shops)
	{
		foreach($shops as $shopid)
		{
			
			$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' ");
			$shop['cailist']=$GLOBALS['db']->getAll("select s.*  from ".table('shopcar')." as s where $wu AND s.shopid=".$shopid." ");	
			$shop['money']=$GLOBALS['db']->getOne("select sum(s.cainum*s.price) from ".table('shopcar')." as s  where $wu  AND s.shopid=".$shopid." ");
			$money+=$shop['money'];
			
			$shoplist[]=$shop;
		
		}
	}
	$ids=$db->getCols("SELECT caiid FROM ".table('shopcar')." WHERE (userid='$userid' OR ssid='{$ss_id}') AND siteid='$cksiteid' ");
	if($ids)
	{
		foreach($ids as $id)
		{
			$caiids[$id]=$id;
		}
	}
	
	return array('caiids'=>$caiids,'shoplist'=>$shoplist,'totalmoney'=>$money);
}


