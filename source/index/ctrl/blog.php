<?php
check_login();

require_once(ROOT_PATH."source/function/function_follow.php");
$_GET['a']=$_GET['a']?htmlspecialchars(trim($_GET['a'])):'index';
switch($_GET['a'])
{
	case 'index':
			//前期试用			 
			$uids=getfollows(intval($_SESSION['ssuser']['userid']));
			$uids=array_merge(array(intval($_SESSION['ssuser']['userid'])),$uids);
			assignlist('blog',10," AND siteid='$cksiteid' AND userid in("._implode($uids).")",' ORDER BY id DESC','index.php?m=blog');
		$smarty->display("blog.html");
		break;
	case 'my':
		assignlist('blog',10,'',"ORDER BY id DESC",'index.php?m=blog');
		$smarty->display("blog.html");
		break;
	case 'post':
			$content=htmlspecialchars(removelink($_POST['content']));
			//@at 解析 返回 array($userids,$content);
			$arr=Analyticat($content);

			$db->query("INSERT INTO ".table('blog')." SET siteid='$cksiteid',userid='{$_SESSION['ssuser']['userid']}',nickname='{$_SESSION['ssuser']['nickname']}',content='{$arr[1]}',dateline=".time()." ");
			 
			$id=$db->insert_id();
			if($arr[0])
			{			  
				  $content=$arr[1]." <a href=\'index.php?m=blog&a=show&id={$id}\'>点击查看</a>";
				  foreach($arr[0] as $touserid)
				  {
					  $db->query("INSERT INTO ".table('at')." SET userid='{$_SESSION['userid']}',touserid='$touserid',content='$content',dateline=".time()." ");
				  }
 
			}
			$db->query("UPDATE ".table('user')." SET blogs=blogs+1 WHERE userid='{$_SESSION['ssuser']['userid']}' ");
			//删除cookie
			setcookie("content","",time()-30);
			gourl();
		break;
	case 'show':
			$blogid=intval($_GET['blogid']);
			$blog=$db->getRow("SELECT * FROM ".table('blog')." WHERE id='$blogid' ");
			
			$smarty->assign("blog",$blog);
			assignlist("blog_comment","10", " AND blogid='$blogid' AND forbid=0 "," ORDER BY dateline DESC ","index.php?m=blog&a=show&blogid=$blogid");
			$smarty->display("blog_comment.html");
			
		break;
	case 'ajaxcommentlist':
			header("Content-type:text/html;charset=gb2312");
			$blogid=intval($_GET['blogid']);
			assignlist("blog_comment","10", " AND blogid='$blogid' AND forbid=0 "," ORDER BY dateline DESC ","index.php?m=blog&a=show&blogid=$blogid");
			$smarty->display("blog_ajaxcommentlist.html");
		break;
	case "commentpost":
			header("Content-type:text/html;charset=gb2312");
			$blogid=intval($_GET['blogid']);
			$content=iconv("utf-8","gb2312",htmlspecialchars(trim($_POST['content'])));
			$userid=intval($_SESSION['ssuser']['userid']);
			$nickname=$_SESSION['ssuser']['nickname'];
			$db->query("INSERT INTO ".table('blog_comment')." SET siteid='$cksiteid',blogid='$blogid',userid='$userid',nickname='$nickname',content='$content',dateline=".time()." ");
			$db->query("UPDATE ".table('blog')." SET comments=comments+1 WHERE id='$blogid' ");
			assignlist("blog_comment","10", " AND blogid='$blogid' AND forbid=0 "," ORDER BY dateline DESC ","index.php?m=blog&a=show&blogid=$blogid");
			$smarty->display("blog_ajaxcommentlist.html");
		break;
}

?>