<?php echo $this->fetch('lib/header.html'); ?>
 
<?php echo $this->fetch('searchnav.html'); ?>
 
<div class="row">
<div class="span9">
  <table class="table table-bordered  table-condensed  "  >
 
 <?php $_from = $this->_var['shoplist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shop');if (count($_from)):
    foreach ($_from AS $this->_var['shop']):
?>
  <tr>
    <td width="104" rowspan="2" align="center" bgcolor="#FFFFFF"><a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>"><img src="<?php if ($this->_var['shop']['logo']): ?><?php echo $this->_var['shop']['logo']; ?><?php else: ?>images/nologo.gif<?php endif; ?>" style="width:100px; height:100px;" /></a></td>
    <td width="513" height="26" bgcolor="#FFFFFF"><a href="index.php?m=shop&shopid=<?php echo $this->_var['shop']['shopid']; ?>"><?php echo $this->_var['shop']['shopname']; ?></a>  
    <span style="float:right;">
    <?php if ($this->_var['ssuser']): ?><?php if ($this->_var['shop']['isfav']): ?> 
      <a href="javascript:;" class="delshopfav btn btn-warning" shopid="<?php echo $this->_var['shop']['shopid']; ?>">移出首页</a>
      <?php else: ?><a href="javascript:;" class="addshopfav btn" shopid="<?php echo $this->_var['shop']['shopid']; ?>">加入首页</a><?php endif; ?>
      <?php else: ?><a href="index.php?m=user&a=login" class="btn">登录收藏</a><?php endif; ?>
      </span>
      </td>
    </tr>
    
   
  <tr>
    <td height="25" valign="top" bgcolor="#FFFFFF">
    
    店铺地址：<?php echo $this->_var['shop']['address']; ?><span style="float:right">起送价：<?php echo $this->_var['shop']['minprice']; ?> 元</span>
    <br />
    联系电话：<?php echo $this->_var['shop']['phone']; ?>
    <br />
    店铺简介：<?php echo $this->_var['shop']['info']; ?>
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