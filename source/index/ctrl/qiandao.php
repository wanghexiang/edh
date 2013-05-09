<?php
$a=get('a');
$a=$a?$a:"index";
$userid=intval($_SESSION['ssuser']['userid']);
check_login();
switch($a){
	case 'add':
			$smarty->display("qiandao_add.html");
		break;
	case 'check':
			$day=date("Y-m-d");
			if(!$db->getOne("SELECT id FROM ".table('qiandao')." WHERE userid='$userid' AND day='$day' ")){
				echo 0;
			}else{
				echo 1;
			}
			exit;
		break;
	case 'post':
			header("Content-type:text/html;charset=gb2312");
			$day=date("Y-m-d");
			$lastday=date("Y-m-d",time()-3600*24);
			
			$times=$db->getOne("SELECT times FROM ".table('qiandao')." WHERE userid='$userid' AND day='$lastday' order by id desc ");
		 	 
			if(!$db->getOne("SELECT id FROM ".table('qiandao')." WHERE userid='$userid' AND day='$day' ")){
				$data['userid']=$userid;
				$data['dateline']=time();
				$data['xinqing']=htmlspecialchars(get_post('xinqing'));
				$data['content']=htmlspecialchars(post('content'));
				$data['siteid']=intval($cksiteid);
				$grade=intval($times)+1;
				if($grade>MAXGRADE){
					$grade=MAXGRADE;
				}
				$data['times']=$grade;
				$data['day']=$day;
				$db->insert("qiandao",$data);
				$db->query("update ".table('user')." set grade=grade+'$grade',usegrade=usegrade+'$grade' where userid='$userid' ");
				errback("签到成功,您获得了{$grade}积分,连续签到可以加更多分哦");
			}else{
				errback("你已经签到过了");
			}
		break;	
		
	case 'index':
			assignlist("qiandao",20," AND userid='$userid' "," order by id desc","index.php?m=qiandao");
			$smarty->display("qiandao.html");
		break;
}

?>