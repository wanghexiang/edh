<?php

check_login();
$a=trim($_GET['a']?$_GET['a']:$_POST['a']);
if(empty($a))
{
	$a="index";
}
require(ROOT_PATH."/includes/cls_comment.php");
$comment= new cls_comment("cook_comment");
if($a=="index")
{
	$arr=array();
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pid=intval($_GET['pid']);
	if(isset($_GET['status']))
	{
	$rscount=$comment->commentCount($pid,intval($_GET['status']));
	$pagelist=multipage($rscount,$pagesize,$page,"admin.php?m=cook_comment&status=".intval($_GET['status']));
	$commentlist=$comment->commentList($pid,$start,$pagesize,intval($_GET['status']));
	}else
	{
	$rscount=$comment->commentCount($pid );
	$pagelist=multipage($rscount,$pagesize,$page,"admin.php?m=cook_comment");
	$commentlist=$comment->commentList($pid,$start,$pagesize);
	}
	$smarty->assign("pagelist",$pagelist);
	$smarty->assign("commentlist",$commentlist);
	$smarty->display("cook_comment.html");
}elseif($a=='del')
{
	$rids=$_POST['rids'];
	$comment->delComment($rids);
	header("Location: ".$_SERVER['HTTP_REFERER']);	
}elseif($a=='status')
{
	$rids=$_POST['rids'];
	$comment->setstatus($rids,1)	;
	header("Location: ".$_SERVER['HTTP_REFERER']);
}elseif($a=='nostatus')
{
	$rids=$_POST['rids'];
	$comment->setstatus($rids,0)	;
	header("Location: ".$_SERVER['HTTP_REFERER']);
}



?>