
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" type="text/css" href="image/gong.css"/>
<link rel="stylesheet" type="text/css" href="image/nei.css"/>
</head>

<body>
<?php echo $this->fetch('lib/header.html'); ?>
<div class="kuan clear col pb10"><?php echo $this->_var['town']; ?><a href="index.php" class="c">[�л���ַ]</a></div>
<div class="kuan mt5"><img src="image/banner.jpg" /></div>
<dl class="cang kuan">
	<dt>�Ƽ�����</dt>
    <dd><a href=""  ><img src="/image/cang_j.jpg"/></a></dd>
    <dd><a href="#">�Ƽ�</a></dd>
    <dd><a href="#">�Ƽ�</a></dd>
    <dd><a href="#">�Ƽ�</a></dd>
    <dd><a href="#">�Ƽ�</a></dd>
    <dd><a href="#">�Ƽ�</a></dd>
  	<dt class="bd"><h1 class="fb"><a href="#">�������</a></h1></dt>
</dl>
<dl class="cang kuan">
	<dt>�ղص���</dt>
	 
    <dd><a href="#">�ղ�</a></dd> 
    <dd><a href="#">�ղ�</a></dd>
    <dd><a href="#">�ղ�</a></dd>
    <dd><a href="#">�ղ�</a></dd>
    <dd><a href="#">�ղ�</a></dd>
    <dd><a href="#">�ղ�</a></dd>
  	<dt class="bd"><h1 class="fb"><a href="#">�������</a></h1></dt>
</dl>
<div class="can_ming">
  <dl class="cai_lan">
<dt>
  <input type="checkbox" class="xuan" />    	
  Ӫҵ��       <span>
  <a <?php if ($_GET['catid'] == 0): ?> class="tabhover"<?php endif; ?> href="index.php?m=shoplist&catid=0&provinceid=<?php echo $_GET['provinceid']; ?>&cityid=<?php echo $_GET['cityid']; ?>&townid=<?php echo $_GET['townid']; ?>&smid=<?php echo $_GET['smid']; ?>&amid=<?php echo $_GET['amid']; ?>&orderby=<?php echo $_GET['orderby']; ?>">ȫ��</a>
  <?php $_from = $this->_var['catlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
           <a <?php if ($_GET['catid'] == $this->_var['c']['catid']): ?> class="tabhover"<?php endif; ?> href="index.php?m=shoplist&catid=<?php echo $this->_var['c']['catid']; ?>&provinceid=<?php echo $_GET['provinceid']; ?>&cityid=<?php echo $_GET['cityid']; ?>&townid=<?php echo $_GET['townid']; ?>&smid=<?php echo $_GET['smid']; ?>&amid=<?php echo $_GET['amid']; ?>&orderby=<?php echo $_GET['orderby']; ?>"><?php echo $this->_var['c']['cname']; ?></a>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</span>
</dt>
        <dd>���ͼۣ� <a <?php if ($_GET['smid'] == 0): ?> class="tabhover"<?php endif; ?> href="index.php?m=shoplist&catid=<?php echo $_GET['catid']; ?>&provinceid=<?php echo $_GET['provinceid']; ?>&cityid=<?php echo $_GET['cityid']; ?>&townid=<?php echo $_GET['townid']; ?>&smid=0&amid=<?php echo $_GET['amid']; ?>&orderby=<?php echo $_GET['orderby']; ?>">����</a>
        	<?php $_from = $this->_var['smlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 's');if (count($_from)):
    foreach ($_from AS $this->_var['s']):
?>
            <a <?php if ($_GET['smid'] == $this->_var['s']['smid']): ?> class="tabhover"<?php endif; ?> href="index.php?m=shoplist&catid=<?php echo $_GET['catid']; ?>&provinceid=<?php echo $_GET['provinceid']; ?>&cityid=<?php echo $_GET['cityid']; ?>&townid=<?php echo $_GET['townid']; ?>&smid=<?php echo $this->_var['s']['smid']; ?>&amid=<?php echo $_GET['amid']; ?>&orderby=<?php echo $_GET['orderby']; ?>"><?php echo $this->_var['s']['cname']; ?>Ԫ</a>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></dd>
  </dl>
   <?php $_from = $this->_var['shoplist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shop');if (count($_from)):
    foreach ($_from AS $this->_var['shop']):
?>
  <div class="left dian_pu">
  <div class="pu_on">
  <dl class="can_nei">
  <a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>" >
  	<dt> <img  width='46' height='46'src="<?php if ($this->_var['shop']['logo']): ?><?php echo $this->_var['shop']['logo']; ?><?php else: ?>images/nologo.gif<?php endif; ?>"  />
  	  <p><a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>"><?php echo $this->_var['shop']['shopname']; ?></a></p>
	<p>��Ӫ�����</p>
	<br/>
    </dt>
    <dd><h1><?php if ($this->_var['shop']['flag'] == 2): ?>��Ϣ�� <?php else: ?>Ӫҵ��<?php endif; ?></h1>
		<span>
			<a style="padding-left:18px;padding-top:2px;padding-right:10px;background-size:50px 22px;"  href="index.php?m=fav&a=shopadd&shopid=<?php echo $this->_var['shop']['shopid']; ?>">�ղ�</a>
		</span>
	</dd>
    </a>
  </dl>
  <div class="can_xiang">
 <a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>" ><img width='46' height='46' src="<?php if ($this->_var['shop']['logo']): ?><?php echo $this->_var['shop']['logo']; ?><?php else: ?>images/nologo.gif<?php endif; ?>"  /></a>
  <h1><a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>"><?php echo $this->_var['shop']['shopname']; ?></a></h1>
  <p>��Ӫ�����</p>
  <p>���ͼ۸�:<?php echo $this->_var['shop']['sendplace']; ?></p>
  <p>��ַ:<?php echo $this->_var['shop']['address']; ?></p>
  <p>�绰:<?php echo $this->_var['shop']['phone']; ?></p>
  <p>Ӫҵʱ��: <?php echo $this->_var['shop']['starthour']; ?>:<?php echo $this->_var['shop']['startminute']; ?>-<?php echo $this->_var['shop']['endhour']; ?>:<?php echo $this->_var['shop']['endminute']; ?></p>
  </div>
  </div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <div class="clear"></div>
 <?php if (empty ( $this->_var['shoplist'] )): ?>
 <br/><br/><br/>
 <center><font color='green'>��������ʱ��û������Ŷ!</font></center>
 <br/><br/><br/>
 <?php endif; ?> 
</div>
<?php echo $this->fetch('lib/footer.html'); ?>
</body>
</html>
<script>
	

</script>