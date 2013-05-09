<?php

check_login();
$smarty->assign("menu",7);
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a="index";
}
checkpermission("photo",$a);
if($a=='index')
{
	$pagesize=10;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$sql=" select * from ".table('photo')." order by pid desc ";
	$rscount=$db->getOne("select count(*) from ".table('photo')." ");
	$pagelist=multipage($rscount,$pagesize,$page,"admin.php?m=photo&");
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	
	$rsarr=array();
	$res=$db->query($sql);
	while($rs=$db->fetch_array($res))
	{
		$rsarr[$rs['pid']]=$rs;
	}
	$smarty->assign("photolist",$rsarr);
	$smarty->display("photo.html");
}elseif($a=="add")
{
	$pid=intval($_GET['pid']);
	$smarty->assign("rs",$db->getRow("select * from ".table('photo')." where pid='$pid' "));
	$smarty->display("photo_add.html");
}elseif($a=='post')
{
	header("Content-type:text/html;charset=gb2312");
	$pid=intval($_POST['pid']);
	$title=iconv("utf-8","gb2312",strip_tags(trim($_POST['title'])));
	$keyword=iconv("utf-8","gb2312",strip_tags(trim($_POST['keyword'])));
	$des=iconv("utf-8","gb2312",trim(strip_tags($_POST['des'])));
	$info=iconv("utf-8","gb2312",trim(strip_tags($_POST['info'])));
	$logo=iconv("utf-8","gb2312",trim($_POST['logo']));
	$dateline=strtotime(date("Y-m-d H:i:s"));
	if($pid)
	{
		$db->query("update ".table('photo')." set title='$title',logo='$logo',keyword='$keyword',des='$des',info='$info',dateline='$dateline' where pid='$pid' ");
	}else
	{
		$db->query("insert into ".table('photo')." set title='$title',logo='$logo',keyword='$keyword',des='$des',info='$info',dateline='$dateline' ");
		$pid=$db->insert_id();
	}
	//Í¼Æ¬ÉÏ´«
	$uploads_dir="upfile/photo/{$pid}";
	if(@is_dir($uploads_dir)==false)
	{
		mkdir($uploads_dir,0777);
	}
	require_once(ROOT_PATH."includes/cls_image.php");
	$img=new image();
	
	foreach ($_FILES["Filedata"]["error"] as $key => $error) {
	if ($error == UPLOAD_ERR_OK) {
		$tmp_name = $_FILES["Filedata"]["tmp_name"][$key];
		$name =$_FILES["Filedata"]["name"][$key];
		$fs=getimagesize($_FILES['Filedata']['tmp_name'][$key]);
		if($fs[0]<5 || $fs[1]<5)
		{
			continue;
		}
		$ext = substr(strrchr($name, '.'), 1);
		$name=date("YmdHis").$key.".".$ext;
		switch(strtolower($ext)) {
			case 'jpg':	
			case 'jpeg':
			case 'png':
			case 'gif':
			case 'png':
				
				move_uploaded_file($tmp_name,"$uploads_dir/{$name}");
				//ÖÆ×÷ËõÂÔÍ¼
				$img->makethumb("$uploads_dir/thumb_{$name}","$uploads_dir/{$name}",200,200);
				$upfile="upfile/photo/{$pid}/$name";
				$thumb="upfile/photo/{$pid}/thumb_{$name}";
				$db->query("insert into ".table("photo_pic")." set pid='$pid',picurl='$upfile',thumb_picurl='$thumb' ");
			break;
			default:
				exit();
			break;
			}
		}
	}
	gourl("admin.php?m=photo&");	
}elseif($a=='del')
{
	$pid=intval($_GET['pid']);
	//É¾³ýÏà²á
	$db->query("delete from ".table('photo')." where pid='$pid'");
	//É¾³ýÏà²áÍ¼Æ¬
	$db->query("delete from ".table('photo_pic')." where pid='$pid' ");
	//É¾³ýÕû¸öÄ¿Â¼
	deldir(ROOT_PATH."upfile/photo/{$pid}");
	errback("¹§Ï²£¬Ïà²áÉ¾³ýÍê±Ï","admin.php?m=photo&");
}
elseif($a=='pic')
{//ÏàÆ¬¹ÜÀí
	$pagesize=10;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$pid=intval($_GET['pid']);
	$sql="select pp.*,p.title from ".table('photo_pic')." as pp left join ".table('photo')." as p on pp.pid=p.pid   ";
	$sql2="select count(*) from ".table('photo_pic')."  ";
	$sql.=$pid?" where pp.pid='$pid' ":"";
	$sql2.=$pid?" where pid='$pid' ":"";
	$rscoount=$db->getOne($sql2);
	$sql.=" order by id desc ";
	$pagelist=multipage($rscoount,$pagesize,$page,"admin.php?m=photo&a=pic&pid={$pid}");
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",$pagelist);
	$smarty->assign("piclist",$db->getAll($sql));
	$smarty->display("photo_pic.html");
}elseif($a=='picdel')
{//É¾³ýÏàÆ¬
	$id=intval($_GET['id']);
	$rs=$db->getRow("select * from ".table("photo_pic")." where id='$id' ");
	@unlink(ROOT_PATH.$rs['picurl']);
	@unlink(ROOT_PATH.$rs['thumb_picurl']);
	$db->query("delete from ".table('photo_pic')." where id='$id' ");
	gourl();
	
	
}elseif($a=='isding')
{
	$pid=intval($_GET['pid']);
	$db->query("update ".table('photo')." set isding=1 where pid='$pid' ");
	gourl();
}elseif($a=='noisding')
{
	$pid=intval($_GET['pid']);
	$db->query("update ".table('photo')." set isding=0 where pid='$pid' ");
	gourl();
}elseif($a=='isnew')
{
	$pid=intval($_GET['pid']);
	$db->query("update ".table('photo')." set isnew=1 where pid='$pid' ");
	gourl();
	
	
}elseif($a=='noisnew')
{
	$pid=intval($_GET['pid']);
	$db->query("update ".table('photo')." set isnew=0 where pid='$pid' ");
	gourl();
}elseif($a=='ishot')
{
	$pid=intval($_GET['pid']);
	$db->query("update ".table('photo')." set ishot=1 where pid='$pid' ");
	gourl();
	
}elseif($a=='noishot')
{
	$pid=intval($_GET['pid']);
	$db->query("update ".table('photo')." set ishot=0 where pid='$pid' ");
	gourl();
	
}
?>