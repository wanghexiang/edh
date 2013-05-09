<?php
function onIndex(){
	global $smarty,$db,$siteid,$shopid;	
	assignlist("room",20," AND shopid='$shopid' ","","shopadmin.php?m=room");
	$smarty->display("room.html");
}
 
function onAdd(){
	global $smarty,$db,$siteid,$shopid;	
	$id=intval(get_post('id'));
	if($id){
		$room=$db->getRow("SELECT * FROM ".table('room')." WHERE id='$id' AND shopid='$shopid' ");
		$smarty->assign("rs",$room);
	}
	$smarty->display("room_add.html");
}

function onSave(){
	global $smarty,$db,$siteid,$shopid;
	$id=intval(get_post('id'));
	$data['room_name']=post('room_name',"h");
	$data['room_type']=post('room_type',"i");
	$data['room_men']=post('room_men','h');
	$data['room_pic']=post('room_pic',"h");
	$data['room_desc']=post('room_desc','h');
	$data['room_content']=post('room_content');
	if($id){
		$db->update("room",$data," AND id='$id' AND shopid='$shopid' ");
	}else{
		$data['siteid']=$siteid;
		$data['shopid']=$shopid;
		$db->insert("room",$data);	
	}
	gourl();
}

function onDel(){
	global $smarty,$db,$siteid,$shopid;
	$id=intval(get_post('id'));
	$db->delete("room"," AND id='$id' ");	
}

function onOrder(){
	global $smarty,$db,$siteid,$shopid;
	$status=intval(get_post('status'));
	if($status){
		$order=" order by id DESC ";
	}else{
		$order=" order by order_time ASC ";
	}
	assignlist("roomorder",20," AND shopid='$shopid' AND status='$status'  ",$order,"shopadmin.php?m=room&a=order&status=$status");
	$smarty->display("room_order.html");
}

function onChangeStatus(){
	global $smarty,$db,$siteid,$shopid;
	$id=intval(get('id'));
	$status=get('status',"i");
	$db->update("room",array("status"=>$status)," AND id='$id' AND shopid='$shopid' ");
}

function onOrderStatus(){
	global $smarty,$db,$siteid,$shopid;
	$id=intval(get('id'));
	$status=get('status',"i");
	$db->update("roomorder",array("status"=>$status)," AND id='$id' AND shopid='$shopid' ");
}

function onOrderDel(){
	global $smarty,$db,$siteid,$shopid;
	$id=intval(get('id'));
	$db->update("roomorder",array("status"=>99)," AND id='$id' AND shopid='$shopid' ");
	
}

function onGetOrderReply(){
	global $smarty,$db,$siteid,$shopid;
	header("Content-type:text/html;charset=gb2312");
	$id=intval(get('id'));
	$reply=$db->getOne("SELECT reply FROM ".table('roomorder')." WHERE id='$id' ");
	echo $reply;
}

function onOrderReply(){
	global $smarty,$db,$siteid,$shopid;
	$id=intval(get_post('id'));
	$data['reply']=iconv("utf-8","gbk",get_post('content',"h"));
	$db->update("roomorder",$data," AND id='$id' ");
}

?>