<?php

check_login();
$a=trim($_GET['a']?$_GET['a']:$_POST['a']);
if(empty($a))
{
	$a="index";
}
checkpermission("cai_comment",$a);
require(ROOT_PATH."/includes/cls_comment.php");

$comment= new cls_comment("cai_comment");
if($a=="index")
{
	$arr=array();
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pid=intval($_GET['pid']);
	$w=" AND siteid ='$siteid' AND status=".intval($_GET['status'])." ";
	if($pid) $w=" AND pid='$pid' ";
	$rscount=$comment->commentCount($w);
	
	$pagelist=multipage($rscount,$pagesize,$page,"admin.php?m=cai_comment&status=".intval($_GET['status']));

	$commentlist=$comment->commentList($w,$start,$pagesize);
	
	$smarty->assign("pagelist",$pagelist);
	$smarty->assign("commentlist",$commentlist);
	$smarty->display("cai_comment.html");
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