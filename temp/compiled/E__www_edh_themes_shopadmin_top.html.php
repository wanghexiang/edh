<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>���¹���</title>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="<?php echo $this->_var['skins']; ?>js/common.js"></script>
<script language="javascript">
$(document).ready(function()
{
setInterval("play()",6000);
});


function play()
{  
	if($("#isplay").is(":checked"))
	{	
		
		$.get("shopadmin.php?m=getordermsg&",function(data)
		{
			
			if(data)
			{	
				playstop();
				playstart();
			}
		});
	}
	
	
}

	function playstart()
	{
		if(!document.all)
		{
			$("#playmsg").html('<audio src="<?php echo $this->_var['skins']; ?>images/sms.mp3" autoplay ></audio>')
		}else
		{
		$("#playmsg").html("<embed src=\"<?php echo $this->_var['skins']; ?>images/sms.mp3\" style=\"HEIGHT: 0px; WIDTH: 0px\" type=audio/mpeg AUTOSTART=\"1\" loop=\"0\"></EMBED>");
		}
	}
	function playstop()
	{
	$("#playmsg").html("");
	}
	
	
	
	
</script>


<link href="<?php echo $this->_var['skins']; ?>css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="playmsg" ></div>
<div class="top">
<div class="logo"><img src="<?php echo $this->_var['skins']; ?>images/logo.gif" /></div>
<div class="topnav" id="topnav">
<a class="on">
<?php 
echo $_SESSION['adminshop']['shopname'];
?></a></div>
<div class="header">
���ã�<?php echo $_SESSION['ssadminshop']['adminname'];?> 
<a href="shopadmin.php?m=logint&a=logout" target="_parent">�˳�����</a>
<a href="shopadmin.php?m=main&" target="main-frame">������ҳ</a>
<a href="index.php?m=shop&shopid=<?php echo  $_SESSION['adminshop']['shopid'] ?>" target="_blank">������ҳ</a>
<input type="checkbox" id="isplay" value="1"  checked="checked"/> <label for='isplay'>��ʾ����</label> 
</div>
</div>
</body>
</html>