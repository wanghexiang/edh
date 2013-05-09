<?php
function getfollows($userid)
{
	global $db;
	return $db->getCols("SELECT touserid  FROM ".table('follow')." WHERE userid='$userid' ");;
}
?>