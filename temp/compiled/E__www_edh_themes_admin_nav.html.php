<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=web_nav&">��������</a> <a href="admin.php?m=web_nav&a=add">�������</a></div>
<div class="nav_title">��������</div>
<div class="rbox">
<form action="admin.php?m=web_nav&a=order" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" class="tb1">
  <tr>
    <td width="21%" align="center">������</td>
    <td width="31%" height="30" align="center">��������</td>
    <td width="12%" align="center">�򿪷�ʽ</td>
    
    <td width="15%" height="30" align="center">����</td>
    <td width="21%" height="30" align="center">����</td>
  </tr>
  <?php $_from = $this->_var['navlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
  <td align="left"><a href="<?php echo $this->_var['t']['navurl']; ?>" target="_blank"><?php echo $this->_var['t']['title']; ?></a></td>
    <td height="25" align="center"><?php echo $this->_var['t']['pname']; ?></td>
    <td align="center"><?php if ($this->_var['t']['ctype'] == 1): ?>�´���<?php else: ?>Ĭ��<?php endif; ?></td>
    <input type="hidden" name="id[]" value="<?php echo $this->_var['t']['id']; ?>" />
    <td height="25" align="center"><input name="orderid[]" type="text" value="<?php echo $this->_var['t']['orderid']; ?>" size="6" /></td>
    <td height="25" align="center"><a href="admin.php?m=web_nav&a=add&amp;id=<?php echo $this->_var['t']['id']; ?>">�༭</a> <a href="admin.php?m=web_nav&a=del&amp;id=<?php echo $this->_var['t']['id']; ?>" onclick="return confirm('ɾ���󲻿ɻָ���ȷ��ɾ����');">ɾ��</a></td>
  </tr>
  <?php if ($this->_var['t']['child']): ?>
  <?php $_from = $this->_var['t']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
    <tr>
  <td align="left">|__<a href="<?php echo $this->_var['c']['navurl']; ?>" target="_blank"><?php echo $this->_var['c']['title']; ?></a> </td>
    <td height="25" align="center"><?php echo $this->_var['t']['title']; ?></td>
    <td align="center"><?php if ($this->_var['c']['ctype'] == 1): ?>�´���<?php else: ?>Ĭ��<?php endif; ?></td>
    <input type="hidden" name="id[]" value="<?php echo $this->_var['c']['id']; ?>" />
    
    <td height="25" align="center"><input name="orderid[]" type="text" value="<?php echo $this->_var['c']['orderid']; ?>" size="6" /></td>
    <td height="25" align="center"><a href="admin.php?m=web_nav&a=add&amp;id=<?php echo $this->_var['c']['id']; ?>">�༭</a> <a href="admin.php?m=web_nav&a=del&amp;id=<?php echo $this->_var['c']['id']; ?>" onclick="return confirm('ɾ���󲻿ɻָ���ȷ��ɾ����');">ɾ��</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td colspan="5" align="right"><input type="submit" name="button" id="button" value="��������" class="btn" /></td>
    </tr>
    <?php if ($this->_var['pagelist']): ?>
    <tr>
    <td colspan="5" align="right"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
    <?php endif; ?>
</table>

</form>
</div>

<?php echo $this->fetch('lib/foot.lbi'); ?>