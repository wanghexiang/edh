<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

$a=htmlspecialchars($_GET['a']);
$fun="on_{$a}";
$fun();//���ú���
function on_index()
{
	return false;
}
//����ʼ���ַ�Ƿ�Ϸ�
function on_ckemail()
{
	$email=htmlspecialchars(trim($_GET['email']));
	if(is_email($email))
	{
		echo 1;
	}else
	{
		echo  0;
	}
}
//����û����Ƿ�Ϸ�
function on_ckuser()
{
	global $db;
	$username=trim(htmlspecialchars($_GET['username']));
	$ct=$db->getOne("select count(*) from ".table('user')." where username='$username' ");
	
	if($ct)
	{
		echo 1;
		
	}else
	{
		echo 0;
	}
	
}
/*�����֤��*/

function on_ckyzm()
{
	$yzm=strtoupper(trim(htmlspecialchars($_GET['yzm'])));
	if($_SESSION['code']==$yzm)
	{
		echo 1;
	}else
	{
		echo 0;
	}
}
/*ʡ*/
function on_ajaxprovinces()
{
	global $db;
	header("content-type:text/html;charset=gb2312");
	$provinces=$db->getAll("SELECT provinceid,province FROM ".table('province')." ");
	if($provinces)
	{
		echo "<option value='0'>ѡ��һ������</option>";
		foreach($provinces as $c)
		{
			echo "<option value=".$c['provinceid'].">".$c['province']."</option>";
		}
	}else
	{
		echo "<option value='0'>����һ������</option>";
	}
	exit();
}
/*��*/
function on_ajaxcitys()
{
	global $db;
	header("content-type:text/html;charset=gb2312");
	$citys=citys(intval($_GET['provinceid']));
	if($citys)
	{
		echo "<option value='0'>ѡ���������</option>";
		foreach($citys as $c)
		{
			echo "<option value=".$c['cityid'].">".$c['city']."</option>";
		}
	}else
	{
		echo "<option value='0'>���޶�������</option>";
	}
	exit();
}

function on_ajaxtowns()
{
	global $db;
	header("content-type:text/html;charset=gb2312");
	$towns=towns(intval($_GET['cityid']));
	if($towns)
	{
		echo "<option value='0'>��ѡ��</option>";
		foreach($towns as $t)
		{
			echo "<option value='".$t['townid']."'>".$t['town']."</option>";
		}
	}else
	{
		echo "<option value='0'>������������</option>";
	}
}

function on_getmsg()
{
	global $db;
	if(!$_SESSION['ssuser']['userid']) return false;
	header("Content-type:text/html;charset=gb2312");
	$rscount=$db->getOne("SELECT count(*) FROM ".table('message')." WHERE userid=".intval($_SESSION['ssuser']['userid'])." AND status=0 ");
	if($rscount)
	{
		echo $rscount;
	}
}

?>