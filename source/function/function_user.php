<?php
function regUC($username,$password,$email)
{
	global $db;
				
	/*UCע��*/
	//��UCenterע���û���Ϣ
	$username=iconv("gbk","utf-8",$username);
	$password=iconv("gbk","utf-8",$password);
	$u=uc_get_user($username);
	if($u[0]){
		
		errback("���û��Ѵ��ڣ���ֱ�ӵ�½��");exit;
	}
	
	$userid = uc_user_register($username, $password, iconv("gbk","utf-8",$email));
	if($userid <= 0) {
		if($userid == -1) {
			errback( '�û������Ϸ�');
		} elseif($userid == -2) {
			errback( '����Ҫ����ע��Ĵ���');
		} elseif($userid == -3) {
			errback( '�û����Ѿ�����');
		} elseif($userid == -4) {
			errback( 'Email ��ʽ����');
		} elseif($userid == -5) {
			errback( 'Email ������ע��');
		} elseif($userid == -6) {
			errback( '�� Email �Ѿ���ע��' );
		} else {
			errback( 'δ����' );
		}
	} 
	$db->query("SET NAMES gbk");
	//����ͬ����¼�Ĵ���
	 
	$username=iconv("utf-8","gbk",$username);
	if($username) {
		//��ֹ�û����ظ�
		  $tempuser=$username;
		  $i=0;
		  while($db->getOne("SELECT userid FROM ".table('user')." WHERE username='$tempuser' " ))
		  {
			  $i++;
			  $tempuser=$username.$i;
		  }
		$db->query("INSERT INTO ".table('user')." SET username='$tempuser',nickname='$tempuser',password='".umd5($password)."',email='$email',userid='$userid'  ");
		errback('ע��ɹ�','index.php?m=user&a=login');
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
			//�ж��û��Ƿ�������û�����������ע��
			//��ֹ�û����ظ�
			$tempuser=$username;
			$i=0;
			
			while($db->getOne("SELECT userid FROM ".table('user')." WHERE username='$tempuser' " ))
			{
				$i++;
				$tempuser=$username.$i;
			}
			$db->query("INSERT INTO ".table('user')." SET username='$tempuser',nickname='$tempuser',password='".umd5($password)."',email='$email',userid='$userid'  ");
		}
		//�û���½�ɹ������� Cookie������ֱ���� uc_authcode �������û�ʹ���Լ��ĺ���
		setcookie('KOUFU_auth', uc_authcode($userid."\t".$username, 'ENCODE'));
		//����ͬ����¼�Ĵ���
		 
		 
		$_SESSION['ssuser']=$db->getRow("SELECT * FROM ".table('user')." WHERE userid='$userid' ");
		 
		errback("��½�ɹ�".uc_user_synlogin($userid),$url);
	} elseif($userid == -1) {
		
		errback('�û�������,���߱�ɾ��');
	} elseif($userid == -2) {
		errback( '�����');
	} else {
		errback( 'δ����');
	}
}

function logoutUC(){
	$_SESSION['ssuser']="";
	errback("�����˳���½�����Ժ�...".uc_user_synlogout(),"index.php");
	exit;
	
}



?>