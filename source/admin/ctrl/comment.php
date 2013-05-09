<?php
$_GET['a']=isset($_GET['a'])?htmlspecialchars($_GET['a']):'index';
switch($_GET['a'])
{
	case 'index':
		assignlist("shop_comment",10," AND siteid='$siteid'  ",'',"admin.php?m=comment");
		$smarty->display("comment.html");
		break;
	case '':
	
		break;
	case 'getreply':
			header("Content-type:text/html;charset=gb2312");
			$id=intval($_GET['id']);
			echo $db->getOne("SELECT reply FROM ".table('shop_comment')." WHERE id='$id' ");
			exit;
		break;
		
	case 'reply':
			$id=intval($_POST['id']);
			$content=htmlspecialchars($_POST['content']);
			$db->query("UPDATE ".table("shop_comment")." SET reply='$content' WHERE id='$id' ");
		break;
}

?>