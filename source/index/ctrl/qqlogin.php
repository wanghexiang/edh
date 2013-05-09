<?php
if(!defined("CT"))
{
	die('Is wrong');
}

require_once("config/qq_config.php");
$a=$_GET['a'];
//获取登录按钮
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
	//QQ登录成功后的回调地址,主要保存access token
	qq_callback();	
	//获取用户标示id
	get_openid();	
	//echo $_SESSION['openid'];
	$arr=get_user_info();
	
	$nickname=iconv("utf-8","gbk",$arr['nickname']);
	if(empty($nickname))
	{
		errback('qq接口错误','index.php?m=index');
	}
	if($uid=$db->getOne("SELECT uid   FROM ".table('userapi')." WHERE openid='".$_SESSION['openid']."' AND xfrom='qq' "))
	{
		$_SESSION['ssuser']=$db->getRow("SELECT * FROM ".table('user')." WHERE userid='$uid' ");
		errback('登陆成功','index.php');
	}else
	{
		//生成账户
		$i=0;
		$u=$nickname;
		while($db->getOne("SELECT userid FROM ".table('user')." WHERE username='$u' OR nickname='$u' "))
		{
			$i++;
			$u=$nickname.$i;
		}
		//生产账户
		$db->query("INSERT INTO ".table('user')." SET username='$u',nickname='$u' ");
		$uid=$db->insert_id();
		//关联插件
		$db->query("INSERT INTO ".table('userapi')." SET xusername='$u',xfrom='qq',uid='$uid',bind=1,openid='".$_SESSION['openid']."' ");
		
		$_SESSION['ssuser']=$db->getRow("SELECT * FROM ".table('user')." WHERE userid='$uid' ");
		errback('注册登陆成功','index.php');
	}
}


?>