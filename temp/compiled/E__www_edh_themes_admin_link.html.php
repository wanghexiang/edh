<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=link&">���ӹ���</a> <a href="admin.php?m=link&a=add">�������</a></div>
<div class="nav_title">���ӹ���</div>
<div class="rbox">
  <form action="admin.php?m=link&a=order" method="post">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="mid tb1">
  <tr>
    <td width="51" height="30" align="center">ID</td>
    <td width="346" height="30" align="center">��������</td>
    <td width="106" height="30" align="center">����</td>
    <td width="76" align="center">����</td>
    <td width="121" align="center">����</td>
  </tr>
  <?php $_from = $this->_var['linklist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td height="25" align="center"><?php echo $this->_var['t']['id']; ?></td>
    <td height="25"><?php echo $this->_var['t']['title']; ?>
      <input name="id[]" type="hidden" id="id[]" value="<?php echo $this->_var['t']['id']; ?>" /></td>
    <td height="25" align="center"><?php if ($this->_var['t']['linktype'] == 0): ?>��ͨ<?php else: ?>��ҳ<?php endif; ?></td>
    <td align="center"><input name="orderid[]" type="text" id="orderid[]" value="<?php echo $this->_var['t']['orderid']; ?>" size="6" /></td>
    <td align="center"><a href="admin.php?m=link&a=add&id=<?php echo $this->_var['t']['id']; ?>">�༭</a> <a href="admin.php?m=link&a=del&id=<?php echo $this->_var['t']['id']; ?>">ɾ��</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td height="30" align="center">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td height="30" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><input type="submit" name="button" id="button" class="btn" value="��������" /></td>
  </tr>
  </table>

  
  </form>
  
</div> 
<?php echo $this->fetch('lib/foot.lbi'); ?>
