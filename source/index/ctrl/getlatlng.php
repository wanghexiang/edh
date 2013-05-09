<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>地图标注</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
 
</head>

<body>
<div style="width:60%; height:100%; float:left; display:block;"><div id="map_canvas" style="width:100%; height:400px; "></div></div>
<div style="width:35%; height:100%; float:right;">地理位置：<br /><input name="area" type="text" id="area" value="118.18045211417393,24.481007243304155 " style="width:90%;" /> <br />点击地图标注 复制以上信息即可</div>


<script type="text/javascript">

		var map = new BMap.Map("map_canvas");
		var point = new BMap.Point( 118.1804,24.4810 );
		map.centerAndZoom(point, 14);
		map.enableScrollWheelZoom();
		var marker = new BMap.Marker(point);
		map.addOverlay(marker);
		 
		map.addEventListener("click", function(e){
		  document.getElementById("area").value=e.point.lng + ", " + e.point.lat;
		  var newpoint=new BMap.Point(e.point.lng,e.point.lat);
		  map.clearOverlays(marker);
		 marker = new BMap.Marker(newpoint);
		  map.addOverlay(marker);
		});

</script>

</div>
</div>
</div>

</body>
</html>
