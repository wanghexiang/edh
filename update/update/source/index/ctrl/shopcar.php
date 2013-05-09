<?php
if(!defined("CT"))
{
	die("IS WRONG");
}


/*-------------------购物车---------------------------*/

function ontotalmoney()
{
	global $cksiteid,$ss_id;
	$userid=intval($_SESSION['ssuser']['userid']); 
	$wu=$userid?"(s.userid=".$userid." OR s.ssid='{$ss_id}')" : "   s.ssid='{$ss_id}'";
	echo $GLOBALS['db']->getOne("select sum(s.cainum*s.price) from ".table('shopcar')."   s   where $wu  AND s.siteid='$cksiteid' ");
}
	
function onIndex()
{
	global $web;
	$s=shopcarinfo(get_post('shopid','i'));
	
	$GLOBALS['smarty']->assign("totalmoney",$s['totalmoney']);
	$GLOBALS['smarty']->assign("where","<a href='{$web['weburl']}'>首页</a> > 购物车");
	
	if($_GET['ajax'])
	{
		header("Content-type:text/html;charset=gb2312");
		$GLOBALS['smarty']->assign("shopcart",$s['shoplist']);
		$GLOBALS['smarty']->display("ajax_shopcar.html");
		 
	}else
	{
		$GLOBALS['smarty']->assign("shopcarlist",$s['shoplist']);
		$GLOBALS['smarty']->display("shopcar.html");
	}
}


function onAdd_db()
{
	global $db,$cksiteid,$ss_id;
	/*添加到购物车*/
	@header("Content-type:text/html;charset=gb2312");
	
	$caiid=intval($_GET['caiid']);
	$cainum=max(1,intval($_GET['cainum']));
	$cai=$db->getRow("SELECT * FROM ".table('cai')." WHERE id='$caiid' AND siteid='$cksiteid' ");
	
	if(!$caiid or !$cai)
	{
		if($_GET['ajax'])
		{
			
			echo "发生错误，未能成功添加到购物车1";
			exit();
		}else
		{
			errback('发生错误，未能成功添加到购物车');
		}
	}
	//缺货
	if($cai['oos']==1)
	{
		if($_GET['ajax'])
		{
			echo "很抱歉,该美食已经卖完了";
			exit();
		}else
		{
			errback('很抱歉，该美食已经卖完了');
		}
	}
	
	//商店配置
	$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid=".$cai['shopid']." ");
	if($shopconfig['ordertype'])
	{
		if($_GET['ajax'])
		{
			echo "很抱歉,该店铺只支持电话预定";
			exit();
		}else
		{
			errback('很抱歉,该店铺只支持电话预定');
		}
	}
	//如果开启经营时间 判断是否在营业时间段
	$opentype="doing";
	if($shopconfig['opentime']==1)
	{
		$opentype=opentype($shopconfig['starthour'],$shopconfig['startminute'],$shopconfig['endhour'],$shopconfig['endminute']);
	}
	
	if($opentype!='doing' )
	{
		if($_GET['ajax'])
		{
			echo "当前的时段不在营业范围，不能订餐";
			exit();
		}else
		{
			errback("当前的时段不在营业范围，不能订餐");
		}
	}
	
	
	
	//判断是否是星期几上线
	$week=getweek();

	if($shopconfig['showweek'])
	{
		
		$weekon=$cai["week{$week}"];
		
		if(!$weekon)
		{
			if($_GET['ajax'])
			{
				echo "很抱歉，该美食今天没有销售";
				exit();
			}else
			{
				errback('很抱歉，该美食今天没有销售');
			}
		}
	}
	
	$userid=intval($_SESSION['ssuser']['userid']);
	$wu=$userid?"(userid=".$userid." OR ssid='{$ss_id}')" : " ssid='{$ss_id}' ";
	$ct=$GLOBALS['db']->getOne("select id from ".table('shopcar')." where  $wu  and caiid='$caiid' AND  shopid=".$cai['shopid']." ");


	if(!$ct)
	{
		$price=$cai['promote']?$cai['lowprice']:$cai['price'];
		$GLOBALS['db']->query("INSERT INTO ".table('shopcar')." SET userid='$userid',ssid='{$GLOBALS['ss_id']}',caiid='$caiid',cainum='$cainum',shopid=".$cai['shopid']." ,siteid='$cksiteid',title='".$cai['title']."',price='$price' ");
	}else
	{
		$GLOBALS['db']->query("UPDATE ".table('shopcar')." SET cainum=cainum+1 WHERE $wu AND caiid='$caiid' ");
	}
	
	if(!$_GET['ajax'])
	{
		errback("成功加入购物车");
	}
}

