<?php
if(!defined("CT"))
{
	die('Is wrong');
}

require_once("config/qq_config.php");
$a=$_GET['a'];
//��ȡ��¼��ť
if($a=='geturl')
{
	$_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . APPID . "&redirect_uri=" . urlencode(CALLBACK)
        . "&state=" . $_SESSION['state']
        . "&scope=".SCOPE;
	header("Location:$login_url");
	exit();
}elseif($a=='callback')
{
	require("api/qq/qqapi.php");		
	//QQ��¼�ɹ���Ļص���ַ,��Ҫ����access token
	qq_callback();	
	//��ȡ�û���ʾid
	get_openid();	
	//echo $_SESSION['openid'];
	$arr=get_user_info();
	
	$nickname=iconv("utf-8","gbk",$arr['nickname']);
	if(empty($nickname))
	{
		errback('qq�ӿڴ���','index.php?m=index');
	}
	if($uid=$db->getOne("SELECT uid   FROM ".table('userapi')." WHERE openid='".$_SESSION['openid']."' AND xfrom='qq' "))
	{
		$_SESSION['ssuser']=$db->getRow("SELECT * FROM ".table('user')." WHERE userid='$uid' ");
		errback('��½�ɹ�','index.php');
	}else
	{
		//�����˻�
		$i=0;
		$u=$nickname;
		while($db->getOne("SELECT userid FROM ".table('user')." WHERE username='$u' OR nickname='$u' "))
		{
			$i++;
			$u=$nickname.$i;
		}
		//�����˻�
		$db->query("INSERT INTO ".table('user')." SET username='$u',nickname='$u' ");
		$uid=$db->insert_id();
		//�������
		$db->query("INSERT INTO ".table('userapi')." SET xusername='$u',xfrom='qq',uid='$uid',bind=1,openid='".$_SESSION['openid']."' ");
		
		$_SESSION['ssuser']=$db->getRow("SELECT * FROM ".table('user')." WHERE userid='$uid' ");
		errback('ע���½�ɹ�','index.php');
	}
}


?>