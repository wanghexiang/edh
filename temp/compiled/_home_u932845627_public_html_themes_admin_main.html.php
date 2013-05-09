<?php echo $this->fetch('lib/top.lbi'); ?>
<div class="nav">管理首页</div>
<div class="nav_title">管理首页</div>
<div class="rbox">
<table width="100%" border="0"  cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td  height="30"><?php echo $this->_var['ct_version']; ?></td>
  </tr>
  <tr>
    <td  height="30">
    新订单： <font color="red"><?php echo $this->_var['ordernewnum']; ?></font> 单, 今日成交 <font color="red"><?php echo $this->_var['orderdaynum']; ?></font> 单，共 <font color="red"><?php echo $this->_var['daymoney']; ?></font> 元。总成交订单： <font color="red"><?php echo $this->_var['ordernum']; ?></font> 单，共<font color="red"><?php echo $this->_var['money']; ?></font> 元。
    
    </td>
    </tr>
  <tr>
    <td height="30">新留言 <font color="red"><?php echo $this->_var['guestnum']; ?></font> 条， 
    新美食评论 <font color="red"><?php echo $this->_var['caicommentnum']; ?></font> 条 ,
    新厨师评论 <font color="red"><?php echo $this->_var['cookcommentnum']; ?></font> 条 ，
    新文章评论 <font color="red"><?php echo $this->_var['artcommentnum']; ?></font> 条
    </td>
    </tr>
  <tr>
    <td height="30">新用户 <font color="red"><?php echo $this->_var['userdaynum']; ?></font> 人， 用户总数 <font color="red"><?php echo $this->_var['usernum']; ?></font> 人。</td>
    </tr>
  <tr>
    <td height="30">&nbsp;</td>
    </tr>
  <tr>
    <td height="30">&nbsp;</td>
    </tr>
  <tr>
    <td height="30">&nbsp;</td>
    </tr>
</table>

</div> 
<?php echo $this->fetch('lib/foot.lbi'); ?>