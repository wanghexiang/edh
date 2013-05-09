<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
<div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
<div class="span7">
<?php echo $this->fetch('membernav.html'); ?>
<?php if ($this->_var['list']): ?>
<table class="table table-bordered">
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 's');if (count($_from)):
    foreach ($_from AS $this->_var['s']):
?>
<tr>
<td><?php echo $this->_var['s']['content']; ?></td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<?php else: ?>
<h2>还没有点餐分享</h2>
<?php endif; ?>
</div>
<div class="span3">
<h2>吃吃</h2>
<p>分享你订过的东西</p>
</div>

</div>

<?php echo $this->fetch('lib/footer.html'); ?>