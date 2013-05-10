<?php echo $this->fetch('lib/top.lbi'); ?>
<script type="text/javascript" src="xheditor/xheditor.js" ></script>
<script language="javascript">
$(document).ready(function()
{
$('#content').xheditor({forcePtag:false,upImgUrl:"admin.php?m=upfile&xh=1",upImgExt:"jpg,jpeg,gif,png",html5Upload:false});
});
</script>
<?php echo $this->fetch('activity_nav.html'); ?>
<div class="nav_title">添加活动</div>
<div class="rbox">
<form method="post" action="admin.php?m=activity&a=save">
<input type="hidden" name="id" value="<?php echo $this->_var['data']['id']; ?>" />
<table width="100%"  class="tb1">
<tr>
<td width="16%" align="right">活动主题：</td>
<td width="84%"><label for="title"></label>
  <input name="title" type="text" id="title" value="<?php echo $this->_var['data']['title']; ?>" style="width:400px;" /></td>
</tr>

<tr>
<td width="16%" align="right">活动地点：</td>
<td width="84%"><label for="title"></label>
  <input name="address" type="text" id="address" value="<?php echo $this->_var['data']['address']; ?>" style="width:400px;" /></td>
</tr>

<tr>
  <td align="right">开始时间：</td>
  <td><input name="starttime" type="text" id="starttime" value="<?php if ($this->_var['data']): ?><?php echo date("Y-m-d H:i:s",$this->_var['data']['starttime']); ?><?php endif; ?>" /> 格式（2012-10-12 10:10:10）</td>
</tr>
<tr>
  <td align="right">结束时间：</td>
  <td><input name="endtime" type="text" id="endtime" value="<?php if ($this->_var['data']): ?><?php echo date("Y-m-d H:i:s",$this->_var['data']['endtime']); ?><?php endif; ?>" /></td>
</tr>
<tr>
  <td align="right">关键字：</td>
  <td><label for="keywords"></label>
    <input name="keywords" type="text" id="keywords" value="<?php echo $this->_var['data']['keywords']; ?>" style="width:400px;" /></td>
</tr>
<tr>
  <td align="right">描述：</td>
  <td><label for="description"></label>
    <textarea name="description" id="description" style="width:400px;"><?php echo $this->_var['data']['description']; ?></textarea></td>
</tr>
<tr>
  <td align="right">简介：</td>
  <td><label for="info"></label>
    <textarea name="info" id="info" cols="45" rows="5" style="width:400px;"><?php echo $this->_var['data']['info']; ?></textarea></td>
</tr>
<tr>
  <td align="right">内容：</td>
  <td><textarea name="content" id="content" style="width:100%;height:400px;"><?php echo $this->_var['data']['content']; ?></textarea></td>
</tr>
<tr>
  <td align="right">&nbsp;</td>
  <td><input type="submit" name="button" id="button" value="提交" class="btn" /></td>
</tr>
</table>
</form>
</div>
<?php echo $this->fetch('lib/foot.lbi'); ?>