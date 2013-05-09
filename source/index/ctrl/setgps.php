<?php
$lat=floatval($_GET['lat']);
$lng=floatval($_GET['lng']);

if($lat && $lng)
{
	list($lat,$lng)=gps2baidu($lat,$lng);	
	$_SESSION['ss_latlng']=$lat."-".$lng."-".time();
	$_SESSION['ssuser']['lng']=$lat;
	$_SESSION['ssuser']['lat']=$lng;
	$db->query("INSERT INTO ".table('user_gps')." SET lat='$lat',lng='$lng',userid=".intval($_SESSION['ssuser']['userid']).",dateline=".time()." ");
	echo "OK";	 
}
?>