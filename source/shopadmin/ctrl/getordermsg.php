<?php

check_login();
$shopid=$_SESSION['adminshop']['shopid'];
$num=$db->getOne("SELECT COUNT(1) FROM ".table('`order`')." WHERE sendtype=0 AND shopid='$shopid' AND isvalid=1 ");
if($num)
{
	echo 1;
}

?>