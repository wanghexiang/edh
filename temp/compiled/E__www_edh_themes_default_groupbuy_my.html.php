<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
<div class="span2">
<?php echo $this->fetch('usernavleft.html'); ?>
</div>
<div class="span10">
<p><h2>�ҵ��Ź�</h2></p>
<p>��¼���������Ź�</p>
<table class="table table-bordered">
<tr>
<td>�Ź�����</td>
<td>����</td>
<td>�ܼ�</td>
<td>�ֻ�</td>
<td>��ַ</td>
<td>�µ�ʱ��</td>
<td>֧��</td>
<td>״̬</td>
</tr>

<?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['g']):
?>
<tr>
<td><a href="index.php?m=groupbuy&a=show&id=<?php echo $this->_var['g']['groupid']; ?>" target="_blank"><?php echo $this->_var['g']['title']; ?></a></td>
<td><?php echo $this->_var['g']['goodsnum']; ?></td>
<td><?php echo $this->_var['g']['totalprice']; ?></td>
<td><?php echo $this->_var['g']['phone']; ?></td>
<td><?php echo $this->_var['g']['address']; ?></td>
<td><?php echo date("Y-m-d",$this->_var['g']['dateline']); ?></td>
<td>
	<?php if ($this->_var['g']['ispay']): ?>������֧��<?php else: ?>��������<?php endif; ?>
</td>
<td>
<?php if ($this->_var['g']['status'] == 0): ?>δȷ��<?php elseif ($this->_var['g']['status'] == 1): ?>��ȷ��<?php elseif ($this->_var['g']['status'] == 2): ?>������<?php elseif ($this->_var['g']['status'] == 3): ?>�����<?php endif; ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php if ($this->_var['pagelist']): ?>
<tr>
<td colspan="6"><?php echo $this->_var['pagelist']; ?></td>
</tr>
<?php endif; ?>
</table>
</div>
 
</div>
<?php echo $this->fetch('lib/footer.html'); ?>