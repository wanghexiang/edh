<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):'index';
switch($_GET['a'])
{
	case 'index':
			$arr=array();
			$pagesize=20;
			$page=max(1,intval($_GET['page']));
			$start=($page-1)*$pagesize;
			$rscount=$db->getOne("select count(1) from ".table('grade_log')." where userid=".$_SESSION['ssuser']['userid']." ");
		
			$smarty->assign("pagelist",multipage($rscount,$pagesize,$page,"index.php?m=grade_log"));
			$res=$db->query("select * from ".table('grade_log')." where userid=".$_SESSION['ssuser']['userid']." order by id desc limit $start,$pagesize ");
			
			while($rs=$db->fetch_array($res))
			{
				$rs['dateline']=date("Y-m-d ",$rs['dateline']);
				$arr[]=$rs;
			}
			$smarty->assign("loglist",$arr);
			//获取可用金额
			$smarty->assign("usegrade",$db->getOne("select usegrade from ".table('user')." where userid='{$_SESSION['ssuser']['userid']}' "));
			
			$smarty->display("grade_log.html");

	
		break;
}

?>