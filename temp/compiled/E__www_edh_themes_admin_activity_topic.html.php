<?php echo $this->fetch('lib/top.lbi'); ?>
<?php echo $this->fetch('activity_nav.html'); ?>
<div class="nav_title">活动主题</div>
<div class="rbox">
<table width="100%" border="0" class="tb1">
  <tr>
    <td width="10%" align="center">ID</td>
    <td width="30%" align="center">内容</td>
    <td width="20%" align="center">时间</td>
    <td width="20%" align="center">显示</td>
    <td width="20%" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?>
  <tr>
    <td align="center"><?php echo $this->_var['c']['id']; ?></td>
    <td><?php echo $this->_var['c']['content']; ?></td>
    <td align="center"><?php echo date("Y-m-d H:i:s",$this->_var['c']['dateline']); ?></td>
    <td align="center"><?php if ($this->_var['c']['status'] == 1): ?> <img src="images/yes.gif" class="ajax_no" url="admin.php?m=activity&a=topicstatus&id=<?php echo $this->_var['c']['id']; ?>&status=0" rurl="admin.php?m=activity&a=topicstatus&id=<?php echo $this->_var['c']['id']; ?>&status=1" /> <?php else: ?>
    <img src="images/no.gif" class="ajax_yes" url="admin.php?m=activity&a=topicstatus&id=<?php echo $this->_var['c']['id']; ?>&status=1" rurl="admin.php?m=activity&a=topicstatus&id=<?php echo $this->_var['c']['id']; ?>&status=0" />
    <?php endif; ?></td>
    <td align="center"><a href="javascript:;" url="admin.php?m=activity&a=topicdel&id=<?php echo $this->_var['c']['id']; ?>" class="ajax_del">删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
<?php echo $this->fetch('lib/foot.lbi'); ?>