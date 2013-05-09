<?php
require_once("config/ad.php");
$_GET['a']=isset($_GET['a'])?$_GET['a']:'index';
switch($_GET['a']){
	case 'index':
			$cname=get_post('cname');
			if($cname){
				$w=" AND cname='$cname' ";
				$u="&cname=".urlencode($cname);
			}
			$status=intval(get('status'));
			assignlist('ad',10," AND siteid='$siteid' AND status='$status' {$w} "," ORDER BY id DESC "," admin.php?m=ad&status={$status}{$u}");
			$smarty->assign("catlist",$catlist);
			$smarty->display("ad.html");
		break;
		
	case 'add':
			if($_GET['id'])
			{
				$smarty->assign("rs",$db->getRow("SELECT * FROM ".table('ad')." WHERE id='".intval($_GET['id'])."' AND siteid='$siteid' "));
			}
			$smarty->assign("catlist",$catlist);
			$smarty->display("ad_add.html");
		break;
	case 'post':
			$id=$_GET['id']?intval($_GET['id']):intval($_POST['id']);
			$data['title']=htmlspecialchars($_POST['title']);
			$data['cname']=trim(htmlspecialchars($_POST['cname']));
			$data['url']=htmlspecialchars($_POST['url']);
			$data['info']=htmlspecialchars($_POST['info']);
			$data['starttime']=strtotime($_POST['starttime']);
			$data['endtime']=strtotime($_POST['endtime']);
			
			$data['showid']=intval($_POST['showid']);
			$data['imgurl']=htmlspecialchars($_POST['imgurl']);
			$data['price']=htmlspecialchars($_POST['price']);
			$data['orderindex']=intval(post('orderindex'));
			if($id){
				$db->update("ad",$data," AND id='$id' ");
			}else{
				$data['dateline']=time();
				$data['siteid']=$siteid;
				$db->insert("ad",$data);	
			}
			errback('±£´æ³É¹¦');
		break;
	case 'del':
			$id=intval($_GET['id']);
			$db->query("DELETE FROM ".table('ad')." WHERE id='$id' AND siteid='$siteid' ");
			gourl();
		break;
	case 'changestatus':
			$id=intval(get('id'));
			$status=intval(get('status'));
			$db->query("UPDATE ".table('ad')." SET status={$status} WHERE id='$id' ");
		break;
}

?>