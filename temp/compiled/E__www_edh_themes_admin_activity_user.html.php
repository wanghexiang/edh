<?php echo $this->fetch('lib/top.lbi'); ?>
<?php echo $this->fetch('activity_nav.html'); ?>
<div class="nav_title">�����û�</div>
<div class="rbox">
<table width="100%" class="tb1" border="0">
  <tr>
    <td align="center">ID</td>
    <td align="center">�ǳ�</td>
    <td align="center">�ֻ�</td>
    <td align="center">������Ϣ</td>
    <td align="center">״̬</td>
    <td align="center">ʱ��</td>
    <td align="center">����</td>
  </tr>
  <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['c']['id']; ?></td>
    <td align="center"><?php echo $this->_var['c']['nickname']; ?></td>
    <td align="center"><?php echo $this->_var['c']['telephone']; ?></td>
    <td align="center"><?php echo $this->_var['c']['info']; ?></td>
    <td align="center"><?php if ($this->_var['c']['status'] == 0): ?>δ���<?php elseif ($this->_var['c']['status'] == 1): ?>��ͨ��<?php elseif ($this->_var['c']['status'] == 2): ?>δͨ��<?php endif; ?></td>
    <td align="center"><?php echo date("Y-m-d",$this->_var['c']['dateline']); ?></td>
    <td align="center"><a href="javascript:;" class="ajax_del" url="admin.php?m=activity&a=userdel&id=<?php echo $this->_var['c']['id']; ?>">ɾ��</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
<?php echo $this->fetch('lib/foot.lbi'); ?>