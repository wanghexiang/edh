<?php  
error_reporting(E_ALL& ~E_NOTICE);
session_start();
define("CT",1);
date_default_timezone_set('PRC');  //����Ĭ��ʱ��
define('ROOT_PATH',  str_replace('\\', '/', dirname(__FILE__))."/");

//���������ļ�
require_once(ROOT_PATH."config/config.inc.php");
@ini_set("session.cookie_domain", DOMAIN);
require_once(ROOT_PATH."config/lib_config.php");

require_once(ROOT_PATH."includes/cls_db.php");//�������ݿ��ļ�
$db=new Db_class(MYSQL_HOST,MYSQL_USER,MYSQL_PWD,MYSQL_DB,MYSQL_CHARSET);
require_once(ROOT_PATH."includes/cls_session.php");
require_once(ROOT_PATH."includes/cls_smarty.php");//����ģ���ļ�
define("ISWAP",false);
$smarty=new Smarty();
$skins="admin";
$smarty->template_dir   = ROOT_PATH . 'themes/admin';
$smarty->compile_dir    = ROOT_PATH . 'temp/compiled';
$smarty->assign("skins","themes/admin/");
/*���빫�����ļ�*/

require_once(ROOT_PATH."includes/lib_base.php");
require_once(ROOT_PATH."includes/cls_model.php");
require_once(ROOT_PATH."includes/lib_safe.php");
//�����ݵĹ����ļ�
require_once(ROOT_PATH."source/function/function_base.php");
require_once(ROOT_PATH."source/function/function_address.php");

/*Ĭ��վ��*/
if($_GET['setsite']=='yes')
{
	if($_SESSION['ssadmin'])
	{
		$_SESSION['ssadmin']['siteid']=intval($_GET['siteid']);
		$_SESSION['ssadmin']['sitename']=$db->getOne("SELECT sitename FROM ".table('sites')." WHERE siteid=".$_SESSION['ssadmin']['siteid']." ");
	}
}
$siteid=$_SESSION['ssadmin']['siteid']?intval($_SESSION['ssadmin']['siteid']):1;
/*Ĭ��վ�����*/
$m=isset($_GET['m'])?htmlspecialchars($_GET['m']):"index";
$m=str_replace(array("/","\\"),"",$m);
if(!file_exists("source/admin/ctrl/$m.php"))
{
	$m="index";
}
$a=get_post('a');
$a=$a?$a:"index";

require_once("source/admin/ctrl/$m.php");

if(function_exists("on{$a}")){
	 
	$fun="on{$a}";
	
	$fun();
}
function check_login()
{
	if(!$_SESSION['ssadmin'])
	{
		echo "<script>alert('���ȵ�¼');parent.location.href='admin.php?m=admin&m=index&';</script>";
		exit();
	}
}

 

 
function checkpermission($m,$a)
{
	global $pers;
	if($_SESSION['ssadmin']['isfounder']) return true;
	$pers=$_SESSION['ssadmin']['pers'];
	$p=$pers[$m];
	$all=false;
	$arr=array();
	if($p)
	{
		foreach($p as $v)
		{
			if($v[0]=='all')
			{
				$all=true;
			}
			$arr=array_merge($arr,$v);
			
		}
	}
	if(!in_array($a,$arr) && !$all)
	{
			errback("�����޹���Ȩ��","admin.php?m=admin&m=main");
	}
	 
	
	
}





?>