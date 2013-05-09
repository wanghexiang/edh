<?php
//$data 二维数组 先将导出的,替换为，
function arr2csv($file,$data)
{
	$data=str_replace(",","，",$data);//先将,替换为，防止导入出错
	$fp=fopen($file,'w');	
	foreach($data as $line)
	{
		if(is_array($line))
		{
			fputcsv($fp,$line);
		}
	}
	fclose($fp);
	
}

//获取csv内容为数组
//内容中不能包含','否则会出错
function csv2arr($file)
{
	$earr=array();
	$arr=file($file);
	foreach($arr as $t)
	{
		$earr[]=explode(",",$t);
	}
	return $earr;
	
}

?>