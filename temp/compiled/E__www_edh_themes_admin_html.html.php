<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=html&a=cat">��ҳ����</a> <a href="admin.php?m=html&">��ҳ����</a> <a href="admin.php?m=html&a=add">��ҳ���</a></div>
<div class="nav_title">��ҳ����</div>
<div class="rbox">
<form action="admin.php?m=html&a=order" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td width="85" height="30" align="center">ID</td>
    <td width="219" height="30" align="center">����</td>
    <td width="115" height="30" align="center">���ñ�ǩ</td>
    <td width="84" align="center">��ҳ����</td>
    <td width="114" height="30" align="center">����</td>
    <td width="116" height="30" align="center">����</td>
  </tr>
  <?php $_from = $this->_var['htmllist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td height="25" align="center"><?php echo $this->_var['t']['id']; ?>
      <input name="id[]" type="hidden" id="id[]" value="<?php echo $this->_var['t']['id']; ?>" /></td>
    <td height="30" align="center"><?php echo $this->_var['t']['title']; ?></td>
    <td height="30" align="center"><?php echo $this->_var['t']['tagname']; ?></td>
    <td align="center">
    <?php if ($this->_var['t']['isnav']): ?>
    <img src='images/yes.gif' class="ajax_no" url='admin.php?m=html&a=noisnav&id=<?php echo $this->_var['t']['id']; ?>' rurl='admin.php?m=html&a=isnav&id=<?php echo $this->_var['t']['id']; ?>'>
    <?php else: ?>
    <img src='images/no.gif' class="ajax_yes" url='admin.php?m=html&a=isnav&id=<?php echo $this->_var['t']['id']; ?>' rurl='admin.php?m=html&a=noisnav&id=<?php echo $this->_var['t']['id']; ?>'>
    <?php endif; ?></td>
    <td height="30" align="center"><input name="orderid[]" type="text" id="orderid[]" value="<?php echo $this->_var['t']['orderid']; ?>" size="6" /></td>
    <td height="30" align="center"><a href="admin.php?m=html&a=add&amp;id=<?php echo $this->_var['t']['id']; ?>">�༭</a> 
    <a href="admin.php?m=html&a=del&amp;id=<?php echo $this->_var['t']['id']; ?>" onclick="return confirm('ɾ���󲻿ɻָ���ȷ��ɾ��?')">ɾ��</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td height="30" colspan="6" align="right"><input type="submit" name="button" id="button" value="��������" class="btn" /></td>
  </tr>
  <?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="30" colspan="6" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
    <?php endif; ?>
</table>


</form>
</div> 
<?php echo $this->fetch('lib/foot.lbi'); ?>