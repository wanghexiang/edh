<?php

check_login();

$a=trim($_REQUEST['a']);
if(empty($a))
{
	$a="skinsedi";
}
checkpermission("skins",$a);
if($_GET['skinsdir'])
{
	$_SESSION['ss_skinsdir']=trim($_GET['skinsdir']);
}elseif($_SESSION['ss_skinsdir']=='')
{
	$_SESSION['ss_skinsdir']=$skins;
}


$skins=$_SESSION['ss_skinsdir'];	


$dir=ROOT_PATH."themes/".$skins;
if($a=="skinsedi")
{
	
	
	if(trim($_GET['skinsfile']))
	{
		$f=$dir."/".trim($_GET['skinsfile']);
	
		$content=file_get_contents($f);
		$content=str_replace("textarea","html:textarea",$content);
		$smarty->assign("content",$content);
		$smarty->assign("skinsfile",$_GET['skinsfile']);
			
		
	}
	//获取所有的文件
	
	$smarty->assign("filelist",str_replace($dir."/","",getfile($dir)));
	$smarty->display("skins_edi.html");
}elseif($a=="edifile")
{
	$content=trim($_POST['content']);
	$file=trim($_POST['file']);
	$f=$dir."/".$file;

	file_put_contents($f,str_replace("html:textarea","textarea",stripslashes($content)));
	header("Location: ".$_SERVER['HTTP_REFERER']);
}

function getfile($dir)
{
	$dh=opendir($dir);
	static $arr=array();
	while(($f=readdir($dh))!=false)
	{
		if($f!="." and $f!="..")
		{
			$ff=$dir."/".$f;
			if(is_dir($ff))
			{
				getfile($ff);
			}else
			{
				
				if(in_array(getfiletype($ff),array("html","htm","css","js","lbi")))
				{	
				$arr[]=$ff;
				}
			}
		}
	}
	
	return $arr;
}

function getfiletype($file)
{
	return substr(strrchr($file,"."),1);
}
?>