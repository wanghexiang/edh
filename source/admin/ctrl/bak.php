<?php
/*
���ݿⱸ�ݻ�ԭ by���ս� 2011.11.14
php���ݻ�ԭmysql���ݿ�˵��
header("Content-type:text/html;charset=gbk");
$link=mysql_connect('localhost','root','123');
mysql_query("SET NAMES GBK ");
mysql_select_db('book',$link);

$backdir="bak/".date("Ymd");
if(!file_exists($backdir))
{
	mkdir($backdir,0777);
}
define("BACKDIR",$backdir);//���ݵ��ļ���
define("DB",'book');//Ҫ���ݵ����ݿ�
*/

/*
������ ���
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

/*�г����б�����*/
function getTables()
{
	$res=mysql_query("SHOW TABLES FROM ".DB." ");
	while($rs=mysql_fetch_array($res,MYSQL_NUM))
	{
		$arr[]=$rs[0];
	}
	return $arr;
}


/*���ݱ��ʽ*/
function backTable()
{
	//���ݴ�����
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
/*��ԭ��*/
function restoreTable()
{
	$content=file_get_contents(BACKDIR."/".DB.".sql",$str);
	$arr=explode(";",$content);
	foreach($arr as $sql)
	{
		mysql_query($sql);
	}
}

/*ѡ�����������*/
function getColumns($table)
{
	$res=mysql_query('SHOW COLUMNS FROM $table ');
	while($rs=mysql_fetch_array($res,MYSQL_NUM))
	{
		$arr[$rs[0]]=$rs[0];
	}
	return $arr;
}
/*��ȡ�����������*/
function getrscount($table)
{
	
	$res=mysql_query("SELECT count(*) FROM $table");
	$rs=mysql_fetch_row($res);
	return $rs[0];
}

/*ѡ��������*/
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
/*��������*/
function backAllData()
{
	$tables=getTables();
	foreach($tables as $table)
	{
	
		backdata($table);
	}
}
/*��������*/

function insertdb()
{
	for($i=0;$i<10000;$i++)
	{
		mysql_query("INSERT INTO ".DB." SET title='dsa' ");
	}
}


/*��ԭĳ���ļ�����*/

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