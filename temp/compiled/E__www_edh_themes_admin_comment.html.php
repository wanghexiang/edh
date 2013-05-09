<?php echo $this->fetch('lib/top.lbi'); ?>
<script language="javascript" src="<?php echo $this->_var['skins']; ?>js/jquery.center.js"></script>
<div class="nav"><a href="admin.php?m=comment">订单评论</a> </div>
<div class="nav_title">订单评论 </div>
<div class="rbox">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tb1">
  <tr>
    <td width="50" height="30" align="center">ID</td>
    <td width="143" height="30" align="center">评论内容</td>
    <td width="172" align="center">回复内容</td>
    <td width="50" height="30" align="center">评论者</td>
    
   
    <td width="140" height="30" align="center">时间</td>
     <td width="223">积分</td>
    <td width="100" height="30" align="center">操作</td>
  </tr>
  <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 't');if (count($_from)):
    foreach ($_from AS $this->_var['t']):
?>
  <tr>
    <td height="25" align="center"><?php echo $this->_var['t']['id']; ?></td>
    <td><?php echo $this->_var['t']['content']; ?></td>
    <td align="center"><?php echo $this->_var['t']['reply']; ?></td>
    <td align="center"><?php if ($this->_var['t']['nickname']): ?><?php echo $this->_var['t']['nickname']; ?><?php else: ?>游客<?php endif; ?></td>
    <td align="center"><?php echo date("Y-m-d",$this->_var['t']['dateline']); ?></td>
    <td>服务:<?php echo $this->_var['t']['jf_fuwu']; ?> 口味:<?php echo $this->_var['t']['jf_kouwei']; ?> 价格:<?php echo $this->_var['t']['jf_jiage']; ?> 配送:<?php echo $this->_var['t']['jf_shijian']; ?> </td>
    <td align="center"><a href="javascript:;" class="replybox_btn" replyid="<?php echo $this->_var['t']['id']; ?>" title='<?php echo $this->_var['t']['content']; ?>' replycontent="<?php echo $this->_var['t']['reply']; ?>" geturl="shopadmin.php?m=comment&a=getreply&id=<?php echo $this->_var['t']['id']; ?>"  url='shopadmin.php?m=comment&a=reply'>回复</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="25" colspan="6" align="center"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
    <?php endif; ?>
</table>

</div> 

</div>


</div>
<div id="replybox" >

<div id="replybox_nav">回复:<span id="replybox_title"></span><span class="floatright"><a href="javascript:;" id="replybox_close">关闭</a></span></div>
<div>
    <input type="hidden" id="replybox_id" value="" />
    <input type="hidden" id="replybox_url" value="" />
    <textarea name="replybox_content" id="replybox_content" cols="45" rows="5" style="width:380px;"></textarea>
</div>
<div style="height:30px; line-height:30px;">   
   <input type="submit" name="button" id="replybox_submit" class="btn" value="回复" />
</div><?php echo $this->fetch('lib/foot.lbi'); ?>