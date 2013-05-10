<?php echo $this->fetch('lib/header.html'); ?>
 
<?php echo $this->fetch('searchnav.html'); ?>
 
<div class="row">
<div class="span9">
  <table class="table table-bordered  table-condensed  "  >
 
 <?php $_from = $this->_var['userlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'u');if (count($_from)):
    foreach ($_from AS $this->_var['u']):
?>
  <tr>
    <td width="104" rowspan="2" align="center" bgcolor="#FFFFFF"><a href="index.php?m=member&userid=<?php echo $this->_var['u']['userid']; ?>"><img src="<?php if ($this->_var['u']['logo']): ?><?php echo $this->_var['u']['logo']; ?><?php else: ?>images/nologo.gif<?php endif; ?>" style="width:100px; height:100px;" /></a></td>
    <td width="513" height="26" bgcolor="#FFFFFF">
    <a href="index.php?m=member&userid=<?php echo $this->_var['u']['userid']; ?>"><?php echo $this->_var['u']['nickname']; ?></a> 
    &nbsp;粉丝 <?php echo $this->_var['u']['followeds']; ?> &nbsp;关注 <?php echo $this->_var['u']['followers']; ?>  
    <span style="float:right;">
    <?php if ($this->_var['ssuser']): ?><?php if ($this->_var['u']['isfollowed']): ?> 
      <a href="javascript:;" url='index.php?m=friend&a=follow_del&touserid=<?php echo $this->_var['u']['userid']; ?>' class="ajax_follow_del btn btn-warning" shopid="<?php echo $this->_var['shop']['shopid']; ?>">取消关注</a>
      <?php else: ?>
      <a href="javascript:;" url='index.php?m=friend&a=follow_add&touserid=<?php echo $this->_var['u']['userid']; ?>' class="ajax_follow_add btn btn-success" shopid="<?php echo $this->_var['shop']['shopid']; ?>">加关注</a><?php endif; ?>
      <?php endif; ?>
      </span>
      </td>
    </tr>
    
   
  <tr>
    <td height="25" valign="top" bgcolor="#FFFFFF">
    
    个人简介：<?php echo $this->_var['u']['info']; ?>
     </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php if ($this->_var['pagelist']): ?>
  <tr>
    <td height="30" colspan="2" align="center" bgcolor="#FFFFFF"><?php echo $this->_var['pagelist']; ?></td>
    </tr>
    <?php endif; ?>
</table>

</div>
<div class="span3">
<div>
 <h3>还是不太敢在线订餐？</h3>
 <p>别担心，你的订单会立刻得到处理，进度还会实时反馈给你。很多人已经用上瘾了，你也试一次吧。</p>
 </div>
 <form   action="index.php?m=guest&a=add_db" method="post">
								 
					<textarea id="ask_answer_content"  class="input-xlarge"  style="width:100%; height:100px;" name="content"></textarea>
				 
					<input   type="submit" value="好了，提交" class="btn">
				 
			</form>
 
 
 <?php $_from = $this->_var['guestlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'guest');if (count($_from)):
    foreach ($_from AS $this->_var['guest']):
?>
 <table class="table table-bordered  table-condensed   ">
 <tr>
        <td><strong><?php echo $this->_var['guest']['username']; ?></strong> ： <?php echo $this->_var['guest']['content']; ?> </td>  </tr>
 <tr>
            
             
           <td> 口福答疑 <?php echo $this->_var['guest']['reply']; ?> </td>
</tr>
        
 </table>      	
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 

</div>
</div>


<?php echo $this->fetch('lib/footer.html'); ?>