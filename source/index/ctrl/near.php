<?php
$action=array("index","user");
if(!in_array($_GET['a'],$action))
{
	$_GET['a']='index';
}

	if(isset($_SESSION['ss_latlng']))
	{
		
		$latlng=explode("-",$_SESSION['ss_latlng']);
		if(($latlng[2]+300)>time())
		{
			$lat=$_GET['lat']=$latlng[0];
			$lng=$_GET['lng']=$latlng[1];
			$_SESSION['ss_latlng']="$lat"."-".$lng."-".time();
		}
	}
	



switch($_GET['a'])
{
	case 'index':
			$meter=0.00001*1.1;//1米以内
			$meter=isset($_GET['mi'])?$meter*intval($_GET['mi']):$meter*500;
			$miarr=array();
			if($lat>0)
			{				
				$ilng=$lng+$meter;
				$mlng=$lng-$meter;
				$ilat=$lat+$meter;
				$mlat=$lat-$meter;
				$pagesize=10;
				$page=max(1,intval($_GET['page']));
				$start=($page-1)*$pagesize;
				$rscount=$db->getOne("SELECT count(1) FROM ".table('shop')." WHERE (lng<'$ilat' AND lng>'$mlat' AND lat>'$mlng' AND lat<'$ilng') AND visible=0 AND siteid='$cksiteid' ");
				$sql="SELECT s.* FROM ".table('shop')." s  WHERE  (lng<'$ilat' AND  lng>'$mlat' AND  lat>'$mlng' AND  lat<'$ilng') AND siteid='$cksiteid' AND visible=0   LIMIT $start,$pagesize  ";
										
				$arr=$db->getAll($sql);		
				foreach($arr as $k=>$v){
					 $arr[$k]['distance']=distanceByLnglat($lng,$lat,$v['lat'],$v['lng']);
					
				}
				$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=near&a=index&mi={$_GET[mi]}"));
				
			}
			
			$smarty->assign("shoplist",$arr);
			$smarty->display("near_shop.html");
			
			break;
			
	
	
	
}


?>