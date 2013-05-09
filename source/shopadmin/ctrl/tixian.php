<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):'index';
$shopid=$_SESSION['adminshop']['shopid'];
$siteid=$_SESSION['adminshop']['siteid'];
switch($_GET['a'])
{
	case 'index':
			assignlist("shop_tixian",10," AND shopid='$shopid' "," ORDER BY id DESC ","shopadmin.php?m=tixian");
			$smarty->display("tixian.html");
		break;
	case 'apply':
			$balance=$db->getOne("SELECT balance FROM ".table('shop')." WHERE shopid='$shopid' ");
			if($_GET['op']=='post')
			{
				if($_POST['money']<100)
				{
					errback('提现金额不能少于100元');
				}elseif($_POST['money']>$balance)
				{
					errback('提现金额不能大于可提现额度');
				}
				$info=htmlspecialchars(trim($_POST['info']));
				$db->query("INSERT INTO ".table('shop_tixian')." SET money=".intval($_POST['money']).",shopid='$shopid',shopname='".$_SESSION['adminshop']['shopname']."',info='$info',dateline=".time()." ");
				//减去账户金额
				$db->query("UPDATE ".table('shop')." SET balance=balance-".intval($_POST['money'])." WHERE shopid='$shopid' ");
				errback('提现申请提交成功，请稍等！',"shopadmin.php?m=tixian");
			}else
			{
				$smarty->assign("balance",$balance);
				$smarty->display("tixian_apply.html");
			}
			
		break;
}

?>