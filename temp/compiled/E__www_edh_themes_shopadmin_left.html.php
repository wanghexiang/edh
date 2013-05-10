<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>管理后台</title>
<link type="text/css" rel="stylesheet" href="<?php echo $this->_var['skins']; ?>css.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript">
$(document).ready(function()
{
		$(".mtitle").click(function()
	{
		if($(this).next(".menu").css("display")=="block")
		{
			$(".menu").css("display","none")
		}else
		{
			$(".menu").css("display","none")
			$(this).next(".menu").css({display:"block"});
		}
	});
	$("ul li a:eq(0)").addClass('on'); 
	$('ul li a').click(function(){
		$('ul li a').removeClass('on');
		$(this).addClass('on');
	});
});
</script>
</head>

<body id="menu-body">


<div class="mtitle">网站管理</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="shopadmin.php?m=order" target="main-frame">订单管理</a></li>
<li><a href="shopadmin.php?m=groupbuy&a=order" target="main-frame">团购订单</a></li>
<li><a href="shopadmin.php?m=guest" target="main-frame">留言管理</a></li>
<li><a href="shopadmin.php?m=comment" target="main-frame">店铺评论</a></li>
<li><a href="shopadmin.php?m=map" target="main-frame">店铺地图</a>
<li><a href="shopadmin.php?m=shop" target="main-frame">店铺信息</a>
<li><a href="shopadmin.php?m=config" target="main-frame">店铺设置</a></li>
<li><a href="shopadmin.php?m=paylog" target="main-frame">收支记录</a></li>
<li><a href="shopadmin.php?m=tixian" target="main-frame">提现记录</a></li>
<li><a href="shopadmin.php?m=shop&a=check" target="main-frame">纠错管理</a></li>
</ul>
</div>



<div class="mtitle">美食模块</div>
<div class="menu"    >
<ul>
<li><a href="shopadmin.php?m=cai" target="main-frame">美食管理</a></li>
<li><a href="shopadmin.php?m=cai&a=add" target="main-frame">美食添加</a></li>
<li><a href="shopadmin.php?m=cai_comment" target="main-frame">美食评论</a></li>
<li><a href="shopadmin.php?m=cai_cat" target="main-frame">美食分类</a></li>
<li><a href="shopadmin.php?m=cai&a=import" target="main-frame">美食导入</a></li>
</ul>
</div>

<div class="mtitle">餐位模块</div>
<div class="menu">
<ul>
<li><a href="shopadmin.php?m=room" target="main-frame">餐位管理</a></li>
<li><a href="shopadmin.php?m=room&a=order" target="main-frame">预定管理</a></li>
<li><a href="shopadmin.php?m=room&a=add" target="main-frame">餐位添加</a></li>
</ul>
</div>


<div class="mtitle">美食团购</div>
<div class="menu"  >
<ul>
<li><a href="shopadmin.php?m=groupbuy" target="main-frame">团购管理</a></li>
<li><a href="shopadmin.php?m=groupbuy&a=add" target="main-frame">团购添加</a></li>
<li><a href="shopadmin.php?m=groupbuy&a=order" target="main-frame">团购订单</a></li>
<li><a href="shopadmin.php?m=groupbuy&a=order&s=1" target="main-frame">今日订单</a></li>
<li><a href="shopadmin.php?m=groupbuy&a=order&s=2" target="main-frame">明日订单</a></li>
</ul>
</div>


<div class="mtitle">管理员</div>
<div class="menu"  >
<ul>
<li><a href="shopadmin.php?m=admin" target="main-frame">管理员</a></li>
<li><a href="shopadmin.php?m=admin&a=add"  target="main-frame">管理员添加</a></li>
</ul>
</div>






</body>
</html>