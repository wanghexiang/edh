<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

//seo选项
$smarty->assign("title",$web['webtitle']);
$smarty->assign("keywords",$web['webkey']);
$smarty->assign("description",$web['webdesc']);
//seo选项结束
$smarty->display("link.html");

?>