<?php
if(!defined("CT"))
{
	die("IS WRONG");
}
switch($a){
	case "test":
			if(!$smarty->is_cached("test.html",1)){
				$smarty->assign("time",time());
			}
			 
			$smarty->display("test.html",1);
			break;
		break;
	case "index":
		$smarty->assign("topic",urlencode(iconv("gbk","utf-8","网上订餐")));
		$smarty->display("weibo.html");
	break;
	case "getweibo":
			/*发送微博*/
			require_once("config/sina_config.php");
			require_once("api/sina/saetv2.ex.class.php");
			$xusername=$db->getOne("SELECT nickname FROM ".table('weibo_config')." WHERE siteid='$cksiteid' LIMIT 1 ");
			$accesstoken=$db->getOne("SELECT accesstoken FROM ".table('userapi')." where xusername='$xusername'  ");
			if($accesstoken){
				$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$accesstoken );
				$arr=$c->home_timeline(1, 50, 0, 0, 0, 1 );//获取原创
				 $k=0;
				foreach($arr['statuses'] as $v){
					if(strlen($v['text'])>80){
						if($k<6){
							$data[]= $v['text'].($v['bmiddle_pic']?"<img src='{$v['bmiddle_pic']}'>":"");
							$k++;
						}
					}
				}
				if(empty($data)) exit('授权失效');
				$content=iconv("utf-8","gbk",implode("<br><br>",$data));
				
				$d=array();
				$d['title']=addslashes(cutstr(strip_tags($content),60,""));
				$wtitle=file_get_contents(ROOT_PATH."temp/weibo.txt");
				if($wtitle==$d['title']) exit("已经获取过了");
				$d['dateline']=time();
				$d['catid']=rand(1,2);
				$d['keyword']=$d['title'];
				$d['des']=addslashes(cutstr(strip_tags($content),200));
				$d['siteid']=1;
				 
				$db->insert("art",$d);
				file_put_contents(ROOT_PATH."temp/weibo.txt",$d['title']);
				echo $id=$db->insert_id();
				$da['id']=$id;
				$da['content']=addslashes($content);
				$db->insert("art_data",$da);
				echo "添加成功";
			}
		break;
	case "souser":
			
			set_time_limit(0);
			$tk=@file_get_contents(ROOT_PATH."temp/tk");
			$tk=intval($tk);
			require_once("config/sina_config.php");
			require_once("api/sina/saetv2.ex.class.php");
			
			$tokenarr=array(
				"2.00Ry9i9Bxk_VOEb254444d3fJT_LOE",//雷日锦创业
				"2.00aqQLXCxk_VOE08774d2693hBOv2E",//我是挑食客
				"2.00qh6sKCxk_VOE0e070b01cc0RHEjT",//三网达人
				"2.00sz_LXCxk_VOE722020f0620vp9rQ",//厦门一起玩
				"2.00SwFMaCxk_VOEdd3c460babH8GOwD",//厦门旅游记
				"2.00y5xdvCxk_VOEc456a32fcbjrMRAC",//石雕展
				"2.00Me_evCxk_VOE5d4f241f397vG2ZE",//来做幸福女人
				"2.00YnyBBDxk_VOE5a12bbb9560D84RP",//美图王937
				
			);
			 
			$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$tokenarr[$tk]);
			//$a=$c->friends_by_name("雷日锦创业");
			$su=$db->getRow("SELECT uid,step,screen_name FROM ".table('weibo_souser')." where status=0 ORDER BY followers_count desc LIMIT 1 ");
			//锁住进程
			$su && $db->update("weibo_souser",array("status"=>1)," AND uid='{$su['uid']}' ");
			$uid=$su?$su['uid']:1197161814;
			$step=intval($su['step'])+1;
			
			$a=$c->bilateral($uid,1,200);
			if($a['error']){
				//解锁
				$su && $db->update("weibo_souser",array("status"=>0)," AND uid='{$su['uid']}' ");
				//切换token
				if($tk>count($tokenarr)-1){
					$tk=0;
				}else{
					$tk=$tk+1;
				}
				file_put_contents(ROOT_PATH."temp/tk",$tk);
				echo $a['error'];
				echo "<script>location.href='index.php?m=weibo&a=souser&t=".time()."';</script>";
				exit;
			}
			$a=iconvstr("utf-8","gbk",$a);
			if($a['users']){
			foreach($a['users'] as $v){
				
				$status=($v['followers_count']<200)?1:0;//小于500粉丝则不索引
				$user=array(	
						'uid'=>$v['idstr'],
						'screen_name'=>$v['screen_name'],
						'location'=>$v['location'],
						'description'=>$v['description'],
						'avatar_large'=>$v['avatar_large'],
						'friends_count'=>$v['friends_count'],
						'domain'=>$v['domain'],
						'followers_count'=>$v['followers_count'],
						'statuses_count'=>$v['statuses_count'],
						'step'=>$step,
						'status'=>$status,
						'gender'=>$v['gender'],
						
					);
					
				if(!$db->getOne("SELECT uid FROM ".table('weibo_souser')." WHERE uid='{$v['idstr']}' ")){	
					$db->insert("weibo_souser",$user);
				} 
			}
			}
			echo "正在索引{$su['screen_name']}";
			
		echo "<script>location.href='index.php?m=weibo&a=souser&t=".time()."';</script>";
		break;
	case "userlist":
			assignlist("weibo_souser",20," AND visible=1 "," order by followers_count desc","index.php?m=weibo&a=userlist");
			$smarty->display("weibo_userlist.html");
		break;
	case "userindex":
			
			$uid=get('uid',"i");
			$uid=$uid?$uid:1243015277;
			 $smarty->cache_lifetime = 3600*24;
			if(!$smarty->is_cached("weibo_userindex.html",$uid)){
					
				require_once(ROOT_PATH."config/sina_config.php");
				require_once(ROOT_PATH."api/sina/saetv2.ex.class.php");
				$tk=intval($_SESSION['tk']);
				$token_users=$db->getOne("SELECT token_users FROM ".table('weibo_config')." WHERE siteid='{$cksiteid}' ");
				$token_users=explode("\r\n",$token_users);
				$tokenarr=$db->getCols("SELECT accesstoken FROM ".table('userapi')." WHERE xusername in("._implode($token_users).") ");
			
				
				$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$tokenarr[$tk]);
				$data=$c->user_timeline_by_id($uid,1,100,0,0,2);
				
				if(isset($data['statuses'])){
					$screen_name=$data['statuses'][0]['user']['screen_name'] ;
					foreach($data['statuses'] as $k=>$v){
						if(strlen($v['text'])<40) continue;
						$blogs[]=array(
							'picture'=>$v['bmiddle_pic'],
							"content"=>preg_replace("/http:([\w\/\.]+)/i","",$v['text']),
							"dateline"=>strtotime($v['created_at']),
							"screen_name"=>$v['user']['screen_name'],
						);
						
					}
				}elseif($data['error']){
					//切换token
					if($tk>count($tokenarr)-1){
						$_SESSION['tk']=0;
					}else{
						$_SESSION['tk']=$tk+1;
					}
					gourl("index.php?m=weibo&a=userindex&uid=$uid");
				}
				$screen_name=iconvstr("utf-8","gbk",$screen_name);
				$seo=array(
					"title"=>"{$screen_name}的挑食客专栏-".$seo['title'],
					"keywords"=>"{$screen_name}的挑食客专栏，".$seo['keywords'],
					"description"=>"{$screen_name}的挑食客专栏,".$seo['description']
				);
				$smarty->assign("seo",$seo);
				$smarty->assign("screen_name",$screen_name);
				$smarty->assign("list",iconvstr("utf-8","gbk",$blogs));
				
			}
			 $smarty->display("weibo_userindex.html",$uid); 
		break;
	case "del":
			set_time_limit(0);
			$data=$db->getAll("SELECT uid,count(uid) as c from hck_weibo_souser   GROUP BY uid HAVING c>1");
			foreach($data as $v){
				$db->query("delete  from hck_weibo_souser WHERE uid=".$v['uid']." limit 1");
			}
			echo "删除成功";
		break;
	case "getbyuid":
			require_once(ROOT_PATH."config/sina_config.php");
			require_once(ROOT_PATH."api/sina/saetv2.ex.class.php");
			$tk=intval($_SESSION['tk']);
			$token_users=$db->getOne("SELECT token_users FROM ".table('weibo_config')." WHERE siteid='{$cksiteid}' ");
			$token_users=explode("\r\n",$token_users);
			 
			$tokenarr=$db->getCols("SELECT accesstoken FROM ".table('userapi')." WHERE xusername in("._implode($token_users).") ");
			$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$tokenarr[$tk]);
			$data=$c->show_user_by_id(get('uid','i'));
			if($data['error']){
				//切换token
				if($tk>count($tokenarr)-1){
					$_SESSION['tk']=0;
				}else{
					$_SESSION['tk']=$tk+1;
				}
				exit($a['error']);
			}
			$user=array(	
						'uid'=>$data['idstr'],
						'screen_name'=>$data['screen_name'],
						'location'=>$data['location'],
						'description'=>$data['description'],
						'avatar_large'=>$data['avatar_large'],
						'friends_count'=>$data['friends_count'],
						'domain'=>$data['domain'],
						'followers_count'=>$data['followers_count'],
						'statuses_count'=>$data['statuses_count'],						 					
					);
			echo json_encode($user);
		break;
	case "rscount":
		echo $db->getOne("SELECT count(*) from hck_weibo_souser ");
	break;
}
?>