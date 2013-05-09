<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=guest">留言管理</a> <a href="index.php?m=guest&" target="_blank">查看留言板</a></div>
<div class="nav_title">留言管理: 
<?php if ($_GET['status'] == 0): ?>未审核<?php else: ?><a href="admin.php?m=guest&status=0">未审核</a><?php endif; ?>  
<?php if ($_GET['status'] == 1): ?>已审核<?php else: ?><a href="admin.php?m=guest&status=1">已审核</a><?php endif; ?> 
<?php if ($_GET['status'] == 2): ?>未审核<?php else: ?><a href="admin.php?m=guest&status=2">已禁止</a><?php endif; ?> </div>
<div class="rbox">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td width="61" height="30" align="center">ID</td>
    <td width="271" height="30" align="center">留言信息</td>
    <td width="156" height="30" align="center">留言者</td>
    <td width="183" height="30" align="center">时间</td>
    <td width="111" align="center">审核</td>
    <td width="305" height="30" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['glist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td height="25" align="center"><?php echo $this->_var['t']['id']; ?></td>
    <td><?php echo $this->_var['t']['content']; ?></td>
    <td align="center"><?php echo $this->_var['t']['username']; ?></td>
    <td align="center"><?php echo date("m-d H:i",$this->_var['t']['dateline']); ?></td>
    <td align="center"><?php if ($this->_var['t']['status'] == 1): ?>已审核<?php elseif ($this->_var['t']['status'] == 2): ?>禁止<?php else: ?>未审核<?php endif; ?></td>
    <td align="center">
    <?php if ($this->_var['t']['status'] == 1): ?><a href="javascript:;" url="admin.php?m=guest&a=status&id=<?php echo $this->_var['t']['id']; ?>&status=2" class="ajax_forbid">禁止</a><?php endif; ?>
    <?php if ($this->_var['t']['status'] == 2): ?><a href="javascript:;" url="admin.php?m=guest&a=status&id=<?php echo $this->_var['t']['id']; ?>&status=1" class="ajax_pass">审核</a><?php endif; ?>
    <?php if ($this->_var['t']['status'] == 0): ?><a href="javascript:;"  url="admin.php?m=guest&a=status&status=2" class="ajax_forbid"> 禁止</a> <a url="admin.php?m=guest&a=status&id=<?php echo $this->_var['t']['id']; ?>&status=1" class="ajax_pass">审核</a><?php endif; ?>
    <a href="admin.php?m=guest&a=reply&amp;id=<?php echo $this->_var['t']['id']; ?>">回复</a> <a href="admin.php?m=guest&a=del&amp;id=<?php echo $this->_var['t']['id']; ?>">删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="25" colspan="6" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
    <?php endif; ?>
</table>

</div> <?php echo $this->fetch('lib/foot.lbi'); ?>
