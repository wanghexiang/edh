<?php echo $this->fetch('lib/top.lbi'); ?>
<?php echo $this->fetch('activity_nav.html'); ?>
<div class="nav_title">活动管理</div>
<div class="rbox">
<table width="100%" border="0" class="tb1">
  <tr>
    <td width="5%" align="center">ID</td>
    <td width="33%" align="center">主题</td>
    <td width="14%" align="center">显示</td>
    <td width="16%" align="center">开始时间</td>
    <td width="15%" align="center">结束时间</td>
    <td width="17%" align="center">操作</td>
    </tr>
   <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c');if (count($_from)):
    foreach ($_from AS $this->_var['c']):
?> 
  <tr>
    <td align="center"><?php echo $this->_var['c']['id']; ?></td>
    <td><?php echo $this->_var['c']['title']; ?></td>
    <td align="center"><?php if ($this->_var['c']['status'] == 1): ?> <img src="images/yes.gif" class="ajax_no" url="admin.php?m=activity&a=changestatus&id=<?php echo $this->_var['c']['id']; ?>&status=0" rurl="admin.php?m=activity&a=changestatus&id=<?php echo $this->_var['c']['id']; ?>&status=1" /> <?php else: ?>
    <img src="images/no.gif" class="ajax_yes" url="admin.php?m=activity&a=changestatus&id=<?php echo $this->_var['c']['id']; ?>&status=1" rurl="admin.php?m=activity&a=changestatus&id=<?php echo $this->_var['c']['id']; ?>&status=0" />
    <?php endif; ?></td>
    <td align="center"><?php echo date("Y-m-d H:i:s",$this->_var['c']['starttime']); ?></td>
    <td align="center"><?php echo date("Y-m-d H:i:s",$this->_var['c']['endtime']); ?></td>
    <td align="center"><a href="admin.php?m=activity&a=add&id=<?php echo $this->_var['c']['id']; ?>">编辑</a> <a href="javascript:;" class="ajax_del" url="admin.php?m=activity&a=del&id=<?php echo $this->_var['c']['id']; ?>">删除</a></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>

</div>
<?php echo $this->fetch('lib/foot.lbi'); ?>