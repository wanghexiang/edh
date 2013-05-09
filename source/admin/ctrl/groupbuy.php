<?php
check_login();
$_GET['a']=$_GET['a']?$_GET['a']:'index';

$shopid=$_SESSION['adminshop']['shopid'];
switch($_GET['a'])
{
	case 'index':
			assignlist("groupbuy",10,'','','groupbuy.php'); 
			$smarty->display("groupbuy.html");
		break;
	case 'status':
			$status=intval($_POST['status']);
			$ids=$_POST['ids'];
			$db->query("UPDATE ".table('groupbuy')." SET status='$status' WHERE id in("._implode($ids).")  AND siteid='$siteid' ");
			
			errback('操作成功');
		break;
	case 'recommend':
			$id=intval($_GET['id']);
			$isrecommend=intval($_GET['isrecommend']);
			$db->query("UPDATE ".table('groupbuy')." SET isrecommend='$isrecommend' WHERE  id='$id' ");
		break;		

	case 'del':
			$id=intval($_GET['id']);
			$db->query("DELETE FROM ".table('groupbuy')." WHERE id='$id' AND shopid='$shopid' ");
			gourl();
	
		break;
		
	case 'category':
				if($_GET['op'])
				{
					$cnames=$_POST['cname'];
					$orderindexs=$_POST['orderindex'];
					if($cnames)
					{
						foreach($cnames as $catid=>$cname)
						{
							$db->query("UPDATE ".table('groupbuy_category')." SET cname='".$cname."',orderindex=".$orderindexs[$catid]." WHERE siteid='$siteid' AND catid='$catid' ");
						}
					}
					$newcname=htmlspecialchars(trim($_POST['newcname']));
					$neworderindex=intval($_POST['neworderindex']);
					if($newcname)
					{
						$db->query("INSERT INTO ".table('groupbuy_category')." SET siteid='$siteid',cname='$newcname',orderindex='$neworderindex' ");
					}
					gourl();
				}else
				{
					$smarty->assign("catlist",$db->getAll("SELECT * FROM ".table('groupbuy_category')." WHERE siteid='$siteid' "));
					$smarty->display("groupbuy_cat.html");
				}
		break;
	case 'del':
			$catid=intval($_GET['catid']);
			$db->query("DELETE FROM ".table('groupbuy_category')." WHERE catid='$catid' ");
			gourl();
	
		break;
	case 'order':
			$w='';
			$url="admin.php?m=groupbuy&a=order";
			if($_GET['nickname'])
			{
				$w.=" AND nickname like '".htmlspecialchars(trim($_GET['nickname']))."%' ";
				$url.="&nickname=".urlencode($_GET['nickname']);
			}
			$_GET['status']=isset($_GET['status'])?$_GET['status']:'-1';
			if($_GET['status']>-1)
			{
				$w.=" AND status = ".intval($_GET['status'])." ";
				$url.="&status=".intval($_GET['status']);
			}
			
			if($_GET['starttime'])
			{
				$w.=" AND dateline>".strtotime($_GET['starttime'])." ";
				$url.="&starttime=".$_GET['starttime'];
			}
			if($_GET['endtime'])
			{
				$w.=" AND dateline<".strtotime($_GET['endtime'])." ";
				$url.="&endtime=".$_GET['endtime'];
			}
			
			
			assignlist('groupbuy_order',10,$w,' ORDER BY orderid DESC ',$url);
			$smarty->display("groupbuy_order.html");
		break;
	case 'orderstatus':
			$ids=$_POST['orderid'];
			$status=intval($_GET['status']);
			$ids=$db->getCols("SELECT orderid FROM ".table('groupbuy_order')." WHERE orderid in("._implode($ids).") AND status<3 ");
			if(!empty($ids))
			{			 
				$db->query("UPDATE ".table('groupbuy_order')." SET status='$status' WHERE orderid in("._implode($ids).") ");
			}
			errback('操作成功');
		break;
}
?>