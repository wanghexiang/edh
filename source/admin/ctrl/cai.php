<?php

check_login();
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a="index";	
}
checkpermission("cai",$a);
if($a=='index')
{
	$title=trim($_GET['title']);
	$week1=intval($_GET['week1']);
	$week2=intval($_GET['week2']);
	$week3=intval($_GET['week3']);
	$week4=intval($_GET['week4']);
	$week5=intval($_GET['week5']);
	$week6=intval($_GET['week6']);
	$week7=intval($_GET['week7']);
	
	$sql="select id,shopid,title,ishot,isnew,doid,visible,weiid,promote,oos,price  from ".table('cai')."   c    where siteid='$siteid' ";
			
	
	$sql2="select count(1) from ".table('cai')." where siteid='$siteid' ";
	$url="admin.php?m=cai&a=index";
	if(!empty($title))
	{
		$sql .=" and c.title like '%".$title."%' ";
		$sql2.=" and title='".$title."'";
		$url.="&title={$title}";
	}
	$_GET['isding']=isset($_GET['isding'])?intval($_GET['isding']):-1;
	
	if($_GET['isding']>-1)
	{
		$sql.=" and c.isding=".intval($_GET['isding'])."";
		$sql2.=" and isding=".intval($_GET['isding'])." ";
		$url.="&isding=".intval($_GET['isding'])."";
	}
	$_GET['ishot']=isset($_GET['ishot'])?intval($_GET['ishot']):-1;
	
	if($_GET['ishot']>-1)
	{
		$sql.=" and c.ishot=".intval($_GET['ishot'])."";
		$sql2.=" and ishot=".intval($_GET['ishot'])." ";
		$url.="&ishot=".intval($_GET['ishot'])."";
	}
	$_GET['isnew']=isset($_GET['isnew'])?intval($_GET['isnew']):-1;
	if($_GET['isnew']>-1)
	{
		$sql.=" and c.isnew=".intval($_GET['isnew'])."";
		$sql2.=" and isnew=".intval($_GET['isnew'])." ";
		$url.="&isnew=".intval($_GET['isnew'])."";
	}
	$_GET['visible']=isset($_GET['visible'])?intval($_GET['visible']):-1;
	if($_GET['visible']>-1)
	{
		$sql.=" and c.visible=".intval($_GET['visible'])."";
		$sql2.=" and visible=".intval($_GET['visible'])." ";
		$url.="&visible=".intval($_GET['visible'])."";
	}
	$_GET['promote']=isset($_GET['promote'])?intval($_GET['promote']):-1;
	if($_GET['promote']>-1)
	{
		$sql.=" and c.promote=".intval($_GET['promote'])."";
		$sql2.=" and promote=".intval($_GET['promote'])." ";
		$url.="&promote=".intval($_GET['promote'])."";
	}
	$_GET['oos']=isset($_GET['oos'])?intval($_GET['oos']):-1;
	if($_GET['oos']>-1)
	{
		$sql.=" and c.promote=".intval($_GET['promote'])."";
		$sql2.=" and promote=".intval($_GET['promote'])." ";
		$url.="&promote=".intval($_GET['promote'])."";
	}
	
	
	if($week1)
	{
		$sql.=" and c.week1=1 ";
		$sql2.=" and week1=1 ";
		$url.="&week1=1";
	}
	
	if($week2)
	{
		$sql.=" and c.week2=1 ";
		$sql2.=" and week2=1 ";
		$url.="&week2=1";
	}
	
	if($week3)
	{
		$sql.=" and c.week3=1 ";
		$sql2.=" and week3=1 ";
		$url.="&week3=1";
	}
	
	if($week4)
	{
		$sql.=" and c.week4=1 ";
		$sql2.=" and week4=1 ";
		$url.="&week4=1";
	}
	
	if($week5)
	{
		$sql.=" and c.week5=1 ";
		$sql2.=" and week5=1 ";
		$url.="&week5=1";
	}
	
	if($week6)
	{
		$sql.=" and c.week6=1 ";
		$sql2.=" and week6=1 ";
		$url.="&week6=1";
	}
	if($week7)
	{
		$sql.=" and c.week7=1 ";
		$sql2.=" and week7=1 ";
		$url.="&week7=1";
	}
	$sql .=	" order by c.id desc ";	
	//开始分页
	$rscount=$db->getOne($sql2);
	$pagesize=20;
	$page=max(1,intval($_GET['page']));
	$start=($page-1)*$pagesize;
	$sql.=" limit $start,$pagesize";
	$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,$url));
	//结束
	$res=$db->query($sql);
	$cailist=array();
	while($rs=@$db->fetch_array($res))
	{
		$cailist[$rs['id']]=$rs;		
	}
	$smarty->assign("cailist",$cailist);
	$smarty->display("cai.html");	
}
elseif($a=='add')
{
		
	$id=intval($_GET['id']);
	if($id)
	{
		$sql="select c.*,cd.content,ct.cname  from ".table('cai')."   c   ".
			" LEFT JOIN ".table('cai_data')." cd ON c.id=cd.id  " .
			" LEFT JOIN ".table('cai_cat')." ct ON c.catid=ct.catid " .
			" where c.id='$id' LIMIT 1 ";

		$rs=$db->getRow($sql);
		
		$smarty->assign("rs",$rs);
		//获取标签
		$tarr=$db->getCols("select tagname from ".table('cai_tags')." where caiid='$id' ");
		$smarty->assign("tagname",implode(",",$tarr));
	}
	
	$smarty->display("cai_add.html");
}elseif($a=='add_db')
{
	require_once(ROOT_PATH."includes/cls_image.php");
	$clsimg=new image();
	$id=intval($_POST['id']);
	$title=$_POST['title'];
	ckempty($title,'美食名称不能为空');

	$thum_img=$_POST['thum_img'];
	$img=$_POST['img'];
	if($id)
	{
		$im=$db->getRow("SELECT thum_img,middle_img,img FROM ".table('cai')." WHERE id='$id' ");
	}
	if($thum_img )
	{
		if(!$im['thum_img'] or ($im['thum_img']!=$thum_img) )
		{
			$clsimg->makethumb("$thum_img","$thum_img",200,200);
		}
		$clsimg->makethumb("$thum_img","$thum_img",200,200);
	}else
	{
		if($img)
		{
			$thum_img="$img.thum.gif";
			$clsimg->makethumb($thum_img,$img,200,200);
		}
		
	}
	if($img && ($img!=$im['img']))
	{
		$middle_img="$img.middle.gif";
		$clsimg->makethumb($middle_img,$img,800,800);
	}
	
	if($img && $water_on)
	{
		if($water_type==0)
		{
		$clsimg->addwater($img,$water_pos,"{$water_img}");
		}else
		{
			$clsimg->addwater("{$img}",$water_pos,"",$water_str,$water_size);
		}
	}
	$keyword=$_POST['keyword'];
	$des=$_POST['des'];
	$price=(float)$_POST['price'];
	$tagname=$_POST['tagname'];
	$isding=intval($_POST['isding']);
	$ishot=intval($_POST['ishot']);
	$isnew=intval($_POST['isnew']);
	$content=$_POST['content'];
	$dateline=time();
	$week1=intval($_POST['week1']);
	$week2=intval($_POST['week2']);
	$week3=intval($_POST['week3']);
	$week4=intval($_POST['week4']);
	$week5=intval($_POST['week5']);
	$week6=intval($_POST['week6']);
	$week7=intval($_POST['week7']);
	$lowprice=(float)$_POST['lowprice'];
	$promote=intval($_POST['promote']);
	if($id)
	{
		$sql="update ".table('cai')." set title='$title',thum_img='$thum_img',".
			" img='$img',middle_img='$middle_img',keyword='$keyword',des='$des',price='$price',isding='$isding',ishot='$ishot',isnew='$isnew',content='$content',week1='$week1',week2='$week2',week3='$week3',week4='$week4',week5='$week5',week6='$week6',week7='$week7',lowprice='$lowprice',promote='$promote' where id='$id'";
		$db->query($sql);
		$db->query("UPDATE ".table('cai_data')." SET  content='$content' WHERE id='$id' " );
		//开始处理标签
		$tagname2=$_POST['tagname2'];
		if($tagname!=$tagname2){
			$db->query("delete from ".table('cai_tags')." where caiid='$id' ");
			$tarr=explode(",",$tagname);
			$arr=array();
			$sql="insert into ".table('cai_tags')."(caiid,tagname) values ";
			foreach($tarr as $t)
			{
				$arr[]="('$id','$t')";
			}
			$sql.=implode(",",$arr);
			$db->query($sql);
		}
	}
	gourl();
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('cai')." where id='$id' ");
	gourl();	
}elseif($a=='isding')
{
	$id=intval($_GET['id']);
	$t=intval($_GET['t']);
	$db->query("update ".table('cai')." set isding='$t' where id='$id' ");
}elseif($a=='ishot')
{
	$id=intval($_GET['id']);
	$t=intval($_GET['t']);
	$db->query("update ".table('cai')." set ishot='$t' where id='$id' ");	
}elseif($a=='isnew')
{
	$id=intval($_GET['id']);
	$t=intval($_GET['t']);
	$db->query("update ".table('cai')." set isnew='$t' where id='$id' ");	
}elseif($a=='visible')
{
	$visible=intval($_GET['visible']);
	$id=intval($_GET['id']);
	$db->query("update ".table('cai')." set visible='$visible' where id='$id' ");
	
}elseif($a=='promote')
{
	$t=intval($_GET['t']);
	$db->query("update ".table('cai')." set promote='$t' where id=".intval($_GET['id'])." ");
}elseif($a=='oos')
{
	$db->query("update ".table('cai')." set oos=".intval($_GET['t'])." where id=".intval($_GET['id'])." ");
}