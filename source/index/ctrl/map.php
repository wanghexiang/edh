<?php
if(!defined("CT"))
{
	die("IS WRONG");
}

$shopid=intval($_GET['shopid']);
$rs=$db->getRow("SELECT * FROM ".table('shop')." WHERE shopid=".$shopid." limit 1 ");

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=gb2312"/>
<title>餐厅地图</title>

<style type="text/css">
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

#map_canvas {
  height: 100%;
}

@media print {
  html, body {
    height: auto;
  }

  #map_canvas {
    height: auto;
  }
}
#map_canvas{width:100%; height:100%;}
#mapcontent{line-height:25px;}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>

</head>
<body>
  <div id="map_canvas"></div>
<script language="javascript">

var contentString = '<div id="mapcontent">'+
        '商店名称：<?php echo $rs['title'];?><br>'+
		'联系电话：<?php echo $rs['phone'];?><br>'+
		'详细地址：<?php echo $rs['address'];?><br>'+
		'其他说明：<?php echo str_replace(array("\n","\r","\t"),"",nl2br($rs['info']));?><br>'+
        '</div>';
var map = new BMap.Map("map_canvas");
var point = new BMap.Point(<?php echo $rs['lat'].','.$rs['lng'] ?>);
var marker = new BMap.Marker(point);
var infoWindow = new BMap.InfoWindow(contentString);  // 创建信息窗口对象
map.enableScrollWheelZoom();

map.centerAndZoom(point, <?php echo ($_GET['zoom']?intval($_GET['zoom']):15);?>);
<?php if($rs['sendmeter']){
 ?>
var circle = new BMap.Circle(point,<?php echo $rs['sendmeter'] ?>);
circle.setFillColor("#ccd");
circle.setStrokeWeight(1);
map.addOverlay(circle);
<?php
}
?>
map.addOverlay(marker);
marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
/*
marker.addEventListener("click", function(){          
   this.openInfoWindow(infoWindow);
   //图片加载完毕重绘infowindow
   document.getElementById('imgDemo').onload = function (){
       infoWindow.redraw();
   }
});
*/
</script>
</body>
</html>