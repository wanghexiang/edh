<?php

$smarty->assign("menu",2);
$a=$_GET['a']?$_GET['a']:$_POST['a'];
if(empty($a))
{
	$a='index';
}
checkpermission("rank",$a);
if($a=='index')
{
	if($_POST)
	{
		$rank_name=$_POST['rank_name'];
		$mingrade=$_POST['mingrade'];
		$maxgrade=$_POST['maxgrade'];
		$discount=$_POST['discount'];
		$new_rank_name=trim(strip_tags($_POST['new_rank_name']));
		$new_mingrade=intval($_POST['new_mingrade']);
		$new_maxgrade=intval($_POST['new_maxgrade']);
		$new_discount=intval($_POST['new_discount']);
		if(is_array($rank_name))
		{
			foreach($rank_name as $key=>$val)
			{
				$db->query("update ".table('user_rank')." set rank_name='{$rank_name[$key]}',min_grade='{$mingrade[$key]}',max_grade='{$maxgrade[$key]}',discount='{$discount[$key]}' where id='$key' ");
				
			}
			
		}
		if($new_rank_name)
			{
				$db->query("insert into ".table('user_rank')." set rank_name='$new_rank_name',min_grade='$new_mingrade',max_grade='$new_maxgrade',discount='$new_discount' ");
			}
			header("Location: admin.php?m=rank&");
	}else
	{
		$smarty->assign("ranklist",$db->getAll("select * from ".table('user_rank')." order by id desc   "));
		$smarty->display("rank.html");	
	}
	
}elseif($a=='del')
{
	$id=intval($_GET['id']);
	$db->query("delete from ".table('user_rank')." where id='$id' ");
	gourl();
}

?>