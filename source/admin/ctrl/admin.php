<?php

check_login();
$a=$_GET['a']?htmlspecialchars($_GET['a']):htmlspecialchars($_POST['a']);
if(empty($a))
{
	$a='index';
}

checkpermission("admin",$a);

if($a=='index')
{
	$adminname=trim($_GET['adminname']);
	$url="admin.php";
	$sql="select a.*,z.title from ".table('admin')." a LEFT JOIN ".table('admin_zu')." z ON a.zuid=z.id  WHERE a.siteid='$siteid'  ";
	$sql2="select count(1) from ".table('admin')."   WHERE  siteid='$siteid' ";

	if($adminname)
	{
		$sql.="   a.adminname like '%".$adminname."%'";
		$sql2.="   adminname like '%".$adminname."%' ";	
		$smarty->assign("adminname",$adminname);
		$url.="?adminname={$adminname}";
	}
	$sql.="order by a.adminid desc";
	//开始分页
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pagelist=multipage($rscount,$pagesize,$page,$url);
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	//结束分页
	$res=$db->query($sql);
	$arr=array();
	while($rs=@$db->fetch_array($res))
	{
		$arr[$rs['adminid']]=$rs;
	}
	$smarty->assign("adminlist",$arr);
	$smarty->display("admin.html");
}
elseif($a=='add')
{

	if($_GET['op']=='db')
	{
		$adminname=trim($_POST['adminname']);
		ckempty($adminname,"用户名不能为空！");
		$email=trim($_POST['email']);
		if(!(is_email($email))) errback('邮箱不合法');
		$pwd1=trim($_POST['pwd1']);
		cklong($pwd1,"密码长度介于7-50",50,7);
		$pwd2=trim($_POST['pwd2']);
		if($pwd1!=$pwd2) errback("两次密码输入不一致");
		$zuid=intval($_POST['zuid']);
		$ct=$db->getOne("select adminid from ".table('admin')." where adminname='$adminname' ");
		if($ct) errback("该用户名已被注册"); 
		$db->query("insert into ".table('admin')."(adminname,email,password,zuid,siteid) values('$adminname','$email','".umd5($pwd1)."',".$zuid.",'$siteid') "); 
		gourl();
	}else
	{
		$zulist=$db->getAll("SELECT title,id FROM ".table('admin_zu')." WHERE siteid='$siteid' ");
		$smarty->assign("zulist",$zulist);
		$smarty->display("admin_add.html");	
	}
	
}elseif($a=="del")
{
	$adminid=intval($_GET['adminid']);
	$db->query("delete from ".table('admin')." where adminid='$adminid' ");
	gourl();
}elseif($a=='chpwd')
{
	$adminid=intval($_GET['adminid']);
	if($_GET['op']=='db')
	{
		if($pwd1)
		{
		$pwd1=trim($_POST['pwd1']);
		cklong($pwd1,"密码长度介于7-50",50,7);
		$pwd2=trim($_POST['pwd2']);
		if($pwd1!=$pwd2) errback("两次密码输入不一致");
		$db->query("update ".table('admin')." set password='".umd5($pwd1)."' where adminid='$adminid'  ");
		}
		$zuid=intval($_POST['zuid']);
		$db->query("update ".table('admin')." set zuid='$zuid' where adminid='$adminid'  ");
		gourl("admin.php?m=admin");
	}else
	{
		$zulist=$db->getAll("SELECT title,id FROM ".table('admin_zu')." ");
		$smarty->assign("zulist",$zulist);
		$smarty->assign("rs",$db->getRow("SELECT adminid,adminname,zuid FROM ".table('admin')." WHERE adminid='$adminid'"));
		$smarty->display("admin_chpwd.html");
	}
}elseif($a=='zu')
{
	if($_GET['op']=='add')
	{	
		require_once("permission.php");
		$str="";
		$id=intval($_GET['id']);
		if($id)
		{
			$zu=$db->getRow("SELECT * FROM ".table('admin_zu')." WHERE id='$id' ");
			$zups=unserialize($zu['content']);
			$smarty->assign("zu",$zu);
		}
		foreach($permission as $key=>$val)
		{
			$tmparr=array();
			$chk="";
			$str.="<tr>";
			$str.="<td align='right'>".$val[0][0]."：</td>";
			$str.="<td>";
			if($zups[$key])
			{
				
				foreach($zups[$key] as $t)
				{
					$tmparr[]=serialize($t);
				}
			}
		
			foreach($val as $v)
			{
				$chk="";
				if($tmparr)
				{
					
					if(in_array(serialize($v[1]),$tmparr))
					{
						$chk=" checked='checked' ";
					}
				}
				$str.= " <input type='checkbox' name='ps[".$key."][]' class='percheck' value='".serialize($v[1])."' ".$chk." > ".$v[0]; 
			}
			$str.="</td>";
			$str.= "</tr>";
		}
		$smarty->assign("str",$str);
		$smarty->display("admin_zu_add.html");
	}elseif($_GET['op']=='add_db')
	{
		$id=intval($_POST['id']);
		
		$p=array();
		$title=htmlspecialchars($_POST['title']);
		if(empty($title))
		{
			errback('组名不能为空');
		}
		$ps=$_POST['ps'];
		
		if($ps)
		{
			foreach($ps as $key=>$arr)
			{				
				foreach($arr as $k=>$v)
				{
					
					$p[$key][]=unserialize(stripslashes($v));
				}
				
			}
		}
		if($id)
		{
			$db->query("UPDATE ".table('admin_zu')." SET title='$title',content='".serialize($p)."' WHERE id='$id' ");
		}else
		{
			$db->query("INSERT INTO ".table('admin_zu')." SET title='$title',content='".serialize($p)."',siteid='$siteid' ");
		}
		gourl();
	}elseif($_GET['op']=='del')
	{
		$id=intval($_GET['id']);
		$db->query("DELETE FROM ".table('admin_zu')." WHERE id='$id' ");
		gourl();
	}else
	{
	
		$zulist=$db->getAll("SELECT * FROM ".table('admin_zu')." WHERE siteid='$siteid' ");
		$smarty->assign("zulist",$zulist);
		$smarty->display("admin_zu.html");
	}
}
?>

