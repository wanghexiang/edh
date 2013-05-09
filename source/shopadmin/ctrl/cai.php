<?php

check_login();
$a=$_REQUEST['a'];
if(empty($a))
{
	$a="index";	
}
$shopid=$_SESSION['adminshop']['shopid'];
$siteid=$_SESSION['adminshop']['siteid'];
switch($a)
{
	case 'index':
		$title=trim($_GET['title']);
		$week1=intval($_GET['week1']);
		$week2=intval($_GET['week2']);
		$week3=intval($_GET['week3']);
		$week4=intval($_GET['week4']);
		$week5=intval($_GET['week5']);
		$week6=intval($_GET['week6']);
		$week7=intval($_GET['week7']);
		
		$sql="select c.*  from ".table('cai')."  c    where c.shopid='$shopid' ";
				
		$sql2="select count(1) from ".table('cai')." where  shopid='$shopid' ";
		$url="shopadmin.php?m=cai&a=index";
		if(!empty($title))
		{
			$sql .=" and c.title like '%".$title."%' ";
			$sql2.=" and title like '%".$title."%'";
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
		$cailist=$cat=array();
		$ces=$db->query("SELECT catid,cname FROM ".table('cai_cat')." WHERE shopid='$shopid' LIMIT 50 ");
		while($cs=$db->fetch_array($ces)) 
		{
			$cat[$cs['catid']]=$cs['cname'];
		}
		
		while($rs=@$db->fetch_array($res))
		{
			$rs['cname']=$cat[$rs['catid']];
			$cailist[$rs['id']]=$rs;	
		}
		$smarty->assign("cailist",$cailist);
		$smarty->display("cai.html");
	
	break;	
	
	case 'add':

		$catlist=$db->getAll("select catid,cname from ".table('cai_cat')." WHERE shopid='$shopid' order by orderid asc");
		$smarty->assign("catlist",$catlist);
		$dolist=$db->getAll("select id,dname from ".table('cai_do')." order by orderid asc ");
		$smarty->assign("dolist",$dolist);
		$weilist=$db->getAll("select id,wname from ".table('cai_wei')." order by orderid asc ");
		$smarty->assign("weilist",$weilist);
		$addpic=$db->getone("select addpic from  ".table('shop')." where shopid='$shopid'");
		$smarty->assign("addpic",$addpic);
		
		$id=intval($_GET['id']);
		if($id)
		{
			$sql="select c.*,cd.content,ct.cname  from ".table('cai')."   c   ".
				" LEFT JOIN ".table('cai_data')." cd ON c.id=cd.id  " .
				" LEFT JOIN ".table('cai_cat')." ct ON c.catid=ct.catid " .
				" where c.id='$id' and c.shopid='$shopid' LIMIT 1 ";
			$rs=$db->getRow($sql);
		
			$smarty->assign("rs",$rs);
			//获取标签
			$tarr=$db->getCols("select tagname from ".table('cai_tags')." where caiid='$id' ");
			$smarty->assign("tagname",implode(",",$tarr));
		}
		
		$smarty->display("cai_add.html");
	break;
	
	case "add_db":
	
		require_once(ROOT_PATH."includes/cls_image.php");
		$clsimg=new image();
		$id=intval($_POST['id']);
		$title=$_POST['title'];
		ckempty($title,'美食名称不能为空');
		$catid=intval($_POST['catid']);
		$doid=intval($_POST['doid']);
		$weiid=intval($_POST['weiid']);
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
			$clsimg->addwater("".$img,$water_pos,"{$water_img}");
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
			$sql="update ".table('cai')." set title='$title',catid='$catid',doid='$doid',weiid='$weiid',thum_img='$thum_img',".
				" img='$img',keyword='$keyword',des='$des',price='$price',isding='$isding',ishot='$ishot',isnew='$isnew',week1='$week1',week2='$week2',week3='$week3',week4='$week4',week5='$week5',week6='$week6',week7='$week7',lowprice='$lowprice',promote='$promote' where id='$id' and shopid='$shopid' ";
			$db->query($sql);
			if(!$db->getOne("SELECT id FROM ".table('cai_data')." WHERE id='$id' "))
			{
				$db->query("INSERT INTO  ".table('cai_data')." SET  content='$content' , id='$id' " );
			}else
			{
			$db->query("UPDATE ".table('cai_data')." SET  content='$content' WHERE id='$id' " );
			}
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
		}else
		{
			$sql="insert into ".table('cai')." set title='$title',catid='$catid',doid='$doid',weiid='$weiid',thum_img='$thum_img',							             img='$img',keyword='$keyword',des='$des',price='$price',isding='$isding',ishot='$ishot',isnew='$isnew'
				,dateline='$dateline',week1='$week1',week2='$week2',week3='$week3',week4='$week4',week5='$week5',week6='$week6',week7='$week7',lowprice='$lowprice',promote='$promote',visible=1,shopid='$shopid',siteid='$siteid' ";
			$db->query($sql);
			$id=$db->insert_id();
			$db->query("INSERT INTO ".table('cai_data')." SET id='$id',content='$content' " );
			//处理标签
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
		errback("美食保存成功");
	break;
	
	case 'del':
		$id=intval($_GET['id']);
		$db->query("delete from ".table('cai')." where id='$id' and shopid='$shopid' ");
		gourl();
	break;
	
	case 'isding':	
		$id=intval($_GET['id']);
		$t=intval($_GET['t']);
		$db->query("update ".table('cai')." set isding='$t' where id='$id' ");
	break;
	
	case 'ishot':

		$id=intval($_GET['id']);
		$t=intval($_GET['t']);
		$db->query("update ".table('cai')." set ishot='$t' where id='$id' ");
	break;	
	
	case 'isnew':

		$id=intval($_GET['id']);
		$t=intval($_GET['t']);
		$db->query("update ".table('cai')." set isnew='$t' where id='$id' ");
	
	break;
	
	case 'visible':	
		$visible=intval($_GET['visible']);
		$id=intval($_GET['id']);
		$db->query("update ".table('cai')." set visible='$visible' where id='$id' ");
	break;
	
	case 'promote':
	
		$t=intval($_GET['t']);
		$db->query("update ".table('cai')." set promote='$t' where id=".intval($_GET['id'])." ");
	break;
	
	case 'oos':
		$db->query("update ".table('cai')." set oos=".intval($_GET['t'])." where id=".intval($_GET['id'])." ");
	break;
	
	case 'tocsv':
		$cailist=$db->getAll("SELECT c.title,c.price,c.catid,cc.cname FROM ".table('cai')." c LEFT JOIN ".table('cai_cat')." cc ON c.catid=cc.catid   WHERE c.shopid='$shopid' " );
	
		
		$f=session_id().time().".csv";
		
		header("Content-type:application/xls");
		header("Content-Disposition: attachment; filename={$f}"); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0');   
		header('Pragma:public'); 
		echo "美食名称,价格 ,分类ID,分类名称\n";
		if($cailist)
		{
			foreach($cailist as $c)
			{
				 echo "{$c['title']},{$c['price']},{$c['catid']},{$c['cname']}\n";     
			}
		}
	break;
	
	case 'import':
		 
		$_GET['op']=$_GET['op']?htmlspecialchars(trim($_GET['op'])):'index';
		
		switch($_GET['op'])
		{
			case 'index':
					$smarty->display("cai_import.html");
				break;
			case 'upload':
					if($_FILES['excel'])
					{
						include (ROOT_PATH."includes/cls_excel.php");
						include (ROOT_PATH."includes/cls_csv.php");
						$arr=csv2arr($_FILES['excel']['tmp_name']);
						//Read_Excel_File($_FILES['excel']['tmp_name'],$arr);
						$ids=array();
						unset($arr[0]);
						$arr=addslashes_deep($arr);
						foreach($arr as $k=>$v)
						{
							
								$catid=$db->getOne("select catid FROM ".table('cai_cat')." WHERE cname='{$v[5]}' AND shopid='$shopid' ");
								if(empty($catid) && $v[5]){
									$db->query("INSERT INTO ".table('cai_cat')." set shopid='$shopid',cname='{$v[5]}' ");
									$catid=$db->insert_id();	
								}
								$catid=intval($catid);
								$db->query("INSERT INTO ".table('cai')." SET shopid='$shopid',siteid='$siteid',title='".addslashes($v[0])."',price=".intval($v[1]).",keyword='".addslashes($v[2])."',des='".addslashes($v[3])."',catid='{$catid}' ");
							
							
							$db->query("INSERT INTO ".table('cai_data')." SET id='$id',content='".addslashes($v[4])."' ");
							
						}
						if(empty($ids)){
							gourl("shopadmin.php?m=cai");
						}else{
							gourl("shopadmin.php?m=cai&a=import&op=edi&ids=".serialize($ids));
						}
					}
				break;
			case 'edi':
					
						$cailist=$db->getAll("SELECT * FROM ".table('cai')." WHERE id in("._implode(unserialize($_GET['ids'])).") ");
						$smarty->assign("cailist",$cailist);
						$catlist=$db->getAll("select catid,cname from ".table('cai_cat')." WHERE shopid='$shopid' order by orderid asc");
						
						$smarty->assign("catlist",$catlist);
						$dolist=$db->getAll("select id,dname from ".table('cai_do')." order by orderid asc ");
						$smarty->assign("dolist",$dolist);
						$weilist=$db->getAll("select id,wname from ".table('cai_wei')." order by orderid asc ");
						$smarty->assign("weilist",$weilist);
						$smarty->display("cai_import_edi.html");
						
				break;
				
			case 'save':	
						$catids=$_POST['catid'];
						$weiids=$_POST['weiid'];
						$doids=$_POST['doid'];
						foreach($catids as $id=>$catid)
						{
							$db->query("UPDATE ".table('cai')." SET catid=".intval($catid).",weiid=".intval($weiids[$id]).",doid=".intval($doids[$id])." WHERE id='$id' ");
						}
						
						errback("导入成功","shopadmin.php?m=cai");
			
				break;
		}
	break;
	
}