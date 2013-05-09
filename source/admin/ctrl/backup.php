<?php
header("Content-type: text/html; charset=gbk");

require("bak.php");
check_login();

@set_time_limit(0);
$a = isset($_GET["a"]) ? $_GET["a"] : 'index';
checkpermission("backup",$a);
if($a=="index")
{
	$backlist=array();
	$dir="backup";
	$dh=opendir($dir);
	while(false!==($file=readdir($dh)))
	{
		if($file!="." && $file!=".." && $file!='csv')
		{
			if(is_dir($dir."/".$file))
			{
			$backlist[]=$file;
			}
		}
	}
	$smarty->assign("backlist",$backlist);
	$smarty->display("backup.html");
}


$link=mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PWD);
mysql_query("SET NAMES GBK ");
mysql_select_db(MYSQL_DB,$link);

if(in_array($a,array('restoretable','restoredb')))
{
	if($_GET['backdir'])
	{
		$_SESSION['ssbackdir']="backup/".$_GET['backdir'];
	}
	$backdir=$_SESSION['ssbackdir'];

}else
{
	if($_SESSION['ssbackdir'])
	{
		$backdir=$_SESSION['ssbackdir'];
	}
}


define("BACKDIR",$backdir);//备份的文件夹
define("DB",MYSQL_DB);//数据库

if($a=='backtable')
{
	$backdir="backup/".date("YmdHis");
	if(!file_exists($backdir))
	{
		mkdir($backdir,0777);
	}
	$_SESSION['ssbackdir']=$backdir;
	backtable();
	echo "<script>location.href='admin.php?m=backup&a=backdata';</script>";
	exit();
}elseif($a=='backdata')
{
	
	$tables=getTables();
	$tkey=intval($_GET['tkey']);
	if($tkey==count($tables)-1)
	{
		echo "<a href='javascript:;' onclick='window.close()'>备份完毕</a>";
		exit();
	}
	$table=$tables[$tkey];
	
	$rscount=getrscount($table);
	$limit=1000;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$limit;
	
	if($start<$rscount)
	{
		
		backdata($table,$start,$limit);
		$page++;
		echo "<script>location.href='admin.php?m=backup&a=backdata&tkey=$tkey&page=$page';</script>";
		exit();
		
	}
	$tkey++;
	echo "<script>location.href='admin.php?m=backup&a=backdata&tkey=$tkey';</script>";
	exit();
}elseif($a=='restoretable')
{
	restoreTable();
	echo "<script>location.href='admin.php?m=backup&a=restoredb';</script>";
	exit();
}elseif($a=='restoredb')
{
	$files=getfiles();
	$fkey=intval($_GET['fkey']);
	if($fkey==count($files)-1)
	{
		echo "<a href='javascript:;' onclick='window.close()'>数据恢复完毕</a>";
		exit();
	}

	$file=$files[$fkey];
	restoredb($file);
	$fkey++;
	echo "<script>location.href='admin.php?m=backup&a=restoredb&fkey=$fkey';</script>";
	exit();
}
?>




