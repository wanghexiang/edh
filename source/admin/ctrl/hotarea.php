<?php
check_login();
$_GET['a']=isset($_GET['a'])?htmlspecialchars($_GET['a']):'index';
switch($_GET['a'])
{
	case 'index':
		$list=$db->getAll("SELECT * FROM ".table('hotarea')." WHERE siteid='$siteid' ORDER BY orderindex ASC");
		$smarty->assign("list",$list);
	$smarty->display("hotarea.html");
		break;
	case 'post':
		$titles=$_POST['title'];
		$latlngs=$_POST['latlng'];
		$orderindexs=$_POST['orderindex'];
		$newtitle=htmlspecialchars($_POST['newtitle']);
		$newlatlng=$_POST['newlatlng'];
		$neworderindex=intval($_POST['neworderindex']);
		if($titles)
		{
			foreach($titles as $id=>$title)
			{
				
				list($lat,$lng)=explode(",",$latlngs[$id]);
				$lat=floatval($lat);
				$lng=floatval($lng);
				$db->query("UPDATE ".table('hotarea')." SET title='".htmlspecialchars($title)."',lat='$lat',lng='$lng',orderindex=".intval($orderindexs[$id])." WHERE id='$id' AND siteid='$siteid' ");
			}
		}
		
		if($newtitle)
		{
			if($newlatlng)
			{
				list($lat,$lng)=explode(",",$newlatlng);
			}
			$db->query("INSERT INTO ".table('hotarea')." SET siteid='$siteid',title='$newtitle',lat=".floatval($lat).",lng=".floatval($lng).",orderindex='$neworderindex' ");
			
			
		}
		
		gourl();
		break;
	case 'del':
			$id=intval($_GET['id']);
			$db->query("DELETE FROM ".table('hotarea')." WHERE id='$id' AND siteid='$siteid' ");
			gourl();
		break;
	
}
?>