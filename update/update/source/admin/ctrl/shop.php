<?php

check_login();
$a=$_GET['a']?$_GET['a']:"index";
switch($a)
{
	case 'index':	
		$provinces=provinces($siteid);
		$shopname=htmlspecialchars(trim($_GET['shopname']));
		$citys=$_GET['provinceid']?citys(intval($_GET['provinceid'])):array();
		$towns=$_GET['city']?towns(intval($_GET['cityid'])):array();
		$smarty->assign("provinces",$provinces);
		$smarty->assign("citys",$citys);
		$smarty->assign("towns",$towns);
		$isrecommend=intval($_GET['isrecommend']);
		$isnew=intval($_GET['isnew']);
		$ishot=intval($_GET['ishot']);
		$visible=intval($_GET['visible']);
		$shoplist=array();
		$sql="SELECT * FROM ".table('shop')."  WHERE siteid='$siteid' ";
		$w.=$shopname?" AND shopname like '".$shopname."%'":"";
		$w.=$isrecommend?" AND isrecommend='$isrecommend' ":"";
		$w.=$isnew?" AND isnew='$isnew' ":"";
		$w.=$ishot?" AND ishot='$ishot' ":"";
		$w.=$visible?" AND visible='$visible' ":"";
		$w.=$_GET['provinceid']?" AND provinceid=".intval($_GET['provinceid'])." ":"";
		$w.=$_GET['cityid']?" AND cityid=".intval($_GET['cityid'])." ":"";
		$w.=$_GET['townid']?" AND townid=".intval($_GET['townid'])." ":"";
		$pagesize=20;
		$page=max(1,intval($_GET['page']));
		$start=($page-1)*$pagesize;
		$sql.=" $w ORDER BY shopid DESC LIMIT $start,$pagesize ";
	
		$rscount=$db->getOne("SELECT count(*) FROM ".table('shop')." WHERE siteid='$siteid' $w ");
		$res=$db->query($sql);
		
		while($rs=$db->fetch_array($res))
		{
			$rs['province']=$rs['provinceid']?$provinces[$rs['provinceid']]:0;
			$rs['city']=$rs['cityid']?$citys[$rs['cityid']]:0;
			$rs['town']=$rs['townid']?$towns[$rs['townid']]:0;
			$shoplist[]=$rs;
		}
		$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"admin.php?m=shop&shopname={$_GET['shopname']}&provinceid={$_GET['provinceid']}&cityid={$_GET['cityid']}&townid={$_GET['townid']}&isrecommend=$isrecommend&isnew=$isnew&ishot=$ishot&visible=$visible"));
		$smarty->assign("shoplist",$shoplist);
		
		$smarty->display("shop.html");
	break;
	case 'add':

		$shopid=intval($_GET['shopid']);
		$provinces=provinces($siteid);
		
		if($shopid)
		{
			$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' ");
			$content=$db->getOne("SELECT content FROM ".table('shop_data')." WHERE shopid='$shopid' ");
			$content && $shop['content']=$content;
			$shop['province']=$shop['provinceid']?$provinces[$shop['provinceid']]:0;
			$shop['city']=$shop['cityid']?$citys[$shop['cityid']]:0;
			$citys=$shop['provinceid']?citys($shop['provinceid']):array();
			$towns=$shop['cityid']?towns($shop['cityid']):array();
			$shop['town']=$shop['townid']?$towns[$shop['townid']]:0;
			$shopareas=$db->getAll("SELECT p.province,s.provinceid,s.cityid,s.townid,c.city,t.town FROM ".table('shoparea')." s ".
			"LEFT JOIN ".table('province')." p ON s.provinceid=p.provinceid ".
			"LEFT JOIN ".table('city')." c ON s.cityid=c.cityid ".
			"LEFT JOIN ".table('town')." t ON s.townid=t.townid WHERE s.shopid='$shopid'   ");
			$smarty->assign("shopareas",$shopareas);
		}
		$smarty->assign("shop",$shop);
		$smarty->assign("provinces",$provinces);
		$smarty->assign("citys",$citys);
		$smarty->assign("towns",$towns);
		$smarty->assign("catlist",$db->getAll("SELECT catid,cname FROM ".table('shop_cat')." ORDER BY orderindex ASC "));
		$smarty->assign("smlist",$db->getAll("SELECT smid,cname FROM ".table('shop_sendmoney')."  ORDER BY orderindex ASC  "));
		$smarty->assign("amlist",$db->getAll("SELECT amid,cname FROM ".table('shop_avgmoney')."  ORDER BY orderindex ASC  "));
		$smarty->display("shop_add.html");
	break;
	case 'add_db':
		$shopid=intval($_POST['shopid']);
		$shopname=trim($_POST['shopname']);
		$provinceid=intval($_POST['provinceid']);
		$cityid=intval($_POST['cityid']);
		$townid=intval($_POST['townid']);
		$address=htmlspecialchars($_POST['address']);
		$qq=htmlspecialchars($_POST['qq']);
		$phone=htmlspecialchars($_POST['phone']);
		$shopno=htmlspecialchars($_POST['shopno']);
		$info=$_POST['info'];
		$content=$_POST['content'];
		$shopareas=$_POST['sendarea'];
		$catid=intval($_POST['catid']);
		$smid=intval($_POST['smid']);
		$amid=intval($_POST['amid']);
		if(empty($shopname))
		{
			errback('商店名称不能为空');
		}
		if($shopid)
		{
			$db->query("UPDATE ".table('shop')." SET endtime=".time().",catid='$catid',smid='$smid',amid='$amid',shopname='$shopname',provinceid='$provinceid',cityid='$cityid',townid='$townid',address='$address',qq='$qq',phone='$phone',shopno='$shopno',info='$info' WHERE shopid='$shopid' ");
			//更新过度版
			$sc_data['content']=$content;
			
			if($db->getOne("SELECT shopid FROM ".table('shop_data')." WHERE shopid='$shopid' ")){
				 
				$db->update("shop_data",$sc_data," AND shopid='$shopid' ");
			}else{
				$sc_data['shopid']=$shopid;
				$db->insert("shop_data",$sc_data);
			}
			
		}else
		{
			$db->query("INSERT INTO ".table('shop')." SET starttime=".time().",catid='$catid',smid='$smid',amid='$amid',shopname='$shopname',provinceid='$provinceid',cityid='$cityid',townid='$townid',address='$address',qq='$qq',phone='$phone',shopno='$shopno',info='$info',siteid='$siteid' ");
			
			$shopid=$db->insert_id();
			$db->query("INSERT INTO ".table('shop_data')." SET shopid='$shopid',content='$content' ");
		}
		
			$db->query("DELETE FROM ".table('shoparea')." WHERE shopid='$shopid' ");
			$db->query("INSERT INTO ".table('shoparea')." set shopid='$shopid',provinceid=".intval($provinceid).",cityid=".intval($cityid).",townid=".intval($townid)." ");
			if($shopareas)
		{
			foreach($shopareas as $shoparea)
			{
				list($provinceid,$cityid,$townid)=explode(",",$shoparea);
				if(!$db->getOne("SELECT shopid FROM ".table('shoparea')." WHERE provinceid=".intval($provinceid)." and cityid=".intval($cityid)." and townid=".intval($townid)." AND shopid='$shopid' "))
				{
				$db->query("INSERT INTO ".table('shoparea')." set shopid='$shopid',provinceid=".intval($provinceid).",cityid=".intval($cityid).",townid=".intval($townid).",siteid='$siteid' ");
				}
			}
		}
		gourl();
	break;
	case 'del':
		$shopid=intval($_GET['shopid']);
		$db->query("DELETE FROM ".table('shop')." WHERE shopid='$shopid' ");
		gourl();
	break;
	
	case 'recommend':
		$shopid=intval($_GET['shopid']);
		$isrecommend=intval($_GET['isrecommend']);
		$db->query("UPDATE ".table('shop')." SET isrecommend='$isrecommend' WHERE shopid='$shopid' ");
	break;
	
	case 'hot':
		$shopid=intval($_GET['shopid']);
		$ishot=intval($_GET['ishot']);
		$db->query("UPDATE ".table('shop')." SET ishot='$ishot' WHERE shopid='$shopid' ");
	break;
	
	case 'new':
		$shopid=intval($_GET['shopid']);
		$isnew=intval($_GET['isnew']);
		$db->query("UPDATE ".table('shop')." SET isnew='$isnew' WHERE shopid='$shopid' ");
	break;
	
	case 'visible':	
		$shopid=intval($_GET['shopid']);
		$visible=intval($_GET['visible']);
		$db->query("UPDATE ".table('shop')." SET visible='$visible' WHERE shopid='$shopid' ");
	break;
	
	case 'cat':
		if($_GET['op']=='post')
		{
			$cnames=$_POST['cname'];
			$orderindexs=$_POST['orderindex'];
			if($cnames)
			{
				foreach($cnames as $catid=>$cname)
				{
					$db->query("UPDATE ".table('shop_cat')." SET cname='".$cname."',orderindex=".$orderindexs[$catid]." WHERE  catid='$catid' ");
				}
			}
			$newcname=htmlspecialchars(trim($_POST['newcname']));
			$neworderindex=intval($_POST['neworderindex']);
			if($newcname)
			{
				$db->query("INSERT INTO ".table('shop_cat')." SET siteid='$siteid',cname='$newcname',orderindex='$neworderindex' ");
			}
			gourl();
		}elseif($_GET['op']=='del'){
			$catid=intval($_GET['catid']);
			$db->query("DELETE FROM ".table('shop_cat')." WHERE catid='$catid' ");
			gourl();
		}else
		{
			$smarty->assign("catlist",$db->getAll("SELECT * FROM ".table('shop_cat')." ORDER BY orderindex ASC,catid ASC  "));
			$smarty->display("shop_cat.html");
		}
	break;

	case 'avgmoney':
		if($_GET['op']=='post')
		{
			$cnames=$_POST['cname'];
			$orderindexs=$_POST['orderindex'];
			if($cnames)
			{
				foreach($cnames as $amid=>$cname)
				{
					$db->query("UPDATE ".table('shop_avgmoney')." SET cname='".$cname."',orderindex=".$orderindexs[$amid]." WHERE  amid='$amid' ");
				}
			}
			$newcname=htmlspecialchars(trim($_POST['newcname']));
			$neworderindex=intval($_POST['neworderindex']);
			if($newcname)
			{
				$db->query("INSERT INTO ".table('shop_avgmoney')." SET siteid='$siteid',cname='$newcname',orderindex='$neworderindex' ");
			}
			echo "why";
			gourl();
		}elseif($_GET['op']=='del'){
			$amid=intval($_GET['amid']);
			$db->query("DELETE FROM ".table('shop_avgmoney')." WHERE amid='$amid' ");
			gourl();
		}else
		{
			$smarty->assign("catlist",$db->getAll("SELECT * FROM ".table('shop_avgmoney')." ORDER BY orderindex ASC  "));
			$smarty->display("shop_avgmoney.html");
		}
	break;
	

	case 'sendmoney':
		if($_GET['op']=='post')
		{
			$cnames=$_POST['cname'];
			$orderindexs=$_POST['orderindex'];
			if($cnames)
			{
				foreach($cnames as $smid=>$cname)
				{
					$db->query("UPDATE ".table('shop_sendmoney')." SET cname='".$cname."',orderindex=".$orderindexs[$smid]." WHERE  smid='$smid' ");
				}
			}
			$newcname=htmlspecialchars(trim($_POST['newcname']));
			$neworderindex=intval($_POST['neworderindex']);
			if($newcname)
			{
				$db->query("INSERT INTO ".table('shop_sendmoney')." SET siteid='$siteid',cname='$newcname',orderindex='$neworderindex' ");
			}
			gourl();
		}elseif($_GET['op']=='del'){
			$smid=intval($_GET['smid']);
			$db->query("DELETE FROM ".table('shop_sendmoney')." WHERE smid='$smid' ");
			gourl();
		}else
		{
			$smarty->assign("catlist",$db->getAll("SELECT * FROM ".table('shop_sendmoney')." ORDER BY orderindex ASC  "));
			$smarty->display("shop_sendmoney.html");
		}
	break;
	
	
	case 'apply':
		if($_GET['op']=='status')
		{
			$id=$db->query("UPDATE ".table('shop')." SET status=1 WHERE shopid=".intval($_GET['shopid'])." ");
			
		}else
		{		
			assignlist("shop",30," AND status=0 "," ORDER BY shopid DESC ","admin.php?m=shop&a=apply");
			$smarty->display("shop_apply.html");
		}
	break;
	
	case 'check':
			
			switch($_GET['op'])
			{
				case "del":
						$id=intval($_GET['id']);
						$db->query("DELETE FROM ".table('shop_check')." WHERE id='$id' ");
						exit;
					break;
				case 'status':
						$id=intval($_GET['id']);
						$db->query("UPDATE ".table('shop_check')." SET status=1 WHERE id='$id' ");
						exit;
					break;
				default:
						assignlist("shop_check",5," AND siteid='$siteid' ","","admin.php?m=shop&a=check");
						
						$smarty->display("shop_check.html");
					break;
			}
		break;
	
}
?>