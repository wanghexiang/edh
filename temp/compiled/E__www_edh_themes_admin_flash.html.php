<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav">

<a href="admin.php?m=flash&">轮显管理</a>
</div>
<div class="nav_title">轮显管理</div>
<div class="rbox">

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tb1">
  <tr>
    <td align="center">排序</td>
    <td height="30" align="center">标题</td>
    <td height="30" align="center">链接</td>
    <td align="center">图片</td>
    <td align="center">操作</td>
    
  </tr>
  <?php $_from = $this->_var['flashlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <form method="post" name="f<?php echo $this->_var['t']['fid']; ?>" action="admin.php?m=flash&a=add_db">
  <tr><input type="hidden" name="fid" value="<?php echo $this->_var['t']['fid']; ?>" />
    <td width="28" align="center"><input name="forder" type="text" id="forder" size="4" value="<?php echo $this->_var['t']['forder']; ?>" /></td>
    <td width="140" height="30" align="center"><input name="ftitle" type="text" id="ftitle" value="<?php echo $this->_var['t']['ftitle']; ?>" size="20" /></td>
    <td width="140" height="30" align="center"><input name="furl" type="text" id="furl"  value="<?php echo $this->_var['t']['furl']; ?>" size="20"/></td>
    <td width="140" align="center"><input name="fimg" type="text" id="fimg"  value="<?php echo $this->_var['t']['fimg']; ?>" size="20"/></td>
    <td width="306" align="center"><input type="button" name="button3" id="button3" value="上传图片" onclick="window.open('admin.php?m=upload&formname=f<?php echo $this->_var['t']['fid']; ?>&editname=fimg&f_type=1','文件上传','left=300px,height=400,width=500');"  />
      <input type="submit" name="button4" id="button4" value="编辑"   />
      <input type="button" name="button5" id="button5" value="删除" onclick="location.href='admin.php?m=flash&a=del&fid=<?php echo $this->_var['t']['fid']; ?>'" /></td>
    
  </tr>
  </form>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 <form method="post" name="f" action="admin.php?m=flash&a=add_db">
  <tr>
    <td height="30" align="center"><input name="forder" type="text" id="forder" size="4" /></td>
    <td height="30" align="center"><input name="ftitle" type="text" id="ftitle" size="20" /></td>
    <td align="center"><input name="furl" type="text" id="furl" size="20" /></td>
    <td align="center"><input name="fimg" type="text" id="fimg" size="20" /></td>
    <td align="center"><input type="button" name="button" id="button" value="上传图片" onclick="window.open('admin.php?m=upload&formname=f&editname=fimg&f_type=1','文件上传','left=300px,height=400,width=500');" class="btn" /> 
    
    <input type="submit" name="button2" id="button2" value="添加"  class="btn"/></td>
  </tr>
  </form>
  <tr>
    <td height="30" colspan="5" align="center">&nbsp;</td>
    </tr>
  </table>




</div><?php echo $this->fetch('lib/foot.lbi'); ?>
