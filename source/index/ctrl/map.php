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
<title>������ͼ</title>

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
        '�̵����ƣ�<?php echo $rs['title'];?><br>'+
		'��ϵ�绰��<?php echo $rs['phone'];?><br>'+
		'��ϸ��ַ��<?php echo $rs['address'];?><br>'+
		'����˵����<?php echo str_replace(array("\n","\r","\t"),"",nl2br($rs['info']));?><br>'+
        '</div>';
var map = new BMap.Map("map_canvas");
var point = new BMap.Point(<?php echo $rs['lat'].','.$rs['lng'] ?>);
var marker = new BMap.Marker(point);
var infoWindow = new BMap.InfoWindow(contentString);  // ������Ϣ���ڶ���
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
marker.setAnimation(BMAP_ANIMATION_BOUNCE); //�����Ķ���
/*
marker.addEventListener("click", function(){          
   this.openInfoWindow(infoWindow);
   //ͼƬ��������ػ�infowindow
   document.getElementById('imgDemo').onload = function (){
       infoWindow.redraw();
   }
});
*/
</script>
</body>
</html>