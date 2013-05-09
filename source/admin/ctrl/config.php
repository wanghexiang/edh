<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a='index';
}
checkpermission("config",$a);

$ct=$db->getOne("select count(*) from ".table('config')." ");
if(!$ct)
{
	$db->query("insert into ".table('config')." set id=1 ");
}
$rs=$db->getRow("select * from ".table('config')." LIMIT 1 ");
if($a=='testemail')
{
	header("Content-type:text/html;charset=gb2312");
	if(send_mail($smptArr,SMTPEMAIL,'测试','测试'))
	{
		echo '成功';
	}else
	{
		echo '失败';
	}
	
	exit;
}
$smarty->assign("rs",$rs);
if($a=='phone')
{
	$smarty->display("config_phone.html");
}elseif($a=='phone_db')
{
	$phone_on=intval($_POST['phone_on']);
	$phone_user=trim($_POST['phone_user']);
	$phone_pwd=trim($_POST['phone_pwd']);
	$phone_num=trim($_POST['phone_num']);
	$db->query("update ".table('config')." set phone_on='$phone_on',phone_user='$phone_user',phone_pwd='$phone_pwd',phone_num='$phone_num' ");
	configfile();//重新生成配置文件
	gourl();
}elseif($a=='email')
{
	$smarty->display("config_email.html");	
}elseif($a=='email_db')
{
	$smtphost=trim($_POST['smtphost']);
	$smtpport=trim($_POST['smtpport']);
	$smtpemail=trim($_POST['smtpemail']);
	$smtpuser=trim($_POST['smtpuser']);
	$smtppwd=trim($_POST['smtppwd']);
	$db->query("update ".table('config')." set smtphost='$smtphost',smtpport='$smtpport',smtpemail='$smtpemail',smtpuser='$smtpuser',smtppwd='$smtppwd' ");
	configfile();//重新生成配置文件
	gourl();
	
}
elseif($a=='water')
{
	$smarty->display("config_water.html");	
}elseif($a=='water_db')
{
	$water_on=intval($_POST['water_on']);
	$water_type=intval($_POST['water_type']);
	$water_pos=intval($_POST['water_pos']);
	$water_size=intval($_POST['water_size']);
	$water_str=trim($_POST['water_str']);
	$water_img=trim($_POST['water_img']);
	$db->query("update ".table('config')." set water_on='$water_on',water_type='$water_type',water_pos='$water_pos',water_size='$water_size',water_str='$water_str',water_img='$water_img' ");
	configfile();//重新生成配置文件
	gourl();
	
}elseif($a=='rewrite')
{
	$smarty->display("config_rewrite.html");
}elseif($a=='rewrite_db')
{
	$rewrite_on=intval($_POST['rewrite_on']);
	$db->query("update ".table('config')." set rewrite_on='$rewrite_on' ");
	configfile();
	gourl();
}elseif($a=='spread')
{
	$smarty->display("config_spread.html");
	
}elseif($a=='spread_db')
{
	$spread_on=intval($_POST['spread_on']);
	$spread_discount=intval($_POST['spread_discount']);
	$grade_on=intval($_POST['grade_on']);
	$maxgrade=intval($_POST['maxgrade']);
	$db->query("update ".table('config')." set spread_on='$spread_on',spread_discount='$spread_discount',maxgrade='$maxgrade',grade_on='$grade_on' ");
	configfile();
	gourl();
}elseif($a=='opentime')
{
	if($_GET['op']=='db')
	{
		$opentime=intval($_POST['opentime']);
		$starthour=intval($_POST['starthour']);
		$startminute=intval($_POST['startminute']);
		$endhour=intval($_POST['endhour']);
		$endminute=intval($_POST['endminute']);
		$showweek=intval($_POST['showweek']);
		$minprice=floatval($_POST['minprice']);
		$db->query("update ".table('config')." set opentime='$opentime',starthour='$starthour',startminute='$startminute',endhour='$endhour',endminute='$endminute',showweek='$showweek',minprice='$minprice'");
		configfile();
		gourl();
	}else
	{
		$smarty->display("config_opentime.html");
	}
}elseif($a=='pay')
{
	if($_GET['op']=='db')
	{
		$alipay=intval($_POST['alipay']);
		$tenpay=intval($_POST['tenpay']);
		$db->query("UPDATE ".table('config')." SET alipay='$alipay',tenpay='$tenpay' ");
		configfile();
		gourl();
	}else
	{
		$smarty->display('config_pay.html');
	}
}elseif($a=='thumb')
{
	if($_GET['op']=='db')
	{
		$thumb_width=$_POST['thumb_width'];
		$thumb_height=$_POST['thumb_height'];
		$db->query("UPDATE ".table('config')." SET thumb_width='$thumb_width',thumb_height='$thumb_height' ");
		configfile();
		gourl();
	}else
	{
		$smarty->display("config_thumb.html");
	}
}

function configfile()
{
	global $db;
	$rs=$db->getRow("select * from ".table('config')." ");
	$str='<?php'."\r\n";
	foreach($rs as $key=>$val)
	{
		$str.='define("'.strtoupper($key).'",'."\"{$val}\");\r\n";
		
	}
	$str.='$smptArr=array(SMTPHOST,SMTPPORT,SMTPEMAIL,SMTPUSER,SMTPPWD);//配置邮箱服务器'."\r\n";
	$str.='?>';
	file_put_contents(ROOT_PATH."/config/lib_config.php",$str);
}
?>