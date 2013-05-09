<?php
check_login();
$a=get_post('a');
$a=$a?$a:"index";
switch($a){
	case "index":
			assignlist("activity",20,"","","admin.php?m=activity");
			$smarty->display("activity.html");
		break;
	case "add":
			$id=intval(get('id'));
			if($id){
				$smarty->assign("data",$db->getRow("SELECT * FROM ".table('activity')." WHERE id='$id' "));
			}
			$smarty->display("activity_add.html");
		break;
	case  "save":
			$data['title']=htmlspecialchars(post('title'));
			$data['address']=htmlspecialchars(post('address'));
			$data['keywords']=htmlspecialchars(post('keywords'));
			$data['description']=htmlspecialchars(post('description'));
			$data['info']=htmlspecialchars(post('info'));
			$data['content']=trim(post('content'));
			$data['starttime']=intval(strtotime(post('starttime')));
			$data['endtime']=intval(strtotime(post('endtime')));
			$id=intval(get_post('id'));
			if($id){
				$db->update("activity",$data," AND id='$id' ");	
			}else{
				$data['siteid']=intval($siteid);
				$data['dateline']=time();
				$db->insert("activity",$data);
			}
			gourl();
		break;
	case	"del":
			$id=intval(get('id'));
			$db->query("DELETE FROM ".table('activity')." WHERE id='$id' ");
		break;
	case	"changestatus":
			$id=intval(get('id'));
			$status=intval(get('status'));
			$db->query("UPDATE ".table('activity')."  SET status='$status' WHERE id='$id' ");
		break;
	case	"topic":
			assignlist("activity_topic",10,"","","admin.php?m=activity&a=topic");
			$smarty->display("activity_topic.html");
		break;
	case	"topicdel":
			$id=intval(get('id'));
			$db->query("DELETE FROM ".table('activity_topic')." WHERE id='$id' ");
		break;
	case	"topicstatus":
			$id=intval(get('id'));
			$status=intval(get('status'));
			$db->query("UPDATE ".table('activity_topic')."  SET status='$status' WHERE id='$id' ");
		break;
	case	"user":
			assignlist("activity_user",10,"","","admin.php?m=activity&a=user");
			$smarty->display("activity_user.html");
		break;
	case	"usestatus":
			$id=intval(get('id'));
			$status=intval(get('status'));
			$db->query("UPDATE ".table('activity_user')."  SET status='$status' WHERE id='$id' ");
		break;
	case	"userdel":
			$id=intval(get('id'));
			$db->query("DELETE FROM ".table('activity_user')." WHERE id='$id' ");
		break;
	 
}
?>