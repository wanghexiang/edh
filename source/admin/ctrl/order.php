<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a='index';
}
checkpermission("order",$a);
if($a=='index')
{
	$w="";
	$sql="select  id  from ".table('order')." where isvalid=1 AND siteid='$siteid'  ";
	$sql2="select count(1) from ".table('order')."  where isvalid=1  AND siteid='$siteid' ";
	$sql3=" select SUM(money) as summoney, AVG(money) as avgmoney from ".table('order')." where isvalid=1 AND siteid='$siteid' ";
	$orderno=$_GET['orderno'];
	$uid=intval($_GET['uid']);
	$url="admin.php?m=order&";

	if(isset($_GET['t']))
	{	
		$t=intval($_GET['t']);
		$daystart=strtotime(date("Y-m-d"));//一天的开始
		$dayend=$daystart+86400;//一天的结束
		if($t==1)
		{//今天
			$w.=" and dateline>'$daystart' ";
			
		}elseif($t==2)
		{//昨天
			$dateline=$daystart-86400;
			$w.=" and dateline<'$daystart' and dateline>'$dateline' ";
			
			
		}elseif($t==3)
		{//7天
			$dateline=$daystart-86400*7;			
			$w.="  and  dateline>'$dateline' ";			
		}elseif($t==4)
		{//本月
			$dateline=mktime(0,0,0,date("m"),1,date("Y"));
			$w.="  and  dateline>'$dateline' ";
					
		}elseif($t==5)
		{//上月
			$lm=mktime(0,0,0,date("m")-1,1,date("Y"));
			$dateline=mktime(0,0,0,date("m"),1,date("Y"));
			$w.="  and  dateline<'$dateline' and dateline>'$lm' ";
			
		}
		$url.="&t={$t}";
	}
	if($uid)
	{
	$w.= " and  userid='$uid' " ;
	$url.="&uid={$uid}";
	}
	if(isset($_GET['sendtype']) && $_GET['sendtype']>-1)
	{
		$w.=" and sendtype=".intval($_GET['sendtype'])." ";
		$url.="&sendtype=".intval($_GET['sendtype']);
		$smarty->assign("sendtype",intval($_GET['sendtype']));
	}else
	{
		$smarty->assign("sendtype",-1);
	}
	
	if($orderno)
	{
		$w.=" and  orderno='$orderno' ";
		$smarty->assign("orderno",$orderno);
		$url.="&orderno={$orderno}";
	}
	$username=trim($_GET['username']);
	if($username)
	{
		$w.=" and orderuser='$username' ";
		$smarty->assign("username",$username);
		$url.="&username={$username}";
	}
	$starttime=$_GET['starttime']=htmlspecialchars($_GET['starttime']);
	$endtime=$_GET['endtime']=htmlspecialchars($_GET['endtime']);
	if($starttime && $endtime)
	{
		$url.="&starttime=$starttime&endtime=$endtime";
		$starttime=strtotime($starttime);
		$endtime=strtotime($endtime);
		$w.=" AND dateline>'$starttime' AND dateline<'$endtime' ";
		
	}
	
	$sql.=$w;
	$sql2.=$w;
	$sql3.=$w;
	$sql.=" order by  id desc ";
	//开始分页
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);	
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//分页结束
	$ids=$db->getCols($sql);
	if($ids)
	{
		$res=$db->query("SELECT o.*,s.shopname FROM ".table('order')." o LEFT JOIN ".table('shop')." s ON o.shopid=s.shopid WHERE o.id in("._implode($ids).") ORDER BY o.id DESC ");
		$orderlist=array();
		while($rs=@$db->fetch_array($res))
		{
			
			$rs['dateline']=date("H:i:s",$rs['dateline']);
			switch($rs['sendtype'])
			{
				case 0;
					$rs['sendtype']="未确认";
					break;
				case 1:
					$rs['sendtype']="已确认";
					break;
				case 2:
					$rs['sendtype']="正在配送";
					break;
				
				case 3:
					$rs['sendtype']="订单完成";
					break;	
			}
			if($rs['userid']==0)
			{
				$rs['orderuser']="游客";
			}
			
			$orderlist[$rs['id']]=$rs;
		}
	}
	$smarty->assign("money",$db->getRow($sql3));//统计账单
	$smarty->assign("rscount",$rscount);//统计订单总数
	$smarty->assign("orderlist",$orderlist);
	$smarty->display("order.html");
}elseif($a=='view')
{
	$id=intval($_GET['id']);
	$rs=$db->getRow("select o.*,u.username,u.phone,u.address from ".table('order')." as o left join ".table('user')." as u on o.userid=u.userid  where o.id='$id' ");
	$rs['dateline']=date("y-m-d H:i:s",$rs['dateline']);
	if($rs['username']=='')
	{
		$rs['username']='游客';
	}
	if(!$rs['phone'])
	{
		$rs['phone']=$rs['orderphone'];
	}
	if(!$rs['address'])
	{
		$rs['address']=$rs['orderaddress'];	
	}
	$rs['comment']=nl2br($rs['comment']);
	$rs['orderinfo']=nl2br($rs['orderinfo']);
	$smarty->assign("order",$rs);
	$sql="select oc.*,c.title,c.price from ".table('order_cai')." as oc left join ".table('cai')." as c on oc.caiid=c.id where oc.orderid='$id'  ";
	$rs=$db->getAll($sql);
	$smarty->assign("rs",$rs);
	$smarty->display("order_view.html");
	
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('order')." where id='$id' AND siteid='$siteid' ");
	//删除订单详情
	$db->query("delete from ".table('order_cai')." where orderid='$id' ");
	gourl();
}elseif($a=='sendtype')
{
	$sendtype= $_GET['sendtype'];
	if(is_array($_POST['id']))
	{
		$id=$_POST['id'];
		if($sendtype==3)
		{
			$rs=$db->getAll("select id,userid,shopid,money,orderuser,orderno,ispay from ".table('order')." where sendtype<3 and id in("._implode($id).") AND shopid='$shopid' ");
		
			foreach($rs as $key=>$val)
			{
				// 获取用户积分
				$grade=$db->getOne("select grade from ".table('user')." where userid=".$val['userid']." ")	;	
				//将折扣给用户
				$discount=$db->getOne("select discount from ".table('user_rank')." where min_grade<='$grade' and max_grade>='$grade' LIMIT 1 ");
				//实际支付的费用
				$money=(GRADE_ON==1 && $discount)?$val['money']*$discount/100:$val['money'];
				if($val['ispay']==1)
				{
					
					//店铺余额使用记录
					$content="用户".$val['orderuser']."编号为".$val['orderno']."的订单处理完毕,获得".$money."元 ";
					$db->query("INSERT INTO ".table('shop_paylog')." SET shopid=".$val['shopid'].",dateline=".time().",content='".addslashes($content)."',money='+{$money}' ");
					$db->query("UPDATE ".table('shop')." SET balance=balance+".$money." WHERE shopid=".$val['shopid']." ");
					
				}
				//个人优惠折扣返利
				$bonus=$val['money']-$money;
				if($bonus)
				{
					$db->query("UPDATE ".table('user')." SET balance=balance+".$bonus." WHERE userid=".intval($val['userid'])." ");
					//用户余额使用记录
					$content="订单编号为{$val['orderno']}购买成功,总额{$val['money']}元,使用余额支付，获得返利{$bonus}元";
					$db->query("INSERT INTO ".table('user_paylog')." SET userid=".$val['userid'].",content='".addslashes($content)."',money='$bonus',dateline=".time()." ");
				}
					
				
				//推广奖励开始
				//获取引荐人
				$fuserid=$db->getOne("select fuserid from ".table('user')." where userid='{$val['userid']}' ") ;
				if($fuserid && (SPREAD_ON==1))
				{
					$bonus=SPREAD_DISCOUNT*$val['money']/100;//奖励
					$db->query("UPDATE ".table('user')." SET balance=balance+".$bonus." WHERE userid=".$fuserid." ");
					
					//写入优惠日志
					$content="您推荐的人购买了订单编号为{$val['orderno']}的产品,总额{$val['money']}元，您获得金额为{$bonus}元的优惠";
					$db->query("insert into ".table('user_paylog')." set content='$content',userid=".$fuserid.",bonus='$bonus',dateline=".time()." ");
					//发送通知
					sendMessage($fuserid,$content);
						
				}
					
				//推广奖励结束
				//添加等级积分		
				$db->query("update ".table('user')." set grade=grade+".$val['money'].",usegrade=usegrade+".$val['money']." where userid=".$val['userid']." ");
				//添加可兑换积分
				$content="订单".$val['orderno']."完成，您获得".$val['money']."可用积分。";
				$db->query("INSERT ".table('grade_log')." SET userid=".$val['userid'].",content='$content',dateline=".time().",grade=".$val['money']." ");
				//可兑换积分结束
				$db->query("update ".table('order')." set sendtype='$sendtype' where  sendtype<3 and id='{$val['id']}'   ");
				//发送通知
				$content="订单编号为{$val['orderno']}已送货,<a href='index.php?m=shopcar&a=history'>请确认收货</a>";
				sendMessage($val['userid'],$content);
				//更新店铺销售数量
				$db->query("UPDATE ".table('shop')." SET orders=orders+1 WHERE shopid=".intval($val['shopid'])." ");
				//更新美食销售数量
				$db->query("UPDATE ".table('cai')." SET orders=orders+1 WHERE id in(SELECT caiid FROM ".table('order_cai')." WHERE orderid=".$val['id']."  ) ");
			}//foreach结束
		}//sendtype=3结束
		$db->query("update ".table('order')." set sendtype='$sendtype' where  sendtype<3 and id in("._implode($id).")  ");
		
		
	}
	if($_GET['orderid'])
	{
		$orderid=intval($_GET['orderid']);
		if($sendtype==3)
		{
			$rs=$db->getRow("select id,userid,shopid,money,orderuser,orderno,ispay from ".table('order')." where  sendtype<3 and id ='$orderid' AND shopid='$shopid' ");
			if($rs)
			{
				//获取积分
				$grade=$db->getOne("select grade from ".table('user')." where userid=".$rs['userid']." ")	;	
				
				//将折扣给用户
				$discount=$db->getOne("select discount from ".table('user_rank')." where min_grade<'$grade' and max_grade>'$grade' ");
				//实际支付的费用
				$money=(GRADE_ON==1 && $discount)?$rs['money']*$discount/100:$rs['money'];
				if($rs['ispay']==1)
				{
					
					//店铺余额使用记录
					$content="用户".$rs['orderuser']."编号为".$rs['orderno']."的订单处理完毕,获得".$money."元 ";
					$db->query("INSERT INTO ".table('shop_paylog')." SET shopid=".$rs['shopid'].",dateline=".time().",content='".addslashes($content)."',money='+{$money}' ");
					$db->query("UPDATE ".table('shop')." SET balance=balance+".$money." WHERE shopid=".$rs['shopid']." ");
					
				}
				//个人优惠折扣返利
				$bonus=$rs['money']-$money;
				if($bonus)
				{
					$db->query("UPDATE ".table('user')." SET balance=balance+".$bonus." WHERE userid=".intval($rs['userid'])." ");
					//用户余额使用记录
					$content="订单编号为{$rs['orderno']}购买成功,总额{$rs['money']}元,使用余额支付，获得返利{$bonus}元";
					$db->query("INSERT INTO ".table('user_paylog')." SET userid=".$rs['userid'].",content='".addslashes($content)."',money='$bonus',dateline=".time()." ");
				}
				
				//添加等级积分		
				$db->query("update ".table('user')." set grade=grade+".$rs['money'].",usegrade=usegrade+".$rs['money']." where userid=".$rs['userid']." ");
				$content="订单".$rs['orderno']."完成，您获得".$rs['money']."可用积分。";
				$db->query("INSERT ".table('grade_log')." SET userid=".$rs['userid'].",content='$content',dateline=".time().",grade=".$rs['money']." ");
				$content="订单编号为{$rs['orderno']}已送货,<a href='index.php?m=shopcar&a=history'>请确认收货</a>";
				sendMessage($rs['userid'],$content);
				//更新店铺销售
				$db->query("UPDATE ".table('shop')." SET orders=orders+1 WHERE shopid=".intval($rs['shopid'])." ");
				//更新美食销售数量
				$db->query("UPDATE ".table('cai')." SET orders=orders+1 WHERE id in(SELECT caiid FROM ".table('order_cai')." WHERE orderid=".$rs['id']."  ) ");

				//可兑换积分结束				
				//推广奖励开始
				//获取引荐人
				$fuserid=$db->getOne("select fuserid from ".table('user')." where userid='{$rs['userid']}' ") ;
				if($fuserid && (SPREAD_ON==1))
				{
					$bonus=SPREAD_DISCOUNT*$rs['money']/100;//奖励
					$db->query("UPDATE ".table('user')." SET balance=balance+".$bonus." WHERE userid=".$fuserid." ");
					
					//写入优惠日志
					$content="您推荐的人购买了订单编号为{$rs['orderno']}的产品,总额{$rs['money']}元，您获得金额为{$bonus}元的优惠";
					$db->query("insert into ".table('user_paylog')." set content='$content',userid=".$fuserid.",bonus='$bonus',dateline=".time()." ");
					//发送通知
					sendMessage($fuserid,$content);
						
				}
				
				//推广奖励结束
			}//$rs结束
				
		}
		
		$db->query("update ".table('order')." set sendtype='$sendtype' where sendtype<3 and id='$orderid' ");
	}	
	gourl();	
	
}elseif($a=='senddes')
{
	$id=intval($_POST['id']);
	$senddes=trim($_POST['senddes']);
	$db->query("update ".table('order')." set senddes='$senddes' where id='$id' AND siteid='$siteid' ");	
	gourl();
}elseif($a=='tocsv')
{
	$w="";
	//转化为mysql2excel
	if(isset($_GET['t']))
	{	
		$t=intval($_GET['t']);
		$daystart=strtotime(date("Y-m-d"));//一天的开始
		$dayend=$daystart+86400;//一天的结束
		if($t==1)
		{//今天
			$w.=" and dateline>'$daystart' ";
			
		}elseif($t==2)
		{//昨天
			$dateline=$daystart-86400;
			$w.=" and dateline<'$daystart' and dateline>'$dateline' ";
			
			
		}elseif($t==3)
		{//7天
			$dateline=$daystart-86400*7;			
			$w.="  and  dateline>'$dateline' ";			
		}elseif($t==4)
		{//本月
			$dateline=mktime(0,0,0,date("m"),1,date("Y"));
			$w.="  and  dateline>'$dateline' ";
					
		}elseif($t==5)
		{//上月
			$lm=mktime(0,0,0,date("m")-1,1,date("Y"));
			$dateline=mktime(0,0,0,date("m"),1,date("Y"));
			$w.="  and  dateline<'$dateline' and dateline>'$lm' ";
			
		}
		
	}
	header("Content-type:application/xls");
	header("Content-Disposition: attachment; filename=".time().".csv"); 
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');  
    header('Expires:0');   
    header('Pragma:public');
	$sql="select id,orderno,money,orderuser ,orderphone,orderaddress,dateline from ".table('order')." where isvalid=1  AND siteid='$siteid' $w  ORDER BY id DESC LIMIT 100 ";
	echo "订单编号 ,价格 ,联系人 ,联系电话  ,联系地址  ,时间,所点菜  \r";
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		$rs['orderno']="no:".$rs['orderno'];
		$rs['dateline']=date("Y-m-d H:i:s");
		$cid=$db->getCols("select caiid from ".table('order_cai')." where orderid=".$rs['id']." ");
		
		$caiids=$db->getAll("select title,cainum from ".table('cai')." where id in("._implode($cid).") ");
		
		echo "{$rs['orderno']},{$rs['money']},{$rs['orderuser']},{$rs['orderphone']},{$rs['orderaddress']},{$rs['dateline']},{$rs['cai']} \r"; 
	}

	
	/*require_once(ROOT_PATH."includes/cls_csv.php");
	$f=time().".csv";
	arr2csv("backup/csv/".$f,$arr);
	echo "导出成功 <a href='admin.php?m=order&a=downcsv&f={$f}'>下载</a>";*/
	
}elseif($a=='downcsv')
{
	$f=$_GET['f'];
	header("Content-type:application/xls");
	header("Content-Disposition: attachment; filename={$f}"); 
	 header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
	 header('Content-Length:' . filesize("backup/csv/".$f));  
     header('Expires:0');   
     header('Pragma:public'); 
	 echo file_get_contents("backup/csv/".$f);
}
?>