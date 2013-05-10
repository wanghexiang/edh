<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<div class="row">

<div class="span8">

<?php if ($this->_var['list']): ?>

<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['g']):
?>
<table class="table table-bordered">
<tr>
<td>留言者：<?php if ($this->_var['g']['username']): ?><?php echo $this->_var['g']['username']; ?><?php else: ?>游客<?php endif; ?></td>
<td>留言时间:<?php echo date("Y-m-d",$this->_var['g']['dateline']); ?></td>
</tr>
<tr>
<td colspan="2">内容：<?php echo $this->_var['g']['content']; ?></td>
</tr>

<?php if ($this->_var['g']['reply']): ?>
<tr>
<td colspan="2">
回复：<?php echo $this->_var['g']['reply']; ?>
</td>
</tr>
<?php endif; ?>
</table>

<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<?php if ($this->_var['pagelist']): ?><?php echo $this->_var['pagelist']; ?><?php endif; ?>
<?php else: ?>
<h2>暂无留言</h2>
<?php endif; ?>

</div>
<!--左边结束-->
<div class="span4">
<?php echo $this->fetch('shop_right.html'); ?>
 <!--右侧结束-->
</div>
<?php echo $this->fetch('lib/footer.html'); ?>