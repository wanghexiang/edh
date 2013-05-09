<?php

check_login();
$a=trim($_GET['a']?$_GET['a']:$_POST['a']);
if(empty($a))
{
	$a='index';	
}
checkpermission("caches",$a);
if($a=='index')
{
	$smarty->display("caches.html");	
}elseif($a=='clear')
{	
	switch($_GET['type'])
	{
		case 2:
			delfile(ROOT_PATH."temp/sqlcache/");
			break;
		case 3:
			delfile(ROOT_PATH."temp/caches/");
			break;
		
		case 'all':

			delfile(ROOT_PATH."temp/sqlcache/");
			delfile(ROOT_PATH."temp/caches/");
		
			delfile(ROOT_PATH."temp/compiled/");
			break;
		default:
		break;				
		
	}
	errback("³É¹¦É¾³ý»º´æ");
	
}

?>