<?php
error_reporting(E_ALL& ~E_NOTICE);
define("APPURL","shopadmin.php");
define("CT",1);
session_start();
date_default_timezone_set('PRC');  //设置默认时区
define('ROOT_PATH',  str_replace('\\', '/', dirname(__FILE__))."/");
//引入配置文件
require_once(ROOT_PATH."config/config.inc.php");
@ini_set("session.cookie_domain", DOMAIN);
require_once(ROOT_PATH."config/lib_config.php");

require_once(ROOT_PATH."includes/cls_db.php");//引入数据库文件
$db=new Db_class(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB,MYSQL_CHARSET);
require_once(ROOT_PATH."includes/cls_smarty.php");//引入模板文件
define("ISWAP",false);
$skins="shopadmin";
$smarty=new Smarty();
$smarty->template_dir   = ROOT_PATH . 'themes/shopadmin';
$smarty->compile_dir    = ROOT_PATH . 'temp/compiled';
$smarty->assign("skins","themes/shopadmin/");
/*载入公共库文件*/

require_once(ROOT_PATH."includes/lib_base.php");
require_once(ROOT_PATH."includes/cls_model.php");
require_once(ROOT_PATH."includes/lib_safe.php");
//有数据的公共文件
require_once(ROOT_PATH."source/function/function_base.php");
require_once(ROOT_PATH."source/function/function_address.php");



$m=isset($_GET['m'])?htmlspecialchars($_GET['m']):"index";
$m=str_replace(array("/","\\"),"",$m);
if(!file_exists("source/shopadmin/ctrl/$m.php"))
{
	$m="index";
}
$siteid=isset($_SESSION['adminshop']['siteid'])?intval($_SESSION['adminshop']['siteid']):1;
$shopid=intval($_SESSION['adminshop']['shopid']);
require_once("source/shopadmin/ctrl/$m.php");
$a=get_post('a');
$a=$a?$a:"index";
if(function_exists("on{$a}")){
	 
	$fun="on{$a}";
	
	$fun();
}

function check_login()
{
	if(empty($_SESSION['adminshop']))
	{
		echo "<script>alert('请先登录');parent.location.href='shopadmin.php';</script>";
		exit();
	}
}






?>