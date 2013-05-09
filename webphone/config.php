<?php
$arr=array(
"aboutstr"=>'挑食客-爱美食爱挑食，我们是美食达人',
"strDialogTitle"=>"挑食客",
"strDialogBody"=>"正在加载中...",
"exitstr"=>"退出",
"exitmsg"=>"是否退出以挑食客?",
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