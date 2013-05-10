<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?php echo $this->_var['shopinfo']['shopname']; ?></title>
<link rel="stylesheet" type="text/css" href="image/gong.css"/>
<link rel="stylesheet" type="text/css" href="image/nei.css"/>
<link rel="stylesheet" type="text/css" href="plugin/bootstrap/css/shopcar.css"/>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/jquery.center.js"></script>
<script language="javascript" src="plugin/bootstrap/js/bootstrap-dropdown.js"></script>
 <script src="plugin/bootstrap/js/bootstrap-collapse.js"></script>
 <script src="plugin/bootstrap/js/bootstrap-carousel.js"></script>

<script language="javascript" src="js/common.js"></script>
<script language="javascript">
$(document).ready(function()
{
	$('.dropdown-toggle').dropdown();
	$('.carousel').carousel();
	 
	$('tr').addClass('odd'); 
	$('tr:even').addClass('even'); //奇偶变色，添加样式 
});
</script>
</head>
<body>
<?php echo $this->fetch('lib/header.html'); ?>

<div class="kuan clear col pb10"><?php echo $this->_var['shopinfo']['shopname']; ?><a href="index.php" class="c">[切换地址]</a></div>
<div class="kuan" style="margin-top:45px;">
	<div class="kuan float" id="float">
  <h1>菜单<br />分类</h1>
  <p><a href="index.php?m=shop&shopid=<?php echo $this->_var['shopinfo']['shopid']; ?>">所有美食</a> 
  <?php $_from = $this->_var['cats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
  <a href="index.php?m=shop&shopid=<?php echo $this->_var['c']['shopid']; ?>&catid=<?php echo $this->_var['c']['catid']; ?>"><?php echo $this->_var['c']['cname']; ?></a> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </p>
</div>
	<div class="left shang_jie">
    <h1>菜单</h1>
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare right fen">
    <span class="bds_more">分享到：</span>
    <a class="bds_qzone"></a>
    <a class="bds_tsina"></a>
    <a class="bds_tqq"></a>
    <a class="bds_renren"></a>
    <a class="bds_t163"></a>
    <a class="shareCount"></a>
    </div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=483169" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
    </script>
    <!-- Baidu Button END -->
    </div>
    <div class="right"><img src="image/dian_jian.jpg" /></div>
    <div class="clear cai_pin pb40">
    	<div class="cai_ming left">
        	<div class="cai_fen"><a href="index.php?m=shop&shopid=<?php echo $this->_var['c']['shopid']; ?>">所有美食</a> 
            <?php $_from = $this->_var['cats']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
			<a href="index.php?m=shop&shopid=<?php echo $this->_var['c']['shopid']; ?>&catid=<?php echo $this->_var['c']['catid']; ?>"><?php echo $this->_var['c']['cname']; ?></a> 
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <div class="cai_tu fc"><?php if ($this->_var['current_cat']): ?><?php echo $this->_var['current_cat']['cname']; ?><?php else: ?>所有美食<?php endif; ?></div>
			
			<!-- 显示图片
			<?php $_from = $this->_var['foods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'f');if (count($_from)):
    foreach ($_from AS $this->_var['f']):
?>
			<?php if ($this->_var['f']['img']): ?>
            <dl class="left cai_chi">
            	<dt><img src="<?php echo $this->_var['f']['img']; ?>" /></dt>
            	<dd><p><h1><?php echo $this->_var['f']['price']; ?></h1><?php echo $this->_var['f']['title']; ?></p>
                <p><span><?php if ($this->_var['shopconfig']['ordertype'] == 0): ?><a href="javascript:;" class="addCart" caiid="<?php echo $this->_var['f']['id']; ?>"  shopid='<?php echo $this->_var['f']['shopid']; ?>' name="<?php echo $this->_var['f']['title']; ?>" price="<?php echo $this->_var['f']['price']; ?>" cart_count='0' >来一份</a><?php else: ?><a href="javascript:;" title="电话预定" class="addCart" caiid="<?php echo $this->_var['f']['id']; ?>"  shopid='<?php echo $this->_var['f']['shopid']; ?>' name="<?php echo $this->_var['f']['title']; ?>" price="<?php echo $this->_var['f']['price']; ?>" cart_count='0'>+</a><?php endif; ?></span></p>
                </dd>
            </dl>
			<?php elseif ($this->_var['f']['thum_img']): ?>
			<dl class="left cai_chi">
            	<dt><img src="<?php echo $this->_var['f']['thum_img']; ?>" /></dt>
            	<dd><p><h1><?php echo $this->_var['f']['price']; ?></h1><?php echo $this->_var['f']['title']; ?></p>
                <p><span><?php if ($this->_var['shopconfig']['ordertype'] == 0): ?><a href="javascript:;" class="addCart" caiid="<?php echo $this->_var['f']['id']; ?>"  shopid='<?php echo $this->_var['f']['shopid']; ?>' name="<?php echo $this->_var['f']['title']; ?>" price="<?php echo $this->_var['f']['price']; ?>" cart_count='0' >来一份</a><?php else: ?><a href="javascript:;" title="电话预定" class="addCart" caiid="<?php echo $this->_var['f']['id']; ?>"  shopid='<?php echo $this->_var['f']['shopid']; ?>' name="<?php echo $this->_var['f']['title']; ?>" price="<?php echo $this->_var['f']['price']; ?>" cart_count='0'>+</a><?php endif; ?></span></p>
                </dd>
            </dl>
			<?php endif; ?>
			
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			-->
            <div class="clear"></div>
			<?php $_from = $this->_var['foods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'f');if (count($_from)):
    foreach ($_from AS $this->_var['f']):
?>
		
            <ul class="cai_wchi left" style="width:680px;">
            	<li style="padding-top:15px;width:600px;">
					<span style="width:300px;float:left"><?php echo $this->_var['f']['title']; ?></span>
					<span style="margin-left:100px; height:10px;foat:left"><?php echo $this->_var['f']['price']; ?>元</span>
					
					<span style=""><?php if ($this->_var['shopconfig']['ordertype'] == 0): ?><a href="javascript:;" style="margin-top:5px;" class="addCart" caiid="<?php echo $this->_var['f']['id']; ?>"  shopid='<?php echo $this->_var['f']['shopid']; ?>' name="<?php echo $this->_var['f']['title']; ?>" price="<?php echo $this->_var['f']['price']; ?>" cart_count='0' >来一份</a><?php else: ?><a href="javascript:;" title="电话预定" class="addCart" caiid="<?php echo $this->_var['f']['id']; ?>"  shopid='<?php echo $this->_var['f']['shopid']; ?>' name="<?php echo $this->_var['f']['title']; ?>" price="<?php echo $this->_var['f']['price']; ?>" cart_count='0'>+</a><?php endif; ?></span>
				</li>
		   </ul>
			<style>
				.cai_wchi:hover{
					background:rgb(239,248,255);
				}
			</style>
		
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            
   		</div>
        <div class="left dian_abou ml20 mt15">
        	<img width='45' height='45' src="<?php if ($this->_var['shopinfo']['logo']): ?><?php echo $this->_var['shopinfo']['logo']; ?><?php else: ?>images/nologo.gif<?php endif; ?>"/><h1><?php echo $this->_var['shopinfo']['shopname']; ?></h1>
            <p><?php echo $this->_var['shopinfo']['cname']; ?></p>
          <h2 style="margin-top:10px;padding:0px;"><?php echo $this->_var['shopinfo']['content']; ?></h2>
		  
          <p>配送价格: <?php echo $this->_var['shopinfo']['sendplace']; ?></p>
          <p>地址: <?php echo $this->_var['shopinfo']['address']; ?></p>
		 
		  <p>商户类型: <?php if ($this->_var['shopinfo']['ordertype'] == 1): ?>手机商户<?php else: ?>互联网商户<?php endif; ?></p>
		  <p>营业时间:<?php echo $this->_var['shopinfo']['starthour']; ?>:<?php echo $this->_var['shopinfo']['startminute']; ?>-<?php echo $this->_var['shopinfo']['endhour']; ?>:<?php echo $this->_var['shopinfo']['endminute']; ?></p>
		  <p>简介:<?php echo $this->_var['shopinfo']['info']; ?></p>
		  <a href="index.php?m=fav&a=shopadd&shopid=<?php echo $this->_var['shopinfo']['shopid']; ?>">添加收藏</a>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
$.fn.smartFloat = function() {
	var position = function(element) {
		var top = element.position().top, pos = element.css("position");
		$(window).scroll(function() {
			var scrolls = $(this).scrollTop();
			if (scrolls > top) {
				if (window.XMLHttpRequest) {
					element.css({
						position: "fixed",
						top: 0
					});	
				} else {
					element.css({
						top: scrolls
					});	
				}
			}else {
				element.css({
					position: pos,
					top: top
				});	
			}
		});
};
	return $(this).each(function() {
		position($(this));						 
	});
};
//绑定
$("#float").smartFloat();
</script>
<?php echo $this->fetch('lib/shopcar.html'); ?>
<?php echo $this->fetch('lib/footer.html'); ?>
</body>
</html>
