<?php
function regUC($username,$password,$email)
{
	global $db;
				
	/*UC注册*/
	//在UCenter注册用户信息
	$username=iconv("gbk","utf-8",$username);
	$password=iconv("gbk","utf-8",$password);
	$u=uc_get_user($username);
	if($u[0]){
		
		errback("该用户已存在，请直接登陆！");exit;
	}
	
	$userid = uc_user_register($username, $password, iconv("gbk","utf-8",$email));
	if($userid <= 0) {
		if($userid == -1) {
			errback( '用户名不合法');
		} elseif($userid == -2) {
			errback( '包含要允许注册的词语');
		} elseif($userid == -3) {
			errback( '用户名已经存在');
		} elseif($userid == -4) {
			errback( 'Email 格式有误');
		} elseif($userid == -5) {
			errback( 'Email 不允许注册');
		} elseif($userid == -6) {
			errback( '该 Email 已经被注册' );
		} else {
			errback( '未定义' );
		}
	} 
	$db->query("SET NAMES gbk");
	//生成同步登录的代码
	 
	$username=iconv("utf-8","gbk",$username);
	if($username) {
		//防止用户名重复
		  $tempuser=$username;
		  $i=0;
		  while($db->getOne("SELECT userid FROM ".table('user')." WHERE username='$tempuser' " ))
		  {
			  $i++;
			  $tempuser=$username.$i;
		  }
		$db->query("INSERT INTO ".table('user')." SET username='$tempuser',nickname='$tempuser',password='".umd5($password)."',email='$email',userid='$userid'  ");
		errback('注册成功','index.php?m=user&a=login');
	}
}

function loginUC($username, $password)
{
	global $db;
	$username=iconv("gbk","utf-8",$username);
	$password=iconv("gbk","utf-8",$password);
	$u= uc_user_login($username, $password);
	$u=iconvstr("utf-8","gbk",$u);
	list($userid, $username, $password, $email) = $u;
	$db->query("SET NAMES gbk");
	 
	setcookie('KOUFU_auth', '', -86400);
	
	if($userid > 0) {
		
		if(!$db->getOne("SELECT userid FROM ".table('user')." WHERE userid='$userid'")) {
			//判断用户是否存在于用户表，不存在则注册
			//防止用户名重复
			$tempuser=$username;
			$i=0;
			
			while($db->getOne("SELECT userid FROM ".table('user')." WHERE username='$tempuser' " ))
			{
				$i++;
				$tempuser=$username.$i;
			}
			$db->query("INSERT INTO ".table('user')." SET username='$tempuser',nickname='$tempuser',password='".umd5($password)."',email='$email',userid='$userid'  ");
		}
		//用户登陆成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
		setcookie('KOUFU_auth', uc_authcode($userid."\t".$username, 'ENCODE'));
		//生成同步登录的代码
		 
		 
		$_SESSION['ssuser']=$db->getRow("SELECT * FROM ".table('user')." WHERE userid='$userid' ");
		 
		errback("登陆成功".uc_user_synlogin($userid),$url);
	} elseif($userid == -1) {
		
		errback('用户不存在,或者被删除');
	} elseif($userid == -2) {
		errback( '密码错');
	} else {
		errback( '未定义');
	}
}

function logoutUC(){
	$_SESSION['ssuser']="";
	errback("正在退出登陆，请稍后...".uc_user_synlogout(),"index.php");
	exit;
	
}



?>