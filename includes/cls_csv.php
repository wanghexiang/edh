<?php
//$data ��ά���� �Ƚ�������,�滻Ϊ��
function arr2csv($file,$data)
{
	$data=str_replace(",","��",$data);//�Ƚ�,�滻Ϊ����ֹ�������
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

//��ȡcsv����Ϊ����
//�����в��ܰ���','��������
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