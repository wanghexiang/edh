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
		$smarty->assign("topic",urlencode(iconv("gbk","utf-8","���϶���")));
		$smarty->display("weibo.html");
	break;
	case "getweibo":
			/*����΢��*/
			require_once("config/sina_config.php");
			require_once("api/sina/saetv2.ex.class.php");
			$xusername=$db->getOne("SELECT nickname FROM ".table('weibo_config')." WHERE siteid='$cksiteid' LIMIT 1 ");
			$accesstoken=$db->getOne("SELECT accesstoken FROM ".table('userapi')." where xusername='$xusername'  ");
			if($accesstoken){
				$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$accesstoken );
				$arr=$c->home_timeline(1, 50, 0, 0, 0, 1 );//��ȡԭ��
				 $k=0;
				foreach($arr['statuses'] as $v){
					if(strlen($v['text'])>80){
						if($k<6){
							$data[]= $v['text'].($v['bmiddle_pic']?"<img src='{$v['bmiddle_pic']}'>":"");
							$k++;
						}
					}
				}
				if(empty($data)) exit('��ȨʧЧ');
				$content=iconv("utf-8","gbk",implode("<br><br>",$data));
				
				$d=array();
				$d['title']=addslashes(cutstr(strip_tags($content),60,""));
				$wtitle=file_get_contents(ROOT_PATH."temp/weibo.txt");
				if($wtitle==$d['title']) exit("�Ѿ���ȡ����");
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
				echo "��ӳɹ�";
			}
		break;
	case "souser":
			
			set_time_limit(0);
			$tk=@file_get_contents(ROOT_PATH."temp/tk");
			$tk=intval($tk);
			require_once("config/sina_config.php");
			require_once("api/sina/saetv2.ex.class.php");
			
			$tokenarr=array(
				"2.00Ry9i9Bxk_VOEb254444d3fJT_LOE",//���ս���ҵ
				"2.00aqQLXCxk_VOE08774d2693hBOv2E",//������ʳ��
				"2.00qh6sKCxk_VOE0e070b01cc0RHEjT",//��������
				"2.00sz_LXCxk_VOE722020f0620vp9rQ",//����һ����
				"2.00SwFMaCxk_VOEdd3c460babH8GOwD",//�������μ�
				"2.00y5xdvCxk_VOEc456a32fcbjrMRAC",//ʯ��չ
				"2.00Me_evCxk_VOE5d4f241f397vG2ZE",//�����Ҹ�Ů��
				"2.00YnyBBDxk_VOE5a12bbb9560D84RP",//��ͼ��937
				
			);
			 
			$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$tokenarr[$tk]);
			//$a=$c->friends_by_name("���ս���ҵ");
			$su=$db->getRow("SELECT uid,step,screen_name FROM ".table('weibo_souser')." where status=0 ORDER BY followers_count desc LIMIT 1 ");
			//��ס����
			$su && $db->update("weibo_souser",array("status"=>1)," AND uid='{$su['uid']}' ");
			$uid=$su?$su['uid']:1197161814;
			$step=intval($su['step'])+1;
			
			$a=$c->bilateral($uid,1,200);
			if($a['error']){
				//����
				$su && $db->update("weibo_souser",array("status"=>0)," AND uid='{$su['uid']}' ");
				//�л�token
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
				
				$status=($v['followers_count']<200)?1:0;//С��500��˿������
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
			echo "��������{$su['screen_name']}";
			
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
					//�л�token
					if($tk>count($tokenarr)-1){
						$_SESSION['tk']=0;
					}else{
						$_SESSION['tk']=$tk+1;
					}
					gourl("index.php?m=weibo&a=userindex&uid=$uid");
				}
				$screen_name=iconvstr("utf-8","gbk",$screen_name);
				$seo=array(
					"title"=>"{$screen_name}����ʳ��ר��-".$seo['title'],
					"keywords"=>"{$screen_name}����ʳ��ר����".$seo['keywords'],
					"description"=>"{$screen_name}����ʳ��ר��,".$seo['description']
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
			echo "ɾ���ɹ�";
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
				//�л�token
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