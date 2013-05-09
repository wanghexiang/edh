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
//获取二级地区
function onCity(){
	global $smarty,$db,$cksiteid;
    $provinceid=intval($_GET['provinceid']);
	$citys=$db->getAll("SELECT * FROM ".table('city')." where provinceid='$provinceid'");
	$str="<ul><li style='width:404px;height:25px;text-align:right;line-height: 25px;'><a onclick='hide()' href='#' style='background:none; color:#7A7A7A;'>关闭&nbsp;</a></li>";
	foreach($citys as $k=>$v){
		$cityid=$v['cityid'];
		$str.="<li><a onclick='gettowns($cityid)' href='#'>".iconv("GB2312","UTF-8",$v['city'])."</a></li>";
	}
	if(empty($citys))
	$str.="<font color='green'>该地区暂无信息!</font><br/>";
	$str.="</ul>";
	echo $str;
}
//获取三级地区
function onTown(){
	global $smarty,$db,$cksiteid;
    $cityid=intval($_GET['cityid']);
	$towns=$db->getAll("SELECT * FROM ".table('town')." where cityid='$cityid'");
	$str="<ul><li style='width:403px;height:25px;text-align:right;line-height: 25px;'><a onclick='hide()' href='#'>关闭&nbsp;</a></li>";
	foreach($towns as $k=>$v){
		$townid=$v['townid'];
		$str.="<li><a href='index.php?m=shoplist&townid=$townid'>".iconv("GB2312","UTF-8",$v['town'])."</a></li>";
	}
	$str.="</ul>";
	echo $str;
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