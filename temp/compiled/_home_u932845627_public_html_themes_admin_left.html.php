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
	parent['main-frame'].location.href=$("a:eq(0)").attr("href");
	$("ul li a:eq(0)").addClass('on'); 
	$('ul li a').click(function(){
		$('ul li a').removeClass('on');
		$(this).addClass('on');
	});
});
</script>
</head>

<body id="menu-body">
<?php if ($_GET['a'] == 'shop'): ?>
<div class="mtitle">店铺管理</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="admin.php?m=shop" target="main-frame">店铺管理</a></li>
<li><a href="admin.php?m=shop&a=add" target="main-frame">店铺添加</a></li>
<li><a href="admin.php?m=shop&a=cat" target="main-frame">店铺分类</a></li>
<li><a href="admin.php?m=shop&a=sendmoney" target="main-frame">起送金额</a></li>
<li><a href="admin.php?m=shop&a=avgmoney" target="main-frame">人均消费</a></li>
<li><a href="admin.php?m=shop&a=apply" target="main-frame">申请管理</a></li>
<li><a href="admin.php?m=hotarea" target="main-frame">热点商圈</a></li>
<li><a href="admin.php?m=shop&a=check" target="main-frame">纠错管理</a></li>
<li><a href="admin.php?m=province" target="main-frame">一级区域</a></li>
<li><a href="admin.php?m=city" target="main-frame">二级区域</a></li>
<li><a href="admin.php?m=town" target="main-frame">三级区域</a></li>
</ul>
</div>
<?php endif; ?>


<?php if ($_GET['a'] == 'config'): ?>
<div class="mtitle">网站设置</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="admin.php?m=web" target="main-frame">网站信息</a></li>
<li><a href="admin.php?m=seo" target="main-frame">seo优化</a></li>
<li><a href="admin.php?m=rank" target="main-frame">积分等级</a></li>
<li><a href="admin.php?m=config&a=spread" target="main-frame">推广设置</a></li>
<li><a href="admin.php?m=config&a=thumb" target="main-frame">缩略图设置</a></li>
<li><a href="admin.php?m=config&a=phone" target="main-frame">短信设置</a></li>
<li><a href="admin.php?m=config&a=email" target="main-frame">邮箱设置</a></li>
<li><a href="admin.php?m=config&a=water" target="main-frame">水印设置</a></li>
<li><a href="admin.php?m=config&a=rewrite" target="main-frame">伪静态设置</a></li>

<li><a href="admin.php?m=config&a=pay" target="main-frame">支付设置</a></li>


</ul>
</div>
<?php endif; ?>

<?php if ($_GET['a'] == 'yewu'): ?>
<div class="mtitle">业务管理</div>
<div class="menu" style="display:block;">
<ul>

<li><a href="admin.php?m=order" target="main-frame">订单管理</a></li>
<li><a href="admin.php?m=goods_order" target="main-frame">积分兑换</a></li>
<li><a href="admin.php?m=paylog" target="main-frame">充值消费记录</a></li>
<li><a href="admin.php?m=grade_log" target="main-frame">积分兑换记录</a></li>
<li><a href="admin.php?m=tixian" target="main-frame">提现管理</a></li>
<li><a href="admin.php?m=ad" target="main-frame">广告管理</a></li>
</ul>
</div>
<?php endif; ?>

<?php if ($_GET['a'] == 'con' || ! $_GET['a']): ?>
<div class="mtitle">网站管理</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="admin.php?m=blog" target="main-frame">说说管理</a></li>
<li><a href="admin.php?m=comment" target="main-frame">店铺评论</a></li>
<li><a href="admin.php?m=guest" target="main-frame">留言管理</a></li>
<li><a href="admin.php?m=flash" target="main-frame">轮显管理</a></li>
<li><a href="admin.php?m=web_nav" target="main-frame">导航管理</a></li>

<li><a href="admin.php?m=html" target="main-frame">单页管理</a></li>
<li><a href="admin.php?m=link" target="main-frame">链接管理</a></li>

</ul>
</div>

<div class="mtitle">文章模块</div>
<div class="menu" >
<ul>

<li><a href="admin.php?m=art" target="main-frame">文章管理</a></li>
<li><a href="admin.php?m=art&a=add" target="main-frame">文章添加</a></li>
<li><a href="admin.php?m=art_cat" target="main-frame">文章分类</a></li>
<li><a href="admin.php?m=art_comment" target="main-frame">文章评论</a></li>

