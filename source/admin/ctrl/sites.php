<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):'index';
switch($_GET['a'])
{
	case 'index':
			$sites=$db->getAll("SELECT * FROM ".table('sites')." ORDER BY orderindex ASC ");
			$smarty->assign("sites",$sites);
			$smarty->display("sites.html");
			
		break;
	case 'post':
		$sitenames=$_POST['sitename'];
		$latlngs=$_POST['latlng'];
		$domains=$_POST['domain'];
		$orderindexs=$_POST['orderindex'];
		if(!empty($sitenames))
		{
			foreach($sitenames as $siteid=>$sitename )
			{
				 
				list($lat,$lng)=explode(",",$latlngs[$siteid]);
				  
				$lat=floatval($lat);
				$lng=floatval($lng);
				$orderindex=intval($orderindexs[$siteid]);
				$domain=htmlspecialchars($domains[$siteid]);
				$db->query("UPDATE ".table('sites')." SET sitename='".htmlspecialchars($sitename)."',lat='$lat',lng='$lng',orderindex='$orderindex',domain='$domain' WHERE siteid=".intval($siteid)."  ");
				
			}
		}
		$newsitename=htmlspecialchars($_POST['newsitename']);

		if($newsitename)
		{
			$newlat=floatval($_POST['newlat']);
			$newlng=floatval($_POST['newlnt']);
			$newdomain=htmlspecialchars(trim($_POST['newdomain']));
			$neworderindex=intval($_POST['neworderindex']);
			$db->query("INSERT INTO ".table('sites')." SET sitename='$newsitename',lat='$newlat',lng='$newlng',orderindex='$neworderindex',domain='$newdomain' ");
		}
		gourl("admin.php?m=sites");
		break;

	case "del":
			$siteid=intval($_GET['siteid']);
			if($siteid==1)
			{
				errback('默认站点不能删除');
			}else
			{
				$db->query("DELETE FROM  ".table('sites')." WHERE siteid='$siteid' ");
			}
			gourl();
		break;
}
?>