<?php echo $this->fetch('lib/header.html'); ?>
<div class="row">
<div class="span2"><?php echo $this->fetch('usernavleft.html'); ?></div>
<div class="span10">
<p><h2>�һ���¼</h2></p>
<div class="breadcrumb">
�һ���¼�ǹ������Ļ�����Ʒ�һ���¼
</div>
    
<table  class="table table-bordered">
  <tr>
    <td height="30" colspan="3">��ӭ����<?php echo $this->_var['ssuser']['nickname']; ?>!</td>
    </tr>
  <tr>
    <td height="30" colspan="3">��Ŀǰ���û���Ϊ<?php echo $this->_var['usegrade']; ?>�֣����������Ŀ��Ի��ּ�¼��</td>
    </tr>
   
 
  
  <tr>
    <td  class="span2">�Żݶ�</td>
    <td  class="span8" align="center">����</td>
    <td  class="span2">ʱ��</td>
    </tr>
     <?php $_from = $this->_var['loglist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td width="87" height="30" align="center"><?php echo $this->_var['t']['grade']; ?></td>
    <td><?php echo $this->_var['t']['content']; ?></td>
    <td width="141" align="center"><?php echo $this->_var['t']['dateline']; ?></td>
  </tr> <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td height="30" colspan="3" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
</table>
    
    
</div>


</div>

<?php echo $this->fetch('lib/footer.html'); ?>