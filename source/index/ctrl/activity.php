<?php
$a=get('a')?get('a'):"index";
switch($a){
	case	"index":
			$d=intval(get('d'));
			if($d==1){
				$w=" AND starttime>".time()." ";
			}elseif($d==2){
				$w=" AND endtime<".time()." ";
			}else{
				$w=" AND endtime>".time()." AND starttime<".time()." ";
			}
			assignlist("activity",20," AND status=1 $w "," ORDER BY id DESC","index.php?m=activity");
			$smarty->assign("actlist",$d=$db->getAll("SELECT * FROM ".table('activity')." WHERE status=1 ORDER BY id DESC LIMIT 10 "));
			$smarty->display("activity.html");
		break;
	case	"show":
			$id=intval(get('id'));
			$data=$db->getRow("SELECT * FROM ".table('activity')." WHERE id='$id' AND status=1 ");
			if(!$data){
				errback("该活动不存在","index.php?m=activity");	
			}
			$smarty->assign("actlist",$d=$db->getAll("SELECT * FROM ".table('activity')." WHERE status=1 ORDER BY id DESC LIMIT 10 "));
			 
			assignlist("activity_topic",10," AND status=1 AND act_id='$id' "," ORDER BY id DESC ","index.php?m=activity&a=show&id={$id}");
			$smarty->assign("data",$data);
			$smarty->assign("act_id",$id);
			$smarty->display("activity_show.html");
			
		break;
	case	"savetopic":
			$id=intval(get('id'));
			$data['content']=trim(htmlspecialchars(post('content')));
			$data['act_id']=$id;
			$data['userid']=intval($_SESSION['ssuser']['userid']);
			$data['nickname']=$_SESSION['ssuser']['nickname'];
			$data['dateline']=time();
			$data['siteid']=$cksiteid;
			$db->insert("activity_topic",$data);
			errback("感谢您的参与");
		break;
	case	"apply":
			$id=intval(get('id'));
			if($id){
				$smarty->assign("data",$db->getRow("SELECT * FROM ".table('activity')." WHERE id='$id' "));
				$smarty->assign("act_id",$id);
			}
			$smarty->display("activity_apply.html");
			break;
	case	"mycreate":
				assignlist("activity",10," AND userid='".intval($_SESSION['ssuser']['userid'])."' ","","index.php?m=user&a=mycreate");
				$smarty->display("activity_mycreate.html");
			break;
	case	"myjoin":
				check_login();
				$ids=$db->getCols("SELECT act_id FROM  ".table('activity_user')." WHERE userid=".intval($_SESSION['ssuser']['userid'])." ");
				$ids && assignlist("activity",10," AND id in("._implode($ids).") "," ORDER BY id DESC","index.php?m=user&a=myjoin");
				$smarty->display("activity_myjoin.html");
			break;
			
	case	"save":
			check_login();
			$data['title']=htmlspecialchars(post('title'));
			$data['keywords']=htmlspecialchars(post('keywords'));
			$data['description']=htmlspecialchars(post('description'));
			$data['info']=htmlspecialchars(post('info'));
			$data['content']=trim(post('content'));
			$data['starttime']=intval(strtotime(post('starttime')));
			$data['endtime']=intval(strtotime(post('endtime')));
			$data['address']=htmlspecialchars(post('address'));
			$id=intval(get_post('id'));
			if($id){
				$db->update("activity",$data," AND id='$id' ");	
			}else{
				$data['siteid']=intval($cksiteid);
				$data['dateline']=time();
				$data['nickname']=$_SESSION['ssuser']['nickname'];
				$data['userid']=$_SESSION['ssuser']['userid'];
				$db->insert("activity",$data);
			}
			gourl();
			break;
	case	"join":
			check_login();
			$act_id=intval(get('act_id'));
			$data=$db->getRow("SELECT * FROM ".table('activity')." WHERE id='$act_id' AND status=1 ");

			if(!$data or ($data['endtime']<time())){
				errback("很抱歉，该活动已取消或者已结束");
			}
			//判断是否已经参与
			if($db->getOne("SELECT id FROM ".table('activity_user')." WHERE act_id='$act_id' AND userid=".intval($_SESSION['ssuser']['userid'])." ")){
				errback("你已经申请过了");
			}
			
			$smarty->assign("data",$data);
			$smarty->assign("act_id",$act_id);
			$smarty->display("activity_join.html");
		break;
	case "saveuser";
			check_login();
			$act_id=intval(get_post('act_id'));
			$data=$db->getRow("SELECT * FROM ".table('activity')." WHERE id='$act_id' AND status=1 ");

			if(!$data or ($data['endtime']<time())){
				errback("很抱歉，该活动已取消或者已结束");
			}
			//判断是否已经参与
			if($db->getOne("SELECT id FROM ".table('activity_user')." WHERE act_id='$act_id' AND userid=".intval($_SESSION['ssuser']['userid'])." ")){
				errback("你已经申请过了");
			}
			$data=array();
			$data['nickname']=htmlspecialchars(post('nickname'));
			$data['logo']=$_SESSION['ssuser']['logo'];
			$data['siteid']=intval($cksiteid);
			$data['userid']=intval($_SESSION['ssuser']['userid']);
			$data['telephone']=htmlspecialchars(post('telephone'));
			$data['info']=htmlspecialchars(post('info'));
			$data['act_id']=$act_id;
			$data['dateline']=time();
			$db->insert("activity_user",$data);
			errback("恭喜参与申请成功","index.php?m=activity&a=show&id={$act_id}");
		break;
	case	"cpcomment":
			switch(get('op')){
				case	"changestatus":
						$id=intval(get('id'));
						$act_id=intval(get('act_id'));
						$status=intval(get('status'));
						$db->query("UPDATE ".table('activity_topic')." SET status='$status' WHERE id='$id' AND act_id='$act_id' ");
						exit;
					break;	
			}
			$id=intval(get('id'));
			$data=$db->getRow("SELECT * FROM ".table('activity')." WHERE id='$id' ");
			assignlist('activity_topic',20," AND act_id='$id' "," ORDER BY id DESC ","index.php?m=activity&a=cpcommment&id={$id}");
			$smarty->assign(
				array(
					"data"=>$data,
					"act_id"=>$id,
				)
			);
			$smarty->display("activity_cpcomment.html");
		break;
	case "cpuser":
			switch(get('op')){
				case	"changestatus":
						$id=intval(get('id'));
						$act_id=intval(get('act_id'));
						$status=intval(get('status'));
						$db->query("UPDATE ".table('activity_user')." SET status='$status' WHERE id='$id' AND act_id='$act_id' ");
						exit;
					break;	
			}
			$id=intval(get('id'));
			$data=$db->getRow("SELECT * FROM ".table('activity')." WHERE id='$id' ");
			assignlist('activity_user',20," AND act_id='$id' "," ORDER BY id DESC ","index.php?m=activity&a=cpuser&id={$id}");
			$smarty->assign(
				array(
					"data"=>$data,
					"act_id"=>$id,
				)
			);
			$smarty->display("activity_cpuser.html");
				 
		break;
	case	"joinuser":
			$id=intval(get('id'));
			$data=$db->getRow("SELECT * FROM ".table('activity')." WHERE id='$id' ");
			assignlist('activity_user',20," AND act_id='$id' AND status=1 "," ORDER BY id DESC ","index.php?m=activity&a=cpuser&id={$id}");
			$smarty->assign(
				array(
					"data"=>$data,
					"act_id"=>$id,
				)
			);
			$smarty->display("activity_joinuser.html");
		break;
	
}

?>