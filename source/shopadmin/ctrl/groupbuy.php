<?php
check_login();
$_GET['a']=$_GET['a']?$_GET['a']:'index';

$shopid=$_SESSION['adminshop']['shopid'];
switch($_GET['a'])
{
	case 'index':
			
			assignlist("groupbuy",10," AND shopid='$shopid' " ,' ORDER BY id DESC ','groupbuy.php'); 
			$smarty->display("groupbuy.html");
		break;
		
	case 'add':
			if($_GET['id'])
			{
				$smarty->assign("groupbuy",$db->getRow("SELECT * FROM ".table('groupbuy')." WHERE id=".intval($_GET['id'])." "));
			}
			$smarty->assign("catlist",$db->getAll("SELECT catid,cname FROM ".table('groupbuy_category')." ORDER BY orderindex ASC "));
	
			$smarty->assign("goods",$db->getAll("SELECT id,title,price FROM ".table('cai')." WHERE shopid='$shopid' "));
			$smarty->display("groupbuy_add.html");
		break;
	case 'post':
			$id=intval($_POST['id']);
			$catid=intval($_POST['catid']);
			$title=trim(htmlspecialchars(trim($_POST['title'])));
			$groupprice=floatval($_POST['groupprice']);
			$endtime=strtotime($_POST['endtime']);
			$minjoins=intval($_POST['minjoins']);
			$info=htmlspecialchars(trim($_POST['info']));
			$content=$_POST['content'];
			$img=htmlspecialchars(trim($_POST['img']));
			$goodsprice=floatval($_POST['goodsprice']);
			if($id)
			{
				$oldimg=$db->getOne("SELECT  img FROM ".table('groupbuy')." WHERE id='$id' ");
			}
			if($img && ($img!=$oldimg))
			{
				require_once(ROOT_PATH."includes/cls_image.php");
				$clsimg=new image();
				$thum_img="$img.thumb.jpg";
				$clsimg->makethumb($thum_img,$img,200,200);
				$middle_img="$img.middle.jpg";
				$clsimg->makethumb($middle_img,$img,800,400);
			}
			if($id)
			{
				$db->query("UPDATE ".table('groupbuy')." SET catid='$catid',title='$title',img='$img',groupprice='$groupprice',endtime='$endtime',minjoins='$minjoins',goodsprice='$goodsprice',info='$info',content='$content' WHERE id='$id' AND shopid='$shopid' ");
				
			}else
			{
				$db->query("INSERT INTO ".table('groupbuy')." SET catid='$catid',siteid='$siteid',shopid='$shopid',title='$title',img='$img',goodsprice='$goodsprice',groupprice='$groupprice',endtime='$endtime',minjoins='$minjoins',info='$info',content='$content'  ");
			}
			errback('团购保存成功');
	case 'del':
			$id=intval($_GET['id']);
			$db->query("DELETE FROM ".table('groupbuy')." WHERE id='$id' AND shopid='$shopid' ");
			gourl();
	
		break;
	case "change":
			$id=intval(get('id'));
			$status=intval(get('status'));
			$db->query("UPDATE ".table('groupbuy')." SET status='$status' WHERE id='$id' AND status<2 ");
		break;
			
	case 'order':
			$w='';
			$url="shopadmin.php?m=groupbuy&a=order";
			if($_GET['nickname'])
			{
				$w.=" AND nickname like '".htmlspecialchars(trim($_GET['nickname']))."%' ";
				$url.="&nickname=".urlencode($_GET['nickname']);
			}
			$_GET['status']=isset($_GET['status'])?$_GET['status']:'-1';
			if($_GET['status']>-1)
			{
				$w.=" AND status = ".intval($_GET['status'])." ";
				$url.="&status=".intval($_GET['status']);
			}
			
			if($_GET['starttime'])
			{
				$w.=" AND dateline>".strtotime($_GET['starttime'])." ";
				$url.="&starttime=".$_GET['starttime'];
			}
			if($_GET['endtime'])
			{
				$w.=" AND dateline<".strtotime($_GET['endtime'])." ";
				$url.="&endtime=".$_GET['endtime'];
			}
			if(get('s')==1){
				$st=strtotime(date("Y-m-d 00:00:00"));
				 $w.=" AND dateline>{$st} AND dateline<".($st+3600*24)." ";
				 $url.="&s=1";
			}elseif(get('s')==2){
				$st=strtotime(date("Y-m-d 00:00:00"))-3600*24; 
				$w.=" AND dateline>{$st} AND dateline<".($st+3600*24)." ";
				$url.="&s=2";
			}
			if(get('s')){
				$order=" order BY orderid ASC";	
			}else{
				$order=" ORDER BY orderid DESC ";	
			}
			 
			assignlist('groupbuy_order',10,$w,$order,$url);
			$smarty->display("groupbuy_order.html");
		break;
		
	case 'status':
			$ids=$_POST['orderid'];
			$status=intval($_GET['status']);
			$ids=$db->getCols("SELECT orderid FROM ".table('groupbuy_order')." WHERE orderid in("._implode($ids).") AND status<3 ");
			if(!empty($ids))
			{			 
				$db->query("UPDATE ".table('groupbuy_order')." SET status='$status' WHERE orderid in("._implode($ids).") ");
			}
			errback('操作成功');
		break;
}
?>