</ul>
</div>

 

<div class="mtitle">美食模块</div>
<div class="menu" >
<ul>
<li><a href="admin.php?m=cai" target="main-frame">美食管理</a></li>
<li><a href="admin.php?m=cai_comment" target="main-frame">美食评论</a></li>
<li><a href="admin.php?m=cai_cat" target="main-frame">美食分类</a></li>
<li><a href="admin.php?m=cai_do" target="main-frame">工艺分类</a></li>
<li><a href="admin.php?m=cai_wei" target="main-frame">口味分类</a></li>
</ul>
</div>

<div class="mtitle">团购管理</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=groupbuy" target="main-frame">团购管理</a></li>
<li><a href="admin.php?m=groupbuy&a=category" target="main-frame">团购分类</a></li>
<li><a href="admin.php?m=groupbuy&a=order" target="main-frame">团购订单</a></li>
</ul>
</div>

<div class="mtitle">活动管理</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=activity" target="main-frame">活动管理</a></li>
<li><a href="admin.php?m=activity&a=add" target="main-frame">添加活动</a></li>
<li><a href="admin.php?m=activity&a=topic" target="main-frame">主题管理</a></li>
<li><a href="admin.php?m=activity&a=user" target="main-frame">用户管理</a></li>
</ul>
</div>


<div class="mtitle">积分商品</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=goods" target="main-frame">商品管理</a></li>
<li><a href="admin.php?m=goods&a=cat" target="main-frame">商品分类</a></li>
<li><a href="admin.php?m=goods&a=add" target="main-frame">商品添加</a></li>
<li><a href="admin.php?m=goods_comment" target="main-frame">商品评论</a></li>
<li><a href="admin.php?m=goods_order" target="main-frame">兑换订单</a></li>
</ul>
</div>

<div class="mtitle">食谱教程</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=caipu&a=cat" target="main-frame">食谱分类</a></li>
<li><a href="admin.php?m=caipu&a=cat_add" target="main-frame">分类添加</a></li>
<li><a href="admin.php?m=caipu" target="main-frame">食谱</a></li>
<li><a href="admin.php?m=caipu&a=add" target="main-frame">菜谱添加</a>  </li>
<li><a href="admin.php?m=caipu&a=tags" target="main-frame">菜谱标签</a></li>
</ul>
</div>

<div class="mtitle">社交模块</div>
<div class="menu">
<ul>
<li><a href="admin.php?m=weibo&a=config" target="main-frame">微博设置</a></li>
<li><a href="admin.php?m=weibo&a=userlist"  target="main-frame">微博用户</a></li>
<li><a href="admin.php?m=weibo&a=adduser"  target="main-frame">添加微博用户</a></li>
</ul>
</div>

<div class="mtitle">投票模块</div>
<div class="menu" >
<ul>
<li><a href="admin.php?m=vote&" target="main-frame">投票管理</a></li>
<li><a href="admin.php?m=vote&a=tt" target="main-frame">投票选项</a></li>
<li><a href="admin.php?m=vote&a=ttcat" target="main-frame">选项分类</a></li>
</ul>

</div>
<?php endif; ?>
<?php if ($_GET['a'] == 'user'): ?>
<div class="mtitle">用户模块</div>
<div class="menu" style="display:block;">
<ul>
<li><a href="admin.php?m=user" target="main-frame">会员管理</a></li>
<li><a href="admin.php?m=user&a=add" target="main-frame">会员添加</a></li>
<li><a href="admin.php?m=admin" target="main-frame">管理员管理</a></li>
<li><a href="admin.php?m=admin&a=add" target="main-frame">管理员添加</a></li>
<li><a href="admin.php?m=admin&a=zu" target="main-frame">管理组</a></li>
</ul>
</div>
<?php endif; ?>
<?php if ($_GET['a'] == 'data'): ?>
<div class="mtitle">数据模板管理</div>
<div class="menu" style="display:block;" >
<ul>
<li><a href="admin.php?m=caches" target="main-frame">缓存管理</a></li>
<li><a href="admin.php?m=skins" target="main-frame">模板管理</a></li>
<li><a href="admin.php?m=skins_edi" target="main-frame">在线编辑</a></li>
<li><a href="admin.php?m=backup" target="main-frame">备份还原</a></li>
</ul>
</div>
<?php endif; ?>



</body>
</html>