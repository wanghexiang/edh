<?php

check_login();
$provinceid=intval($_GET['provinceid']);
if($_GET['a']=='add')
{
	if(empty($provinceid))
	{
		errback('请选择一级区域','admin.php?m=province&');
	}
	$smarty->assign("provinceid",intval($_GET['provinceid']));
	$smarty->display("city_add.html");
	exit();
}elseif($_GET['a']=='add_db')
{
	$citys=trim($_POST['citys']);
	$citys=explode("\r\n",$citys);
	foreach($citys as $city)
	{
		$db->query("INSERT INTO ".table('city')." set city='$city',provinceid='$provinceid',siteid='$siteid' ");
	}
	gourl("admin.php?m=city&provinceid=$provinceid");
}elseif($_GET['a']=='post')
{
	$citys=$_POST['city'];
	$orderindex=$_POST['orderindex'];
	$latlngs=$_POST['latlng'];
	if(is_array($citys))
	{
		foreach($citys as $id => $city)
		{
			list($lat,$lng)=explode(",",$latlngs[$id]);
			$lat=floatval($lat);
			$lng=floatval($lng);
			$db->query("UPDATE ".table('city')." set city='$city',orderindex=".intval($orderindex[$id]).",lat='$lat',lng='$lng' where cityid='$id' ");
		}
	}
	gourl();
}elseif($_GET['a']=='del')
{
	$cityid=intval($_GET['cityid']);
	if($ct=$db->getOne("select count(*) from ".table('town')." where cityid='$cityid' "))
	{
		errback('请删除下级区域');
	}else
	{
		$db->query("DELETE FROM ".table('city')." WHERE cityid='$cityid' ");
		gourl();
	}
}elseif($_GET['a']=='ajaxcitys')
{
	header("content-type:text/html;charset=gb2312");
	$citys=citys(intval($_GET['provinceid']));
	if($citys)
	{
		echo "<option value='0'>选择二级区域</option>";
		foreach($citys as $c)
		{
			echo "<option value=".$c['cityid'].">".$c['city']."</option>";
		}
	}else
	{
		echo "<option value='0'>暂无二级区域</option>";
	}
	exit();
}

if($provinceid)
{
	$sql="SELECT c.*,p.province FROM ".table('city')." c  LEFT JOIN ".table('province')." p ON c.provinceid=p.provinceid where c.provinceid='$provinceid' AND c.siteid='$siteid' ORDER BY c.orderindex ASC ";
}else
{
	$sql="SELECT c.*,p.province FROM ".table('city')." c LEFT JOIN ".table('province')." p ON c.provinceid=p.provinceid  WHERE c.siteid='$siteid' ORDER BY c.orderindex ASC  ";
}
$smarty->assign("citys",$db->getAll($sql));
$smarty->display("city.html");
?>