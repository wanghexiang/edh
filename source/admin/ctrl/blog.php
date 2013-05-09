<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):'index';
switch($_GET['a'])
{
	case 'index':
			assignlist('blog',10,"","ORDER BY dateline DESC ","admin.php?m=blog");
			$smarty->display("blog.html");
		break;
	case 'del':
			$id=intval($_GET['id']);
			$db->query("DELETE FROM ".table('blog')." WHERE id='$id' ");
		break;
}
?>