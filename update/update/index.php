<?php
define("CT",1);
/*ȡ�ø�Ŀ¼����·��*/
error_reporting(0);


if(!file_exists("config/install.lock"))
{
	header("Location: install/");
}

date_default_timezone_set('PRC');  //����Ĭ��ʱ��
define('ROOT_PATH',  str_replace('\\', '/', dirname(__FILE__))."/");
//���������ļ�
require_once(ROOT_PATH."config/config.inc.php");//���ݿ�����
@ini_set("session.cookie_domain", DOMAIN);
require_once(ROOT_PATH."config/lib_config.php");//��������
/*���빫�����ļ�*/
require_once(ROOT_PATH."includes/lib_base.php");
require_once(ROOT_PATH."includes/lib_safe.php");
require_once(ROOT_PATH."includes/cls_db.php");//�������ݿ��ļ�
$db=new Db_class(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB,MYSQL_CHARSET);
require_once(ROOT_PATH."includes/cls_model.php");
/*�������ݿ�洢session
require_once(ROOT_PATH."includes/cls_session.php");
$session=new session($db,3600);
*/
session_start();
//����ģ��
require_once(ROOT_PATH."includes/cls_smarty.php");//����ģ���ļ�
$smarty=new Smarty();
$smarty->caching=true;
$smarty->cache_lifetime = 3600;
$smarty->rewrite_on=REWRITE_ON;
$smarty->charset="gb2312";
if($_COOKIE['ck_ss_id']=='')
{
	$ss_id=time().session_id();
	setcookie("ck_ss_id",$ss_id,time()+360000,'/',DOMAIN);	
}
$ss_id=$_COOKIE['ck_ss_id'];
//�����ݵĹ����ļ�
require_once(ROOT_PATH."source/function/function_common.php");

/*Ĭ�ϳ���վ������*/
if($_GET['setsite']=='yes')
{
	setcookie("cksiteid",intval($_GET['siteid']),time()+36000,'/',DOMAIN);
	
	$domain=$db->getOne("SELECT domain FROM ".table('sites')." WHERE siteid=".intval($_GET['siteid'])."  ");
	if($domain && !$_GET['iswap'])
	{
		gourl(str_replace($_SERVER['HTTP_HOST'],$domain,$_SERVER['HTTP_REFERER']));
	}else
	{
		gourl(); 
	}
}

if($siteid=$db->getOne("SELECT siteid FROM ".table('sites')." WHERE domain='".$_SERVER['HTTP_HOST']."' "))
{
	setcookie("cksiteid",intval($siteid),time()+36000,'/',DOMAIN);
	$cksiteid=$siteid;
}else{
	if(!$_COOKIE['cksiteid'])
	{
		$cksiteid=1;
	}else
	{
		$cksiteid=$_COOKIE['cksiteid'];
	}
}


$smarty->assign("site",$db->getRow("SELECT siteid,sitename,lat,lng,domain FROM ".table('sites')." WHERE siteid='$cksiteid' "));
$smarty->assign("sitelist",sitelist());
$web=web();//������վ
$nav=nav();//���õ���
friendlink();//������������ 
/*Ĭ�ϳ���*/

if($_GET['skins'] )
{
	$_SESSION['skins']=$_GET['skins'];
}
if($_SESSION['skins'])
{
	$skins=$_SESSION['skins'];
}else
{
	$skins=SKINS;
}
if(empty($skins))
{
	$skins="default";
}



if( $_SERVER['SERVER_NAME']==WAPURL   or $skins=="wap" or $skins=="phone" or is_mobile() )
{
	if(!defined("ISWAP"))
	{
 		define("ISWAP",true);
	}
	$skins="wap";
}else
{
	define("ISWAP",false);
}
 

$smarty->cache_dir      = ROOT_PATH . 'temp/caches';
$smarty->compile_dir    = ROOT_PATH . 'temp/compiled';

$smarty->template_dir   = ROOT_PATH . "themes/{$skins}";
require_once("rewriterule.php");
$smarty->rewriterule=$rewriterule;
$smarty->assign("skins","themes/{$skins}/");
$smarty->assign("ssuser",$_SESSION['ssuser']);


if($web['weboff']==1)
{
	echo '<table align="center" width="500px" height="300px;" style=" padding:20px;margin:0 auto; background-color:#E2CD67; margin-top:100px;"><tr><td>'.$web['offwhy'].'</td></tr></table></div>';	
	exit();
}



$m=isset($_GET['m'])?htmlspecialchars($_GET['m']):"index";
$m=str_replace(array("/","\\"),"",$m);

if(!file_exists("source/index/ctrl/$m.php"))
{
	$m="index";
}
//�Զ���¼
auto_login();
//session�ر�д����
$m=get_post('m');
$m=$m?$m:"index";
if(!in_array($_GET['m'],array('user','sinalogin','qqlogin','near','setgps')))
{
	//session_write_close();
}
$a=get_post('a');
$a=$a?$a:"index";
//seo��Ϣ
$smarty->assign("seo",$seo=$db->getRow("SELECT title,keywords,description FROM ".table('seo')." WHERE siteid='$cksiteid' AND m='$m' AND a='$a'  "));
require_once("source/index/ctrl/$m.php");
if(function_exists("on{$a}")){
	 
	$fun="on{$a}";
	
	$fun();
}

function check_login()
{
	if(!$_SESSION['ssuser']['userid'])
	{
		errback('���ȵ�¼','index.php?m=user&a=login');
	}
}
function auto_login(){
	if(empty($_SESSION['ssuser']) && $_COOKIE['loginaccess']){
		$access=unserialize(stripslashes($_COOKIE['loginaccess']));
		
		$user=$GLOBALS['db']->getRow("SELECT userid,nickname,password,username FROM ".table('user')." WHERE userid='{$access[0]}' ");
		
		if($user['password']==$access[1])
		{			
			unset($user['password']);
			setcookie('loginaccess',serialize($access),time()+48*3600,"/",DOMAIN);
			$_SESSION['ssuser']=$user;
			header("Location: index.php");
		}
	}
	
}
?>