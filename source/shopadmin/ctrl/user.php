<?php

check_login();
$a=$_REQUEST['a'];
if(empty($a))
{
$a='index';	
}
if($a=='index')
{
	$username=trim($_GET['username']);
	$url="shopadmin.php?m=user";
	$sql="select * from ".table('user')." ";
	$sql2="select count(*) from ".table('user')." ";
	if($username)
	{
		$sql.=" where username like '%".$username."%'";
		$sql2.=" where username like '%".$username."%' ";	
		$smarty->assign("username",$username);
		$url.="?username={$username}";
	}
	$sql.="order by userid desc";
	//��ʼ��ҳ
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//������ҳ
	$res=$db->query($sql);
	$arr=array();
	while($rs=@$db->fetch_array($res))
	{
		if($rs['status']==0)
		{
			$rs['dotype']="<a href=\"shopadmin.php?m=user&a=dotype&userid=".$rs['userid']."&status=1\">δ���</a>";
		}elseif($rs['status']==1)
		{
			$rs['dotype']=" <a href=\"shopadmin.php?m=user&a=dotype&userid=".$rs['userid']."&status=-1\">�����</a>";
		}elseif($rs['status']==-1)
		{
			$rs['dotype']=" <a href=\"shopadmin.php?m=user&a=dotype&userid=".$rs['userid']."&status=1\">�ѽ�ֹ</a>";
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
	ckempty($username,"�û�������Ϊ�գ�");
	$email=trim($_POST['email']);
	if(!(is_email($email))) errback('���䲻�Ϸ�');
	$pwd1=trim($_POST['pwd1']);
	cklong($pwd1,"���볤�Ƚ���7-50",50,7);
	$pwd2=trim($_POST['pwd2']);
	if($pwd1!=$pwd2) errback("�����������벻һ��");
	$ct=$db->getOne("select count(*) from ".table('user')." where username='$username' ");
	if($ct) errback("���û����ѱ�ע��"); 
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
	cklong($pwd1,"���볤�Ƚ���7-50",50,7);
	$pwd2=trim($_POST['pwd2']);
	if($pwd1!=$pwd2) errback("�����������벻һ��");
	$db->query("update ".table('user')." set password='".umd5($pwd1)."' where username='$username'  ");
	gourl("shopadmin.php?m=user&");
}elseif($a=='info')
{
	$userid=intval($_GET['userid']);
	$user=$db->getRow("select * from ".table('user')." where userid='$userid' ");
	$smarty->assign("user",$user);
	//��ȡ�ۿ���Ϣ
	$discount=intval($db->getOne("select discount from ".table('user_rank')." where min_grade<'{$user['grade']}' and max_grade>'{$user['grade']}' "));
	$smarty->assign("discount",$discount);
	//��ȡ���ý��
	$smarty->assign("bonus",$db->getOne("select bonus from ".table('user_bonus')." where userid='$userid' "));
	//��ȡ�ƹ��û���
	$smarty->assign("spread",$db->getOne("select count(*) from ".table('user')." where fuserid='$userid' "));
	//������ѽ��
	$smarty->assign("ordermoney",$db->getOne("select sum(money) from ".table('order')." where userid='$userid' "));
	//�������ѽ��
	$smarty->assign("friendmoney",$friendmoney=$db->getOne("select sum(money) from ".table('order')." where userid in(select userid from ".table('user')." where fuserid='$userid') "));
	//���Ѵ����Ľ���
	$smarty->assign("friendbonus",$friendmoney*SPREAD_DISCOUNT);
	$smarty->display("user_info.html");	
}