/*购物车删除 美食*/
function onDel()
{
	global $ss_id;
	$userid=$_SESSION['ssuser']['userid'];
	$caiid=intval($_GET['caiid']);
	$wu=$userid?"(userid=".$userid." OR ssid='{$ss_id}')" : "  ssid='{$ss_id}'";
	$GLOBALS['db']->query("delete from ".table('shopcar')." where caiid='$caiid' AND $wu  ");
	
	gourl();
	
}
/*删除订单*/
function onDelOrder()
{
	global $db;
	check_login();
	$id=intval($_GET['id']);
	$userid=intval($_SESSION['ssuser']['userid']);
	$db->query("DELETE FROM ".table('order')." WHERE id='$id' AND userid='$userid' AND sendtype=0 ");
	if($_GET['url'])
	{
		switch($_GET['url'])
		{
			case 'orderphone':
							gourl("index.php?m=shopcar&a=orderphone");
							break;
						
		}
	}else
	{
		gourl('index.php');
	}
}

/*清除购物车*/
function onClearcar()
{
	global $ss_id;
	$userid=intval($_SESSION['ssuser']['userid']);
	$wu=$userid?"(userid=".$userid." OR ssid='{$ss_id}')" : "   ssid='{$ss_id}'";
	$GLOBALS['db']->query("delete from ".table('shopcar')." where $wu  ");	
	
	if(!$_GET['ajax'])
	{
		gourl();
	}
}

function onedinum()
{
	global $ss_id;
	$userid=intval($_SESSION['ssuser']['userid']);
	$wu=$userid?"(userid=".$userid." OR ssid='{$ss_id}')" : "   ssid='{$ss_id}'";
	/*-------------编辑购物车数量-----------*/
	if($_POST['ids'])
	{
		$ids=$_POST['ids'];
		$cainum=$_POST['cainum'];
		foreach($ids as $k=>$id)
		{
			$GLOBALS['db']->query("update ".table('shopcar')." set cainum=".intval($cainum[$k])." where id='$id'  and $wu ");
		}
		errback("更改成功");
	}else
	{
		$caiid=intval($_GET['caiid']);
		$cainum=intval($_GET['cainum']);
		$GLOBALS['db']->query("update ".table('shopcar')." set cainum=".$cainum." where caiid='$caiid'  and $wu ");
	}

	
	
}

