<?php echo $this->fetch('lib/header.html'); ?>
<?php echo $this->fetch('shopnav.html'); ?>
<div class="row">

<div class="span8">

<?php if ($this->_var['list']): ?>
<table class="table table-bordered">
<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['g']):
?>
<tr><td>@<?php echo $this->_var['g']['orderuser']; ?> 下了订单<?php echo $this->_var['g']['orderno']; ?> 时间：<?php echo date("Y-m-d H:i",$this->_var['g']['dateline']); ?> </td></tr>
<tr><td>
 菜单：<?php $_from = $this->_var['g']['cais']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?><?php echo $this->_var['c']['title']; ?> &nbsp;  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td></tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<?php else: ?>
<h2>暂无订单</h2>
<?php endif; ?>

</div>
<!--左边结束-->
<div class="span4">
<?php echo $this->fetch('shop_right.html'); ?>
 </div>
 <!--右侧结束-->
</div>
<?php echo $this->fetch('lib/footer.html'); ?>