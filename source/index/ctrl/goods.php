<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):"";
$userid=intval($_SESSION['ssuser']['userid']);
switch($_GET['a'])
{
	case 'cat':
			$pagesize=21;
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$catid=$_GET['catid']=intval($_GET['catid']);
			$w=$catid?" AND g.catid='$catid' ":"";
			$grade=$db->getOne("SELECT usegrade FROM ".table('user')." WHERE userid='$userid' ");
			$grade2=$db->getOne("SELECT SUM(grade) FROM ".table('goods_order')." WHERE userid='$userid' AND sendtype=0  ");
			$smarty->assign("usegrade",($grade-$grade2));
			
			$catrs=$db->getRow("SELECT catid,cname FROM ".table('goods_cat')." WHERE catid='$catid' ");
			$smarty->assign("catrs",$catrs);
			$smarty->assign("goodscat",$db->getAll("SELECT catid,cname,orderindex FROM ".table('goods_cat')." ORDER BY orderindex ASC LIMIT 200  "));
			$list=$db->getAll("SELECT g.*,c.cname FROM ".table('goods')." g LEFT JOIN ".table('goods_cat')." c ON g.catid=c.catid WHERE g.visible=1 $w LIMIT $start,$pagesize ");
			$rscount=$db->getOne("SELECT count(1) FROM ".table('goods')." g WHERE g.visible=1 $w ");
			$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=goods&a=cat"));
			$smarty->assign("list",$list);
			//推荐商品
			$smarty->assign("recommendgoods",$db->getAll("SELECT g.*,c.cname FROM ".table('goods')." g LEFT JOIN ".table('goods_cat')." c ON g.catid=c.catid   WHERE g.visible=1 $w LIMIT 10"));
			//seo项
			$smarty->assign("title",$web['webtitle']);
			$smarty->assign("keywords",$web['webkey']);
			$smarty->assign("description",$web['webdesc']);
			$smarty->display("goods_cat.html");
		break;
	case 'list':
	
			$smarty->display("goods_list.html");
		break;
	case 'detail':
			$grade=$db->getOne("SELECT usegrade FROM ".table('user')." WHERE userid='$userid' ");
			$grade2=$db->getOne("SELECT SUM(grade) FROM ".table('goods_order')." WHERE userid='$userid' AND sendtype=0   ");
			$smarty->assign("usegrade",($grade-$grade2));
			$id=intval($_GET['id']);
			$goods=$db->getRow("SELECT g.*,c.cname FROM ".table('goods')." g LEFT JOIN ".table('goods_cat')." c ON g.catid=c.catid   WHERE g.id='$id' ");
			$db->query("UPDATE ".table('goods')." SET clicks=clicks+1 WHERE id='$id' ");
			$smarty->assign("goodscat",$db->getAll("SELECT catid,cname,orderindex FROM ".table('goods_cat')." ORDER BY orderindex ASC LIMIT 100 "));
			$smarty->assign("goods",$goods);
			//推荐商品
			$smarty->assign("recommendgoods",$db->getAll("SELECT g.*,c.cname FROM ".table('goods')." g LEFT JOIN ".table('goods_cat')." c ON g.catid=c.catid   WHERE g.catid=".$goods['catid']." LIMIT 10 "));
			require_once("includes/cls_comment.php");
			commentlist("goods_comment","index.php?m=goods&a=detail",$id);
			
			//获取上下篇
			$sql.=" SELECT id,title FROM ".table('goods')." where catid=".$goods['catid']." AND visible=1 ";
			$nx=$db->getRow($sql." and id>".$id." order by id asc ");
			if($nx)
			{
				$nextrs="<a href=\"index.php?m=goods&a=detail&id=".$nx['id']."\">".$nx['title']."</a>";
			}else
			{
				$nextrs="已经是最后一条记录";
			}
			$lx=$db->getRow($sql." and id<'$id' order by id desc ");
			if($lx)
			{
				$lastrs="<a href=\"index.php?m=goods&a=detail&id=".$lx['id']."\">".$lx['title']."</a>";
			}else
			{
				$lastrs="已经是第一条记录";	
			}
			$smarty->assign("nextrs",$nextrs);
			$smarty->assign("lastrs",$lastrs);
			//当前位置
			$where="<a href=\"".$web['weburl']."\">网站首页</a> ";
			$where.=" / <a href=\"index.php?m=goods&a=cat&catid={$goods['catid']}\">".$goods['cname']."</a>";
			$where.=" / ".$goods['title'];
			$smarty->assign("where",$where);
			//seo项
			$smarty->assign("title",$goods['title']."-".$web['webtitle']);
			$smarty->assign("keywords",$goods['title'].",".$web['webkey']);
			$smarty->assign("description",$goods['info']);
			$smarty->display("goods.html");
		break;
	case 'addcomment':
			require_once("includes/cls_comment.php");
			addcomment("goods_comment","index.php?m=goods&a=detail&id=");
		break;
	case 'order':
			if(empty($_SESSION['ssuser']['userid']))
			{
				errback('请先登录','index.php?m=user&a=login');
			}
			$grade=$db->getOne("SELECT usegrade FROM ".table('user')." WHERE userid='$userid' ");
			$grade2=$db->getOne("SELECT SUM(grade) FROM ".table('goods_order')." WHERE userid='$userid' AND sendtype=0  ");
			$usegrade=$grade-$grade2;
			$smarty->assign("usegrade",$usegrade);
			if($_GET['op']=='buy')
			{
				$goodsid=intval($_POST['goodsid']);
				$goods=$db->getRow("SELECT *  FROM ".table('goods')."   WHERE id='$goodsid' ");
				if($usegrade<$goods['grade'])
				{
					errback('你的积分不足，不能兑换该商品');
				}
				$nickname=htmlspecialchars($_POST['nickname']);
				$phone=htmlspecialchars($_POST['phone']);
				$address=htmlspecialchars($_POST['address']);
				$orderno=$userid.time();
				$db->query("INSERT INTO ".table('goods_order')." SET orderno='$orderno',goodsid='$goodsid',grade=".intval($goods['grade']).",userid='$userid',nickname='$nickname',address='$address',phone='$phone',isvalid=1,money=".floatval($goods['money']).",dateline=".time()."  ");
				
				errback('恭喜，积分兑换成功。','index.php?m=goods&a=cat');
				
			}else
			{
				$id=intval($_GET['id']);
				$goods=$db->getRow("SELECT g.*,c.cname FROM ".table('goods')." g LEFT JOIN ".table('goods_cat')." c ON g.catid=c.catid   WHERE g.id='$id' ");
				if($usegrade<$goods['grade'])
				{
					errback('你的积分不足，不能兑换该商品');
				}
				$smarty->assign("addresslist",$db->getAll("SELECT id,address FROM ".table('user_address')." WHERE userid=".intval($_SESSION['ssuser']['userid'])." "));
				$user=$db->getRow("SELECT username,nickname,phone,address FROM ".table('user')." WHERE userid='$userid' ");
				$smarty->assign("goods",$goods);
				$smarty->assign("user",$user);
				$smarty->display("goods_order.html");
			}
		break;
}

?>