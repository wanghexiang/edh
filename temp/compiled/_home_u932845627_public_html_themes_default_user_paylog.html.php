<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
<div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
<div class="span10">
<?php echo $this->fetch('usernav.html'); ?>
<h2>��� ��ֵ/���Ѽ�¼</h2>
<table class="table table-bordered">
  <tr>
    <td height="30" colspan="3">��ӭ����<?php echo $this->_var['ssuser']['username']; ?>!</td>
    </tr>
  <tr>
    <td height="30" colspan="3">��Ŀǰ���Ϊ<?php echo $this->_var['balance']; ?>Ԫ�����������ĳ�ֵ/���Ѽ�¼��</td>
    </tr>
    
 
  
  <tr>
    <td width="87" height="23" align="center">���</td>
    <td width="468" align="center">����</td>
    <td width="141" align="center">ʱ��</td>
    </tr>
     <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td width="87" height="30" align="center"><?php echo $this->_var['t']['money']; ?></td>
    <td><?php echo $this->_var['t']['content']; ?></td>
    <td width="141" align="center"><?php echo date("Y-m-d H:i:s",$this->_var['t']['dateline']); ?></td>
  </tr> <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td height="30" colspan="3" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
</table>

</div>

 

</div>

<?php echo $this->fetch('lib/footer.html'); ?>