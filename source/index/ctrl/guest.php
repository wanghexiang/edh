<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

$a=$_REQUEST['a'];
if(empty($a))
{
	$a='list';
}

if($a=='list')
{
	$shopid=intval($_GET['shopid']);
	$rscount=$db->getOne("select count(*) from ".table('guest')." where status=1  AND shopid='$shopid' ");
	$sql="select * from ".table('guest')." where status=1  AND shopid='$shopid' order by id desc";
	$pagesize=ISWAP?5:10;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$sql.=" limit $start,{$pagesize}";
	$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=guest&"));
	$res=$db->query($sql);
	$arr=array();
	while($rs=$db->fetch_array($res))
	{
		$arr[$rs['id']]=$rs;
		$arr[$rs['id']]['content']=unHtml($rs['content']);
		$arr[$rs['id']]['reply']=unHtml($rs['reply']);
	}
	$smarty->assign("guestlist",$arr);
	
	$smarty->assign("where","<a href={$web['weburl']}>首页</a> > 留言列表");
	//seo选项
	$smarty->assign("title",$web['webtitle']);
	$smarty->assign("keywords",$web['webkey']);
	$smarty->assign("description",$web['webdesc']);
	//seo选项结束
	$smarty->display("guest.html");
	
}elseif($a=='my')
{
	$userid=intval($_SESSION['ssuser']['userid']);
	$rscount=$db->getOne("select count(*) from ".table('guest')." where userid='$userid'    ");
	$sql="select * from ".table('guest')." where userid='$userid'    order by id desc";
	$pagesize=ISWAP?5:10;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$sql.=" limit $start,{$pagesize}";
	
	$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=guest&a=my"));
	$res=$db->query($sql);
	$arr=array();

	while($rs=$db->fetch_array($res))
	{
		$rs['content']=unHtml($rs['content']);
		$rs['reply']=unHtml($rs['reply']);
		$arr[$rs['id']]=$rs;
	}
	$smarty->assign("guestlist",$arr);
	$smarty->assign("where","<a href={$web['weburl']}>首页</a> > 我的留言");
	$smarty->display("myguest.html");
}
elseif($a=='add')
{
	$smarty->assign("where","<a href={$web['weburl']}>首页</a> > 添加留言");
	$smarty->assign("action","index.php?m=guest&a=add_db");
	//seo选项
	$smarty->assign("title",$web['webtitle']);
	$smarty->assign("keywords",$web['webkey']);
	$smarty->assign("description",$web['webdesc']);
	//seo选项结束
	$smarty->display("guest_add.html");
}elseif($a=='add_db')
{
	check_login();
	$title=strip_tags($_POST['title']);
	$email=strip_tags($_POST['email']);
	if($email && !is_email($email)) errback("邮箱格式不正确");
	$qq=intval($_POST['qq']);
	$phone=strip_tags($_POST["phone"]);
	$content=trim(strip_tags($_POST['content']));
	ckempty($content,"内容不能为空！");
	$userid=intval($_SESSION['ssuser']['userid']);
	$ip=$_SERVER['REMOTE_ADDR'];
	$username=trim(strip_tags($_POST['username']));
	if(empty($username))
	{
		$username=$_SESSION['ssuser']['username']?$_SESSION['ssuser']['username']:'游客';
	}
	$shopid=intval($_POST['shopid']);
	
	$dateline=strtotime(date("y-m-d H:i:s"));
	$db->query("insert into ".table('guest')."(title,email,qq,phone,content,userid,ip,dateline,username,shopid,siteid) values('$title','$email','$qq','$phone','$content','$userid','$ip','$dateline','$username',".$shopid.",'$cksiteid') ");
	errback("感谢您的留言，我们会尽快反馈给你");
}

?>