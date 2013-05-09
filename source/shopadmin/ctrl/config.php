<?php

check_login();
$a=$_REQUEST['a'];
if(empty($a))
{
	$a='index';
}
$shopid=$_SESSION['adminshop']['shopid'];

if($a=='index')
{
	
	$config=$db->getRow("select * from ".table('shopconfig')." WHERE shopid='$shopid' ");
	if(!$config)
	{
		$db->query("insert into ".table('shopconfig')." set shopid='$shopid' ");
	}
	
	$smarty->assign("rs",$config);
	$smarty->display("config.html");
}elseif($a=='db')
{
	
		$opentime=intval($_POST['opentime']);
		$starthour=intval($_POST['starthour']);
		$startminute=intval($_POST['startminute']);
		$endhour=intval($_POST['endhour']);
		$endminute=intval($_POST['endminute']);
		$showweek=intval($_POST['showweek']);
		$minprice=floatval($_POST['minprice']);
		$email=htmlspecialchars($_POST['email']);
		$isemail=htmlspecialchars($_POST['isemail']);
		$sendprice=floatval($_POST['sendprice']);
		$ordertype=intval($_POST['ordertype']);
		$telephone=trim($_POST['telephone']);
		$db->query("update ".table('shopconfig')." set opentime='$opentime',starthour='$starthour',startminute='$startminute',endhour='$endhour',endminute='$endminute',showweek='$showweek',minprice='$minprice',email='$email',isemail='$isemail',sendprice='$sendprice',ordertype='$ordertype',telephone='$telephone' WHERE shopid='$shopid'");
		
		gourl();
	
}


?>