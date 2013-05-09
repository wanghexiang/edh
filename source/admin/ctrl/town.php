<?php

check_login();
$cityid=intval($_GET['cityid']);
if($_GET['a']=='add')
{
	if(empty($cityid))
	{
		errback('请选择二级区域','admin.php?m=city&');
	}
	$smarty->assign("cityid",intval($_GET['cityid']));
	$smarty->display("town_add.html");
	exit();
}elseif($_GET['a']=='add_db')
{
	$towns=trim($_POST['towns']);
	$towns=explode("\r\n",$towns);
	foreach($towns as $town)
	{
		$db->query("INSERT INTO ".table('town')." set town='$town',cityid='$cityid',siteid='$siteid' ");
	}
	gourl("admin.php?m=town&cityid=$cityid");
}elseif($_GET['a']=='post')
{
	$towns=$_POST['town'];
	$orderindex=$_POST['orderindex'];
	$latlngs=$_POST['latlng'];
	if(is_array($towns))
	{
		foreach($towns as $id => $town)
		{
			list($lat,$lng)=explode(",",$latlngs[$id]);
			$lat=floatval($lat);
			$lng=floatval($lng);
			$db->query("UPDATE ".table('town')." set town='$town',orderindex=".intval($orderindex[$id]).",lat='$lat',lng='$lng' where townid='$id' ");
		}
	}
	gourl();
}elseif($_GET['a']=='del')
{
	$townid=intval($_GET['townid']);
	
	$db->query("DELETE FROM ".table('town')." WHERE townid='$townid' ");
	gourl();
	
}elseif($_GET['a']=='ajaxtowns')
{
	header("content-type:text/html;charset=gb2312");
	$towns=towns(intval($_GET['cityid']));
	if($towns)
	{
		echo "<option value='0'>请选择</option>";
		foreach($towns as $t)
		{
			echo "<option value='".$t['townid']."'>".$t['town']."</option>";
		}
	}else
	{
		echo "<option value='0'>暂无三级区域</option>";
	}
	exit();
}

if($cityid)
{
	$sql="SELECT c.*,p.city FROM ".table('town')." c  LEFT JOIN ".table('city')." p ON c.cityid=p.cityid where c.cityid='$cityid' AND c.siteid='$siteid' ORDER BY c.orderindex ASC ";
}else
{
	$sql="SELECT c.*,p.city FROM ".table('town')." c LEFT JOIN ".table('city')." p ON c.cityid=p.cityid WHERE c.siteid='$siteid'  ORDER BY c.orderindex ASC  ";
}
$smarty->assign("towns",$db->getAll($sql));
$smarty->display("town.html");
?>