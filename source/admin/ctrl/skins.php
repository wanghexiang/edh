<?php

check_login();
$a=$_REQUEST['a'];
if(empty($a))
{
$a='index';	
}
checkpermission("skins",$a);
if($a=='index')
{
	$dir=ROOT_PATH."themes/";
	$hd=opendir($dir);
	$arr=array();
	$i=0;
	while(($f=readdir($hd))!=false)
	{
		if($f!="." and $f!=".." )
		{
			$arr[$i]['skins']=$f;
			if(file_exists($dir.$f."/"."config.php"))
			{
				require_once("{$dir}{$f}/config.php");
				$arr[$i]['skinsimg']="themes/".$f."/skins.jpg";
				$arr[$i]['skinsdir']=$f;
				$arr[$i]['skinsname']=$skinsname;
				$arr[$i]['skinsauthor']=$skinsauthor;
				$arr[$i]['skinsversion']=$skinsversion;
				if(SKINS==$f )
				{
				
				$arr[$i]['using']="<font color='red'>正在使用</a>";
				
				}else
				{
					if($f!='wap' && $f!='admin' && $f!='phone')
					{
					$arr[$i]['using']="<a href='admin.php?m=skins&a=using&skins={$f}'>使用</a>";
					}
				}
			}
		}
		$i++;
	}
	$smarty->assign("skinslist",$arr);
	$smarty->display("skins.html");	
}elseif($a=='using')
{
	$skins=$_GET['skins'];
	
	$f=file_get_contents(ROOT_PATH."config/config.inc.php");
	$f=preg_replace("/define\(\"SKINS\".*\);/iUs","define(\"SKINS\",'".$skins."');",$f);
	//$f=preg_replace("/skins=\'.*\';/iUs","skins='".$skins."';",$f);
	file_put_contents(ROOT_PATH."config/config.inc.php",$f);
	$_SESSION['skins']='';
	//清除缓存
	$f="";
	$dir=ROOT_PATH."temp/caches/";
	
	delfile(ROOT_PATH."temp/compiled/");

	delfile($dir);
	

	gourl("admin.php?m=skins");	
}
?>