<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav"><a href="admin.php?m=user&">会员管理</a> <a href="admin.php?m=user&a=add">会员添加</a> <a href="admin.php?m=user&a=info&amp;userid=<?php echo $this->_var['user']['userid']; ?>">会员详情</a></div>
<div class="nav_title">会员详情</div>
<div class="rbox">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td width="112" height="30" align="center">用户名</td>
    <td width="70" align="center">qq</td>
    <td width="93" align="center">手机</td>
    <td width="97" align="center">邮箱</td>
    <td width="82" align="center">昵称</td>
    <td width="66" align="center">积分</td>
    <td width="232" align="center">地址</td>
  </tr>

  <tr>
    <td height="25" align="center"><?php echo $this->_var['user']['username']; ?></td>
    <td align="center"><?php echo $this->_var['user']['qq']; ?></td>
    <td align="center"><?php echo $this->_var['user']['phone']; ?></td>
    <td align="center"><?php echo $this->_var['user']['email']; ?></td>
    <td align="center"><?php echo $this->_var['user']['nickname']; ?></td>
    <td align="center"><?php echo $this->_var['user']['grade']; ?></td>
    <td align="center"><?php echo $this->_var['user']['address']; ?></td>
  </tr>
 
  
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1"  >
  <tr>
    <td   height="30">他目前可用余额为<?php echo $this->_var['user']['balance']; ?> 元，<a href="admin.php?m=paylog&a=log&amp;userid=<?php echo $this->_var['user']['userid']; ?>"><font color="red">查看充值消费记录</font></a>,<a href="admin.php?m=grade_log&userid=<?php echo $this->_var['user']['userid']; ?>"><font color="red">查看积分兑换记录</font></a>。</td>
  </tr>
  <tr>
    <td height="30">在本站累计消费<?php echo $this->_var['ordermoney']; ?>元，获得<?php echo $this->_var['user']['grade']; ?>积分，可以获得<?php echo $this->_var['discount']; ?>%优惠,<a href="admin.php?m=order&uid=<?php echo $this->_var['user']['userid']; ?>">查看消费记录</a>。</td>
    </tr>
  <tr>
    <td height="30">他共引荐了<?php echo $this->_var['spread']; ?>名好友,他的好友累计消费了<?php echo $this->_var['friendmoney']; ?>元，给它带来<?php echo $this->_var['friendbonus']; ?>元奖励。</td>
  </tr>
  </table>

</div> 
<?php echo $this->fetch('lib/foot.lbi'); ?>