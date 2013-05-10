<?php echo $this->fetch('lib/header.html'); ?>
 
<?php echo $this->fetch('searchnav.html'); ?>
<div style="float:none; clear:both;"></div> 
<div class="row">
<div class="span12">
<ul class="unstyled" id="container" > 
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<li  style="width:220px; border:1px #ccc solid; padding:2px; float:left; margin-top:10px; " class="box"  >
     <div  >
     <a href="index.php?m=caipu&a=show&id=<?php echo $this->_var['c']['id']; ?>" target="_blank"> <img src="<?php echo $this->_var['c']['imgurl']; ?>.300x300.jpg" width="220"  > </a> 
     </div>
     <div  class="caption">
     <p style="line-height:25px;"><a href="index.php?m=caipu&a=show&id=<?php echo $this->_var['c']['id']; ?>" target="_blank"><?php echo $this->_var['c']['title']; ?></a></p>
     <p>Ö÷²Ä£º<?php echo $this->_var['c']['maincai']; ?></p>
     
     </div>
</li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

</ul>
<div><?php echo $this->_var['pagelist']; ?></div>
</div>
</div>

<script language="javascript" src="js/jquery.masonry.min.js"></script>
<script language="javascript">
$(document).ready(function(){
	
	var $container=$("#container");
    $container.imagesLoaded(function(){
      $container.masonry({
        itemSelector: '.box',
        columnWidth: 230
      });
    });

});
</script>
<?php echo $this->fetch('lib/footer.html'); ?>