<?php
$_GET['a']=$_GET['a']?htmlspecialchars(trim($_GET['a'])):'index';

switch($_GET['a'])
{
	case 'index':
			$pagesize=20;
			$url="admin.php?m=goods";
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$title=$_GET['title']=htmlspecialchars($_GET['title']);
			$w='';
			$w.=$title?" AND g.title LIKE '".$title."%' ":"";
			$w.=$title?"&=title=$title":"";
			$sql="SELECT g.*,c.cname FROM ".table('goods')." g LEFT JOIN ".table('goods_cat')." c ON g.catid=c.catid  WHERE  1=1 $w ORDER BY g.id DESC ";
			$sql2="SELECT count(1) FROM ".table('goods')." g WHERE 1=1 $w ";
			$rscount=$db->getOne($sql2);
			
			$sql.=" limit $start,$pagesize";
			$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,$url));
			//结束
			$res=$db->query($sql);
			$goodslist=array();
			while($rs=$db->fetch_array($res))
			{
				$goodslist[$rs['id']]=$rs;		
			}
			$smarty->assign("goodslist",$goodslist);
			$smarty->display("goods.html");	
		break;
	case 'add':
			if($_GET['op']=='post')
			{
				require_once(ROOT_PATH."includes/cls_image.php");
				$clsimg=new image();
				$id=intval($_POST['id']);
				$title=$_POST['title'];
				ckempty($title,'商品名称不能为空');
				$catid=intval($_POST['catid']);
				$thumb_img=$_POST['thumb_img'];
				$img=$_POST['img'];
				if($id)
				{
					$im=$db->getRow("SELECT img,thumb_img,middle_img FROM ".table('goods')." WHERE id='$id' ");
				}
				if($thumb_img )
				{
					if(!$im['thumb_img'] or ($im['thumb_img']!=$thumb_img) )
					{
						$clsimg->makethumb("$thumb_img","$thumb_img",200,200);
					}
					$clsimg->makethumb("$thumb_img","$thumb_img",200,200);
				}else
				{
					if($img)
					{
						$thumb_img="$img.thum.gif";
						$clsimg->makethumb($thumb_img,$img,200,200);
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
				$info=$_POST['info'];
				$price=(float)$_POST['price'];
				$tagname=$_POST['tagname'];
				$isrecommend=intval($_POST['isrecommend']);
				$ishot=intval($_POST['ishot']);
				$isnew=intval($_POST['isnew']);
				$content=$_POST['content'];
				$dateline=time();
				$grade=intval($_POST['grade']);
				if($id)
				{
					$sql="update ".table('goods')." set title='$title',catid='$catid',thumb_img='$thumb_img',middle_img='$middle_img',img='$img',keyword='$keyword',info='$info',price='$price',grade='$grade',isrecommend='$isrecommend',ishot='$ishot',isnew='$isnew',content='$content' where id='$id'";
					$db->query($sql);
					
				}else
				{
					$sql="insert into ".table('goods')." set title='$title',catid='$catid',thumb_img='$thumb_img',middle_img='$middle_img',							             img='$img',keyword='$keyword',info='$info',price='$price',isrecommend='$isrecommend',ishot='$ishot',isnew='$isnew',content='$content'
						,dateline='$dateline',grade='$grade',visible=1 ";
					$db->query($sql);
				}
				gourl();
			}else
			{
				$id=intval($_GET['id']);
				if($id)
				{
					$goods=$db->getRow("SELECT g.*,c.cname FROM ".table('goods')." g LEFT JOIN ".table('goods_cat')." c ON g.catid=c.catid  WHERE g.id='$id' ");
				}
				
				$catlist=$db->getAll("SELECT * FROM ".table('goods_cat')." ORDER BY orderindex ASC LIMIT 50 ");
				$smarty->assign("rs",$goods);
				$smarty->assign("catlist",$catlist);
				$smarty->display("goods_add.html");
			}
		break;
	case 'cat':
			if($_GET['op']=='add')
			{
				$cname=$_POST['cname'];
				$catid=$_POST['catid'];
				if($catid)
				{
					$orderindex=intval($_POST['orderindex']);
					$db->query("update ".table('goods_cat')." set cname='$cname',orderindex='$orderindex' where catid='$catid'   ");
				}else
				{
					$db->query("insert into ".table('goods_cat')."(cname) values('$cname') ");	
				}
				gourl("admin.php?m=goods&a=cat");
			}elseif($_GET['op']=='del')
			{
				$catid=intval($_GET['catid']);
				$db->query("delete from ".table('goods_cat')." where catid='$catid' ");
				gourl();
			}else
			{
				$catlist=$db->getAll("select catid,cname,orderindex from ".table('goods_cat')." order by orderindex asc LIMIT 50 ");
	$smarty->assign("catlist",$catlist);
				$smarty->display("goods_cat.html");
			}
	
		break;
	case 'del':
			$id=intval($_GET['id']);
			$db->query("DELETE FROM ".table('goods')." WHERE id='$id'");
			gourl();
		break;
	case 'isrecommend':
				$id=intval($_GET['id']);
				$t=intval($_GET['t']);
				$db->query("update ".table('goods')." set isrecommend='$t' where id='$id' ");
		break;
	case 'ishot':
				$id=intval($_GET['id']);
				$t=intval($_GET['t']);
				$db->query("update ".table('goods')." set ishot='$t' where id='$id' ");
		break;
	case 'isnew':
				$id=intval($_GET['id']);
				$t=intval($_GET['t']);
				$db->query("update ".table('goods')." set isnew='$t' where id='$id' ");
		break;
	case 'visible':
				$visible=intval($_GET['visible']);
				$id=intval($_GET['id']);
				$db->query("update ".table('goods')." set visible='$visible' where id='$id' ");
		break;

	
	
}
?>