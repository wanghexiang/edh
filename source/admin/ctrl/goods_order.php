<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):"index";
switch($_GET['a'])
{
	case 'index':
				$w="";
				$sql="select  id  from ".table('goods_order')." where isvalid=1  ";
				$sql2="select count(1) from ".table('goods_order')."  where isvalid=1 ";
				$orderno=$_GET['orderno'];
				$url="admin.php?m=goods_order";
			
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
					$url.="&order={$orderno}";
				}
				$nickname=trim($_GET['nickname']);
				if($nickname)
				{
					$w.=" and nickname LIKE '%".$nickname."%' ";
					$smarty->assign("nickname",$nickname);
					$url.="&nickname={$nickname}";
				}
				$sql.=$w;
				$sql2.=$w;
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
				$res=$db->query("SELECT * FROM ".table('goods_order')." WHERE id in("._implode($ids).") ORDER BY id DESC ");
				
				$orderlist=array();
				while($rs=$db->fetch_array($res))
				{
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
							$rs['sendtype']="配送中";
							break;
						case 4:
							$rs['sendtype']="订单完成";
							break;	
					}

					
					$orderlist[$rs['id']]=$rs;
				}
				}
				$smarty->assign("rscount",$rscount);//统计订单总数
				$smarty->assign("orderlist",$orderlist);
	
				$smarty->display("goods_order.html");
		break;
	case 'sendtype':
			$sendtype= $_GET['sendtype'];
			$ids=$_POST['id'];
			if($ids)
			{
				$rs=$db->getAll("select o.*,g.title from ".table('goods_order')." o LEFT JOIN ".table('goods')." g ON o.goodsid=g.id  where o.sendtype<4 and o.id in("._implode($ids).") ");
				foreach($rs as $r)
				{
					if($sendtype==4)
					{
						$db->query("UPDATE ".table('user')." SET usegrade=usegrade-".$r['grade']." WHERE userid=".$r['userid']." ");
						//积分兑换记录
						$content="您使用积分兑换  <a href=\'index.php?m=goods&a=detail&id=".$r['goodsid']."\'>".$r['title']."</a>，积分减少".$r['grade']."分";
						$db->query("INSERT ".table('grade_log')." SET userid=".$r['userid'].",content='$content',dateline=".time().",grade=-".$r['grade']." ");
					}
					$db->query("UPDATE ".table('goods_order')." SET sendtype='$sendtype' WHERE id=".$r['id']." ");
				}
			}
			gourl();

		break;
	case 'del':
			$id=intval($_GET['id']);
			$db->query("delete from ".table('goods_order')." where id='$id' ");
			gourl();
		break;
}

?>