/*------------------购买美食---------------------------*/
function onbuy()
{
	global $db,$cksiteid;
	check_login();
	
	$userid=intval($_SESSION['ssuser']['userid']);
	$dateline=time();
	$shopid=get_post('shopid');
	
	//选出商店id
	if(!$shopid){
		if($userid)
		{
			$shops=$db->getCols("SELECT DISTINCT shopid FROM ".table('shopcar')." WHERE userid='$userid' OR ssid='{$GLOBALS['ss_id']}' ");
		}else
		{
			$shops=$db->getCols("SELECT DISTINCT shopid FROM ".table('shopcar')." WHERE   ssid='{$GLOBALS['ss_id']}' ");
		}
	}else{
		$shops=array($shopid);
	}
	
	if(empty($shops))
	{
		if($_GET['ajax'])
			{
				echo "购物车没有商品";
				exit();
			}else
			{
				errback("购物车没有商品，请添加");
			}
	}
	$week=getweek();
	$carts=array();
	
	foreach($shops as $shopid)
	{
		$shop=$db->getRow("SELECT shopname FROM ".table('shop')." WHERE shopid='$shopid' ");
		$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid='$shopid' ");
		if($shopconfig['ordertype'])
		{
			if($_GET['ajax'])
			{
				echo "很抱歉,".$shop['shopname']."只支持电话预定,购买不成功";
				exit();
			}else
			{
				errback("很抱歉,".$shop['shopname']."只支持电话预定,购买不成功");
			}
		}
		//判断是否在营业
		$opentype="doing";
		if($shopconfig['opentime']==1)
		{
			$opentype=opentype($shopconfig['starthour'],$shopconfig['startminute'],$shopconfig['endhour'],$shopconfig['endminute']);
		}
		
		if($opentype!='doing' )
		{
			if($_GET['ajax'])
			{
				echo "商店".$shop['shopname']."当前的时段不在营业范围，不能订餐";
				exit();
			}else
			{
				errback("商店".$shop['shopname']."当前的时段不在营业范围，不能订餐");
			}
		}
		//判断是否小于最小配送金额
		
		$money=$db->getOne("select sum(s.cainum*s.price) from ".table('shopcar')." as s   where (s.userid='$userid' OR s.ssid='{$GLOBALS['ss_id']}') AND s.shopid='$shopid' ");
		
		//加入购物车
		$carts[$shopid]['money']=$money+$shopconfig['sendprice'];
		if($money<$shopconfig['minprice'])
		{
			errback('订单金额小于餐厅['.$shop['shopname'].']规定最小金额，订餐不成功');
		}
		
		//选出当前商店的美食
		if($userid)
		{
			$res=$db->query("SELECT s.cainum,s.price,s.caiid,c.title,c.lowprice,c.promote,c.week1,c.week2,c.week3,c.week4,c.week5,c.week6,c.week6,c.week7,c.oos FROM ".table('shopcar')." s LEFT JOIN ".table('cai')." c ON s.caiid=c.id  WHERE s.shopid='$shopid' AND (s.ssid='{$GLOBALS['ss_id']}' OR s.userid='$userid')");
		}else
		{
			$res=$db->query("SELECT s.cainum,s.caiid,s.price ,c.title,c.promote,c.week1,c.week2,c.week3,c.week4,c.week5,c.week6,c.week6,c.week7,c.oos FROM ".table('shopcar')." s LEFT JOIN ".table('cai')." c ON s.caiid=c.id  WHERE s.shopid='$shopid' s.ssid='{$GLOBALS['ss_id']}' ");
			
		}
		

		while($cai=$db->fetch_array($res))
		{
				//判断是否缺货
				if($cai['oos']==1)
				{
					if($_GET['ajax'])
					{
						echo "很抱歉,美食[".$cai['title']."]已经卖完了,请从购物车删除";
						exit();
					}else
					{
						errback("'很抱歉，美食[".$cai['title']."]已经卖完了,请从购物车删除");
					}
				}
				
				//判断当天是否在卖
	

				if($shopconfig['showweek'])
				{
					
					$weekon=$cai["week{$week}"];
					
					if(!$weekon)
					{
						if($_GET['ajax'])
						{
							echo "很抱歉，美食[".$cai['title']."]今天没有销售,请从购物车删除";
							exit();
						}else
						{
							errback("很抱歉，美食[".$cai['title']."]今天没有销售,请从购物车删除");
						}
					}
				}
				$carts[$shopid]['cailist'][]=$cai;
		}
	}
	
//开始处理订单
$ids=array();
$address=$db->getOne("SELECT address FROM ".table('user_address')." WHERE userid='$userid' ORDER BY id DESC ");
$phone=$db->getOne("SELECT phone FROM ".table('user')." WHERE userid='$userid' ");

foreach($shops as $shopid)
{	
	
	$shopname=$db->getOne("SELECT shopname FROM ".table('shop')." WHERE shopid='$shopid' ");
	$db->query("INSERT INTO ".table('order')."  SET userid='$userid',money=".$carts[$shopid]['money'].",dateline='$dateline',shopid='$shopid',orderaddress='$address',orderphone='$phone',orderuser='".$_SESSION['ssuser']['username']."',siteid='$cksiteid' ");
		
	$orderid=$GLOBALS['db']->insert_id();
	$ids[]=$orderid;
	$orderno=date("Ym").$orderid;
	$GLOBALS['db']->query("update ".table('order')." set orderno='$orderno' where id='$orderid' ");
	//插入菜
	$sharecontent=" @<a href='index.php?m=member&userid=$userid'>{$_SESSION['ssuser']['nickname']}</a> 在<a href='index.php?m=shop&shopid={$shopid}' target='_blank'>{$shopname}</a>点了";
	foreach($carts[$shopid]['cailist'] as $t)
	{
		$sharecontent.=" <a href='index.php?m=cai&id={$t['caiid']}'>{$t['title']}</a> {$t['cainum']} 份&nbsp;&nbsp; ";
		$db->query("INSERT INTO ".table('order_cai')." SET orderid='$orderid',caiid=".$t['caiid'].",cainum=".$t['cainum'].",shopid='$shopid',price=".$t['price'].",title='".$t['title']."' ");
	}
	//加入订餐分享
	$db->query("INSERT INTO ".table('ordershare')." SET siteid='$cksiteid',shopid='$shopid',userid='$userid',dateline=".time().",content='".addslashes($sharecontent)."'  ");
	
	//删除购物车
	$db->query("delete from ".table('shopcar')." where userid='$userid' AND shopid='$shopid' ");
	
}
	header("Location: index.php?m=shopcar&a=orderphone&ids=".implode("-",$ids));
	
}
/*---------------查看订单-------------------*/
function onView()
{	
	$userid=intval($_SESSION['ssuser']['userid']);
	$id=intval($_GET['id']);
	$rs=$GLOBALS['db']->getRow("select o.*,u.username,s.shopname from ".table('order')." as o left join ".table('user')." as u on o.userid=u.userid LEFT JOIN ".table('shop')." s ON o.shopid=s.shopid  where o.id='$id' ");
	$rs['dateline']=date("Y-m-d H:i:s");
	if($rs['username']=='')
	{
		$rs['username']='游客';
	}
	$GLOBALS['smarty']->assign("order",$rs);
	$sql="select oc.*,c.title,c.price from ".table('order_cai')." as oc left join ".table('cai')." as c on oc.caiid=c.id where oc.orderid='$id'  ";
	$rs=$GLOBALS['db']->getAll($sql);
	$GLOBALS['smarty']->assign("cailist",$rs);
	
		//获取购物记录
	if($userid)
	{
		$orderlist=$GLOBALS['db']->getAll("select * from ".table('order')." where userid='$userid' AND siteid='$cksiteid' order by id desc limit 10 ");
	}else
	{
		$orderlist=$GLOBALS['db']->getAll("select * from ".table('order')." where ssid='{$GLOBALS['ss_id']}' AND siteid='$cksiteid' order by id desc limit 10 ");
		
	}
	$GLOBALS['smarty']->assign("orderlist",$orderlist);
	$GLOBALS['smarty']->assign("where","<a href='{$web['weburl']}'>首页</a> > 订单详情");	
	$GLOBALS['smarty']->display("order_view.html");
}
/*---------------------购物记录------------------------------*/
function onHistory()
{
	global $cksiteid;
	check_login();
	$userid=intval($_SESSION['ssuser']['userid']);
	$sql="select o.*,s.shopname from ".table('order')." o LEFT JOIN ".table('shop')." s ON o.shopid=s.shopid  WHERE o.siteid='$cksiteid'  " ;
	if($userid)
	{
		$sql.=" AND o.userid='$userid' ";
	}
	$sql.=" order by o.id desc ";
	$rscount=$GLOBALS['db']->getOne("select count(*) from ".table('order')."  where userid='$userid' AND siteid='$cksiteid' ");
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$sql.=" limit $start,$pagesize";
	$GLOBALS['smarty']->assign("pagelist",multipage($rscount,$pagesize,$_GET['page'],"index.php?m=shopcar&a=history"));
	$res=$GLOBALS['db']->query($sql);
	$orderlist=array();
	while($rs=$GLOBALS['db']->fetch_array($res))
	{
		$orderlist[$rs['id']]=$rs;
	}
	$GLOBALS['smarty']->assign("orderlist",$orderlist);
	$GLOBALS['smarty']->assign("where","<a href='{$web['web_url']}'>首页</a> >购物记录");
	$GLOBALS['smarty']->display("order_history.html");	
}
/*--------------联系方式------------------*/
function onorderphone()
{
	global $db,$smarty,$cksiteid;
	check_login();
	$userid=intval($_SESSION['ssuser']['userid']);
	//选出未生效的订单
	if($_GET['ids'])
	{
		$ids=explode("-",$_GET['ids']);
	}else
	{
		$ids=$db->getCols("SELECT id FROM ".table('order')." WHERE userid='$userid' and isvalid=0 AND siteid='$cksiteid' ");
	}
	$orderlist=array();
	//账户余额
	$balance=$db->getOne("SELECT balance FROM ".table('user')." WHERE userid='$userid' ");
	$smarty->assign("balance",$balance);
	foreach($ids as $id)
	{
		$id=intval($id);
		if($id)
		{	
			//获取订单信息
			$order=$db->getRow("SELECT o.*,s.shopname,s.phone FROM ".table('order')." o LEFT JOIN ".table('shop')." s ON o.shopid=s.shopid  WHERE o.id='$id' AND o.userid='$userid' ");
			$order['cailist']=$db->getAll("SELECT o.* FROM ".table('order_cai')." o  WHERE o.orderid=".$order['id']."  ");
			$order['config']=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid=".$order['shopid']." ");
			$order['comment']=$db->getRow("SELECT * FROM ".table('shop_comment')." WHERE orderid='$id' ");
		}
		$orderlist[]=$order;
	}
	$addresslist=$db->getAll("SELECT address,id FROM ".table('user_address')." WHERE userid='$userid' ORDER BY id desc ");
	$smarty->assign('addresslist',$addresslist);
	$smarty->assign('orderlist',$orderlist);
	$smarty->display("order_phone.html");
}
/*-----------------填写联系方式----------------------*/
function onOrderPhone_db()
{
	global $db;
	//验证表单
	$userid=intval($_SESSION['ssuser']['userid']);
	check_login();
	$orderid=intval($_POST['orderid']);
	$orderphone=strip_tags(trim($_POST['orderphone']));
	ckempty($orderphone,'联系电话不能为空！');
	$orderaddress=strip_tags(trim($_POST['orderaddress']));
	ckempty($orderaddress,'联系地址不能为空');
	//获取账户余额
	$balance=$db->getOne("SELECT balance FROM ".table('user')." WHERE userid='$userid' ");
	$orderinfo=htmlspecialchars(trim($_POST['orderinfo']));
	$ispay=intval($_POST['ispay']);	
	
	$order=$db->getRow("SELECT * FROM ".table('order')." WHERE id='$orderid' ");
	$orderno=$order['orderno'];
	//如果在线支付 则处理余额支付
	if($ispay && !$order['ispay'])
	{
		if($order['money']>$balance)
		{
			errback('您的余额不足，支付不成功');
		}else
		{
			$db->query("UPDATE ".table('user')." SET balance=balance-".$order['money']." WHERE userid=".intval($_SESSION['ssuser']['userid'])." ");
			//用户余额使用记录
			$content="订单编号为{$order['orderno']}购买成功,总额{$order['money']}元,使用余额支付，余额减少{$order['money']}";
			$db->query("INSERT INTO ".table('user_paylog')." SET userid=".intval($_SESSION['ssuser']['userid']).",content='".addslashes($content)."',money='-{$order['money']}',dateline=".time()." ");
			
		}
	}
	$GLOBALS['db']->query("update ".table('order')." set ispay='$ispay',orderphone='$orderphone',isvalid=1,orderaddress='$orderaddress',orderinfo='$orderinfo' where id='$orderid' and userid='$userid' ");
	
	
	$shopconfig=$db->getRow("SELECT * FROM ".table('shopconfig')." WHERE shopid=".$order['shopid']." ");
	
	if($_GET['edi'])
	{
		errback("修改联系方式成功","index.php?m=shopcar&a=view&id={$id}");
		
	}else
	{	
	
		//如果启动订单邮件 或者短信通知 
		if((PHONE_ON==1) or $shopconfig['isemail'])
		{
			//判断是否为老客户
			$isold=0;
			//根据用户id判断是否为老用户 
			
			$c2=$GLOBALS['db']->getOne("select id from ".table('order')." where userid=".intval($_SESSION['ssuser']['userid'])." LIMIT 1 ");
			$isold=$c2>1?1:0;
			
			$content=(($isold?"老":"新")."用户").$_SESSION['ssuser']['username']."点了：";			
			
			$oc=$GLOBALS['db']->getAll(" select oc.caiid,oc.cainum,c.title from ".table('order_cai')." as oc left join ".table('cai')." as c on  oc.caiid=c.id where oc.orderid='$orderid'  ");
			$content2="尊敬的客户，您的订单编号：$orderno ,菜单：";
			foreach($oc as $v)
			{
				$content.=$v['title'].$v['cainum']."份/";
				$content2.=$v['title'].$v['cainum']."份/";
			}
			$content2.=",总价".$order['money']."元".",其他要去：".$order['orderinfo']."。";
			$content.="联系电话：{$orderphone},配送地址：{$orderaddress}。总价".$order['money']."元".",其他要求：".$order['orderinfo']."。";
			
			if(PHONE_ON)
			{		
				require_once(ROOT_PATH."includes/sendSMS.php");
				//发送给商家
				if($shopconfig['telephone']){
					$res = sendSMS(PHONE_USER,PHONE_PWD,$shopconfig['telephone'],$content);
				}		
				//发送给用户			
				$r2 = sendSMS(PHONE_USER,PHONE_PWD,$orderphone,$content2);
			}
			
			if($shopconfig['isemail'])
			{
				global $smptArr;
				 
				 send_mail($smptArr,$shopconfig['email'],'你有新订单',$content);
												
			}
			
			
		}
		
		if($db->getOne("SELECT count(1) FROM ".table('order')." WHERE userid='$userid' AND isvalid=0 "))
		{
			gourl("index.php?m=shopcar&a=orderphone");
		}
		errback("订购完成，欢迎您下次再来 订单号{$orderno}",'index.php?m=shopcar&a=history');
	}
}
/*---------------------订单评论-------------------------*/
function onOrderComment()
{
	global $cksiteid;
	$orderid=intval($_POST['orderid']);
	$userid=intval($_SESSION['ssuser']['userid']);
	$order=$GLOBALS['db']->getRow("SELECT * FROM ".table('order')." WHERE id='$orderid' AND userid='$userid' ");
	if(empty($order)) errback('订单不存在');
	extract($order);
	$ctype=intval($_POST['ctype']);
	$content=htmlspecialchars(trim($_POST['content']));
	$jf_fuwu=intval($_POST['jf_fuwu']);
	$jf_kouwei=intval($_POST['jf_kouwei']);
	$jf_shijian=intval($_POST['jf_shijian']);
	$jf_jiage=intval($_POST['jf_jiage']);
	$jf_all=intval($_POST['jf_all']);
	 
	if($order['iscomment'])
	{
		$GLOBALS['db']->query("UPDATE ".table('shop_comment')." SET   jf_fuwu='$jf_fuwu',jf_kouwei='$jf_kouwei',jf_shijian='$jf_shijian',jf_jiage='$jf_jiage',jf_all='$jf_all',content='$content'   WHERE orderid='$orderid' AND userid=".intval($_SESSION['ssuser']['userid'])." ");

	}else
	{
		$GLOBALS['db']->query("INSERT INTO ".table('shop_comment')." SET siteid='$cksiteid',shopid='$shopid',ctype='$ctype',userid=".intval($_SESSION['ssuser']['userid']).",nickname='".$_SESSION['ssuser']['nickname']."',orderid='$orderid',orderno='$orderno',jf_fuwu='$jf_fuwu',jf_kouwei='$jf_kouwei',jf_shijian='$jf_shijian',jf_jiage='$jf_jiage',jf_all='$jf_all',content='$content',dateline=".time()."  ");
	}
	$avg=$GLOBALS['db']->getRow("SELECT AVG(jf_fuwu) AS fuwu,AVG(jf_kouwei) AS kouwei,AVG(jf_shijian) AS shijian,AVG(jf_jiage) AS jiage ,AVG(jf_all) AS all FROM ".table('shop_comment')." WHERE shopid='$shopid'  ");
	$grade=0;
	if(!$order['iscomment'])
	{
		if($jf_all>3)
		{
			$grade=1;
		}elseif($jf_all<3)
		{
			$grade=-1;
		} 
	}
	
	$GLOBALS['db']->query("UPDATE ".table('shop')." SET jf_fuwu=".intval($avg['fuwu']).",jf_kouwei=".intval($avg['kouwei']).",jf_shijian=".intval($avg['shijian']).",jf_jiage=".intval($avg['jiage']).",jf_all=".intval($avg['all']).",grade=grade+".$grade."  WHERE shopid='$shopid' ");
	
	
	$GLOBALS['db']->query("UPDATE ".table('order')." SET iscomment=1 WHERE id='$orderid' AND userid=".intval($_SESSION['ssuser']['userid'])." ");

	
	errback('感谢您对订单评价');
}
/*--------------------搜索订单----------------------*/
function onOrdersearch()
{
	
	if($_POST)
	{
		$orderno=htmlspecialchars(trim($_POST['orderno']));
		if($id=$GLOBALS['db']->getOne("select id from ".table('order')." where orderno='$orderno' "))
		{
			header("Location: index.php?m=shopcar&a=view&id={$id}");
		}else
		{
			errback("很抱歉！你要查找的订单不存在！","index.php?m=shopcar&a=ordersearch");
		}
	}else
	{
		//获取购物记录
		if($userid)
		{
			$orderlist=$GLOBALS['db']->getAll("select * from ".table('order')." where userid='$userid' order by id desc limit 10 ");
		}else
		{
			$orderlist=$GLOBALS['db']->getAll("select * from ".table('order')." where ssid='{$GLOBALS['ss_id']}' order by id desc limit 10 ");
			
		}
		$GLOBALS['smarty']->assign("orderlist",$orderlist);
		$GLOBALS['smarty']->display("order_search.html");
	}
}

