<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=user&">��Ա����</a> <a href="admin.php?m=user&a=add">��Ա���</a> <a href="admin.php?m=user&a=info&amp;userid=<?php echo $this->_var['user']['userid']; ?>">��Ա����</a></div>
<div class="nav_title">��Ա����</div>
<div class="rbox">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td width="112" height="30" align="center">�û���</td>
    <td width="70" align="center">qq</td>
    <td width="93" align="center">�ֻ�</td>
    <td width="97" align="center">����</td>
    <td width="82" align="center">�ǳ�</td>
    <td width="66" align="center">����</td>
    <td width="232" align="center">��ַ</td>
  </tr>

  <tr>
    <td height="25" align="center"><?php echo $this->_var['user']['username']; ?></td>
    <td align="center"><?php echo $this->_var['user']['qq']; ?></td>
    <td align="center"><?php echo $this->_var['user']['phone']; ?></td>
    <td align="center"><?php echo $this->_var['user']['email']; ?></td>
    <td align="center"><?php echo $this->_var['user']['nickname']; ?></td>
    <td align="center"><?php echo $this->_var['user']['grade']; ?></td>
    <td align="center"><?php echo $this->_var['user']['address']; ?></td>
  </tr>
 
  
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1"  >
  <tr>
    <td   height="30">��Ŀǰ�������Ϊ<?php echo $this->_var['user']['balance']; ?> Ԫ��<a href="admin.php?m=paylog&a=log&amp;userid=<?php echo $this->_var['user']['userid']; ?>"><font color="red">�鿴��ֵ���Ѽ�¼</font></a>,<a href="admin.php?m=grade_log&userid=<?php echo $this->_var['user']['userid']; ?>"><font color="red">�鿴���ֶһ���¼</font></a>��</td>
  </tr>
  <tr>
    <td height="30">�ڱ�վ�ۼ�����<?php echo $this->_var['ordermoney']; ?>Ԫ�����<?php echo $this->_var['user']['grade']; ?>���֣����Ի��<?php echo $this->_var['discount']; ?>%�Ż�,<a href="admin.php?m=order&uid=<?php echo $this->_var['user']['userid']; ?>">�鿴���Ѽ�¼</a>��</td>
    </tr>
  <tr>
    <td height="30">����������<?php echo $this->_var['spread']; ?>������,���ĺ����ۼ�������<?php echo $this->_var['friendmoney']; ?>Ԫ����������<?php echo $this->_var['friendbonus']; ?>Ԫ������</td>
  </tr>
  </table>

</div> 
<?php echo $this->fetch('lib/foot.lbi'); ?>