<?php

check_login();
if($_GET['a']=='post')
{
	$provinces=$_POST['province'];
	$orderindex=$_POST['orderindex'];
	$latlngs=$_POST['latlng'];
	if($provinces)
	{
		foreach($provinces as $id=>$province)
		{
			list($lat,$lng)=explode(",",$latlngs[$id]);
			$lat=floatval($lat);
			$lng=floatval($lng);
			$db->query("UPDATE ".table('province')." set province='".htmlspecialchars($province)."' ,orderindex=".$orderindex[$id].",lat='$lat',lng='$lng' where provinceid='$id' ");
		}
	}
	$newprovince=htmlspecialchars(trim($_POST['newprovince']));
	if($newprovince)
	{
		$db->query("INSERT INTO ".table('province')." set province='$newprovince',orderindex=0,siteid='$siteid' ");
	}
	gourl();
}elseif($_GET['a']=='del')
{
	$provinceid=intval($_GET['provinceid']);
	if($provinceid==1)
	{
		errback('默认一级区域不能删除');
	}
	if($db->getOne("SELECT count(*) FROM ".table('city')." WHERE provinceid='$provinceid' "))
	{
		errback('请删除下级市');
	}else
	{
	$db->query("delete from ".table('province')." where provinceid='$provinceid' ");
	gourl();
	}
}elseif($_GET['a']=='ajaxprovinces')
{
	header("content-type:text/html;charset=gb2312");
	$provinces=$db->getAll("SELECT provinceid,province FROM ".table('province')." WHERE siteid='$siteid' ");
	if($provinces)
	{
		echo "<option value='0'>选择一级区域</option>";
		foreach($provinces as $c)
		{
			echo "<option value=".$c['provinceid'].">".$c['province']."</option>";
		}
	}else
	{
		echo "<option value='0'>暂无一级区域</option>";
	}
	exit();
}
$rs=$db->getAll("select * from ".table('province')." WHERE siteid='$siteid' order by orderindex asc ");
$smarty->assign("rs",$rs);
$smarty->display("province.html");
?>