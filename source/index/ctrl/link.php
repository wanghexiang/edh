<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

//seoѡ��
$smarty->assign("title",$web['webtitle']);
$smarty->assign("keywords",$web['webkey']);
$smarty->assign("description",$web['webdesc']);
//seoѡ�����
$smarty->display("link.html");

?>