<?php
function onIndex(){
	global $smarty,$db,$cksiteid;
	$shopid=get('shopid','i');
	getshopinfo($shopid,1);
	assignlist("room",100," AND shopid='$shopid'  ","");
	$neworder=$db->getAll("SELECT * FROM ".table('roomorder')." WHERE order_time>".time()." AND status=1 ORDER BY order_time ASC ");
	$smarty->assign(
		array(
		"neworder"=>$neworder,
		 
		)
		);
	$smarty->display("room.html");
	
}

function onShow(){
	global $smarty,$db,$cksiteid;
	$id=get('id','i');
	$rs=$db->getRow("SELECT * FROM ".table('room')." WHERE id='$id' ");
	if(!$rs) errback("包间不存在","index.php");
	$neworder=$db->getAll("SELECT * FROM ".table('roomorder')." WHERE roomid='$id' AND status=1 AND order_time>".time()." ORDER BY order_time ASC,id ASC ");
	$smarty->assign("neworder",$neworder);
	getshopinfo($rs['shopid'],1);
	$smarty->assign(
		array(
			"room"=>$rs,
			 
		)
	);
	$smarty->display("room_show.html");
}

function onOrder(){
	global $smarty,$db,$cksiteid;
	check_login();
	$roomid=get_post('roomid','i');
	$rs=$db->getRow("SELECT * FROM ".table('room')." WHERE id='$roomid' ");
	if(!$rs) errback("包间不存在","index.php");
	$data['room_name']=$rs['room_name'];
	$data['room_men']=$rs['room_men'];
	$data['siteid']=$cksiteid;
	$data['shopid']=get_post('shopid','i');
	$data['roomid']=$roomid;
	$data['userid']=intval($_SESSION['ssuser']['userid']);
	$data['nickname']=post('nickname','h');
	if(empty($data['nickname'])) errback("昵称不能为空");
	$data['telephone']=post('telephone','h');
	if(empty($data['telephone'])) errback("电话不能为空");
	$data['info']=post('info');
	$data['order_time']=strtotime(post('order_time'));
	
	$data['dateline']=time();
	$db->insert("roomorder",$data);
	errback("预定成功，请等待审核");
}

function onMy(){
	global $smarty,$db,$cksiteid;
	check_login();
	$pagesize=20;
	$page=max(1,get('page',"i"));
	$start=($page-1)*$pagesize;
	$list=$db->getAll("SELECT * FROM ".table('roomorder')." WHERE  userid=".intval($_SESSION['ssuser']['userid'])." order by id DESC LIMIT $start,$pagesize ");
	if($list){
		foreach($list as $k=>$v){
			
			$list[$k]['shopname']=$db->getOne("SELECT shopname FROM ".table('shop')." WHERE shopid='{$v['shopid']}' ");
		}
	}
	$rscount=$db->getOne("SELECT count(*) FROM  ".table('roomorder')." WHERE  userid=".intval($_SESSION['ssuser']['userid'])." ");
	$pagelist=multipage($rscount,$pagesize,$page,"index.php?m=room&a=my");
	
	$smarty->assign(
		array(
			"pagelist"=>$pagelist,
			"rscount"=>$rscount,
			"list"=>$list
		)
	);
	$smarty->display("room_order_my.html");
	
}
?>