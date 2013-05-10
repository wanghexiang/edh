<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=province&">一级区域管理</a> <a href="admin.php?m=city&">二级区域管理</a> <a href="admin.php?m=town&">三级区域管理</a> <?php if ($_GET['provinceid']): ?><a href="admin.php?m=city&a=add&provinceid=<?php echo $_GET['provinceid']; ?>">添加二级区域</a><?php endif; ?></div>
<div class="nav_title">二级区域管理</div>
<div class="rbox">
<form method="post" action="admin.php?m=city&a=post">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tb1">
  <tr>
    <td width="9%" align="center">ID</td>
    <td width="16%" align="center">二级区域</td>
    <td width="15%" align="center">排序</td>
    <td width="17%" align="center">地理位置</td>
    <td width="18%" align="center">一级区域</td>
    <td width="25%" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['citys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['t']['cityid']; ?></td>
    <td align="center"><input type="text" name="city[<?php echo $this->_var['t']['cityid']; ?>]" id="city[]" value="<?php echo $this->_var['t']['city']; ?>"></td>
    <td align="center"><input type="text" name="orderindex[<?php echo $this->_var['t']['cityid']; ?>]" id="orderindex[]" value="<?php echo $this->_var['t']['orderindex']; ?>"></td>
    <td align="center"><input type="text" name="latlng[<?php echo $this->_var['t']['cityid']; ?>]" id="latlng" value="<?php echo $this->_var['t']['lat']; ?>,<?php echo $this->_var['t']['lng']; ?>" /></td>
    <td align="center"><?php echo $this->_var['t']['province']; ?></td>
    <td align="center">
    <a href="admin.php?m=town&cityid=<?php echo $this->_var['t']['cityid']; ?>">查看三级区域</a> 
    <a href="admin.php?m=town&cityid=<?php echo $this->_var['t']['cityid']; ?>&a=add">添加三级区域</a> 
    <a href="admin.php?m=city&a=del&cityid=<?php echo $this->_var['t']['cityid']; ?>">删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><input type="submit" name="button" id="button" value="提交" class="btn" /></td>
  </tr>
  <tr>
    <td colspan="6" align="left">地理位置说明： <a  href="javascript:;" onclick='$("#mapbox").css("visibility","visible")'  >点击获取地理位置</a> 然后复制即可  </td>
    </tr>
</table>


</form>


</div>

<div id="mapbox" style=" visibility:hidden; position:fixed; left:200px; top:40px; width:640px;  height:460px; background-color:#FFFFFF; padding:5px 10px; border:1px solid #6C9;">
<div style="background-color:#66CC99; height:30px; line-height:30px; padding-left:10px; padding-right:10px;"><span style="float:left;">地图标注::</span> <span style="float:right;"><a href="javascript:;" id="getlatlng_close" onclick="$('#mapbox').css('visibility','hidden')">关闭</a></span></div>
<iframe src="index.php?m=getlatlng" style="width:600px; height:420px; border:0;"></iframe></div>

<?php echo $this->fetch('lib/foot.lbi'); ?>