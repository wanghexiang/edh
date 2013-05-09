<?php

check_login();
$num=$db->getOne("SELECT COUNT(1) FROM ".table('order')." WHERE sendtype=0  AND isvalid=1 AND siteid=".$_SESSION['ssadmin']['siteid']." ");
if($num)
{
	echo 1;
}

?>