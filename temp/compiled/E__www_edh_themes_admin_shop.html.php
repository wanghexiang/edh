<?php echo $this->fetch('lib/top.lbi'); ?>
<script language="javascript">
$(document).ready(function()
{
	$("#provinceid").live("change",function()
	{
		$.get("admin.php?m=city&a=ajaxcitys&provinceid="+$(this).val(),function(data)
		{
			$("#cityid").empty().css("display"," ").append(data);
			$("#townid").empty().css("display","none");
			 
		})
	});
	
	$("#cityid").live("change",function()
	{
		$.get("admin.php?m=town&a=ajaxtowns&cityid="+$(this).val(),function(data)
		{
			
			$("#townid").empty().append(data).show();
		
		});
	});
});

</script>
<div class="nav"><a href="admin.php?m=shop&">店铺管理</a> <a href="admin.php?m=shop&a=add">店铺添加</a></div>
<div class="nav_title">
<form method="get" action="admin.php">
<input type="hidden" name="m" value="shop" />
店铺管理  &nbsp;&nbsp; 
店名：<input name="shopname" type="text" value="<?php echo $_GET['shopname']; ?>" /> 

<select name="provinceid" id="provinceid">
<option value="0">所在一级区域</option>
<?php $_from = $this->_var['provinces']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'p');if (count($_from)):
    foreach ($_from AS $this->_var['p']):
?>
<option value="<?php echo $this->_var['p']['provinceid']; ?>" <?php if ($_GET['provinceid'] == $this->_var['p']['provinceid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['p']['province']; ?></option>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</select> 

<select name="cityid" id="cityid">
<option value="0">所在二级区域</option>
<?php $_from = $this->_var['citys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
<option value="<?php echo $this->_var['c']['cityid']; ?>" <?php if ($_GET['cityid'] == $this->_var['c']['cityid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['c']['city']; ?></option>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</select>

<select name="townid" id="townid">
<option value="0">所在三级区域</option>
<?php $_from = $this->_var['towns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
<option value="<?php echo $this->_var['t']['townid']; ?>" <?php if ($_GET['townid'] == $this->_var['t']['townid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['t']['town']; ?></option>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</select>
<input type="checkbox" value="1" name="isrecommend" <?php if ($_GET['isrecommend'] == 1): ?> checked="checked"<?php endif; ?> /> 推荐
<input type="checkbox" value="1" name="ishot" <?php if ($_GET['ishot'] == 1): ?> checked="checked"<?php endif; ?> /> 热门
<input type="checkbox" value="1" name="isnew" <?php if ($_GET['isnew'] == 1): ?> checked="checked"<?php endif; ?> /> 最新
<input type="checkbox" value="1" name="visible" <?php if ($_GET['visible'] == 1): ?> checked="checked"<?php endif; ?> /> 禁止
<input type="submit" value="搜索" class="btn" />

</form></div>
<div class="rbox">
<form method="post" action="admin.php?m=shop&a=post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tb1">
  <tr>
    <td width="7%" align="center">ID</td>
    <td width="19%" align="center">店面</td>
    <td width="6%" align="center">联系电话</td>
    <td width="10%" align="center">推荐</td>
    <td width="7%" align="center">热门</td>
    <td width="12%" align="center">最新</td>
    <td width="6%" align="center">禁止</td>
    <td width="16%" align="center">所在地</td>
    <td width="17%" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['shoplist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 's');if (count($_from)):
    foreach ($_from AS $this->_var['s']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['s']['shopid']; ?></td>
    <td align="center"><?php echo $this->_var['s']['shopname']; ?></td>
    <td align="center"><?php echo $this->_var['s']['phone']; ?></td>
    <td align="center"><?php if ($this->_var['s']['isrecommend']): ?><img src="images/yes.gif" class="ajax_no" url='admin.php?m=shop&a=recommend&shopid=<?php echo $this->_var['s']['shopid']; ?>&isrecommend=0' rurl='admin.php?m=shop&a=recommend&shopid=<?php echo $this->_var['s']['shopid']; ?>&isrecommend=1' /><?php else: ?><img src="images/no.gif" class="ajax_yes"  url='admin.php?m=shop&a=recommend&shopid=<?php echo $this->_var['s']['shopid']; ?>&isrecommend=1' rurl='admin.php?m=shop&a=recommend&shopid=<?php echo $this->_var['s']['shopid']; ?>&isrecommend=0' /><?php endif; ?></td>
    <td align="center"><?php if ($this->_var['s']['ishot']): ?><img src="images/yes.gif" class="ajax_no" url='admin.php?m=shop&a=hot&shopid=<?php echo $this->_var['s']['shopid']; ?>&ishot=0' rurl='admin.php?m=shop&a=hot&shopid=<?php echo $this->_var['s']['shopid']; ?>&ishot=1' /><?php else: ?><img src="images/no.gif" class="ajax_yes"  url='admin.php?m=shop&a=hot&shopid=<?php echo $this->_var['s']['shopid']; ?>&ishot=1' rurl='admin.php?m=shop&a=hot&shopid=<?php echo $this->_var['s']['shopid']; ?>&ishot=0' /><?php endif; ?></td>
    <td align="center"><?php if ($this->_var['s']['isnew']): ?><img src="images/yes.gif" class="ajax_no" url='admin.php?m=shop&a=new&shopid=<?php echo $this->_var['s']['shopid']; ?>&isnew=0' rurl='admin.php?m=shop&a=new&shopid=<?php echo $this->_var['s']['shopid']; ?>&isnew=1' /><?php else: ?><img src="images/no.gif" class="ajax_yes"  url='admin.php?m=shop&a=new&shopid=<?php echo $this->_var['s']['shopid']; ?>&isnew=1' rurl='admin.php?m=shop&a=new&shopid=<?php echo $this->_var['s']['shopid']; ?>&isnew=0' /><?php endif; ?></td>
    <td align="center"><?php if ($this->_var['s']['visible']): ?><img src="images/yes.gif" class="ajax_no" url='admin.php?m=shop&a=visible&shopid=<?php echo $this->_var['s']['shopid']; ?>&visible=0' rurl='admin.php?m=shop&a=visible&shopid=<?php echo $this->_var['s']['shopid']; ?>&visible=1' /><?php else: ?><img src="images/no.gif" class="ajax_yes"  url='admin.php?m=shop&a=visible&shopid=<?php echo $this->_var['s']['shopid']; ?>&visible=1' rurl='admin.php?m=shop&a=visible&shopid=<?php echo $this->_var['s']['shopid']; ?>&visible=0' /><?php endif; ?></td>
    <td align="center"><?php echo $this->_var['s']['province']['province']; ?> <?php echo $this->_var['s']['city']['city']; ?> <?php echo $this->_var['s']['town']['town']; ?> <?php echo $this->_var['s']['address']; ?></td>
    <td align="center">
    <a href="index.php?m=shop&shopid=<?php echo $this->_var['s']['shopid']; ?>" target="_blank">访问</a>
    <a href="shopadmin.php?m=shopadmin&shopid=<?php echo $this->_var['s']['shopid']; ?>" target="_blank">进入管理</a> 
    <a href="admin.php?m=shop&a=add&shopid=<?php echo $this->_var['s']['shopid']; ?>">编辑</a> 
    <a href="admin.php?m=shop&a=del&shopid=<?php echo $this->_var['s']['shopid']; ?>" onclick="return   confirm('删除后不可恢复，确认删除？')">删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="31" colspan="9" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
   <?php endif; ?>
</table>


</form>
</div>
<?php echo $this->fetch('lib/foot.lbi'); ?>