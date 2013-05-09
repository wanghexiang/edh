<?php
/*
数据库备份还原 by雷日锦 2011.11.14
php备份还原mysql数据库说明
header("Content-type:text/html;charset=gbk");
$link=mysql_connect('localhost','root','123');
mysql_query("SET NAMES GBK ");
mysql_select_db('book',$link);

$backdir="bak/".date("Ymd");
if(!file_exists($backdir))
{
	mkdir($backdir,0777);
}
define("BACKDIR",$backdir);//备份的文件夹
define("DB",'book');//要备份的数据库
*/

/*
创建表 语句
*/
function getTableCreate()
{
	$tables=getTables();
	$arr=array();
	if($tables)
	{
		foreach($tables as $table)
		{
			$sql=" show Create table $table  ";
			$res= mysql_query($sql);
			$rs=mysql_fetch_row($res);
			$arr[]=$rs[1];
		}
	}
	return $arr;
}

/*列出所有表名称*/
function getTables()
{
	$res=mysql_query("SHOW TABLES FROM ".DB." ");
	while($rs=mysql_fetch_array($res,MYSQL_NUM))
	{
		$arr[]=$rs[0];
	}
	return $arr;
}


/*备份表格式*/
function backTable()
{
	//备份创建表
	$arr=getTableCreate();
	$str="";
	if($arr)
	{
		foreach($arr as $table)
		{
			$str.=$table.";\r\n";
		}
	}
	file_put_contents(BACKDIR."/".DB.".sql",$str);
}
/*还原表*/
function restoreTable()
{
	$content=file_get_contents(BACKDIR."/".DB.".sql",$str);
	$arr=explode(";",$content);
	foreach($arr as $sql)
	{
		mysql_query($sql);
	}
}

/*选出表的所有列*/
function getColumns($table)
{
	$res=mysql_query('SHOW COLUMNS FROM $table ');
	while($rs=mysql_fetch_array($res,MYSQL_NUM))
	{
		$arr[$rs[0]]=$rs[0];
	}
	return $arr;
}
/*获取表的数据总数*/
function getrscount($table)
{
	
	$res=mysql_query("SELECT count(*) FROM $table");
	$rs=mysql_fetch_row($res);
	return $rs[0];
}

/*选出表数据*/
function backdata($table,$start=0,$limit=10000)
{
	$str='';
	$res=mysql_query("SELECT * FROM $table limit $start,$limit ");
	while($rs=mysql_fetch_array($res,MYSQL_ASSOC))
	{
		$i=0;
		$num=count($rs);
		$s="REPLACE INTO $table SET";
		
		foreach($rs as $k=>$v)
		{
			$dot=($i==$num-1)?"":",";
			$s.=" $k='".addslashes($v)."'$dot";
			$i++;
		}
		$s.="[sqlend]\r\n";
		$str.=$s;
		
	}
	

	file_put_contents(BACKDIR."/data_{$table}_$start.sql",$str);
}
/*备份数据*/
function backAllData()
{
	$tables=getTables();
	foreach($tables as $table)
	{
	
		backdata($table);
	}
}
/*测试数据*/

function insertdb()
{
	for($i=0;$i<10000;$i++)
	{
		mysql_query("INSERT INTO ".DB." SET title='dsa' ");
	}
}


/*还原某个文件数据*/

function restoredb($file)
{
	$content=file_get_contents(BACKDIR."/$file");
	$arr=explode("[sqlend]",$content);
	foreach($arr as $sql)
	{
		mysql_query($sql);
	}
}

function getfiles()
{
	$dh=opendir(BACKDIR);
	$arr=array();
	while(($file=readdir($dh))!=false)
	{
		if($file!="." && $file!=".." && $file!=DB.".sql")
		{
			$arr[]=$file;
		}
	}
	return $arr;
}


?>