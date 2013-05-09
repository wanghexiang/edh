<?php
/*�������ݲ�������*/
require_once("function_base.php");
require("function_art.php");
require("function_cai.php");
require("function_shopcar.php");
require("function_address.php");
require("function_modfun.php");
require_once("function_shop.php");
/*��վ��Ϣ����*/
function web()
{
	global $db,$smarty,$cksiteid;
	$web=$db->getRow("select * from ".table('web')." WHERE siteid='$cksiteid' ");
	
	$smarty->assign("web",$web);
	return $web;	
}
/*
��ȡ��������
���� navchild �Ƿ�����������
*/

function nav($navchild=1)
{
	global $db,$smarty;
	$arr=array();
	//��ȡ��������
	$cachetime=100000;
	$file="nav.sql";
	if(is_sqlcache($file,$cachetime))
	{
		$arr=getsqlcache($file);
	}else
	{
		$res=$db->query("select id,title,navurl from ".table('nav')." where pid=0 order by orderid asc ");
		while($rs=$db->fetch_array($res))
		{
			$arr[$rs['id']]=$rs;
			if($navchild)
			{
				$arr[$rs['id']]['child']=$db->getAll("select id,title,navurl from ".table('nav')." where pid=".$rs['id']." order by orderid asc ");
			}
				
		}
	}
	$smarty->assign("nav",$arr);
}
/*��������*/
function friendlink()
{
	global $db,$smarty,$cksiteid;
	$smarty->assign("links",$db->getAll("SELECT * FROM ".table('link')." WHERE siteid='$cksiteid' ORDER BY orderid ASC LIMIT 100 "));
}




/*��վ*/
function sitelist()
{
	return $GLOBALS['db']->getAll("SELECT siteid,sitename,domain FROM ".table('sites')." ORDER BY orderindex ASC ");
}

/*��ע����*/
function follows($userid)
{
	global $db;
	$arr=array();
	$res=$db->query("SELECT touserid,status FROM ".table('follow')." WHERE userid='$userid' ");
	
	while($rs=$db->fetch_array($res))
	{
		$arr[$rs['touserid']]=$rs['status'];
	}
	return $arr;
}
//��ע�����
function followeds($touserid)
{
	global $db;
	$arr=array();
	$res=$db->query("SELECT userid,status FROM ".table('follow')." WHERE touserid='$userid' ");
	while($rs=$db->fetch_array($res))
	{
		$arr[$rs['userid']]=$rs['status'];
	}
	return $arr;
}
//���ĳ����
function assignuser($userid)
{
	global $db,$smarty;
	$user=$db->getRow("SELECT * FROM ".table('user')." WHERE userid='$userid' ");
	$follow=$db->getOne("SELECT status FROM ".table('follow')." WHERE userid=".$_SESSION['ssuser']['userid']." AND touserid='$userid' ");
	$followed=$db->getOne("SELECT status FROM ".table('follow')." WHERE userid='$userid' AND touserid=".$_SESSION['ssuser']['userid']." ");
	$user['follow']=$follow;
	$user['followed']=$followed;
	$smarty->assign("user",$user);
}

/*����@*/
function Analyticat($content)
{
	global $db;
	//����@
	preg_match_all("/.*@([^\s@]+?)[\s@]*.*/iUs",$content,$users);
	
	$userids=array();
	if($users)
	{
		$us=$users[1];
		  
		$us=$db->getAll("SELECT userid,nickname FROM ".table('user')." WHERE nickname in("._implode($us).")  ");
 
		if($us)
		{
			foreach($us as $u)
			{
				
				$content=preg_replace("/@".$u['nickname']."[\s]/iU","<a href=\'index.php?m=member&userid=".$u['userid']."\' target=\'_blank\'>@".$u['nickname']."</a> ",$content);
				$userids[]=$u['userid'];
			}
		}
	}
	return array($userids,$content);
}
/*����#*/

function  Analytictopic($content)
{
	global $db;
	$tids=array();
	preg_match_all("/.*#([^#]+?)#.*/iUs",$content,$arr);
	if($arr)
	{
		$topics=$arr[1];		
		foreach($topics as $t)
		{ 
			if($t && strlen($t)<100)
			{
				$tid=$db->getOne("SELECT tid FROM ".table('topic')." WHERE title='$t'");
				if(!$tid)
				{
					$db->query("INSERT INTO ".table('topic')." SET title='$t',dateline=".time().",newdateline=".time()."  ");
					$tid=$db->insert_id();
				}
				$tids[]=$tid;
				$content=preg_replace("/#".$t."#/iU","<a href=\'index.php?m=topic&a=detail&tid=".$tid."\' target=\'_blank\'>#".$t."#</a> ",$content);
			}
		}
	}
	return array($tids,$content);	
}

