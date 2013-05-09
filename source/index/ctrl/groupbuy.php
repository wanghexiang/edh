<?php
$_GET['a']=isset($_GET['a'])?htmlspecialchars($_GET['a']):'index';
switch($_GET['a'])
{
	case 'index':
			$catid=intval($_GET['catid']);
			$w=" AND siteid='$cksiteid' AND status=1 ";
			$w.=$catid?" AND catid='$catid' ":'';
			$url='index.php?m=groupbuy';
			$url.=$catid?"&catid=$catid":"";
			assignlist("groupbuy",10,$w,'',$url);
			$smarty->assign("catlist",$db->getAll("SELECT cname,catid FROM ".table('groupbuy_category')." ORDER BY orderindex ASC "));
			$smarty->display("groupbuy.html");
		break;
	case 'show':
			$_GET['id']=intval($_GET['id']);
			$smarty->assign("groupbuy",$groupbuy=$db->getRow("SELECT * FROM ".table('groupbuy')." WHERE id=".$_GET['id']." AND status=1 "));
			if(empty($groupbuy))
			{
				errback("此团购不存在或者被禁止","index.php");
			}
			$_GET['shopid']=$groupbuy['shopid'];
			getshopinfo($groupbuy['shopid'],1);
			$smarty->display("groupbuy_show.html");
		break;
	case 'join':
			if(!$_SESSION['ssuser']['userid'])
			{
				errback('请先登录','index.php?m=user&a=login');
			}
			$balance=$db->getOne("SELECT balance FROM ".table('user')." WHERE userid=".intval($_SESSION['ssuser']['userid'])." LIMIT 1 ");
			if($_GET['op']=='post')
			{
				$goodsnum=intval($_POST['goodsnum']);
				$id=intval($_POST['id']);
				$groupbuy=$db->getRow("SELECT * FROM ".table('groupbuy')." WHERE id='$id' AND status=1 LIMIT 1 ");
				if($groupbuy['endtime']<time())
				{
					errback('团购已到期不能参与');
				}
				//检查数量
				if($groupbuy['goods_num']<$goodsnum){
					errback('团购商品数不足！');
				}
				
				$ispay=intval($_POST['ispay']);
				$phone=htmlspecialchars(trim($_POST['phone']));
				$address=htmlspecialchars(trim($_POST['address']));
				$totalprice=$groupbuy['groupprice']*$goodsnum;
				if($ispay)
				{
					if($totalprice>$balance)
					{
						errback('您的余额不足不能在线支付，请先充值，或者选择到付');
					}else
					{
						$db->query("UPDATE ".table('user')." SET balance=balance-".$totalprice." WHERE userid=".intval($_SESSION['ssuser']['userid'])." ");
						//用户余额使用记录
						$content="您参与团购<a href='index.php?m=group&a=show&id=".$groupbuy['id']."' target='_blank'>".$groupbuy['title']."</a> ，购买数量".$goodsnum."，总价".$totalprice."元 ";
						$db->query("INSERT INTO ".table('user_paylog')." SET userid=".intval($_SESSION['ssuser']['userid']).",content='".addslashes($content)."',money='-$totalprice',dateline=".time()." ");
						//店铺余额使用记录
						$content="用户".$_SESSION['ssuser']['nickname']."参与团购<a href='index.php?m=group&a=show&id=".$groupbuy['id']."' target='_blank'>".$groupbuy['title']."</a> ，购买数量".$goodsnum."，获得".$totalprice."元 ";
						$db->query("INSERT INTO ".table('shop_paylog')." SET shopid=".$groupbuy['shopid'].",dateline=".time().",content='".addslashes($content)."',money='+$totalprice' ");
						$db->query("UPDATE ".table('shop')." SET balance=balance+".$totalprice." WHERE shopid=".$groupbuy['shopid']." ");
					}
				}
					 
				$db->query("INSERT INTO ".table('groupbuy_order')." SET ispay='$ispay',phone='$phone',address='$address',groupid=".$groupbuy['id'].",userid=".$_SESSION['ssuser']['userid'].",goodsnum='$goodsnum',title='".$groupbuy['title']."',dateline=".time().",groupprice=".$groupbuy['groupprice'].",totalprice=".$totalprice.",nickname='".$_SESSION['ssuser']['nickname']."' ");
				//增加
				$db->query("UPDATE ".table('groupbuy')." SET joins=joins+1,goods_num=goods_num-'$goodsnum' WHERE id=".$groupbuy['id']." "); 
				errback('团购成功，感谢你的参与','index.php?m=groupbuy&a=my');
			}else
			{
				$smarty->assign("addresslist",$db->getAll("SELECT id,address FROM ".table('user_address')." WHERE userid=".intval($_SESSION['ssuser']['userid'])." "));
	
				$_GET['id']=intval($_GET['id']);
				$smarty->assign("balance",$balance);
				$smarty->assign("groupbuy",$db->getRow("SELECT * FROM ".table('groupbuy')." WHERE id=".$_GET['id']." "));
				$smarty->assign("phone",$db->getOne("SELECT phone FROM ".table('user')." WHERE userid=".intval($_SESSION['ssuser']['userid'])." "));
				$smarty->display("groupbuy_join.html");
			}
		break;
		
	case 'shop':
			$shopid=intval($_GET['shopid']);
			assignlist('groupbuy',10," AND shopid='$shopid' ",'',"index.php?m=groupbuy&a=shop&shopid=$shopid");
			getshopinfo($shopid,1);
			$smarty->display("shop_groupbuy.html");
		break;
	case 'my':
			assignlist('groupbuy_order',20," AND userid=".intval($_SESSION['ssuser']['userid'])." "," ORDER BY orderid DESC ","index.php?m=groupbuy&a=my");
			$smarty->display("groupbuy_my.html");
		break; 
}

?>