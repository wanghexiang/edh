<?php
if(!defined("CT"))
{
	die("IS WRONG");
}
$_GET['a']=$_GET['a']?htmlspecialchars(trim($_GET['a'])):'index';
switch($_GET['a'])
{
	case 'index':
		$userid=intval($_SESSION['ssuser']['userid']);
		//初始化 区域
		if(isset($_GET['provinceid'])){
			setcookie("selectarea[provinceid]",intval($_GET['provinceid']),time()+3600000);
		}else{
			$_GET['provinceid']=intval($_COOKIE['selectarea']['provinceid']);
		}
		
		if(isset($_GET['cityid'])){
			setcookie("selectarea[cityid]",intval($_GET['cityid']),time()+3600000);
		}else{
			$_GET['cityid']=intval($_COOKIE['selectarea']['cityid']);
		}
		
		if(isset($_GET['townid'])){
			setcookie("selectarea[townid]",intval($_GET['townid']),time()+3600000);
		}else{
			$_GET['townid']=intval($_COOKIE['selectarea']['townid']);
		}
		
		
		//区域选择
		$provinces=provinces($cksiteid);
		$smarty->assign("provinces",$provinces);
		if($_GET['provinceid'])
		{
			$_GET['provinceid']=intval($_GET['provinceid']);
			
			$citys=citys(intval($_GET['provinceid']));
			$towns=towns(intval($_GET['cityid']));
			$smarty->assign("citys",$citys);
			$smarty->assign("towns",$towns);
		}
		//店铺类目
		$_GET['catid']=intval($_GET['catid']);
		$catlist=$db->getAll("SELECT * FROM ".table('shop_cat')."  ORDER BY orderindex ASC ");
		$smarty->assign("catlist",$catlist);
		//起送金额
		$_GET['smid']=intval($_GET['smid']);
		$smlist=$db->getAll("SELECT * FROM ".table('shop_sendmoney')." ORDER BY orderindex ASC ");
		$smarty->assign("smlist",$smlist);
		//平均消费
		$_GET['amid']=intval($_GET['amid']);
		$amlist=$db->getAll("SELECT * FROM ".table('shop_avgmoney')." ORDER BY orderindex ASC ");
		$smarty->assign("amlist",$amlist);
		extract($_GET);
		//区域结束
		$sw="";
		$shopids=array();
		if(intval($_GET['provinceid']))
		{
			$sw.=" AND s.provinceid=".intval($_GET['provinceid'])." ";
			if(intval($_GET['cityid']))
			{
				$sw.=" AND s.cityid=".intval($_GET['cityid'])." ";
				if(intval($_GET['townid']))
				{
					$sw.=" AND s.townid=".intval($_GET['townid'])." ";
				}
				
			}
			
		}
		//限定地区
		$townid=intval($_GET['townid']);
		if(intval($_GET['townid']))
				{
					$sw.=" AND s.townid=".intval($_GET['townid'])." ";
				}
		//获取三级地区信息 用于头部显示现在所在地区
		$town=$db->getRow("SELECT * FROM ".table('town')." WHERE townid=".$townid);
		$smarty->assign("town",$town['town']);
		if($_GET['catid'])
		{
			$sw.=" AND s.catid=".intval($_GET['catid'])." ";
		}
		if($amid)
		{
			$sw.=" AND s.amid=$amid ";
		}
		if($smid)
		{
			$sw.=" AND s.smid=$smid ";
		}
		
		$order='';
		$_GET['orderby']=isset($_GET['orderby'])?htmlspecialchars(trim($_GET['orderby'])):'orders';
		switch($_GET['orderby'])
		{
			case 'orders ':
					$order=" ORDER BY s.orders DESC";
				break;
			
			case 'new':
					$order=" ORDER BY s.shopid DESC ";
				break;
			
			default :
					$order="ORDER BY s.orders DESC ";
				break;
		}
		
		$smarty->assign("shopnum",$shopnum=$db->getOne("SELECT count(*) FROM ".table("shop")." s    WHERE s.siteid='$cksiteid' AND s.visible=0 $sw "));
		
		
		//调用收藏
		$favshops=$db->getCols("SELECT shopid FROM ".table('fav_shop')." WHERE userid=".$userid." ");
		//调用购物车信息
		$shopcarinfo=shopcarinfo(); 
		
		$smarty->assign("shopcart",$shopcarinfo['shoplist']); 
		$smarty->assign("totalmoney",$shopcarinfo['totalmoney']);
		$pagesize=ISWAP?12:21;
		$page=max(1,intval($_GET['page']));
		$start=($page-1)*$pagesize;
		$sql="SELECT s.sendplace,s.shopid,s.shopname,s.logo,s.phone,s.address,s.info,s.lat,s.lng,s.sendarea,c.opentime,c.starthour,c.endhour,c.startminute,c.endminute,c.showweek,c.minprice FROM ".table('shop')." s  LEFT JOIN ".table('shopconfig')." c ON s.shopid=c.shopid WHERE s.siteid='$cksiteid' AND s.visible=0 $sw  $order  LIMIT $start,$pagesize ";
		
		
		$res=$db->query($sql);
		while($rs=$db->fetch_array($res))
		{
			//计算店铺距离
			if($_SESSION['ssuser']['lat']<>0){
					$rs['distance']=distanceByLnglat($_SESSION['ssuser']['lat'],$_SESSION['ssuser']['lng'],$rs['lat'],$rs['lng']);
			}
			if($favshops)
			{
				if(in_array($rs['shopid'],$favshops))
				{
					$rs['isfav']=1;
				}
				
			}
			//判断店铺的状态是否在营业中  by whx
			$hour=date("H",time());  
			$minute=date("i",time());  
			$flag=1;
			if($rs['starthour']>$hour)
			{
				$flag=2;
			}
			if($rs['starthour']==$hour){
				if($rs['startminute']>$minute)
				{
					$flag=2;
				}	
			}
			if($rs['endhour']<$hour)
			{
				$flag=2;
			}
			if($rs['endthour']==$hour){
				if($rs['endminute']<$minute)
				{	$flag=2;
				}
			}
			$rs['flag']=$flag;
			$shoplist[]=$rs;
          
		}
		
		//得到收藏店铺
		$userid=$_SESSION['ssuser']['userid'];
		
		if($userid){
			$fav=$db->getAll("SELECT * FROM ".table('fav_shop').",".table('shop')." WHERE  fav_shop.userid='$userid' AND fav_shop.shopid=shop.shopid  LIMIT 6 "); 
			//$fav=$db->getAll("SELECT * FROM ".table('guest')." WHERE status=1 AND shopid='$shopid' AND siteid='$cksiteid' ORDER BY id DESC LIMIT 10 ");
		}
		
		
		//推荐店铺
		$recommend=$db->getAll("SELECT * FROM ".table('shop')." WHERE isrecommend=1  LIMIT 6 "); 
		//$fav=$db->getAll("SELECT * FROM ".table('guest')." WHERE status=1 AND shopid='$shopid' AND siteid='$cksiteid' ORDER BY id DESC LIMIT 10 ");
	   
		$smarty->assign("shoplist",$shoplist);
		$smarty->assign("recommend",$recommend);
		$smarty->assign("fav",$fav);
		$smarty->assign("pagelist",multipage($shopnum,$pagesize,$page,"index.php?m=shoplist&provinceid=$provinceid&cityid=$cityid&townid=$townid&catid=$catid&smid=$smid&amid=$amid&orderby=".$_GET['orderby']));
		
		//seo项
		$smarty->assign("title",$web['webtitle']);
		$smarty->assign("keywords",$web['webkey']);
		$smarty->assign("description",$web['webdesc']);
		$smarty->display("shoplist.html");
	break;	
}

?>