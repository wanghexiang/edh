<?php
if(!defined("CT"))
{
	die("IS WRONG");
}
loadModel('user');
$_GET['a']=htmlspecialchars($_GET['a']);
if(in_array($_GET['a'],array('edi','edi_db','chpwd','chpwd_db','home','spread','myaddress','logo')))
{
	check_login();
}

/*�ж��Ƿ��UC*/
if(BINDUC)
{

	include ROOT_PATH.'api/ucconfig/ucenter.config.php';
	include  ROOT_PATH.'uc_client/client.php';
	include ROOT_PATH."source/function/function_user.php"; 
}
switch($_GET['a'])
{
	case 'reg':
		
		if($_SESSION['ssuser']['userid'])
		{                               
			gourl("index.php");
		}
		
		$smarty->assign("fuserid",intval($_GET['fuserid']));
		$smarty->display("user_reg.html");	
	break;
	
	case 'regdb':
	   // print_r($_SESSION);exit();
		if(isset($_POST['yzm']))
		{
			$yzm=strtoupper(trim($_POST['yzm']));
			if($yzm!=$_SESSION['code']) errback('��֤�����');
		}
		
		$username=strip_tags($_POST['username']);
	
		$pwd1=strip_tags($_POST['pwd1']);
		
		$pwd2=strip_tags($_POST['pwd2']);
	
		$email=strip_tags($_POST['email']);
		$address=strip_tags($_POST['address']);
		$phone=strip_tags($_POST['phone']);
		$qq=intval(strip_tags($_POST['qq']));
		$fuserid=intval($_POST['fuserid']);
        $truename=$_POST['truename'];
		
		if(BINDUC)
		{
			regUC($username,$pwd1,$email); 
		/*UCע��*/
		}else
		{
			/*��ͨע��*/
			
			$sql="insert into ".table('user')." SET truename='$truename',username='$username',password='".umd5($pwd1)."',nickname='$username',email='$email',fuserid='$fuserid',phone='$phone'   ";
			$db->query($sql);
			$_SESSION['ssuser']=$db->getRow("select * from ".table('user')." where username='$username' ");
			setcookie('loginaccess',serialize(array($_SESSION['ssuser']['userid'],umd5($pwd1))),time()+48*3600,"/",DOMAIN);
			errback("ע��ɹ�","index.php");
		}
	break;

	case 'login':
		//setcookie("loginaccess","",time()-3600);
		if($_SESSION['ssuser']['userid'])
		{
			gourl("index.php");
		}
		$smarty->display("user_login.html");	
	break;

	case 'logindb':
		if(isset($_POST['yzm']))
		{
			$yzm=strtoupper(trim($_POST['yzm']));
			if($yzm!=$_SESSION['code']) errback('��֤�����');
		}
		$username=trim($_POST['username']);
		ckempty($username,"<fond style='color:red'>�û�������Ϊ��</font>");
		$password=trim($_POST['password']);
		ckempty($password,'���벻��Ϊ�գ�');
		$referer=$_POST['referer'];
		if($referer)
		{
			$url=$referer;
		}else
		{
			$url='index.php';
		}
	
		if(BINDUC)
		{			
			loginUC($username,$password);		
		/*UC��½*/
		}else
		{
			/*��ͨ��½*/
			
			$ct=$db->getOne("select userid from ".table('user')." where username='$username' and password='".umd5($password)."' and status>-1 ");
			if(!$ct)
			{
				errback('�û��������������');
			}else
			{
				$_SESSION['ssuser']=$db->getRow("select * from ".table('user')." where username='$username' ");
				if($_POST['autologin']){
					
					setcookie('loginaccess',serialize(array($_SESSION['ssuser']['userid'],umd5($password))),time()+48*3600,"/",DOMAIN);
					
				}
			}
			
			errback("��½�ɹ�",$url);
		}
	break;
	case 'edi':
		$userid=intval($_SESSION['ssuser']['userid']); 
		$rs=$db->getRow("select * from ".table('user')." where userid='$userid' ");
		$smarty->assign("user",$rs);
		$smarty->display("user_edi.html");
	break;
	case 'edi_db':
		$userid=intval($_SESSION['ssuser']['userid']);
		if($_POST['yzm'])
		{
		$yzm=trim($_POST['yzm']);
		if($yzm!=$_SESSION['code']) errback('��֤�����');
		}

		
		$address=strip_tags($_POST['address']);
		
		$qq=intval($_POST['qq']);
		
		$info=htmlspecialchars(trim($_POST['info']));
		$nickname=strip_tags($_POST['nickname']);
		$phone=strip_tags($_POST['phone']);
		$user=$db->getRow("SELECT phone,nickname FROM ".table('user')." WHERE userid='$userid' ");	
		if($user['nickname']!=$nickname)
		{
			if($db->getOne("SELECT userid FROM ".table('user')." WHERE nickname='$nickname' "))
			{
				errback("�ǳ��ѱ�ʹ��");
			}
		}
		if($user['phone']!=$phone)
		{
			if($db->getOne("SELECT userid FROM ".table('user')." WHERE phone='$phone'"))
			{
				errback("�ֻ��Ѿ�����ʹ��");
			}
		}
		$db->query("update ".table('user')." set address='$address',phone='$phone',qq='$qq',nickname='$nickname',info='$info' where userid='$userid' ");

		errback('��Ϣ�༭�ɹ�');
	break;
	case 'chpwd':
		$userid=intval($_SESSION['ssuser']['userid']); 
		$rs=$db->getRow("select * from ".table('user')." where userid='$userid' ");
		$smarty->assign("user",$rs);
		$smarty->display("user_chpwd.html");
	break;
	
	case 'chpwd_db':
		$userid=intval($_SESSION['ssuser']['userid']);
		$pwd1=trim($_POST['pwd1']);
		
		$pwd2=trim($_POST['pwd2']);
		if($pwd1!=$pwd2)
		{
			errback('�����������벻һ��');
		}
		if($pwd1)
		{
			$db->query("update ".table('user')." set password='".umd5($pwd1)."' where userid='$userid' ");
		}
		$email=trim($_POST['email']);
		if(!$db->getOne("SELECT email FROM ".table('user')." WHERE userid='$userid' "))
		{
			$db->query("UPDATE ".table('user')." SET email='$email' WHERE userid='$userid' ");
		}
		errback("�û���Ϣ�޸ĳɹ�");
	break;
	
	case 'logout':
		if(BINDUC){
			logoutUC();
		}
		$_SESSION['ssuser']=array();
		setcookie('loginaccess','a',time()-360,"/",DOMAIN);
		gourl('index.php');
	break;
	
	case 'findpwd':
		$smarty->display("user_findpwd.html");
	break;	
	case 'findpwd_db':
		$username=trim($_POST['username']);
		ckempty($username,'�û�������Ϊ�գ�');
		$email=trim($_POST['email']);
		if(!is_email($_POST['email'])) errback('�����ʽ����');
		$ct=$db->getOne("select userid from ".table('user')." where username='$username' and email='$email' LIMIT 1 ");
		if($ct==0) errback("���ע�����䲻���������");
		
		$title="{$username}�һ����룡�ʼ�";
		$pwd=rand(100000,999999);
		$db->query("update ".table('user')." set password='".umd5($pwd)."' where username='$username' ");
		$content="{$username}���ã�<br>����������Ϊ��{$pwd}���뾡���½�޸ģ�������վ".$web['webname']."��ַ��".$web['weburl'];
		
		if(send_mail($smptArr,$email,$title,$content))
		{
			errback('�������Ѿ����͵��������䣬�뾡���½�޸ģ�','index.php');
		}else
		{
			errback("�����������������ϵ����Ա");
		}
	break;
	
	case 'logo':
	
		if($_GET['op']=='post')
			{
				
				
				if($_FILES['userlogo'])
				{
					$fs=getimagesize($_FILES['userlogo']['tmp_name']);
					if($fs[0]<5 || $fs[1]<5)
					{
						if($_GET['ajax'])
						{
							echo json_encode(array("err"=>"�ļ����Ͳ���"));
						}else
						{
						 	errback('ͼƬ���Ͳ���ȷ');
						}
					}
					
					require_once("includes/cls_upload.php");
					
					$upload=new upload();
					$upload->uploaddir='upfile/images/';
					$upload->userdir='upfile/images/';
					$data=$upload->uploadfile('userlogo');
					
					 
					$pic=$data['filename'];
					
					require_once(ROOT_PATH."includes/cls_image.php");
					$clsimg = new image();
					$img=dirname($pic)."/middle_".basename($pic);
					
					$clsimg->makethumb($img,$pic,400,400);
					
					@unlink($pic);
					if($_GET['ajax'])
					{
						echo  json_encode(array("img"=>$img)); exit();
					}else
					{
						$db->query("UPDATE ".table('user')." SET logo='$img' WHERE userid='$userid' ");
					}
					
				}else
				{
					
					$targ_w = $targ_h = 180;
					$jpeg_quality = 90;
				
					$pic=$src = stripslashes($_POST['pic']);
					if($pic)
					{
						require_once(ROOT_PATH."includes/cls_image.php");
						$clsimg = new image();
						$im=getimagesize($src);
						
						switch($im['mime'])
						{
							case 'image/gif':
							$img_r = imagecreatefromgif($src);
							break;
							case "image/jpeg":
							$img_r = imagecreatefromjpeg($src);
							break;
							case 'image/png':
							$img_r = imagecreatefrompng($src);
							break;
							default:
							$img_r = imagecreatefromgd($src);
						}
						$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
					
						imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
						$targ_w,$targ_h,$_POST['w'],$_POST['h']);
					
						
						//ѡ��Сͼ
						$userid=intval($_SESSION['ssuser']['userid']);
						$udir=getuserlogo($userid,1);;
						umkdir($udir);
						$logo=$udir."/$userid.jpg";
						$middle_logo=$logo.".middle.jpg";
						$min_logo=$logo.".min.jpg";
						imagejpeg($dst_r,$logo,$jpeg_quality);			
						
						$clsimg->makethumb($middle_logo,$logo,50,50);
						$clsimg->makethumb($min_logo,$logo,30,30);
						$db->query("UPDATE ".table('user')." SET logo='$logo' WHERE userid='{$_SESSION['ssuser']['userid']}' ");
						
					}
				}
				
				gourl('index.php?m=user&a=logo');
			}else
			{
				$smarty->assign("userlogo",$userlogo=$db->getOne("SELECT logo FROM ".table('user')." WHERE userid='{$_SESSION['ssuser']['userid']}' "));
				$smarty->assign("time",time());
				$smarty->display("user_logo.html");
			}
			 
		break;	
	case 'home':
		if(!$_SESSION['ssuser'])
		{
			gourl("index.php");
		}
		$userid=intval($_SESSION['ssuser']['userid']);
		$sql="select * from ".table('user')." where userid='$userid' ";
		$rs=$db->getRow($sql);//��ȡ�û���Ϣ
		//��ȡ�ۿ���Ϣ
		$discount=intval($db->getOne("select discount from ".table('user_rank')." where min_grade<'{$rs['grade']}' and max_grade>'{$rs['grade']}' "));
		$smarty->assign("discount",$discount);
		//��ȡ���ý��
		$smarty->assign("bonus",$db->getOne("select bonus from ".table('user_bonus')." where userid='$userid' "));
		//��ȡ�ƹ��û���
		$smarty->assign("spread",$db->getOne("select count(*) from ".table('user')." where fuserid='$userid' "));
		//������ѽ��
		$smarty->assign("ordermoney",$db->getOne("select sum(money) from ".table('order')." where userid='$userid' "));
		//�������ѽ��
		$smarty->assign("friendmoney",$friendmoney=$db->getOne("select sum(money) from ".table('order')." where sendtype=3 AND userid in(select userid from ".table('user')." where fuserid='$userid') "));
		//���Ѵ����Ľ���
		$smarty->assign("friendbonus",$friendmoney*SPREAD_DISCOUNT);
		$smarty->assign("user",$rs);
		$smarty->display("user_home.html");
	break;
	
	case 'spread':
		if(!$_SESSION['ssuser'])
		{
			gourl("index.php");
		}
		$userid=intval($_SESSION['ssuser']['userid']);
		//��ȡ�ƹ��û���
		$smarty->assign("spread",$db->getOne("select count(*) from ".table('user')." where fuserid='$userid' "));	
		$smarty->assign("friendmoney",$friendmoney=$db->getOne("select sum(money) from ".table('order')." where sendtype=3 AND userid in(select userid from ".table('user')." where fuserid='$userid') "));
		//���Ѵ����Ľ���
		$smarty->assign("friendbonus",$friendmoney*SPREAD_DISCOUNT);
		assignlist("user",10," AND fuserid='$userid' ",'','index.php?m=user&a=spread');
		$smarty->display("user_spread.html");
	break;
	
	case 'myaddress':
		header("Content-type:text/html;charset=gb2312");
		$userid=intval($_SESSION['ssuser']['userid']); 
		switch($_GET['op'])
		{
			
			case 'post':
			
				$id=intval($_POST['id']);
				$address=htmlspecialchars(trim($_POST['address']));
				if($_GET['ajax'])
				{
					$address=iconv("utf-8","gbk",$address);
				}
				if($id)
				{
					$db->query("UPDATE ".table('user_address')." SET userid='$userid',address='$address' WHERE id='$id' ");
				}else
				{
					$db->query("INSERT INTO ".table('user_address')." SET userid='$userid',address='$address' ");
				}
				gourl();
				break;
			case 'del':
					$id=intval($_GET['id']);
					$db->query("DELETE FROM ".table('user_address')." WHERE id='$id' AND userid='$userid' ");
				gourl();
				break;
			default:
				$addresslist=$db->getAll("SELECT id,address FROM ".table('user_address')." WHERE userid='$userid' ORDER BY id DESC ");
				$smarty->assign("addresslist",$addresslist);
				$smarty->display("user_address.html");
			break;
		}
	break;
	
	case 'gps':
		$userid=intval($_SESSION['ssuser']['userid']);
		if(get('op')=='post'){
			list($lat,$lng)=explode(",",$_POST['area']);
			$_SESSION['ssuser']['lat']=$lat;
			$_SESSION['ssuser']['lng']=$lng;
			$db->query("UPDATE ".table('user')." set lat='$lat',lng='$lng' WHERE userid='$userid' ");
			gourl(); 
		}else{
			$u=$db->getRow("SELECT lat,lng FROM ".table('user')." WHERE userid='$userid' ");
			$smarty->assign("rs",$u);
			$smarty->display("user_gps.html");
		}
	break;
    case 'checkusername':
        $username=$_GET['username'];
        $user= $db->getOne("select count(*) from ".table('user')." where username='$username' ");
        if($user>=1){
            
            echo 1;  
        }
        else{
            
            echo 2;
        }
        break;
    case 'checkemail':
        $email=$_GET['email'];
        $e= $db->getOne("select count(*) from ".table('user')." where email='$email' ");
        if($e>=1){
            
            echo 1;  
        }
        else{ 
            
            echo 2;
        }
        break;    
}
?>