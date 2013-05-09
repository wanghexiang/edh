<?php
/*取得根目录所在路径*/
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


date_default_timezone_set('PRC');  //设置默认时区
define('ROOT_PATH', str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__)));
//引入配置文件
require_once(ROOT_PATH."config/config.inc.php");//数据库配置
require_once(ROOT_PATH."config/lib_config.php");//常用配置
require_once(ROOT_PATH."includes/cls_db.php");//引入数据库文件
$db=new Db_class(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB,MYSQL_CHARSET);
//配置模板
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

require_once(ROOT_PATH."includes/cls_smarty.php");//引入模板文件
$smarty=new Smarty();
$smarty->caching=true;
$smarty->cache_lifetime = 3600;
/*载入公共库文件*/
require_once(ROOT_PATH."includes/lib_base.php");
require_once(ROOT_PATH."includes/lib_safe.php");
if($_COOKIE['ck_ss_id']=='')
{
	$ss_id=session_id();
	setcookie("ck_ss_id",$ss_id,time()+3600*240);	
}
$ss_id=$_COOKIE['ck_ss_id'];
//有数据的公共文件
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
/*对非法变量进行检测*/
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
判断用户是否登录 并且给模板赋值
*/
if($_SESSION['ssuser']['userid'])
{
	
	$smarty->assign("ssuser",$_SESSION['ssuser']);
	
}
//检测是否已经停止营业
$opentype='doing';
if(OPENTIME==1)
{
	$hs=date("H");
	
	$h=$hs{0}==0?$hs{1}:$hs;
	if($h<STARTHOUR or ($h==STARTHOUR && date("i")<STARTMINUTE))
	{
		$opentype='will';//未开时
	}elseif($h>ENDHOUR or($h==ENDHOUR && date("i")>ENDMINUTE))
	{
		$opentype='done';//一结束
	}else
	{
		$opentype='doing';
	}
	
	
	$smarty->assign("openhour",STARTHOUR.":".STARTMINUTE."-".ENDHOUR.":".ENDMINUTE);
	
	$smarty->assign("opentime",1);
}

$smarty->assign("opentype",$opentype);
//检测是否按星期几来显示菜单
if(SHOWWEEK)
{
	$smarty->assign("showweek",1);
	$smarty->assign("week",getweek());
}


//检测表单是否合法
if(!isset($_COOKIE['ck_formhash']))
{
setcookie("ck_formhash",time(),time()+3600);
}
$smarty->assign("formhash",$_COOKIE['ck_formhash']);
//载入初始化
$web=web();//获取网站信息
nav(1);//获取导航信息
//首页链接
$indexlink=friendlink(1);
//普通链接
$friendlink=friendlink();

?>