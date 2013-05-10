<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=province&">一级区域管理</a> <a href="admin.php?m=city&">二级区域管理</a> <a href="admin.php?m=town&">三级区域管理</a></div>
<div class="nav_title">一级区域管理  </div>
<div class="rbox">
<form method="post" action="admin.php?m=province&a=post">
<table width="100%" border="0" cellpadding="0" class="tb1">
  <tr>
    <td width="11%" align="center">ID</td>
    <td width="20%" align="center">一级区域</td>
    <td width="28%" align="center">排序</td>
    <td width="18%" align="center">地理位置</td>
    <td width="23%" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['rs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ps');if (count($_from)):
    foreach ($_from AS $this->_var['ps']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['ps']['provinceid']; ?></td>
    <td align="center"><input type="text" name="province[<?php echo $this->_var['ps']['provinceid']; ?>]" id="province[]" value="<?php echo $this->_var['ps']['province']; ?>"></td>
    <td align="center"><input type="text" name="orderindex[<?php echo $this->_var['ps']['provinceid']; ?>]" id="orderindex[]" value="<?php echo $this->_var['ps']['orderindex']; ?>"></td>
    <td align="center"><label for="latlng"></label>
      <input type="text"   id="latlng" name="latlng[<?php echo $this->_var['ps']['provinceid']; ?>]" value="<?php echo $this->_var['ps']['lat']; ?>,<?php echo $this->_var['ps']['lng']; ?>" /></td>
    <td align="center">
    <a href="admin.php?m=city&provinceid=<?php echo $this->_var['ps']['provinceid']; ?>">查看二级区域</a>
    <a href="admin.php?m=city&a=add&provinceid=<?php echo $this->_var['ps']['provinceid']; ?>">添加二级区域</a>
    <a href="admin.php?m=province&a=del&provinceid=<?php echo $this->_var['ps']['provinceid']; ?>">删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td align="center">新增</td>
    <td align="center"><input type="text" name="newprovince" id="newprovince"></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="6" align="left">地理位置说明： <a  href="javascript:;" onclick='$("#mapbox").css("visibility","visible")'  >点击获取地理位置</a> 然后复制即可  </td>
    </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center"><input type="submit" name="button" id="button" value="提交" class="btn"></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>


</form>

</div>

<div id="mapbox" style=" visibility:hidden; position:fixed; left:200px; top:40px; width:640px;  height:460px; background-color:#FFFFFF; padding:5px 10px; border:1px solid #6C9;">
<div style="background-color:#66CC99; height:30px; line-height:30px; padding-left:10px; padding-right:10px;"><span style="float:left;">地图标注::</span> <span style="float:right;"><a href="javascript:;" id="getlatlng_close" onclick="$('#mapbox').css('visibility','hidden')">关闭</a></span></div>
<iframe src="index.php?m=getlatlng" style="width:600px; height:420px; border:0;"></iframe></div>
<?php echo $this->fetch('lib/foot.lbi'); ?>