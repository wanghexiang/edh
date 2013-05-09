<?php
//通用评论类调用函数
function addcomment($tb,$url,$siteid=1)
{
	check_login();
	$comment= new cls_comment($tb);
	$comment->addComment($siteid);
	$url=$url.intval($_POST['pid']);
	errback("评论成功",$url);
}
//评论列表
function commentlist($tb,$url,$pid,$shopid=0)
{
	global $db,$smarty;

/*美食评论*/
$comment= new cls_comment($tb);

$pagesize=ISWAP?5:10;
$page=max(1,intval($_GET['page']));
$start=($page-1)*$pagesize;
$smarty->assign("page",intval($_GET['page']));
$pagelist=multipage($rscount,$pagesize,$page,"cai.php?id={$pid}");
$w=$shopid?" AND pid='$pid' AND shopid='$shopid' ":" AND pid='$pid' ";
$commentlist=$comment->commentList($w,$start,$pagesize,1);
$rscount=$comment->commentCount($w,1);
$smarty->assign("pagelist",$pagelist);
$smarty->assign("commentlist",$commentlist);

}
/*
通用评论文件
数据库
rid 		表rid
pid			回复主题id
title		回复标题
content		回复内容
userid		用户id
reply		贴主回复
ip			用户ip
rtime		时间
status 		审核
*/
class cls_comment
{
	private $table;
	function __construct($tb)
	{
		$this->table=$tb;
	}
	
	function addComment($siteid=1)
	{
		global $db;
		$pid=intval($_POST['pid']);
		$title=trim(htmlspecialchars($_POST['title']));
		$username=trim(htmlspecialchars($_POST['username']));
		$content=trim(htmlspecialchars($_POST['content']));
		$shopid=intval($_POST['shopid']);
		if(empty($content))
		{
			return false;
		}
		$userid=intval($_SESSION['ssuser']['userid']);
		$dateline=time();
		$ip=$_SERVER['REMOTE_ADDR'];
		$db->query("insert into ".table($this->table)."(pid,title,content,userid,dateline,ip,username,siteid) values('$pid','$title','$content','$userid','$dateline','$ip','$username','$siteid') ");
	
		
	}
	function ediComment()
	{
		global $db;
		$rid=intval($_POST['rid']);
		$content=trim(htmlspecialchars($_POST['content']));		
		$userid=intval($_SESSION['ssuser']['userid']);

		$db->db_query("update ".table($this->table)." set content='$content' where rid='$rid' and userid='$userid'  ");
		
	}
	
	function commentList($w='',$start=0,$limit=0,$status=-1)
	{
		global $db;
		$arr=array();
		$sql=" select * from ".table($this->table)." where 1=1  $w ";

		if($status>-1)
		{
			$sql.= " and status='$status' " ;
		}
		$sql.=" order by rid desc ";
		$sql.=$limit?" limit {$start},{$limit}":"";
		$res=$db->query($sql);
		
		while($rs=$db->fetch_array($res))
		{
			$arr[$rs['rid']]=$rs;
		}
		return $arr;
	}
	function commentCount($w='',$status=-1)
	{
		global $db;
		$sql="select count(*) from ".table($this->table)." where 1=1 $w " ;
		
		if($status>-1)
		{
		$sql.= " and status='$status' " ;
		}
		return $db->getOne($sql);
	}
	function getComment($rid)
	{
		global $db;
		return $db->getRow("select * from ".table($this->table)." where rid='$rid'");
	}
	
	
	function reComment($shopid=0)
	{
		global $db;
		$rid=intval($_POST['rid']);
		$w=$shopid?" AND shopid='$shopid' ":"";
		
		$reply=trim(htmlspecialchars($_POST['reply']));
		$db->query("update ".table($this->table)." set reply='$reply' where rid='$rid' $w  ");
	}
	function delComment($ids,$shopid=0)
	{
		global $db;
		$w=$shopid?" AND shopid='$shopid' ":"";
		if(empty($ids))
		{
			return false;
		}
		if(is_array($ids))
		{
			foreach($ids as $t)
			{
				$db->query(" delete from ".table($this->table)." where rid in("._implode($t).") $w ");
			}
		}else
		{
			$db->query(" delete from ".table($this->table)." where rid='$ids' $w ");
		}
	}
	
	function setstatus($rid,$status=0,$shopid=0)
	{
		global $db;
		$w=$shopid?" AND shopid='$shopid' ":"";
		if(is_array($rid))
		{
			
			$db->query("update  ".table($this->table)." set status='$status' where rid in("._implode($rid).") $w  ");
		}else
		{
			$db->query("update ".table($this->table)." set status='$status' where rid='$rid' $w ");
		}
	}
	
	function setTable($tb)
	{
		$this->table=$tb;
	}
	
	function getTable()
	{
		return $this->table;
	}
	
}


