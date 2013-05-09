<?php
set_time_limit(0);
require_once("config/sina_config.php");
require_once("api/sina/saetv2.ex.class.php");

$tokenarr=array(
				"2.00Ry9i9Bxk_VOEb254444d3fJT_LOE",
				"2.00aqQLXCxk_VOE08774d2693hBOv2E",
				"2.00qh6sKCxk_VOE0e070b01cc0RHEjT",
				"2.00sz_LXCxk_VOE1e9bed0588yGOKDC",
				"2.00SwFMaCxk_VOE33a0776254pCfk5B",
				"2.00y5xdvCxk_VOE1bda3f811eGWBu4E",
				"2.00Me_evCxk_VOE5d4f241f397vG2ZE",
				"2.00YnyBBDxk_VOE69df5deb9f9CRX1C",
				"2.00o2jBBDxk_VOEa8241dc6a1zAzagE",
				"2.00k4ACBDxk_VOE77f16b8cd50lZyuE",
				"2.00SJlBBDxk_VOE9f0d40dbddslWWWB",
				 
);
$fp=fopen("s.txt","a+");
$str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

 
	$str=str_shuffle($str);
	$token="2.00".substr($str,0,6)."xk_VOE".substr($str,0,16);
	// echo $token."<br>";
	$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,"2.005wiK1exk_VOE5wiK1edUhTcGayq4");
	$a=$c->bilateral("1197161814",1,1);
	print_r($a);
	if($a['error']!='invalid_access_token'){
		 
		 fwrite($fp,$token."\r\n");
		 exit('找到');
	}

 
fclose($fp);
?>