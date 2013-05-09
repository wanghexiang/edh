<?php
switch($a){
	case "index":
	
		break;
	case "config":
			if(!$db->getOne("SELECT id FROM ".table('weibo_config')." WHERE siteid='$siteid' ")){
				$db->insert("weibo_config",array("siteid"=>$siteid));
				 
			}
			$smarty->assign("data",$db->getRow("SELECT * FROM ".table('weibo_config')."  WHERE siteid='$siteid'  "));
			$smarty->display("weibo_config.html");
		break;
	case "saveconfig":
			$id=post('id',"i");
			$data['nickname']=post('nickname',"html");
			$data['token_users']=post('token_users','html');
			$db->update("weibo_config",$data," AND id='$id' ");
			gourl();
		break;
	
	case "userlist":
			$visible=get('visible','i');
			switch(get('order')){
				case "1":
						$order="order by statuses_count DESC";
					break;
				case "2":
						$order="order by followers_count DESC";
					break;
					
				default:
						$order="order by id DESC";
					break;
			}
			assignlist("weibo_souser",20," AND visible='$visible' ",$order,"admin.php?m=weibo&a=userlist&visible={$visible}&order=".get('order','i'));
			$smarty->assign("baseurl","admin.php?m=weibo&a=userlist&visible={$visible}");
			$smarty->display("weibo_userlist.html");
		break;
	case "adduser":
			$uid=get('uid',"i");
			
			if($uid){
				$smarty->assign("data",$db->getRow("SELECT * FROM ".table('weibo_souser')." where uid='$uid' "));
			}
			$smarty->display("weibo_adduser.html");
		break;
	case "saveuser":
			$user=array(	
						
						'screen_name'=>post('screen_name','h'),
						'location'=>post('location','h'),
						'description'=>post('description','h'),
						'avatar_large'=>post('avatar_large','h'),
						'friends_count'=>post('friends_count','h'),
						'domain'=>post('domain','h'),
						'followers_count'=>post('followers_count','h'),
						'statuses_count'=>post('statuses_count','h'),
						 
					);
				if(!$db->getOne("SELECT uid FROM ".table('weibo_souser')." WHERE uid=".post('uid','i')." ")){
					$user['uid']=post('uid','i');	
					$db->insert("weibo_souser",$user);
				}else{
					$db->update("weibo_souser",$user," AND uid=".post('uid','i')." ");
				}
			 
				gourl();
		break;
	case "del":
			$db->query("DELETE FROM ".table('weibo_souser')." WHERE uid=".get('uid',"i")."  ");
		break;
	case "visible":
			$db->query("UPDATE ".table('weibo_souser')." SET visible=".get('visible','i')." WHERE id=".get('id','i')." ");
		break;
	 
	
}

?>