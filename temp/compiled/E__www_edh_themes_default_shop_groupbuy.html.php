<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<div class="row">
<div class="span9">

<?php if ($this->_var['list']): ?>
<ul class="thumbnails">
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['g']):
?>
<li class="span3" style="height:340px;">
<div class="thumbnail"><a href="index.php?m=groupbuy&a=show&id=<?php echo $this->_var['g']['id']; ?>"><img src="<?php if ($this->_var['g']['img']): ?><?php echo $this->_var['g']['img']; ?>.thumb.jpg<?php else: ?>images/nologo.gif<?php endif; ?>" onerror='images/nologo.gif' style="width:200px; height:140px;"   /></a>
<div class="caption">
<p><?php echo $this->_var['g']['title']; ?></p>
<p><?php echo $this->_var['g']['groupprice']; ?>元  <span style="text-decoration:line-through">￥<?php echo $this->_var['g']['goodsprice']; ?>(<?php echo round($this->_var['g']['groupprice']/$this->_var['g']['goodsprice'],1);?>折)</span></p>

<p><span class="lefttime" endtime=<?php echo $this->_var['g']['endtime']; ?>>离团购结束....</span></p>
</div>
</div>
</li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<script language="javascript">
setInterval("changelefttime()",1000);
</script>
</ul>
<?php else: ?>
<h2>暂无团购</h2>
<?php endif; ?>

</div>
<div class="span3">
<?php mod_base('hotlist',"SELECT * FROM ".table('groupbuy')." ");?> 
<?php if ($this->_var['hostlist']): ?>
<div class="accordion-group">
	<div class="accordion-heading"><div class="accordion-toggle f14 btn-success ">热门团购</div></div>
    <div class="accordion-inner">
    <ul class="unstyled">
    
    <?php $_from = $this->_var['hotlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
    <li><?php echo $this->_var['t']['title']; ?></li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    
    </ul>
    </div>
</div>
<?php endif; ?>
<?php echo $this->fetch('shop_right.html'); ?>
</div>
<!--右边结束->

</div>
<?php echo $this->fetch('lib/footer.html'); ?>