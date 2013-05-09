<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
$a='index';	
}
checkpermission("user",$a);
if($a=='index')
{
	$status=$_GET['status']=intval($_GET['status']);
	$username=trim($_GET['username']);
	$url="admin.php?m=user&status=$status";
	$sql="select * from ".table('user')." WHERE status='$status' ";
	$sql2="select count(1) from ".table('user')." WHERE status='$status' ";
	if($username)
	{
		$sql.=" AND username like '".$username."%'";
		$sql2.=" AND username like '".$username."%' ";	
		$smarty->assign("username",$username);
		$url.="&username={$username}";
	}
	$sql.="order by userid desc";
	//开始分页
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$rscount=$db->getOne($sql2);
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//结束分页
	$res=$db->query($sql);
	$arr=array();
	while($rs=@$db->fetch_array($res))
	{
		if($rs['status']==0)
		{
			$rs['dotype']="<a href=\"admin.php?m=user&a=dotype&userid=".$rs['userid']."&status=1\">未审核</a>";
		}elseif($rs['status']==1)
		{
			$rs['dotype']=" <a href=\"admin.php?m=user&a=dotype&userid=".$rs['userid']."&status=2\">已审核</a>";
		}elseif($rs['status']==2)
		{
			$rs['dotype']=" <a href=\"admin.php?m=user&a=dotype&userid=".$rs['userid']."&status=1\">已禁止</a>";
		}
		
		$arr[$rs['userid']]=$rs;
	}
	$smarty->assign("userlist",$arr);
	$smarty->display("user.html");
}
elseif($a=='add')
{
	$smarty->display("user_add.html");	
}elseif($a=='add_db')
{
	$username=trim($_POST['username']);
	ckempty($username,"用户名不能为空！");
	$email=trim($_POST['email']);
	if(!(is_email($email))) errback('邮箱不合法');
	$pwd1=trim($_POST['pwd1']);
	cklong($pwd1,"密码长度介于7-50",50,7);
	$pwd2=trim($_POST['pwd2']);
	if($pwd1!=$pwd2) errback("两次密码输入不一致");
	$ct=$db->getOne("select count(*) from ".table('user')." where username='$username' ");
	if($ct) errback("该用户名已被注册"); 
	$db->query("insert into ".table('user')."(username,email,password) values('$username','$email','".umd5($pwd1)."') ");
	gourl();
	
}elseif($a=="del")
{
	$userid=intval($_GET['userid']);
	$db->query("delete from ".table('user')." where userid='$userid' ");
	gourl();
}elseif($a=='dotype')
{
	$userid=intval($_GET['userid']);
	$status=intval($_GET['status']);
	$db->query("update ".table('user')." set status='$status' where userid='$userid' ");
	gourl();	
}elseif($a=='chpwd')
{
	$username=$_GET['username'];
	$smarty->assign("username",$username);
	$smarty->display("user_chpwd.html");
}elseif($a=='chpwd_db')
{
	$username=trim($_POST['username']);
	$pwd1=trim($_POST['pwd1']);
	cklong($pwd1,"密码长度介于7-50",50,7);
	$pwd2=trim($_POST['pwd2']);
	if($pwd1!=$pwd2) errback("两次密码输入不一致");
	$db->query("update ".table('user')." set password='".umd5($pwd1)."' where username='$username'  ");
	gourl("admin.php?m=user&");
}elseif($a=='info')
{
	$userid=intval($_GET['userid']);
	$user=$db->getRow("select * from ".table('user')." where userid='$userid' ");
	$smarty->assign("user",$user);
	//获取折扣信息
	$discount=intval($db->getOne("select discount from ".table('user_rank')." where min_grade<'{$user['grade']}' and max_grade>'{$user['grade']}' "));
	$smarty->assign("discount",$discount);
	//获取可用金额
	$smarty->assign("bonus",$db->getOne("select bonus from ".table('user_bonus')." where userid='$userid' "));
	//获取推广用户数
	$smarty->assign("spread",$db->getOne("select count(*) from ".table('user')." where fuserid='$userid' "));
	//获得消费金额
	$smarty->assign("ordermoney",$db->getOne("select sum(money) from ".table('order')." where userid='$userid' AND sendtype=3 "));
	//好友消费金额
	$smarty->assign("friendmoney",$friendmoney=$db->getOne("select sum(money) from ".table('order')." where userid in(select userid from ".table('user')." where fuserid='$userid') AND sendtype=3  "));
	//好友带来的奖励
	$smarty->assign("friendbonus",$friendmoney*SPREAD_DISCOUNT);
	$smarty->display("user_info.html");	
}