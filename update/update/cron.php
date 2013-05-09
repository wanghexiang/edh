<?php
set_time_limit(0);
//curl_get_contents("http://www.tiaoshike.com/index.php?m=stole&a=getcontent");
//curl_get_contents("http://www.tiaoshike.com/m-weibo-a-getweibo.html");
for($i=0;$i<10000000;$i++){
	curl_get_contents("http://t1.hck.com/hck/index.php?m=weibo&a=souser");
}
echo "Ë÷Òý³É¹¦";
function curl_get_contents($url,$timeout=300){
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $url);
	 curl_setopt($ch, CURLOPT_HEADER, 0);
	 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	 $content= curl_exec($ch);
	 curl_close($ch);
	 return $content;
}

?>