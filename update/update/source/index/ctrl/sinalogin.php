<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

require_once("config/sina_config.php");
require_once("api/sina/saetv2.ex.class.php");

$a=trim($_REQUEST['a']);
if(empty($a))
{
	$keys = array();
	$keys['code'] = $_GET['code'];
    $keys['redirect_uri'] = CALLBACK;   	
    $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
	
	$token = $o->getAccessToken('code', $keys);
	$_SESSION['token']=$token;
 	
	header("Location: index.php?m=sinalogin&a=show");
}

if($a=='geturl')
{
	//��ȡ��½url
	header("Location: https://api.weibo.com/oauth2/authorize?client_id=".WB_AKEY."&response_type=code&redirect_uri=".CALLBACK);
}
elseif($a=='apilogin')
{
	
	//�����½���� ���˶�
	//��ȡ��������
	$keys = array();
	$keys['code'] = $_GET['code'];
    $keys['redirect_uri'] = CALLBACK;   	
    $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
	 
	$token = $o->getAccessToken('code', $keys);
	$_SESSION['token']=$token;
 	
	header("Location: index.php?m=sinalogin&a=show");
}elseif($a=="show")
{
	//�����û����� ��վ��
 	$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
	$xuser=$c->show_user_by_id($_SESSION['token']['uid']);
	if(empty($xuser['id']))
	{
		errback('����΢����¼����','index.php?m=user&a=login');
	}
	//ת���ַ�������
	$xuser=iconvstr("utf-8","gbk",$xuser);
	$userid=$db->getOne("select uid from  ".table('userapi')." where xuserid=".$xuser['id']." and xfrom='sina' ");
	
//���ڼ�¼
	if($userid)
	{
		$_SESSION['ssuser']=$db->getRow("SELECT * FROM ".table('user')." WHERE userid=".intval($userid)."  ");
		//����token
		$db->query("UPDATE ".table('userapi')." SET accesstoken='{$_SESSION['token']['access_token']}' WHERE  xuserid=".$xuser['id']." and xfrom='sina' ");
		
	}else
	{
		//������������������		
			$db->query("insert into  ".table('userapi')." set xuserid=".$xuser['id'].",xusername='".$xuser['name']."',xfrom='sina',accesstoken='{$_SESSION['token']['access_token']}' ");
		//���û���� ����һ���˺� ��
			$tempname=$username=$xuser['name'];
			$i=1;
			$j=0;
			while($i)
			{
				
				$i=$db->getOne("select userid from ".table('user')." where username='$tempname' ");
				if($i)
				{
				$tempname=$username.$j;
				$j++;
				}
			}
			$username.=$j?$j:"";
			$db->query("insert into ".table('user')." set username='$username',nickname='".$xuser['name']."' ");	
			$userid=$db->insert_id(); 
			$db->query("update ".table('userapi')." set uid='$userid' where xuserid=".$xuser['id']." and xfrom='sina' ");
			$_SESSION['ssuser']=$db->getRow("SELECT * FROM ".table('user')." WHERE userid=".intval($userid)."  ");

	}
	errback('��½�ɹ�','index.php');
}

?>