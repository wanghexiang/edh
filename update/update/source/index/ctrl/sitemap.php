<?php
set_time_limit(0);
header("Content-type:text/html;charset=gbk");
//文章列表
$artlist=$db->getAll("SELECT id,title,dateline FROM ".table('art')." order by id desc limit 10000 ");
$str2="";
$str='<?xml version="1.0" encoding="utf-8"?>';
$str.='<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
if($artlist){
	foreach($artlist as $v){
		$str2 .= "<a href='http://www.tiaoshike.com/m-art-id-{$v['id']}.html' target='_blank'>{$v['title']}</a>\r\n<br>";
		$str.="<url><loc>http://www.tiaoshike.com/m-art-id-{$v['id']}.html</loc><lastmod>".date("Y-m-d",$v['dateline'])."</lastmod></url>";
	}
}
//店铺
$shoplist=$db->getALl("SELECT shopid,shopname,dateline FROM ".table('shop')." order by shopid DESC limit 10000 ");
if($shoplist){
	foreach($shoplist as $v){
		$str2.="<a href='http://www.tiaoshike.com/m-shop-shopid-{$v['shopid']}.html'>{$v['shopname']}</a>\r\n<br>";
		$str.="<url><loc>http://www.tiaoshike.com/m-shop-shopid-{$v['shopid']}.html</loc><lastmod>".date("Y-m-d",$v['dateline'])."</lastmod></url>";
	}
}
//菜谱
$caipulist=$db->getAll("SELECT id,title,dateline FROM ".table('caipu')." order by id DESC limit 10000 ");
if($caipulist){
	foreach($caipulist as $v){
		$str2.="<a href='http://www.tiaoshike.com/m-caipu-a-show-id-{$v['id']}.html' target='_blank'>{$v['title']}</a>\r\n<br>";
		$str.="<url><loc>http://www.tiaoshike.com/m-caipu-a-show-id-{$v['id']}.html</loc><lastmod>".date("Y-m-d",$v['dateline'])."</lastmod></url>";
	}
}
$str.='</urlset>';
file_put_contents(ROOT_PATH."sitemap.xml",$str);
file_put_contents(ROOT_PATH."sitemap.html",$str2);
echo "生成成功";
?>