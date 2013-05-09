<?php
/*管理*/
function onindex(){
	global $db,$smarty,$siteid;
	
	assignlist("seo",20," AND siteid='$siteid' "," order by m DESC ","admin.php?m=seo&a=index");
	$smarty->display("seo.html");	
}
/*添加*/
function onAdd(){
	global $db,$smarty,$siteid;
	$id=get_post('id');	
	if($id){
		$seo=$db->getRow("SELECT * FROM ".table('seo')." WHERE id='$id' AND siteid='$siteid' ");	
		$smarty->assign("seo",$seo);
	}
	$smarty->display("seo_add.html");	
}

/*保存*/
function onSave(){
	global $db,$siteid;
	$id=get_post('id');
	$data['cname']=post('cname');
	$data['m']=post('m');
	$data['a']=post('a');
	$data['title']=post('title');
	$data['description']=post('description');
	$data['keywords']=post('keywords');
	$data['siteid']=$siteid;
	if($id){
		$db->update("seo",$data," AND id='$id' ");
	}else{
		$db->insert("seo",$data);
	}
	gourl();
}

function onDel(){
	global $db,$siteid;
	$id=get_post('id');
	$db->delete("seo"," AND id='$id' ");
}


?>