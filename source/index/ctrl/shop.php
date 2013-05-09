<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

loadModel(array("user","cai"));
$_GET['a']=isset($_GET['a'])?htmlspecialchars($_GET['a']):'index';
$shopid=intval($_GET['shopid']);
$catid=intval($_GET['catid']);
loadModel('shop');
 
switch($_GET['a'])
{
	case 'index':
		header("Content-type:text/html;charset=gb2312");
		//增加点击率
		$shopModel->addClick($shopid);
		$userid=intval($_SESSION['ssuser']['userid']);
		//调用购物车信息
		$shopcarinfo=shopcarinfo($shopid);
		$smarty->assign("totalmoney",$shopcarinfo['totalmoney']);
		$smarty->assign("shopcart",$shopcarinfo['shoplist']);
		$isfav=$db->getOne("SELECT shopid FROM ".table('fav_shop')." WHERE userid='$userid' AND shopid='$shopid'  ");
		
		$cat=array();
		$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' AND siteid='$cksiteid' AND visible=0    ");
		if(!$shop)
		{
			errback("店铺不存在或者已经禁止",'index.php');
		}
		//计算店铺距离
		if($_SESSION['ssuser']['lat']<>0){
			$shop['distance']=distanceByLnglat($_SESSION['ssuser']['lat'],$_SESSION['ssuser']['lng'],$shop['lat'],$shop['lng']);
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
		$smarty->assign("shopconfig",$shopconfig);
		if($shopconfig['showweek']){
			$shop['caicat']=$caiModel->getByWeek($shopid,3);
		}else{
				//查询特定分类下菜品信息
				if(!empty($catid))
				$foods=shopcailist($shopid," AND catid=".$catid."");
				else 
				$foods=shopcailist($shopid);
		}
		//查询菜品分类
		$fenlei=$db->query("SELECT * FROM ".table('cai_cat')." WHERE shopid=".$shopid." ");
		while ($result=$db->fetch_array($fenlei)) {
			$cats[]=$result;
		}
		//查询店家信息
		$sql="select * ,s.phone as mobiles FROM ".table('shop')." s  LEFT JOIN ".table('shopconfig')." c ON s.shopid=c.shopid  left join ".table('shop_cat')." cat on cat.catid=s.catid left join shop_data on s.shopid=shop_data.shopid WHERE s.shopid='$shopid'";
		$s=$db->query($sql); 
		$shopinfo=$db->fetch_array($s);
		//print_r($shopinfo);
		//查询当前分类
		$current_cat_sql="select * from ".table('cai_cat')." where catid=".$catid ." and shopid=".$shopid;
		$current_cat=$db->fetch_array($db->query($current_cat_sql));
		
		$smarty->assign("foods",$foods);
		$smarty->assign("cats",$cats);
		$smarty->assign("shopinfo",$shopinfo);
		$smarty->assign("current_cat",$current_cat); 
	
		
		if($_GET['ajax'])
		{
			$smarty->display('ajaxshopinfo.html');
		}else
		{
			//附近的商店
			if($shop['lat'])
			{
				$ilng=$shop['lng']+$meter;
				$mlng=$shop['lng']-$meter;
				$ilat=$shop['lat']+$meter;
				$mlat=$shop['lat']-$meter;
				$shoplist=$db->getAll(" SELECT shopid,shopname FROM ".table('shop')."   WHERE  (lng<'$ilng' AND  lng>'$mlng' AND  lat>'$mlat' AND  lat<'$ilat')  AND visible=0  LIMIT 0,10  ");
				$smarty->assign('shoplist',$shoplist);
				
			}
			/*留言板*/
			$guestlist=$db->getAll("SELECT * FROM ".table('guest')." WHERE status=1 AND shopid='$shopid' AND siteid='$cksiteid' ORDER BY id DESC LIMIT 10 ");
			$smarty->assign("guestlist",$guestlist);
			//seo项
			$seo=array(
				"title"=>$shop['shopname']."|".$web['webtitle'],
				"keywords"=>$shop['shopname'].",".$web['webkey'],
				"description"=>$shop['info']
			);
			$smarty->assign("seo",$seo);
			 
			$smarty->display("shopindex.html");
		}
	break;
	
	case 'detail':
		$userid=intval($_SESSION['ssuser']['userid']);
		getshopinfo($shopid,1);
		$shopcarinfo=shopcarinfo($shopid);
		$smarty->assign("totalmoney",$shopcarinfo['totalmoney']);
		$smarty->assign("shopcart",$shopcarinfo['shoplist']);
		$smarty->display("shop_detail.html");		
	break;
	
	case 'promote':
		$userid=intval($_SESSION['ssuser']['userid']);
		getshopinfo($shopid,1);
		$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' AND siteid='$cksiteid' AND visible=0    ");
		$shopcarinfo=shopcarinfo($shopid);
		$smarty->assign("totalmoney",$shopcarinfo['totalmoney']);
		$smarty->assign("shopcart",$shopcarinfo['shoplist']);
		$cailist=$db->getAll("SELECT * FROM ".table('cai')." WHERE shopid='$shopid' AND promote=1 ");
		$smarty->assign("cailist",$cailist);
		//seo项
			$seo=array(
				"title"=>$shop['shopname']."外卖促销|".$web['webtitle'],
				"keywords"=>$shop['shopname'].",外卖促销".$web['webkey'],
				"description"=>$shop['info']
			);
			$smarty->assign("seo",$seo);
		$smarty->display("shop_promote.html");
	
	break;
	case 'guest':
		getshopinfo($shopid,1);
		$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' AND siteid='$cksiteid' AND visible=0    ");
		assignlist("guest",10," AND shopid='$shopid' AND status=1   ",'',"index.php?m=shop&a=guest&shopid=$shopid");
		//seo项
			$seo=array(
				"title"=>$shop['shopname']."的店铺留言",
				"keywords"=>$shop['shopname']."的店铺留言".$web['webkey'],
				"description"=>$shop['info']
			);
			$smarty->assign("seo",$seo);
		$smarty->display("shop_guest.html");
	break;
	case 'comment':
		
		getshopinfo($shopid,1);
		assignlist("shop_comment",10," AND shopid='$shopid' ",'',"index.php?m=shop&a=comment&shopid=$shopid");
		$smarty->display("shop_comment.html");
	break;
	
	case 'neworder':
		getshopinfo($shopid,1);
		$shop=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid='$shopid' AND siteid='$cksiteid' AND visible=0    ");
		$res=$db->query("SELECT * FROM ".table('order')." WHERE shopid='$shopid' AND isvalid=1 ORDER BY id DESC LIMIT 30 ");
		$oids=array();
		while($rs=$db->fetch_array($res))
		{
			$list[$rs['id']]=$rs;
			$oids[]=$rs['id'];
		}
		
		if($oids)
		{
			$res2=$db->query("SELECT c.title,oc.orderid FROM ".table('order_cai')." oc LEFT JOIN ".table('cai')." c ON oc.caiid=c.id WHERE oc.orderid in("._implode($oids).") ");
			while($r2=$db->fetch_array($res2))
			{
				$list[$r2['orderid']]['cais'][]=$r2;
			}
		}
		$seo=array(
				"title"=>$shop['shopname']."的最新订单",
				"keywords"=>$shop['shopname']."的最新订单".$web['webkey'],
				"description"=>$shop['info']
			);
		$smarty->assign("seo",$seo);
		$smarty->assign("list",$list);
		$smarty->display("shop_neworder.html");
	break;
	
	case 'apply':
		check_login();
		$userid=intval($_SESSION['ssuser']['userid']);
		if($db->getOne("SELECT shopid FROM ".table('user')." WHERE userid='$userid' "))
		{
			errback("您已经申请过了","index.php");
		}
		if($_GET['op']=='post')
		{
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
			
			if(empty($shopname))
			{
				errback('商店名称不能为空');
			}
			$db->query("INSERT INTO ".table('shop')." SET userid='$userid',starttime=".time().",catid='$catid',shopname='$shopname',provinceid='$provinceid',cityid='$cityid',townid='$townid',address='$address',qq='$qq',phone='$phone',shopno='$shopno',info='$info',siteid='$cksiteid',visible=1 ");
			$shopid=$db->insert_id();
			$db->query("UPDATE ".table('user')." SET shopid='$shopid' WHERE userid='$userid' ");
			$db->query("INSERT INTO ".table('shoparea')." set shopid='$shopid',provinceid=".intval($provinceid).",cityid=".intval($cityid).",townid=".intval($townid)." ");
			$db->query("INSERT INTO ".table('shop_data')." SET shopid='$shopid',content='申请中' ");

			errback("您的开店申请已经成功发出，请等待审核！");
		}else
		{
			$provinces=provinces($cksiteid);
			$smarty->assign("provinces",$provinces);
			$smarty->assign("catlist",$db->getAll("SELECT catid,cname FROM ".table('shop_cat')." ORDER BY orderindex ASC "));
			$smarty->display("shop_apply.html");
		}
	break;
	
	case 'check':
				if($_GET['op']=='post')
				{
					$shopid=intval($_POST['shopid']);
					$shopname=$db->getOne("SELECT shopname FROM ".table('shop')." WHERE shopid='$shopid' ");
					$content=htmlspecialchars(trim($_POST['content']));
					$db->query("INSERT INTO ".table('shop_check')." SET userid=".intval($_SESSION['ssuser']['userid']).",siteid='$cksiteid',shopid=".$shopid.",shopname='$shopname',content='$content',dateline=".time()." ");
					errback('感谢你的纠错',"index.php?m=shop&shopid=$shopid");
				}else
				{
					$smarty->assign("shop",$db->getRow("SELECT shopid,shopname FROM ".table('shop')." WHERE shopid=".intval($_GET['shopid'])." "));
					$smarty->display("shop_check.html");
				}
		break;
		
	case 'ajaxcailist':
			header("Content-type:text/html;charset=gb2312");
			$shopid=intval($_GET['shopid']);
			$cailist=$db->getAll("SELECT * FROM ".table('cai')." WHERE shopid='$shopid'   ");
			$smarty->assign("cailist",$cailist);
			$smarty->display("ajax_cailist.html");
		break;
	case 'mycomment':
			check_login();
			assignlist("shop_comment",10," AND userid=".$_SESSION['ssuser']['userid']." ",'',"index.php?m=shop&a=mycomment");
			$smarty->display("user_mycomment.html");
		break;


}

?>