<?php echo $this->fetch('lib/top.lbi'); ?>
<link rel="stylesheet" href="plugin/zebra/zebra_datepicker.css" type="text/css">
<script type="text/javascript" src="plugin/zebra/zebra_datepicker.js"></script>
<script language="javascript">
$(document).ready(function()
{
	$("#chkall").click(function()
	{
		$(".orderid").attr("checked","checked");
	});
	$("#chknone").click(function()
	{
		$(".orderid").attr("checked",false);
	});
	$('#starttime').Zebra_DatePicker();

	$('#endtime').Zebra_DatePicker();
});

</script>
<?php echo $this->fetch('groupbuy_nav.html'); ?>
<div class="rbox">
<form action="shopadmin.php " method="get">
<input type="hidden" name="m" value="groupbuy" />
<input type="hidden" name="a" value="order" />
<input type="hidden" name="s" value="<?php echo $_GET['s']; ?>" />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td height="30" align="center">�ͻ���
      <input name="nickname" type="text" id="username" value="<?php echo $_GET['nickname']; ?>" size="16" />

      ����״̬
      <label for="status"></label>
      <select name="status" id="status">
      <option value="-1" <?php if ($_GET['status'] == - 1): ?> selected="selected"<?php endif; ?>>ȫ��</option>
      <option value="0" <?php if ($_GET['status'] == 0): ?> selected="selected"<?php endif; ?>>δȷ��</option>
      <option value="1" <?php if ($_GET['status'] == 1): ?> selected="selected"<?php endif; ?>>��ȷ��</option>
      <option value="2" <?php if ($_GET['status'] == 2): ?> selected="selected"<?php endif; ?>>��������</option>
      <option value="3" <?php if ($_GET['status'] == 3): ?> selected="selected"<?php endif; ?>>�����</option>
     
      </select>  
      <?php if (! $_GET['s']): ?>
       ��ʼʱ�� <span style="position:relative;"><input name="starttime" type="text" id="starttime" value="<?php echo $_GET['starttime']; ?>" size="12" /></span>
       ����ʱ�� <span style="position:relative;"><input name="endtime" type="text" id="endtime" value="<?php echo $_GET['endtime']; ?>" size="12" /></span>   <?php endif; ?>
       <input type="submit" name="button" id="button" value="��ѯ" class="btn"/></td>
    </tr>
  </table>

</form>

<form method="post" action="index.php?m=groupbuy">
<table class="tb1" width="100%">
	<tr>
    	<td width="3%" align="center">ѡ��</td>
    	<td width="8%" align="center">�Ź�����</td>
        <td width="11%" align="center">������</td>
        <td width="8%" align="center">�绰</td>
        <td width="13%" align="center">��ַ</td>
        <td width="9%" align="center">����</td>
        <td width="10%" align="center">�ܼ�</td>
        <td width="13%" align="center">֧��</td>
        <td width="16%" align="center">�µ�ʱ��</td>
        <td width="9%" align="center">״̬</td>
         
    </tr>
    <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'g');if (count($_from)):
    foreach ($_from AS $this->_var['g']):
?>
    	<tr>
        <td><input type="checkbox" name="orderid[]" class="orderid" value="<?php echo $this->_var['g']['orderid']; ?>"></td>
    	<td><?php echo $this->_var['g']['title']; ?></td>
        <td align="center"><?php echo $this->_var['g']['nickname']; ?></td>
        <td align="center"><?php echo $this->_var['g']['phone']; ?></td>
        <td align="center"><?php echo $this->_var['g']['address']; ?></td>
        <td align="center"><?php echo $this->_var['g']['goodsnum']; ?></td>
        <td align="center"><?php echo $this->_var['g']['totalprice']; ?></td>
        <td align="center"><?php if ($this->_var['g']['ispay']): ?>������֧��<?php else: ?>��������<?php endif; ?></td>
        <td align="center"><?php echo date("Y-m-d H:i",$this->_var['g']['dateline']); ?></td>
        <td align="center"><?php if ($this->_var['g']['status'] == 0): ?>δȷ��<?php elseif ($this->_var['g']['status'] == 1): ?>��ȷ��<?php elseif ($this->_var['g']['status'] == 2): ?>������<?php elseif ($this->_var['g']['status'] == 3): ?>�����<?php endif; ?></td>
         
      </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    
    <tr>
    	<td colspan="9"> 
        	<a href="javascript::" id="chkall"  >ȫѡ</a>
      &nbsp;<a href="javascript::" id="chknone"  >ȫ��ѡ</a>
       
        <input type="submit" name="button3" id="button3" value="��ȷ��" class="btn"  onclick="this.form.action='shopadmin.php?m=groupbuy&a=status&status=1'"  />

        <input type="submit" name="button5" id="button5" value="������"  class="btn" 
         onclick="this.form.action='shopadmin.php?m=groupbuy&a=status&status=2'"  />
        <input type="submit" name="button6" id="button6" value="�����" class="btn"  onclick="this.form.action='shopadmin.php?m=groupbuy&a=status&status=3';return confirm('������ɺ󽫲����ٸ��Ķ���״̬');"   />
        </td>
    </tr>
    
    <?php if ($this->_var['pagelist']): ?>
    <tr>
    	<td colspan="9"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
    <?php endif; ?>

</table>
</form>
</div>

<?php echo $this->fetch('lib/foot.lbi'); ?>