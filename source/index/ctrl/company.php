<?php
$_GET['a']=$_GET['a']?htmlspecialchars($_GET['a']):'default';
switch($_GET['a'])
{
	case 'default':
			
			$smarty->display("company.html");	
		break;
	case 'edi':
		
		break;
	case 'shop':
		
		break;
	case 'info':
	
		break;
	case '':
	
		break;
}
?>