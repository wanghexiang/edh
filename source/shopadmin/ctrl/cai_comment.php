<?php

check_login();
$a=trim($_REQUEST['a']);
if(empty($a))
{
	$a="index";
}
$shopid=$_SESSION['adminshop']['shopid'];
require(ROOT_PATH."/includes/cls_comment.php");
$comment= new cls_comment("cai_comment");
if($a=="index")
{
	$arr=array();
	$pid=intval($_GET['pid']);
	$w="  AND shopid='$shopid' ";
	if($pid) $w.=" AND pid='$pid' ";
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$rscount=$comment->commentCount($w,intval($_GET['status']));
	$pagelist=multipage($rscount,$pagesize,$page,"shopadmin.php?m=cai_comment&status=".intval($_GET['status']));
	$commentlist=$comment->commentList($w,$start,$pagesize,intval($_GET['status']));
	
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