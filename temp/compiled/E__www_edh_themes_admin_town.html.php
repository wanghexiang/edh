<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=province&">һ���������</a> <a href="admin.php?m=city&">�����������</a> <a href="admin.php?m=town&">�����������</a> <?php if ($_GET['cityid']): ?><a href="admin.php?m=town&a=add&cityid=<?php echo $_GET['cityid']; ?>">�����������</a><?php endif; ?></div>
<div class="nav_title">�����������</div>
<div class="rbox">
<form method="post" action="admin.php?m=town&a=post">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tb1">
  <tr>
    <td width="12%" align="center">ID</td>
    <td width="20%" align="center">��������</td>
    <td width="18%" align="center">����</td>
    <td width="23%" align="center">����λ��</td>
    <td width="23%" align="center">��������</td>
    <td width="27%" align="center">����</td>
  </tr>
  <?php $_from = $this->_var['towns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['t']['townid']; ?></td>
    <td align="center"><input type="text" name="town[<?php echo $this->_var['t']['townid']; ?>]" id="town[]" value="<?php echo $this->_var['t']['town']; ?>"></td>
    <td align="center"><input type="text" name="orderindex[<?php echo $this->_var['t']['townid']; ?>]" id="orderindex[]" value="<?php echo $this->_var['t']['orderindex']; ?>"></td>
    <td align="center"><label for="textfield"></label>
      <input type="text" name="latlng[<?php echo $this->_var['t']['townid']; ?>]" id="textfield" value="<?php echo $this->_var['t']['lat']; ?>,<?php echo $this->_var['t']['lng']; ?>" /></td>
    <td align="center"><?php echo $this->_var['t']['city']; ?></td>
    <td align="center">
   
    <a href="admin.php?m=town&a=del&townid=<?php echo $this->_var['t']['townid']; ?>">ɾ��</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><input type="submit" name="button" id="button" value="�ύ" class="btn" /></td>
  </tr>
  
  <tr>
    <td colspan="5" align="left">����λ��˵���� <a  href="javascript:;" onclick='$("#mapbox").css("visibility","visible")'  >�����ȡ����λ��</a> Ȼ���Ƽ���  </td>
    </tr>
</table>


</form>

</div>

<div id="mapbox" style=" visibility:hidden; position:fixed; left:200px; top:40px; width:640px;  height:460px; background-color:#FFFFFF; padding:5px 10px; border:1px solid #6C9;">
<div style="background-color:#66CC99; height:30px; line-height:30px; padding-left:10px; padding-right:10px;"><span style="float:left;">��ͼ��ע::</span> <span style="float:right;"><a href="javascript:;" id="getlatlng_close" onclick="$('#mapbox').css('visibility','hidden')">�ر�</a></span></div>
<iframe src="index.php?m=getlatlng" style="width:600px; height:420px; border:0;"></iframe></div>
<?php echo $this->fetch('lib/foot.lbi'); ?>