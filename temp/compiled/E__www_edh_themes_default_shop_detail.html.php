<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<div class="row">

<div class="span8">

<pre><?php echo $this->_var['shop']['shopname']; ?></pre>
<div>
<?php echo $this->_var['shop']['content']; ?>
</div>

 
</div>
<!--��߽���-->
<div class="span4">
 <?php echo $this->fetch('lib/shopcar.html'); ?>
 <?php echo $this->fetch('shop_right.html'); ?>
 </div>
 <!--�Ҳ����-->
</div>
<?php echo $this->fetch('lib/footer.html'); ?>