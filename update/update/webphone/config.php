<?php
$arr=array(
"aboutstr"=>'��ʳ��-����ʳ����ʳ����������ʳ����',
"strDialogTitle"=>"��ʳ��",
"strDialogBody"=>"���ڼ�����...",
"exitstr"=>"�˳�",
"exitmsg"=>"�Ƿ��˳�����ʳ��?",
"firstload"=>0
);




$a=iconvstr("gbk","utf-8",$arr);
echo json_encode($a);
function iconvstr($from,$to,$str)
{
	if(empty($str))
	{
		return false;
	}
	if(is_array($str))
	{
		foreach($str as $key=>$val)
		{
			$str[$key]=iconvstr($from,$to,$val);
		}
		
		
	}else
	{
		$str=iconv($from,$to,$str);
	}
	
	return $str;
}
?>