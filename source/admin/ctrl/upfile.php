<?php
if(!$_SESSION['ssadmin'])
{
exit();	
}
header("Content-type:text/html;charset=gb2312");
require(ROOT_PATH."includes/cls_upload.php");
$up= new upload();
if($_GET['xh'])
{
	$up->uploaddir='upfile/images/';
	$up->userdir='upfile/images/';
	$data=$up->uploadfile('filedata');
	echo "{'err':'".($data['err']?jsonString($data['err']):'')."','msg':'".jsonString($data['filename'])."'}";
}else
{
	$up->uploaddir='upfile/images/';
	$up->userdir='upfile/images/';
	$data=$up->uploadfile('upfile');
	if($data['err'])
	{
		echo "<script>alert(".$data['err'].");history.go(-1);</script>";
	}else
	{
		echo "<script>window.opener.document.".$_POST['formname'].".".$_POST['editname'].".value='".$data['filename']."'</script>";
		echo "<script>alert('上传成功');window.close();</script>";
	}
}





?>