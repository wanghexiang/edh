<?php
/*ȡ�ø�Ŀ¼����·��*/
error_reporting(0);
if(!defined("CT"))
{
	die("IS Wrong");
}
if(!file_exists("install.lock"))
{
	header("Location: install/");
}
session_start();


date_default_timezone_set('PRC');  //����Ĭ��ʱ��
define('ROOT_PATH', str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__)));
//���������ļ�
require_once(ROOT_PATH."config/config.inc.php");//���ݿ�����
require_once(ROOT_PATH."config/lib_config.php");//��������
require_once(ROOT_PATH."includes/cls_db.php");//�������ݿ��ļ�
$db=new Db_class(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB,MYSQL_CHARSET);
//����ģ��
if($_GET['skins'])
{
	$_SESSION['skins']=$_GET['skins'];
}
if($_SESSION['skins'])
{
	$skins=$_SESSION['skins'];
}
if(empty($skins))
{
	$skins="default";
}

require_once(ROOT_PATH."includes/cls_smarty.php");//����ģ���ļ�
$smarty=new Smarty();
$smarty->caching=true;
$smarty->cache_lifetime = 3600;
/*���빫�����ļ�*/
require_once(ROOT_PATH."includes/lib_base.php");
require_once(ROOT_PATH."includes/lib_safe.php");
if($_COOKIE['ck_ss_id']=='')
{
	$ss_id=session_id();
	setcookie("ck_ss_id",$ss_id,time()+3600*240);	
}
$ss_id=$_COOKIE['ck_ss_id'];
//�����ݵĹ����ļ�
require_once(ROOT_PATH."function/function_common.php");
define("ISWAP",false);//$_SERVER['SERVER_NAME']==$web['wapurl']?true:false);

if(ISWAP)
{
	$skins="wap";
	$smarty->cache_dir      = ROOT_PATH . 'temp/wapcaches';
	$smarty->compile_dir    = ROOT_PATH . 'temp/wapcompiled';
}else
{
$smarty->cache_dir      = ROOT_PATH . 'temp/caches';
$smarty->compile_dir    = ROOT_PATH . 'temp/compiled';
}
$smarty->template_dir   = ROOT_PATH . "themes/{$skins}";

$smarty->assign("skins","themes/{$skins}");


if($web['weboff']==1)
{
	echo '<table align="center" width="500px" height="300px;" style=" padding:20px;margin:0 auto; background-color:#E2CD67; margin-top:100px;"><tr><td>'.$web['offwhy'].'</td></tr></table></div>';	
	exit();
}
/*�ԷǷ��������м��*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}

/*
�ж��û��Ƿ��¼ ���Ҹ�ģ�帳ֵ
*/
if($_SESSION['ssuser']['userid'])
{
	
	$smarty->assign("ssuser",$_SESSION['ssuser']);
	
}
//����Ƿ��Ѿ�ֹͣӪҵ
$opentype='doing';
if(OPENTIME==1)
{
	$hs=date("H");
	
	$h=$hs{0}==0?$hs{1}:$hs;
	if($h<STARTHOUR or ($h==STARTHOUR && date("i")<STARTMINUTE))
	{
		$opentype='will';//δ��ʱ
	}elseif($h>ENDHOUR or($h==ENDHOUR && date("i")>ENDMINUTE))
	{
		$opentype='done';//һ����
	}else
	{
		$opentype='doing';
	}
	
	
	$smarty->assign("openhour",STARTHOUR.":".STARTMINUTE."-".ENDHOUR.":".ENDMINUTE);
	
	$smarty->assign("opentime",1);
}

$smarty->assign("opentype",$opentype);
//����Ƿ����ڼ�����ʾ�˵�
if(SHOWWEEK)
{
	$smarty->assign("showweek",1);
	$smarty->assign("week",getweek());
}


//�����Ƿ�Ϸ�
if(!isset($_COOKIE['ck_formhash']))
{
setcookie("ck_formhash",time(),time()+3600);
}
$smarty->assign("formhash",$_COOKIE['ck_formhash']);
//�����ʼ��
$web=web();//��ȡ��վ��Ϣ
nav(1);//��ȡ������Ϣ
//��ҳ����
$indexlink=friendlink(1);
//��ͨ����
$friendlink=friendlink();

?>