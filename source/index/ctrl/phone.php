<?php

switch($_GET['a'])
{
	case 'android':
			$smarty->display("android.html");
		break;
		
	case 'iphone':
			$smarty->display("iphone");
	
		break;
}

?>