<?php

if($_GET['shopid'] && $_SESSION['ssadmin'] )
{
	$_SESSION['adminshop']=$db->getRow("SELECT siteid,shopid,shopname FROM ".table('shop')." WHERE shopid=".intval($_GET['shopid'])." ");
}elseif($_GET['shopid'] && $_SESSION['ssuser']['userid'])
{
	$shop=$db->getRow("SELECT siteid,shopid,shopname,status FROM ".table('shop')." WHERE shopid=".intval($_GET['shopid'])." AND userid=".intval($_SESSION['ssuser']['userid'])." ");
	if($shop['shopid'])
	{
		if($shop['status'])
		{
			$_SESSION['adminshop']=$shop;
		}else
		{
			errback("��ȴ����");
		}
	}else
	{
		errback("����Ȩ��");
	}
}else
{
	echo "<script>alert('���޴�Ȩ��');window.close()</script>";
}
header("Location:shopadmin.php?m=iframe");
?>