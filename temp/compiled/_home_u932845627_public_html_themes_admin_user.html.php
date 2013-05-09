<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=user&">会员管理</a> <a href="admin.php?m=user&a=add">会员添加</a></div>
<div class="nav_title">会员管理::
<?php if ($_GET['status'] == 0): ?>未审核<?php else: ?><a href="admin.php?m=user&status=0">未审核</a> <?php endif; ?>  
<?php if ($_GET['status'] == 1): ?>已审核<?php else: ?><a href="admin.php?m=user&status=1">已审核</a> <?php endif; ?> 
<?php if ($_GET['status'] == - 1): ?>已禁止<?php else: ?><a href="admin.php?m=user&status=2">已禁止</a> <?php endif; ?> 
</div>
<div class="rbox">
<form method="get" action="admin.php">
<input type="hidden" name="m" value="user" />
<input type="hidden" name="status" value="<?php echo $_GET['status']; ?>" />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tb1">
  <tr>
    <td width="246" height="30" align="right">用户名:&nbsp;</td>
    <td width="179" align="left"><input type="text" name="username" id="username" value="<?php echo $_GET['username']; ?>" /></td>
    <td width="315" align="left"><input type="submit" name="button" id="button" value="快速搜索" class="btn" /></td>
    </tr>
  </table>

</form>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td width="85" height="30" align="center">userId</td>
    <td width="126" align="center">用户名</td>
    <td width="126" align="center">真实姓名</td>
    <td width="92" align="center">qq</td>
    <td width="115" align="center">手机</td>
    <td width="123" align="center">邮箱</td>
    <td width="78" align="center">状态</td>
    <td width="467" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['userlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td height="25" align="center"><?php echo $this->_var['t']['userid']; ?></td>
    <td align="center"><?php echo $this->_var['t']['username']; ?></td>
    <td align="center"><?php echo $this->_var['t']['truename']; ?></td>
    <td align="center"><?php echo $this->_var['t']['qq']; ?></td>
    <td align="center"><?php echo $this->_var['t']['phone']; ?></td>
    <td align="center"><?php echo $this->_var['t']['email']; ?></td>
    <td align="center"><?php if ($this->_var['t']['status'] == 1): ?>已审核<?php elseif ($this->_var['t']['status'] == - 1): ?>已禁止<?php else: ?>未审核<?php endif; ?></td>
    <td align="center"> <a href="admin.php?m=user&a=info&amp;userid=<?php echo $this->_var['t']['userid']; ?>">查看</a> 
    <?php if ($this->_var['t']['status'] == 0): ?> <a href="javascript:;" class="ajax_pass" url="admin.php?m=user&a=dotype&userid=<?php echo $this->_var['t']['userid']; ?>&status=1">审核</a> 
    <a href="javascript:;" class="ajax_forbid" url="admin.php?m=user&a=dotype&userid=<?php echo $this->_var['t']['userid']; ?>&status=2"> 禁止</a><?php endif; ?>
   
   <?php if ($this->_var['t']['status'] == 1): ?><a href="javascript:;" class="ajax_forbid" url="admin.php?m=user&a=dotype&userid=<?php echo $this->_var['t']['userid']; ?>&status=2"> 禁止</a><?php endif; ?>
   <?php if ($this->_var['t']['status'] == 2): ?><a href="javascript:;" class="ajax_pass" url="admin.php?m=user&a=dotype&userid=<?php echo $this->_var['t']['userid']; ?>&status=1">审核</a><?php endif; ?>
    
     <a href="admin.php?m=order&uid=<?php echo $this->_var['t']['userid']; ?>">消费记录</a> <a href="admin.php?m=user&a=chpwd&amp;username=<?php echo $this->_var['t']['username']; ?>">密码</a> <a href="admin.php?m=user&a=del&amp;userid=<?php echo $this->_var['t']['userid']; ?>" onclick="return confirm('删除后不可恢复，确定删除？')">删除</a></td>
  </tr><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="25" colspan="9" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
<?php endif; ?>
  
</table>


</div> 
<?php echo $this->fetch('lib/foot.lbi'); ?>
