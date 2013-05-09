<?php
require_once("config/sina_config.php");
require_once("api/sina/saetv2.ex.class.php");
$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,"2.00Ry9i9BgGFRIC984f85c5133cp6fC" );
//$c->upload($content,$imgurl);
//$a=$c->bilateral(1690015640);
$a=$c->get_tags(1340468041);
$tags="";
foreach($a as $k=>$v){
	$tags .= array_shift($v) ." ";
}
echo $tags;
?>