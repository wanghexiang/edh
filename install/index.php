<?php
if(file_exists("../config/install.lock"))
{
	header("Location: ../");
}
require_once("init.php");
if(empty($_REQUEST['step']) || $_REQUEST['step']==1)
{
$smarty->assign("step",1);
$smarty->display("index.html");
}elseif($_REQUEST['step']==2)
{
	$mysql_host=trim($_POST['mysql_host']);
	$mysql_user=trim($_POST['mysql_user']);
	$mysql_pwd=trim($_POST['mysql_pwd']);
	$mysql_db=trim($_POST['mysql_db']);
	$tblpre=trim($_POST['tblpre']);
	$domain==trim($_POST['domain']);
	$wapurl=trim($_POST['wapurl']);
	$str="<?php \r\n";
	$str.='define("MYSQL_HOST","'.$mysql_host.'");'."\r\n";
	$str.='define("MYSQL_USER","'.$mysql_user.'");'."\r\n";
	$str.='define("MYSQL_PWD","'.$mysql_pwd.'");'."\r\n";
	$str.='define("MYSQL_DB","'.$mysql_db.'");'."\r\n";
	$str.='define("MYSQL_CHARSET","GBK");'."\r\n";
	$str.='define("TABLE_PRE","'.$tblpre.'");'."\r\n";
	$str.='define("DOMAIN","'.$domain.'");'."\r\n";
	$str.='define("WAPURL","'.$wapurl.'");'."\r\n";
	$str.='define("SKINS","default");'."\r\n";
	$str.='define("BINDUC",0);'."\r\n";
	
	$str.='?>';
	file_put_contents("../config/config.inc.php",$str);
	$smarty->assign("step",2);
	$smarty->display("index.html");
	echo "<script language=\"JavaScript\">\nfunction moveNew(){\nlocation.href=\"index.php?m=index&step=3\";\n}\nwindow.setTimeout('moveNew()','2000');\n</script>";
	
}elseif($_REQUEST['step']==3)
{
	require_once("../config/config.inc.php");
	//开始创建数据库
	if(!$link=mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PWD))
	{
		echo "<script>alert('服务器连接失败');history.go(-1);</script>";
		exit();
	}
	if(!mysql_select_db(MYSQL_DB,$link))
	{
		
		mysql_query("create database ".MYSQL_DB);
		if(!mysql_select_db(MYSQL_DB,$link))
		{
			echo "<script>alert('创建数据库失败');history.go(-1);</script>";
			exit();
		}
	}
	mysql_query("SET sql_mode=''");
	mysql_query("SET NAMES ".MYSQL_CHARSET );  
	$dbfile="hck.sql";
	$content=iconv("UTF-8","GB2312",file_get_contents($dbfile));
	//获取创建的数据
	//去掉注释
	$content=preg_replace("/--.*\n/iU","",$content);
	//替换前缀
	$content=str_replace("hck_",TABLE_PRE,$content);
	
	$carr=array();
	$iarr=array();
	//提取create
	preg_match_all("/Create table .*\(.*\).*\;/iUs",$content,$carr);
	$carr=$carr[0];
	foreach($carr as $c)
	{
		@mysql_query($c,$link);
	}
	
	//提取insert
	preg_match_all("/INSERT INTO .*\(.*\)\;/iUs",$content,$iarr);
	$iarr=$iarr[0];
	//插入数据
	foreach($iarr as $c)
	{
		@mysql_query($c,$link);
	}
	$smarty->assign("step",3);
	$smarty->display("index.html");
	echo "<script language=\"JavaScript\">\nfunction moveNew(){\nlocation.href=\"index.php?m=index&step=4\";\n}\nwindow.setTimeout('moveNew()','2000');\n</script>";

}elseif($_REQUEST['step']==4)
{
	
	$smarty->assign("step",4);
	$smarty->display("index.html");
	
}elseif($_REQUEST['step']==5)
{
	if($_POST)
	{	require_once("../config/config.inc.php");
		$link=mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PWD);
		mysql_select_db(MYSQL_DB,$link);
		mysql_query("SET NAMES ".MYSQL_CHARSET );
		 mysql_query("SET sql_mode=''");
		$adminname=trim($_POST['adminname']);
		$pwd1=trim($_POST['pwd1']);
		$pwd2=trim($_POST['pwd2']);
		if(empty($adminname))
		{
			echo "<script>alert('管理员不能为空');history.go(-1);</script>";
			exit();
		}
		if(($pwd1!=$pwd2) or empty($pwd1))
		{
			echo "<script>alert('两次输入的密码不一致');history.go(-1);</script>";
		}
		mysql_query("insert into ".TABLE_PRE."admin(adminname,password,isfounder) values('$adminname','".umd5($pwd1)."',1)");
		//添加默认站点
		mysql_query("insert into ".TABLE_PRE."sites SET sitename='默认站点' " );
		 
	}
	/*
	向服务器发送信息 统计使用站点数量
	*/
	if($_SERVER['SERVER_NAME']!='localhost' && $_SERVER['SERVER_NAME']!='127.0.0.1')
	{
		@get_headers("http://www.koufukeji.com/index.php?m=webstats&url=http://".$_SERVER['SERVER_NAME']);
	}
	file_put_contents("../config/install.lock","");
	$smarty->assign("step",5);
	$smarty->display("index.html");
}

?>