function onAjaxGetshopcar()
{
/*ajax获取购物车*/	
	header("Content-type:text/html; charset=gb2312");
	$userid=intval($_SESSION['ssuser']['userid']);
	if($userid)
	{
		$shopcailist=$GLOBALS['db']->getAll("select s.*,c.title,c.price from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.userid='$userid' AND  s.shopid=".$_SESSION['ssshopid']."");	
		$shopmoney=$GLOBALS['db']->getOne("select sum(s.cainum*c.price) from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.userid='$userid' AND  s.shopid=".$_SESSION['ssshopid']." ");
		$shopcainum=$GLOBALS['db']->getOne("select sum(s.cainum) from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.userid='$userid' AND  s.shopid=".$_SESSION['ssshopid']." ");
	}else
	{
		$shopcailist=$GLOBALS['db']->getAll("select s.*,c.title,c.price from  ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.ssid='{$GLOBALS['ss_id']}' AND  s.shopid=".$_SESSION['ssshopid']." ");	
		$shopmoney=$GLOBALS['db']->getOne("select sum(s.cainum*c.price) from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.ssid='{$GLOBALS['ss_id']}' AND  s.shopid=".$_SESSION['ssshopid']."  ");
		$shopcainum=$GLOBALS['db']->getOne("select sum(s.cainum) from ".table('shopcar')." as s left join ".table('cai')." as c on s.caiid=c.id where s.ssid='{$GLOBALS['ss_id']}' AND  s.shopid=".$_SESSION['ssshopid']." ");
	}
	$GLOBALS['smarty']->assign("shopcainum",$shopcainum);
	$GLOBALS['smarty']->assign("shopmoney",$shopmoney);
	$GLOBALS['smarty']->assign("shopcailist",$shopcailist);
	$GLOBALS['smarty']->display("lib/ajaxshopcar.lbi");
}
function onAjaxSendArea()
{
	header("Content-type:text/html;charset=gb2312");
	$pid=intval($_GET['pid']);
	$rs=$GLOBALS['db']->getRow("SELECT catid,cname FROM ".table('sendarea')." WHERE pid=".$pid." AND  shopid=".$_SESSION['ssshopid']." ");
	if($rs)
	{
	$op='<option value="0">请选择</option>';
	foreach($rs as $r);
	{
		$op.="<option value='".$r['catid']."'>".$r['cname']."</option>";
	}
	echo $op;
	}
	
}

function onReceived()
{
	global $db;
	$userid=$_SESSION['ssuser']['userid'];
	$id=intval($_GET['id']);
	$db->query("UPDATE ".table('order')." SET received=1 WHERE userid='$userid' AND id='$id' " );
}

?>