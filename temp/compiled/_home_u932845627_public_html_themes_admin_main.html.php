<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav">������ҳ</div>
<div class="nav_title">������ҳ</div>
<div class="rbox">
<table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td  height="30"><?php echo $this->_var['ct_version']; ?></td>
  </tr>
  <tr>
    <td  height="30">
    �¶����� <font color="red"><?php echo $this->_var['ordernewnum']; ?></font> ��, ���ճɽ� <font color="red"><?php echo $this->_var['orderdaynum']; ?></font> ������ <font color="red"><?php echo $this->_var['daymoney']; ?></font> Ԫ���ܳɽ������� <font color="red"><?php echo $this->_var['ordernum']; ?></font> ������<font color="red"><?php echo $this->_var['money']; ?></font> Ԫ��
    
    </td>
    </tr>
  <tr>
    <td height="30">������ <font color="red"><?php echo $this->_var['guestnum']; ?></font> ���� 
    ����ʳ���� <font color="red"><?php echo $this->_var['caicommentnum']; ?></font> �� ,
    �³�ʦ���� <font color="red"><?php echo $this->_var['cookcommentnum']; ?></font> �� ��
    ���������� <font color="red"><?php echo $this->_var['artcommentnum']; ?></font> ��
    </td>
    </tr>
  <tr>
    <td height="30">���û� <font color="red"><?php echo $this->_var['userdaynum']; ?></font> �ˣ� �û����� <font color="red"><?php echo $this->_var['usernum']; ?></font> �ˡ�</td>
    </tr>
  <tr>
    <td height="30">&nbsp;</td>
    </tr>
  <tr>
    <td height="30">&nbsp;</td>
    </tr>
  <tr>
    <td height="30">&nbsp;</td>
    </tr>
</table>

</div> 
<?php echo $this->fetch('lib/foot.lbi'); ?>