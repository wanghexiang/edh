<?php
/**
所有的app通用的
*/
/*获取单页*/
function gethtml($tagname)
{
	
	return $GLOBALS['db']->getOne("SELECT content FROM ".table('html')." WHERE tagname='$tagname'  ");
}

function assignlist($table,$pagesize=10,$w='',$ord='',$url='')
{
		global $db,$smarty;
		$page=max(1,intval($_GET['page']));
		$start=($page-1)*$pagesize;
		$rscount=$db->getCount($table,$w);
		$list=$db->select(array("table"=>$table,"where"=>$w,"order"=>$ord,"start"=>$start,"pagesize"=>$pagesize));
		$pagelist=multipage($rscount,$pagesize,$page,$url);
		$smarty->assign("rscount",$rscount);
		$smarty->assign("list",$list);
		$smarty->assign("pagelist",$pagelist);
}

/*发送消息*/
function sendMessage($userid,$content)
{
 	$content=addslashes_deep($content);
	$GLOBALS['db']->query("INSERT INTO ".table('message')." SET userid='$userid',content='$content',dateline=".time()." ");
}


?>