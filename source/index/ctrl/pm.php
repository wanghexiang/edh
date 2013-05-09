<?php
session_write_close();
$action=array("list","index",'status',"del",'send','detail');
if(!in_array($_GET['a'],$action))
{
	$_GET['a']='index';
}
check_login();
$userid=$_SESSION['ssuser']['userid'];
switch($_GET['a'])
{
	case 'index':
			$pagesize=20;
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$status=intval($_GET['status']);
			$msglist=array();
			$rscount=$db->getOne("SELECT COUNT(1) FROM ".table('pm_index')."   WHERE userid='$userid'   ");
			$smarty->assign("rscount",$rscount);
			$res=$db->query("SELECT m.*,u.nickname,u.logo FROM ".table('pm_index')." pi ".
			" LEFT JOIN  ".table('pm')." m  ON pi.id=m.id ".
			" LEFT JOIN ".table('user')." u ON pi.touserid=u.userid  WHERE pi.userid='$userid'   ORDER BY m.id DESC LIMIT $start,$pagesize");
			while($rs=$db->fetch_array($res))
			{
				$rs['dateline']=timeago($rs['dateline']);
				$rs['num']=$db->getOne("SELECT count(1) FROM ".table('pm')." WHERE (userid=".$rs['userid']." AND touserid=".$rs['touserid']." AND useridstatus=0 ) OR (touserid=".$rs['userid']." AND userid=".$rs['touserid']." AND touseridstatus=0) ");
				$msglist[]=$rs;
			}
			
			$smarty->assign("msglist",$msglist);
			$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=pm&status=$status"));
			$smarty->display("pm.html");
		break;
	case 'status':
			$id=intval($_GET['id']);
			$db->query("UPDATE ".table('pm')." SET status=1 WHERE id='$id' AND touserid='$userid' ");
			gourl();
		break;
	case 'del':
			$id=intval($_GET['id']);
			$rs=$db->getRow("SELECT userid,touserid FROM ".table('pm')." WHERE id='$id' ");
			if($rs['userid']!=$userid && $rs['touserid']!=$userid) errback('你无删除权限');
			if($rs['userid']==$userid)
			{//发信者
				$db->query("UPDATE ".table('pm')." SET useridstatus=-1 WHERE id='$id' ");
				
			}else
			{
				$db->query("UPDATE ".table('pm')." SET touseridstatus=-1 WHERE id='$id' ");
			}
			$newid=$db->getOne("SELECT id FROM ".table('pm')." WHERE (userid=".$rs['userid']." AND touserid=".$rs['touserid']." AND useridstatus=0 ) OR (userid=".$rs['touserid']." AND touserid=".$rs['userid']." AND touseridstatus=0 ) ");
			
			$db->query("DELETE FROM  ".table('pm_index')." WHERE userid='$userid' AND touserid=".$rs['touserid']." ");
			if($newid)
			{
			$db->query("INSERT INTO ".table('pm_index')." SET userid='$userid' AND touserid=".$rs['touserid'].",id='$newid'");
			}
			gourl();
		break;
	case 'send':
			header("Content-type:text/html;charset=gb2312");
			if($_GET['op']=='post')
			{
				$nicknames=$_POST['nicknames'];
				
				$content=htmlspecialchars($_POST['content']);
				if($_REQUEST['ajax'])
				{
					$nicknames=iconvstr("utf-8","gb2312",$nicknames);
					$content=iconv("utf-8","gb2312",$content);
				 
				}
				$users=explode("@",$nicknames);
				$users=addslashes_deep($users);
				
				$touserids=$db->getCols("SELECT userid FROM ".table('user')." WHERE nickname in("._implode($users).") ");
				 
				
				if($touserids)
				{
					$dateline=time();
					foreach($touserids as $touserid )
					{
						$db->query("INSERT INTO ".table('pm')." SET userid='$userid',touserid='$touserid',dateline='$dateline',content='$content' ");
						$id=$db->insert_id();
						//插入最新的私信
						 
						$db->query("DELETE FROM ".table('pm_index')." WHERE (userid='$userid' AND touserid='$touserid') or (userid='$touserid' AND touserid='$userid') ");
						$db->query("INSERT INTO ".table('pm_index')." SET id='$id',userid='$userid',touserid='$touserid' ");
						$db->query("INSERT INTO ".table('pm_index')." SET id='$id',userid='$touserid',touserid='$userid' ");
					}
				}
				if($_GET['ajax'])
				{
					echo '发送成功';exit();
				}else
				{
					gourl();
				}
					
			}else
			{
				$smarty->display("pm_send.html");
			}
		break;
	case 'detail':
				$touserid=intval($_GET['touserid']);
				//更新状态
				$db->query("UPDATE ".table('pm')." SET status=1 WHERE touserid='$touserid' ");
				$pagesize=20;
				$page=max(1,intval($_GET['page']));
				$start=($page-1)*$pagesize;
				$rscount=$db->getOne("SELECT count(1) FROM ".table('pm')." WHERE (userid='$userid' AND touserid='$touserid' AND useridstatus=0) OR (userid='$touserid' AND touserid='$userid' AND touseridstatus=0) ");		
				$smarty->assign("rscount",$rscount);
				$smarty->assign("nickname",$db->getOne("SELECT nickname FROM ".table('user')." WHERE userid='$touserid' "));
				$pagelist=multipage($rscount,$pagesize,$page,"index.php?m=pm&a=detail&touserid=$touserid");
				$pmlist=$db->getAll("SELECT * FROM ".table('pm')."  WHERE (userid='$userid' AND touserid='$touserid' AND useridstatus=0) OR (userid='$touserid' AND touserid='$userid' AND touseridstatus=0) ORDER BY id DESC LIMIT $start,$pagesize ");
				
				$smarty->assign("pmlist",$pmlist);
				
				$smarty->display("pm_detail.html");
	
			break;
	
}
?>