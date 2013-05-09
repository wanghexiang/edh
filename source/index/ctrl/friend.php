<?php
$action=array('follow','follow_add','follow_del','followed','my','userinfo');
if(!in_array($_GET['a'],$action))
{
	$_GET['a']='follow';
}
if(in_array($_GET['a'],array('follow','follow_add','follow_del','followed','my')))
{
	check_login();
}
$userid=$_SESSION['ssuser']['userid'];
switch($_GET['a'])
{
	case 'follow':
				if($_GET['userid'])
				{
					$userid=intval($_GET['userid']);
				}
				$pagesize=20;
				$page=max(1,intval($_GET['page']));
				$start=($page-1)*$pagesize;
				$rscount=$db->getOne("SELECT count(1) FROM ".table('follow')." WHERE userid='$userid' ");
				
				$users=$db->getAll("SELECT u.userid,u.nickname,u.logo,u.followers,u.followeds,f.status FROM ".table('follow')." f LEFT JOIN ".table('user')." u   ON f.touserid=u.userid WHERE f.userid='$userid' ORDER BY f.dateline DESC LIMIT $start,$pagesize  ");
				
				$smarty->assign("users",$users);
				$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,'index.php?m=friend&a=follow'));
				
				if($userid!=$_SESSION['ssuser']['userid'])
				{
					assignuser($userid);
				}		
				$smarty->display("friend.html");
			break;
	case  'follow_add':
				$touserid=intval($_GET['touserid']);
				if($touserid==$userid)
				{
					if($_GET['ajax'])
					{
						echo '不能关注自己';exit();
					}else
					{
						errback('不能关注自己');
					}
				}
				if(!$db->getOne("SELECT userid FROM ".table('follow')." WHERE userid='$userid' AND touserid='$touserid' "))
				{
					$status=$db->getOne("SELECT status FROM ".table('follow')." WHERE userid='$touserid' AND touserid='$userid'");
					if($status==1)
					{
						$db->query("INSERT INTO ".table('follow')." SET userid='$userid',touserid='$touserid',status=2,dateline=".time()." ");
						$db->query("UPDATE ".table('follow')." SET status=2 WHERE userid='$touserid' AND touserid='$userid' ");
						
					}else
					{
						$db->query("INSERT INTO ".table('follow')." SET userid='$userid',touserid='$touserid',status=1,dateline=".time()." ");
					}
					$db->query("UPDATE ".table('user')." SET followers=followers+1 WHERE userid='$userid' ");
					$db->query("UPDATE ".table('user')." SET followeds=followeds+1 WHERE userid='$touserid' ");
				}
				if($_GET['ajax'])
				{
					echo '添加关注成功';exit();
				}else
				{
					errback('添加关注成功');
				}
			break;
	case 'follow_del':
				$touserid=intval($_GET['touserid']);
				if($db->getOne("SELECT userid FROM ".table('follow')." WHERE userid='$userid' AND touserid='$touserid' "))
				{
					$status=$db->getOne("SELECT status FROM ".table('follow')." WHERE userid='$touserid' AND touserid='$userid'");
					if($status==2)
					{
						$db->query("DELETE FROM ".table('follow')." WHERE userid='$userid' AND touserid='$touserid'");
						$db->query("UPDATE ".table('follow')." SET status=1 WHERE userid='$touserid' AND touserid='$userid' ");						
					}else
					{
						$db->query("DELETE FROM ".table('follow')." WHERE userid='$userid' AND touserid='$touserid'");						
					}
					$db->query("UPDATE ".table('user')." SET followers=followers-1 WHERE userid='$userid' ");
					$db->query("UPDATE ".table('user')." SET followeds=followeds-1 WHERE userid='$touserid' ");
				}
				
				if($_GET['ajax'])
				{
					echo '取消关注成功';exit();
				}else
				{
					errback('取消关注成功');
				}
			break;
	case 'followed':
				if($_GET['userid'])
				{
					$userid=intval($_GET['userid']);
				}
				$pagesize=20;
				$page=max(1,intval($_GET['page']));
				$start=($page-1)*$pagesize;
				$rscount=$db->getOne("SELECT count(1) FROM ".table('follow')." WHERE touserid='$userid' ");
				$users=$db->getAll("SELECT u.userid,u.nickname,u.logo,u.followers,u.followeds,f.status FROM ".table('follow')." f LEFT JOIN ".table('user')." u   ON f.userid=u.userid WHERE f.touserid='$userid' ORDER BY f.dateline DESC LIMIT $start,$pagesize   ");

				$smarty->assign("users",$users);
				$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,'index.php?m=friend&a=followed'));
				if($userid!=$_SESSION['ssuser']['userid'])
				{
					assignuser($userid);
				}				
				$smarty->display("friend.html");
			
			break;
	case 'userinfo':
				$touserid=intval($_GET['touserid']);
				$user=$db->getRow("SELECT * FROM ".table('user')." WHERE userid='$touserid' ");
				$follow=$db->getOne("SELECT status FROM ".table('follow')." WHERE userid='$userid' AND touserid='$touserid' ");
				$followed=$db->getOne("SELECT status FROM ".table('follow')." WHERE userid='$touserid' AND touserid='$userid' ");
				$user['follow']=$follow;
				$user['followed']=$followed;
				$smarty->assign("user",$user);
				if($_GET['ajax'])
				{
					$smarty->display("ajax/userinfo.html");
				}else
				{
					$smarty->display("userinfo.html");
				}
			break;
				
	
}

?>